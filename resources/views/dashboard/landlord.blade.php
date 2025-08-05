@extends('layouts.app')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">
    <!-- Total Property Card -->
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center mb-2">
            <div class="flex items-center">
                <i class="fas fa-building text-green-500"></i>
                <span class="ml-2">Total Property</span>
            </div>
            <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-ellipsis-h"></i></button>
        </div>
        <div class="text-3xl font-bold">1,500</div>
        <div class="text-sm text-gray-500">
            <span class="bg-green-200 text-green-600 px-2 py-1 rounded">~20%</span>
            Last month total 1,050
        </div>
    </div>

    <!-- Number of Sales Card -->
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center mb-2">
            <div class="flex items-center">
                <i class="fas fa-chart-line text-blue-500"></i>
                <span class="ml-2">Number of Sales</span>
            </div>
            <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-ellipsis-h"></i></button>
        </div>
        <div class="text-3xl font-bold">320</div>
        <div class="text-sm text-gray-500">
            <span class="bg-red-200 text-red-600 px-2 py-1 rounded">~20%</span>
            Last month total 950
        </div>
    </div>

    <!-- Total Sales Card -->
    <div class="bg-white p-4 rounded shadow">
        <div class="flex justify-between items-center mb-2">
            <div class="flex items-center">
                <i class="fas fa-dollar-sign text-yellow-500"></i>
                <span class="ml-2">Total Sales</span>
            </div>
            <button class="text-gray-500 hover:text-gray-700"><i class="fas fa-ellipsis-h"></i></button>
        </div>
        <div class="text-3xl font-bold">$150k</div>
        <div class="text-sm text-gray-500">
            <span class="bg-red-200 text-red-600 px-2 py-1 rounded">~20%</span>
            Last month total $1.5M
        </div>
    </div>
</div>

<!-- Report Sales Chart -->
<div class="mt-8 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-bold mb-4">Report Sales</h2>
    <div class="flex justify-between items-center mb-4">
        <div class="text-sm text-gray-500">Weekday</div>
        <select class="border rounded px-2 py-1">
            <option value="weekday">Weekday</option>
            <option value="weekend">Weekend</option>
        </select>
    </div>
    <div class="chart-container">
        <!-- Replace with actual chart library or static image -->
        <canvas id="salesChart"></canvas>
    </div>
</div>

<!-- Cost Breakdown Pie Chart -->
<div class="mt-8 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-bold mb-4">Cost Breakdown</h2>
    <div class="flex justify-between items-center mb-4">
        <div class="text-sm text-gray-500">$4,750</div>
        <button class="text-gray-500 hover:text-gray-700">See Details</button>
    </div>
    <div class="chart-container">
        <!-- Replace with actual chart library or static image -->
        <canvas id="costBreakdownChart"></canvas>
    </div>
</div>

<!-- Last Transactions -->
<div class="mt-8 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-bold mb-4">Last Transactions</h2>
    <div class="flex justify-between items-center mb-4">
        <div>Last Transactions</div>
        <a href="#" class="text-sm text-gray-500 hover:text-gray-700">See All</a>
    </div>
    <div class="space-y-4">
        <div class="flex items-center">
            <img src="https://source.unsplash.com/random/60x60/?house" alt="Property Image" class="w-12 h-12 rounded-full mr-4">
            <div>
                <div class="text-lg font-bold">123 Maple Avenue Springfield</div>
                <div class="text-sm text-gray-500">12 Sep 2024, 9:29</div>
            </div>
            <div class="ml-auto text-lg font-bold">$30K</div>
        </div>
        <div class="flex items-center">
            <img src="https://source.unsplash.com/random/60x60/?apartment" alt="Property Image" class="w-12 h-12 rounded-full mr-4">
            <div>
                <div class="text-lg font-bold">Booking 987 Villa Street</div>
                <div class="text-sm text-gray-500">10 Sep 2024, 9:29</div>
            </div>
            <div class="ml-auto text-lg font-bold">$10K</div>
        </div>
        <div class="flex items-center">
            <img src="https://source.unsplash.com/random/60x60/?hotel" alt="Property Image" class="w-12 h-12 rounded-full mr-4">
            <div>
                <div class="text-lg font-bold">Apartment Booking On Garden Street</div>
                <div class="text-sm text-gray-500">...</div>
            </div>
            <div class="ml-auto text-lg font-bold">$20K</div>
        </div>
    </div>
</div>

<!-- Maintenance Requests -->
<div class="mt-8 bg-white p-4 rounded shadow">
    <h2 class="text-lg font-bold mb-4">Maintenance Requests</h2>
    <div class="flex justify-between items-center mb-4">
        <div>Maintenance Requests</div>
        <a href="#" class="text-sm text-gray-500 hover:text-gray-700">See All</a>
    </div>
    <div class="space-y-4">
        <div class="flex items-center">
            <img src="https://source.unsplash.com/random/60x60/?maintenance" alt="Request Type" class="w-12 h-12 rounded-full mr-4">
            <div>
                <div class="text-lg font-bold">Plumbing | 721 Meadowview</div>
                <div class="text-sm text-gray-500">Broken Garbage</div>
            </div>
            <div class="ml-auto">
                <img src="https://source.unsplash.com/random/60x60/?person" alt="User Avatar" class="w-12 h-12 rounded-full mr-4">
                <div class="text-lg font-bold">Jacob Jones</div>
            </div>
        </div>
        <div class="flex items-center">
            <img src="https://source.unsplash.com/random/60x60/?electricity" alt="Request Type" class="w-12 h-12 rounded-full mr-4">
            <div>
                <div class="text-lg font-bold">Electrical | 721 Meadowview</div>
                <div class="text-sm text-gray-500">No Heat Bathroom</div>
            </div>
            <div class="ml-auto">
                <img src="https://source.unsplash.com/random/60x60/?man" alt="User Avatar" class="w-12 h-12 rounded-full mr-4">
                <div class="text-lg font-bold">Albert Flores</div>
            </div>
        </div>
        <div class="flex items-center">
            <img src="https://source.unsplash.com/random/60x60/?air-conditioning" alt="Request Type" class="w-12 h-12 rounded-full mr-4">
            <div>
                <div class="text-lg font-bold">HVAC | 721 Meadowview</div>
                <div class="text-sm text-gray-500">Non Functional Fan</div>
            </div>
            <div class="ml-auto">
                <img src="https://source.unsplash.com/random/60x60/?woman" alt="User Avatar" class="w-12 h-12 rounded-full mr-4">
                <div class="text-lg font-bold">Robert Fox</div>
            </div>
        </div>
    </div>
</div>
@endsection