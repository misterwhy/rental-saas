{{-- resources/views/analytics/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">My Property Analytics</h1>
    <p class="text-gray-600 mt-1">Insights into your property portfolio.</p>
</div>

<!-- Summary Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
    <div class="dashboard-card">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($totalProperties) }}</div>
                <div class="text-sm text-gray-500">Total Properties</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                 <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">{{ number_format($totalUnits) }}</div>
                <div class="text-sm text-gray-500">Total Units</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-purple-100 rounded-lg flex items-center justify-center mr-3">
                 <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">${{ number_format($totalPortfolioValue ?? 0, 2) }}</div>
                <div class="text-sm text-gray-500">Portfolio Value</div>
            </div>
        </div>
    </div>
    <div class="dashboard-card">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-emerald-100 rounded-lg flex items-center justify-center mr-3">
                 <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 11l3-3m0 0l3 3m-3-3v8m0-13a9 9 0 110 18 9 9 0 010-18z"></path>
                </svg>
            </div>
            <div>
                <div class="text-2xl font-bold text-gray-900">${{ number_format($totalMonthlyIncome ?? 0, 2) }}</div>
                <div class="text-sm text-gray-500">Monthly Income</div>
            </div>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Portfolio Value by Property Type Chart -->
    <div class="dashboard-card">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Portfolio Value by Property Type</h3>
        <div class="relative h-80">
            <canvas id="valueByTypeChart"></canvas>
        </div>
    </div>

    <!-- Property Distribution Chart -->
    <div class="dashboard-card">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Property Distribution</h3>
        <div class="relative h-80">
            <canvas id="countByTypeChart"></canvas>
        </div>
    </div>
</div>

<!-- Additional Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Total Units by Property Type Chart -->
    <div class="dashboard-card">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Total Units by Property Type</h3>
        <div class="relative h-80">
            <canvas id="unitsByTypeChart"></canvas>
        </div>
    </div>

    <!-- Property Profitability Chart -->
    <div class="dashboard-card">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Top Performing Properties</h3>
        <div class="relative h-80">
            <canvas id="profitabilityChart"></canvas>
        </div>
    </div>
</div>

