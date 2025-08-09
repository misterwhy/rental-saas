{{-- resources/views/dashboard/landlord.blade.php --}}
@extends('layouts.app')
@section('content')
<!-- Stats Cards - Updated with Real Data -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <!-- Total Property Card -->
    <div class="dashboard-card">
        <div class="flex justify-between items-start mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <span class="text-gray-600 font-medium">Total Properties</span>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
        {{-- Use real data --}}
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalProperties) }}</div>
    </div>
    <!-- Number of Units Card (Replaces Number of Sales) -->
    <div class="dashboard-card">
        <div class="flex justify-between items-start mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                     <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"> {{-- Icon for units --}}
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                    </svg>
                </div>
                <span class="text-gray-600 font-medium">Total Units</span>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
        {{-- Use real data --}}
        <div class="text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalUnits) }}</div>

    </div>
    <!-- Total Portfolio Value Card (Replaces Total Sales) -->
    <div class="dashboard-card">
        <div class="flex justify-between items-start mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-gray-600 font-medium">Portfolio Value</span>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
        {{-- Use real data --}}
        <div class="text-3xl font-bold text-gray-900 mb-2">${{ number_format($totalPortfolioValue ?? 0) }}</div>
    </div>
</div>

<!-- Charts Row - Updated with Real Data -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Report Sales Chart - Renamed and Updated Data -->
    <div class="lg:col-span-2 dashboard-card">
        <div class="flex justify-between items-center mb-6">
            {{-- Change chart title --}}
            <h3 class="text-lg font-semibold text-gray-900">Property Value by Type</h3>
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-1 bg-gray-100 rounded-lg p-1">
                    {{-- Simplify filter button --}}
                    <button class="px-3 py-1 text-sm text-gray-600 bg-white rounded-md transition-colors">Value ($)</button>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </div>
        </div>
        <div class="relative h-64">
            <canvas id="salesChart" width="100%" height="100%"></canvas>
        </div>
    </div>
    <!-- Cost Breakdown - Updated to show Property Type Distribution -->
    <div class="dashboard-card">
        <div class="flex justify-between items-center mb-6">
            {{-- Change chart title --}}
            <h3 class="text-lg font-semibold text-gray-900">Properties by Type</h3>
            <a href="{{ route('properties.index') }}" class="text-sm text-gray-500 hover:text-gray-700">See All</a>
        </div>
        <div class="flex justify-center mb-6">
            <div class="relative w-40 h-40">
                <canvas id="costChart" width="160" height="160"></canvas>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        {{-- Show total properties in the center --}}
                        <div class="text-2xl font-bold text-gray-900">{{ $totalProperties }}</div>
                        <div class="text-sm text-gray-500">Properties</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-3">
            {{-- Dynamically generate legend items if needed, or keep static for now --}}
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">House</span> {{-- Example --}}
                </div>
                 <span class="text-sm text-gray-900">{{ $doughnutValues[0] ?? 0 }}</span> {{-- Example Count --}}
            </div>
             <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-orange-300 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">Apartment</span> {{-- Example --}}
                </div>
                 <span class="text-sm text-gray-900">{{ $doughnutValues[1] ?? 0 }}</span> {{-- Example Count --}}
            </div>
            <!-- Add more legend items dynamically or statically as needed -->
        </div>
    </div>
</div>

