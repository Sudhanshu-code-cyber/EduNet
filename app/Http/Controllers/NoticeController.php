<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notice;

class NoticeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notices = Notice::paginate(4);
        return view('page.admin.notice',compact('notices'));
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
    public function store(Request $req)
    {
        $data = $req->validate([
                'title' => 'required|string|max:255',
                'posted_by' => 'required|string|max:255',
                'details' => 'required|string',
                'date' => 'required|date',
        ]);
        Notice::create($data);
        return redirect()->route('notice.index')->with('success', 'Notice created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $notice = Notice::findOrFail($id);
        return view('page.admin.notice',compact('notice'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'posted_by' => 'required|string|max:255',
            'details' => 'required|string',
            'date' => 'required|date',
    ]);

$notice = Notice::findOrFail($id);

$notice->update([
    'title' => $request->title,
    'posted_by' => $request->posted_by,
    'details' => $request->details,
    'date' => $request->date,
]);

        return redirect()->route('notice.index')->with('success','Notice updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $notice = Notice::findOrFail($id);
        $notice->delete(); 

        return redirect()->route('notice.index')->with('error','Notice deleted successfully!');
    }

public function search(Request $request)
{
    $query = Notice::query();

    // Filter by title
    if ($request->has('search_title') && $request->search_title != '') {
        $query->where('title', 'like', '%' . $request->search_title . '%');
    }

    // Filter by date
    if ($request->has('search_date') && $request->search_date != '') {
        $query->whereDate('date', $request->search_date);
    }

    $notices = $query->latest()->paginate(4);

    return view('page.admin.notice', compact('notices'));
}

}
