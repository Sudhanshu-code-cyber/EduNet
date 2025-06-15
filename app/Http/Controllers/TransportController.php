<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;

class TransportController extends Controller
{
    public function index()
    {
        $transport=Transport::paginate(5);
        return view('page.admin.transport.transport',compact('transport'));
    }
   public function store(Request $request)
{
    $validated = $request->validate([
        'route_name' => 'required|string|max:255',
        'pickup_time' => 'required|date_format:H:i',  // Changed from picup_time
        'drop_time' => 'required|date_format:H:i',
        'vehicle_number' => 'required|string|max:50',
        'vehicle_capacity' => 'required|integer|min:1',  // Changed to integer
        'driver_name' => 'required|string|max:255',
        'license_number' => 'required|string|max:50',
        'phone_number' => 'required|string|max:20|regex:/^\+?[0-9\s\-]+$/',
    ]);

    Transport::create($validated);

    return redirect()->route('admin.transport')->with('success', 'Transport created successfully.');
}

  public function deletetransport($id){

    $transports=Transport::findOrFail($id);
     $transports->delete();
       return redirect()->route('admin.transport',compact('transports'))->with('error','Transport deleted successfully!');
  } 

  public function search(Request $request)
{
    $search = $request->input('search');

    $transport = Transport::where('route_name', 'like', "%{$search}%")
        ->orWhere('vehicle_number', 'like', "%{$search}%")
        ->paginate(5);

    return view('page.admin.transport.transport', compact('transport'))
        ->with('info', 'Search results for: ' . $search);
}

}
