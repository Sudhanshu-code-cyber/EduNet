<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
   public function index()
    {
        $notices = Notice::where('creator_role', 'admin')
                         ->where('target', 'teacher')
                         ->where(function ($query) {
                             $query->whereNull('expires_at')
                                   ->orWhere('expires_at', '>=', now());
                         })
                         ->latest()
                         ->paginate(4);

        return view('page.admin.notice', compact('notices'));
    }

    /**
     * Show the form for creating a new notice.
     */
    public function create()
    {
        return view('page.admin.notice');
    }

    /**
     * Store a newly created notice in storage.
     */
  public function store(Request $request)
{
    if (!Auth::check()) {
        return redirect()->route('login')->withErrors('Please login to continue.');
    }

    $request->validate([
        'title'      => 'required|string|max:255',
        'details'    => 'required|string',
        'date'       => 'required|date',
        'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
    ]);

    $data = [
        'title'        => $request->title,
        'details'      => $request->details,
        'date'         => $request->date,
        'expires_at'   => now()->addDays(30),
        'created_by'   => Auth::id(), // Will be null if user not logged in
        'creator_role' => 'admin',
        'target'       => 'teacher',
    ];

    if ($request->hasFile('attachment')) {
        $data['attachment'] = $request->file('attachment')->store('notices', 'public');
    }

    Notice::create($data);

    return redirect()->route('notice.index')->with('success', 'Notice created successfully.');
}

    /**
     * Show the form for editing the specified notice.
     */
    public function edit(string $id)
    {
        $notice = Notice::findOrFail($id);
        return view('page.admin.notice-edit-modal', compact('notice'));
    }

    /**
     * Update the specified notice in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'      => 'required|string|max:255',
            'details'    => 'required|string',
            'date'       => 'required|date',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        $notice = Notice::findOrFail($id);

        // Ensure only the creator can update
        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $data = [
            'title'   => $request->title,
            'details' => $request->details,
            'date'    => $request->date,
        ];

        // Handle file replacement
        if ($request->hasFile('attachment')) {
            if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
                Storage::disk('public')->delete($notice->attachment);
            }

            $data['attachment'] = $request->file('attachment')->store('notices', 'public');
        }

        $notice->update($data);

        return redirect()->route('notice.index')->with('success', 'Notice updated successfully!');
    }

    /**
     * Remove the specified notice from storage.
     */
    public function destroy(string $id)
    {
        $notice = Notice::findOrFail($id);

        // Ensure only the creator can delete
        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to delete this notice.');
        }

        // Delete attachment if exists
        if ($notice->attachment && Storage::disk('public')->exists($notice->attachment)) {
            Storage::disk('public')->delete($notice->attachment);
        }

        $notice->delete();

        return redirect()->route('notice.index')->with('error', 'Notice deleted successfully!');
    }

    /**
     * Search and filter notices.
     */
    public function search(Request $request)
    {
        $query = Notice::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('search_date')) {
            $query->whereDate('date', $request->search_date);
        }

        $query->where('creator_role', 'admin')
              ->where('target', 'teacher')
              ->where(function ($q) {
                  $q->whereNull('expires_at')
                    ->orWhere('expires_at', '>=', now());
              });

        $notices = $query->orderByDesc('date')->paginate(10);

        return view('page.admin.notice', compact('notices'));
    }
}
