<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;
use Illuminate\Support\Facades\Auth;

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
                             $query->whereNull('expires_at')->orWhere('expires_at', '>=', now());
                         })
                         ->latest()
                         ->paginate(4);

        return view('page.admin.notice', compact('notices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('page.admin.notice');
    }

    /**
     * Store a newly created resource in storage.
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
            'creator_role' => 'admin',
            'target'       => 'teacher',
        ]);

        return redirect()->route('notice.index')->with('success', 'Notice created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notice = Notice::findOrFail($id);
        return view('page.admin.notice-edit-modal', compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title'   => 'required|string|max:255',
            'details' => 'required|string',
            'date'    => 'required|date',
        ]);

        $notice = Notice::findOrFail($id);

        // Optional: Prevent editing if not creator
        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized action.');
        }

        $notice->update([
            'title'   => $request->title,
            'details' => $request->details,
            'date'    => $request->date,
        ]);

        return redirect()->route('notice.index')->with('success', 'Notice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notice = Notice::findOrFail($id);

        // Only the creator can delete
        if ($notice->created_by !== Auth::id()) {
            abort(403, 'Unauthorized to delete this notice.');
        }

        $notice->delete();

        return redirect()->route('notice.index')->with('error', 'Notice deleted successfully!');
    }

    /**
     * Search filtered notices.
     */
    public function search(Request $request)
    {
        $query = \App\Models\Notice::query();
    
        // Filter by title
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }
    
        // Filter by date
        if ($request->filled('search_date')) {
            $query->whereDate('date', $request->search_date);
        }
    
        // Filter by role and target if needed
        $query->where('creator_role', 'admin')
              ->where('target', 'teacher');
    
        // Exclude expired
        $query->where(function ($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>=', now());
        });
    
        $notices = $query->orderByDesc('date')->paginate(10);
    
        return view('page.admin.notice', compact('notices'));
    }
    
}
