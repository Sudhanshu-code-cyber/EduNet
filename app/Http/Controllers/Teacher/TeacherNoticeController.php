<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TeacherNoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::where('creator_role', 'teacher')
            ->where('created_by', Auth::id())
            ->where('target', 'student')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->latest()
            ->paginate(4);

        return view('page.teacher.notices', compact('notices'));
    }

    public function adminNotices()
    {
        $notices = Notice::where('target', 'teacher')
            ->where('creator_role', 'admin')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->latest()
            ->paginate(5);

        return view('page.teacher.notice-admin', compact('notices'));
    }

    public function create()
    {
        return view('page.teacher.notices');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'details'    => 'required|string',
            'date'       => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $notice = new Notice([
            'title'        => $request->title,
            'details'      => $request->details,
            'date'         => $request->date,
            'expires_at'   => now()->addDays(30),
            'created_by'   => Auth::id(),
            'creator_role' => 'teacher',
            'target'       => 'student',
        ]);

        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('notices', $filename, 'public');
            $notice->attachment = $path;
        }

        $notice->save();

        return redirect()->route('teacher.notice.index')->with('success', 'Notice created successfully.');
    }

    public function edit($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to edit this notice.');
        }

        return view('page.teacher.notice-edit-modal', compact('notice'));
    }

    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to update this notice.');
        }

        $request->validate([
            'title'      => 'required|string|max:255',
            'details'    => 'required|string',
            'date'       => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $notice->title = $request->title;
        $notice->details = $request->details;
        $notice->date = $request->date;

        if ($request->hasFile('attachment')) {
            // Delete old file if exists
            if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
                Storage::disk('public')->delete($notice->attachment);
            }

            $file = $request->file('attachment');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('notices', $filename, 'public');
            $notice->attachment = $path;
        }

        $notice->save();

        return redirect()->route('teacher.notice.index')->with('success', 'Notice updated successfully!');
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to delete this notice.');
        }

        // Delete attached file if exists
        if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
            Storage::disk('public')->delete($notice->attachment);
        }

        $notice->delete();

        return redirect()->route('teacher.notice.index')->with('error', 'Notice deleted successfully!');
    }

    public function search(Request $request)
    {
        $query = Notice::where('creator_role', 'teacher')
            ->where('created_by', Auth::id())
            ->where('target', 'student');

        if ($request->filled('search_title')) {
            $query->where('title', 'like', '%' . $request->search_title . '%');
        }

        if ($request->filled('search_date')) {
            $query->whereDate('date', $request->search_date);
        }

        $notices = $query->latest()->paginate(4);

        return view('page.teacher.notices', compact('notices'));
    }

}
