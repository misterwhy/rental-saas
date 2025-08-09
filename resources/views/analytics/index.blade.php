{{-- resources/views/analytics/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h1 class="text-2xl font-bold text-gray-900">My Property Analytics</h1>
    <p class="text-gray-600 mt-1">Insights into your property portfolio.</p>
</div>

<!-- Summary Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
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

    <!-- Placeholder for Future Analytics -->
    <div class="dashboard-card">
        <h3 class="text-lg font-semibold text-gray-900 mb-6">Upcoming Expirations</h3>
        <div class="flex items-center justify-center h-80 text-gray-500">
            <p>Chart showing lease expirations or maintenance due dates could go here.</p>
        </div>
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
             {
                labels: @json($valueByTypeLabels),
                datasets: [{
                    label: 'Total Value ($)',
                     valueData,
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
             {
                labels: @json($countByTypeLabels),
                datasets: [{
                     @json($countByTypeData),
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
             {
                labels: @json($unitsByTypeLabels),
                datasets: [{
                    label: 'Total Units',
                     unitsData,
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

    });
</script>
@endsection