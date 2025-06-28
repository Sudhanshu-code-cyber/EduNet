@extends('page.student.parent')
@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Header Section -->
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-3xl font-bold text-gray-800">
                <i class="fas fa-bus text-blue-500 mr-3"></i>My Transport Details
            </h1>
            @if($transport)
                <div class="bg-blue-100 text-blue-800 px-4 py-2 rounded-full text-sm font-medium">
                    Active <i class="fas fa-check-circle ml-1"></i>
                </div>
            @endif
        </div>

        @if($transport)
            <!-- Transport Card -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden mb-8 transition-all hover:shadow-lg">
                <div class="md:flex">
                    <!-- Vehicle Image Placeholder -->
                    <div class="md:w-1/3 bg-blue-50 flex items-center justify-center p-6">
                        <i class="fas fa-bus text-blue-400 text-6xl"></i>
                    </div>
                    
                    <!-- Transport Details -->
                    <div class="p-8 md:w-2/3">
                        <div class="flex items-center mb-4">
                            <h2 class="text-2xl font-bold text-gray-800">Route: {{ $transport->route_name ?? 'Not Assigned' }}</h2>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-bus-simple text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Vehicle Number</p>
                                    <p class="font-medium">{{ $transport->vehicle_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-id-card text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Driver</p>
                                    <p class="font-medium">{{ $transport->driver_name ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-phone text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Driver Contact</p>
                                    <p class="font-medium">{{ $transport->phone_number ?? 'N/A' }}</p>
                                </div>
                            </div>
                            
                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-clock text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Pickup Time</p>
                                    <p class="font-medium">{{ $transport->pickup_time ?? 'N/A' }}</p>
                                </div>
                            </div>

                            <div class="flex items-start">
                                <div class="bg-blue-100 p-2 rounded-full mr-3">
                                    <i class="fas fa-clock text-blue-600"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">drop Time</p>
                                    <p class="font-medium">{{ $transport->drop_time ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Information -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <h3 class="text-xl font-semibold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i> Transport Guidelines
                </h3>
                <ul class="space-y-3">
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span>Please be at the pickup point 5 minutes before scheduled time</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span>Wear your ID card at all times during transport</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span>Follow all safety instructions from the driver</span>
                    </li>
                    <li class="flex items-start">
                        <i class="fas fa-check-circle text-green-500 mt-1 mr-2"></i>
                        <span>Report any issues to the transport office immediately</span>
                    </li>
                </ul>
            </div>
        @else
            <!-- No Transport Assigned Message -->
            <div class="bg-white rounded-xl shadow-md p-8 text-center">
                <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                    <i class="fas fa-bus text-blue-400 text-6xl"></i>
                </div>
                <h3 class="text-xl font-semibold text-gray-700 mb-2">No Transport Assigned</h3>
                <p class="text-gray-500 mb-6">You currently don't have any transport service assigned to you.</p>
                <button class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <i class="fas fa-info-circle mr-2"></i> Contact Administration
                </button>
            </div>
        @endif
    </div>
</div>
@endsection