<!-- Property List with Financials -->
<div class="dashboard-card mb-8">
    <h3 class="text-lg font-semibold text-gray-900 mb-6">Property Financial Overview</h3>
    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Property</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Units</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Value</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Monthly Income</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Occupancy</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($propertiesWithFinancials as $property)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">{{ $property->name }}</div>
                        <div class="text-sm text-gray-500">{{ $property->address }}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ ucfirst(str_replace('_', ' ', $property->property_type)) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        {{ $property->number_of_units }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                        ${{ number_format($property->purchase_price ?? 0, 2) }}
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <span class="{{ $property->monthly_income > 0 ? 'text-green-600' : 'text-gray-500' }}">
                            ${{ number_format($property->monthly_income ?? 0, 2) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @if($property->occupancy_rate !== null)
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $property->occupancy_rate > 80 ? 'bg-green-100 text-green-800' : 
                                   ($property->occupancy_rate > 50 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $property->occupancy_rate }}%
                            </span>
                        @else
                            <span class="text-gray-500 text-sm">N/A</span>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        // --- Portfolio Value by Property Type Chart ---
        const valueCtx = document.getElementById('valueByTypeChart').getContext('2d');
        // Find the bar with the maximum value to highlight it
        let maxValueIndex = -1;
        let maxValue = -Infinity;
        const valueData = @json($valueByTypeData);
        valueData.forEach((value, index) => {
            if (value > maxValue) {
                maxValue = value;
                maxValueIndex = index;
            }
        });
        const valueBackgroundColors = valueData.map((_, index) =>
            index === maxValueIndex ? '#059669' : '#e5e7eb'
        );

        new Chart(valueCtx, {
            type: 'bar',
            data: {
                labels: @json($valueByTypeLabels),
                datasets: [{
                    label: 'Total Value ($)',
                    data: valueData,
                    backgroundColor: valueBackgroundColors,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y;
                                return '$' + value.toLocaleString(undefined, {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6b7280' }
                    },
                    y: {
                        grid: { color: '#f3f4f6', borderDash: [2, 2] },
                        ticks: {
                            color: '#6b7280',
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

        // --- Property Distribution Chart ---
        const countCtx = document.getElementById('countByTypeChart').getContext('2d');
        new Chart(countCtx, {
            type: 'doughnut',
            data: {
                labels: @json($countByTypeLabels),
                datasets: [{
                    data: @json($countByTypeData),
                    backgroundColor: ['#6ee7b7', '#fcd34d', '#93c5fd', '#c4b5fd', '#f87171'],
                    borderWidth: 0,
                    cutout: '70%'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                         display: true,
                         position: 'bottom' // Position legend below the chart
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

        // --- Total Units by Property Type Chart ---
         const unitsCtx = document.getElementById('unitsByTypeChart').getContext('2d');
         // Find the bar with the maximum units to highlight it
        let maxUnitsIndex = -1;
        let maxUnits = -Infinity;
        const unitsData = @json($unitsByTypeData);
        unitsData.forEach((units, index) => {
            if (units > maxUnits) {
                maxUnits = units;
                maxUnitsIndex = index;
            }
        });
        const unitsBackgroundColors = unitsData.map((_, index) =>
            index === maxUnitsIndex ? '#3b82f6' : '#bfdbfe' // Blue shades
        );

        new Chart(unitsCtx, {
            type: 'bar',
            data: {
                labels: @json($unitsByTypeLabels),
                datasets: [{
                    label: 'Total Units',
                    data: unitsData,
                    backgroundColor: unitsBackgroundColors,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                         callbacks: {
                            label: function(context) {
                                let value = context.parsed.y;
                                return `${value} unit(s)`;
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6b7280' }
                    },
                    y: {
                        beginAtZero: true, // Start Y axis at 0 for count data
                        grid: { color: '#f3f4f6', borderDash: [2, 2] },
                        ticks: {
                            color: '#6b7280',
                            precision: 0 // Ensure whole numbers for unit counts
                        }
                    }
                }
            }
        });

        // --- Property Profitability Chart ---
        const profitCtx = document.getElementById('profitabilityChart').getContext('2d');
        const profitData = @json($topPropertiesData);
        const profitLabels = @json($topPropertiesLabels);
        
        // Highlight top performing property
        let maxProfitIndex = -1;
        let maxProfit = -Infinity;
        profitData.forEach((profit, index) => {
            if (profit > maxProfit) {
                maxProfit = profit;
                maxProfitIndex = index;
            }
        });
        const profitBackgroundColors = profitData.map((_, index) =>
            index === maxProfitIndex ? '#10b981' : '#a7f3d0'
        );

        new Chart(profitCtx, {
            type: 'bar',
            data: {
                labels: profitLabels,
                datasets: [{
                    label: 'Monthly Income ($)',
                    data: profitData,
                    backgroundColor: profitBackgroundColors,
                    borderRadius: 8,
                    borderSkipped: false,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        backgroundColor: '#1f2937',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#374151',
                        borderWidth: 1,
                        cornerRadius: 8,
                        callbacks: {
                            label: function(context) {
                                let value = context.parsed.y;
                                return '$' + value.toLocaleString(undefined, {
                                    minimumFractionDigits: 2,
                                    maximumFractionDigits: 2
                                });
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        grid: { display: false },
                        ticks: { color: '#6b7280' }
                    },
                    y: {
                        grid: { color: '#f3f4f6', borderDash: [2, 2] },
                        ticks: {
                            color: '#6b7280',
                            callback: function(value) {
                                return '$' + value.toLocaleString();
                            }
                        }
                    }
                }
            }
        });

    });
</script>
@endsection