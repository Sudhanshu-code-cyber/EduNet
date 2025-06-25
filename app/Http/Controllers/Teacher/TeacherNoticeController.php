<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice; 
use Illuminate\Support\Facades\Auth;

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
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>=', now());
            })
            ->latest()
            ->paginate(4);

        return view('page.teacher.notices', compact('notices'));
    }

    public function adminNotices()
    {
        $notices = \App\Models\Notice::where('target', 'teacher')
            ->where('creator_role', 'admin')
            ->where(function ($query) {
                $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
            })
            ->orderByDesc('created_at')
            ->paginate(5);
    
        return view('page.teacher.notice-admin', compact('notices'));
    }
    

    /**
     * Show the form to create a new notice.
     */
    public function create()
    {
        return view('page.teacher.notices'); // Should be a separate create form
    }

    /**
     * Store a newly created notice in the database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'details' => 'required|string',
            'date'    => 'required|date',
        ]);

        Notice::create([
            'title'        => $request->title,
            'details'      => $request->details,
            'date'         => $request->date,
            'expires_at'   => now()->addDays(30),
            'created_by'   => Auth::id(),
            'creator_role' => 'teacher',
            'target'       => 'student',
        ]);

        return redirect()->route('teacher.notice.index')->with('success', 'Notice created successfully.');
    }

    /**
     * Show the form for editing a notice.
     */
    public function edit($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to edit this notice.');
        }

        return view('page.teacher.notice-edit-modal', compact('notice')); // Should be a separate edit view
    }

    /**
     * Update an existing notice.
     */
    public function update(Request $request, $id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to update this notice.');
        }

        $request->validate([
            'title'   => 'required|string|max:255',
            'details' => 'required|string',
            'date'    => 'required|date',
        ]);

        $notice->update([
            'title'   => $request->title,
            'details' => $request->details,
            'date'    => $request->date,
        ]);

        return redirect()->route('teacher.notice.index')->with('success', 'Notice updated successfully!');
    }

    /**
     * Delete a notice permanently.
     */
    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to delete this notice.');
        }

        $notice->delete();

        return redirect()->route('teacher.notice.index')->with('error', 'Notice deleted successfully!');
    }

    /**
     * Search for notices based on title or date.
     */
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