<!-- Bottom Row - Keep or Update Sections -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Last Transactions - Consider replacing with "Recent Properties" -->
    <!-- For now, keep placeholder data or update if you have a way to get recent transactions -->
    <div class="dashboard-card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Recent Activity</h3> {{-- Generic title --}}
            <button class="text-sm text-gray-500 hover:text-gray-700">See All</button>
        </div>
        <div class="space-y-4">
            <!-- Placeholder items -->
            <div class="text-center text-gray-500 py-4">
                <p>Recent property or maintenance activity will appear here.</p>
            </div>
        </div>
    </div>
    <!-- Maintenance Requests - Updated with Real Count -->
    <div class="dashboard-card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Maintenance Requests</h3>
            {{-- Temporarily remove the link or link to a known page --}}
            {{-- <a href="{{ route('properties.index') }}" class="text-sm text-gray-500 hover:text-gray-700">See All</a> --}}
        </div>
        <div class="space-y-4">
             {{-- Show the real count --}}
            <div class="text-center py-4">
                <p class="text-lg font-semibold text-gray-900">{{ $totalMaintenanceRequests }}</p>
                <p class="text-gray-500">Open Requests</p>
            </div>
            <!-- Placeholder items if you want to list specific recent requests -->
            @if($totalMaintenanceRequests > 0)
            <div class="text-center text-gray-500 text-sm">
                <p>You have {{ $totalMaintenanceRequests }} pending maintenance request(s).</p>
            </div>
            @else
            <div class="text-center text-gray-500 text-sm">
                <p>No open maintenance requests.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // --- Update Sales Chart (Now Property Value by Type) ---
    const salesCtx = document.getElementById('salesChart').getContext('2d');
    // Find the index of the bar with the maximum value to highlight it
    let maxIndex = -1;
    let maxValue = -Infinity;
    // Data passed from Blade
    const chartValues = @json($chartValues);
    chartValues.forEach((value, index) => {
        if (value > maxValue) {
            maxValue = value;
            maxIndex = index;
        }
    });

    // Create background colors, highlighting the max
    const backgroundColors = chartValues.map((_, index) =>
        index === maxIndex ? '#059669' : '#e5e7eb' // Highlight max value bar
    );

    new Chart(salesCtx, {
        type: 'bar',
        data: {
            // Use labels passed from the controller
            labels: @json($chartLabels),
            datasets: [{
                // Use values passed from the controller
                data: chartValues,
                backgroundColor: backgroundColors,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1f2937',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#374151',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            // Format the tooltip value as currency
                            let value = context.parsed.y;
                            return '$' + value.toLocaleString(undefined, {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });
                        },
                        // Optional: Add count to tooltip
                        // afterLabel: function(context) {
                        //     const index = context.dataIndex;
                        //     const count = @json($chartCounts)[index] || 0;
                        //     return `(${count} properties)`;
                        // }
                    }
                },
                // Add title plugin to show chart title on canvas if desired
                // title: {
                //     display: true,
                //     text: 'Property Value by Type'
                // }
            },
            scales: {
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 12
                        }
                    }
                },
                y: {
                    grid: {
                        color: '#f3f4f6',
                        borderDash: [2, 2]
                    },
                    ticks: {
                        color: '#6b7280',
                        font: {
                            size: 12
                        },
                        // Format Y-axis ticks as currency (e.g., $50k)
                        callback: function(value) {
                             if (value >= 1000000) {
                                return '$' + (value / 1000000).toFixed(1) + 'M';
                            } else if (value >= 1000) {
                                return '$' + (value / 1000).toFixed(0) + 'k';
                            } else {
                                return '$' + value;
                            }
                        }
                    }
                }
            }
        }
    });

    // --- Update Cost Breakdown Chart (Now Properties by Type) ---
    const costCtx = document.getElementById('costChart').getContext('2d');
    new Chart(costCtx, {
        type: 'doughnut',
        data: {
            // Use labels and values passed from the controller
            labels: @json($doughnutLabels),
            datasets: [{
                data: @json($doughnutValues),
                backgroundColor: ['#6ee7b7', '#fcd34d', '#93c5fd', '#c4b5fd', '#f87171'], // Add more colors if needed
                borderWidth: 0,
                cutout: '70%' // Creates the "donut" hole
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false // We are managing the legend manually below the chart
                },
                tooltip: {
                     backgroundColor: '#1f2937',
                    titleColor: '#ffffff',
                    bodyColor: '#ffffff',
                    borderColor: '#374151',
                    borderWidth: 1,
                    cornerRadius: 8,
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed || 0;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = total > 0 ? Math.round((value / total) * 100) : 0;
                            return `${label}: ${value} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>
@endsection