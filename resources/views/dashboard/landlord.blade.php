@extends('layouts.app')

@section('content')
<!-- Stats Cards -->
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
                <span class="text-gray-600 font-medium">Total Property</span>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
        <div class="text-3xl font-bold text-gray-900 mb-2">1,500</div>
        <div class="flex items-center text-sm">
            <span class="metric-badge positive">~20%</span>
            <span class="text-gray-500 ml-2">Last month total 1,050</span>
        </div>
    </div>

    <!-- Number of Sales Card -->
    <div class="dashboard-card">
        <div class="flex justify-between items-start mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <span class="text-gray-600 font-medium">Number of Sales</span>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
        <div class="text-3xl font-bold text-gray-900 mb-2">320</div>
        <div class="flex items-center text-sm">
            <span class="metric-badge negative">~20%</span>
            <span class="text-gray-500 ml-2">Last month total 950</span>
        </div>
    </div>

    <!-- Total Sales Card -->
    <div class="dashboard-card">
        <div class="flex justify-between items-start mb-4">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-orange-100 rounded-lg flex items-center justify-center mr-3">
                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <span class="text-gray-600 font-medium">Total Sales</span>
            </div>
            <button class="text-gray-400 hover:text-gray-600">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                </svg>
            </button>
        </div>
        <div class="text-3xl font-bold text-gray-900 mb-2">$150k</div>
        <div class="flex items-center text-sm">
            <span class="metric-badge negative">~20%</span>
            <span class="text-gray-500 ml-2">Last month total 1.500</span>
        </div>
    </div>
</div>

<!-- Charts Row -->
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Report Sales Chart -->
    <div class="lg:col-span-2 dashboard-card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Report Sales</h3>
            <div class="flex items-center space-x-2">
                <div class="flex items-center space-x-1 bg-gray-100 rounded-lg p-1">
                    <button class="px-3 py-1 text-sm text-gray-600 hover:bg-white rounded-md transition-colors">Weekday</button>
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

    <!-- Cost Breakdown -->
    <div class="dashboard-card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Cost Breakdown</h3>
            <button class="text-sm text-gray-500 hover:text-gray-700">See Details</button>
        </div>
        <div class="flex justify-center mb-6">
            <div class="relative w-40 h-40">
                <canvas id="costChart" width="160" height="160"></canvas>
                <div class="absolute inset-0 flex items-center justify-center">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">$ 4,750</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-green-400 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">Maintenance</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-orange-300 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">Repair</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-blue-300 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">Taxes</span>
                </div>
            </div>
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-3 h-3 bg-purple-300 rounded-full mr-2"></div>
                    <span class="text-sm text-gray-600">Saving</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bottom Row -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <!-- Last Transactions -->
    <div class="dashboard-card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Last Transactions</h3>
            <button class="text-sm text-gray-500 hover:text-gray-700">See All</button>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?w=48&h=48&fit=crop&auto=format" alt="Property" class="w-12 h-12 rounded-lg object-cover mr-3">
                    <div>
                        <div class="font-medium text-gray-900">123 Maple Avenue Springfield</div>
                        <div class="text-sm text-gray-500">12 Sep 2024, 9:29</div>
                    </div>
                </div>
                <div class="text-lg font-semibold text-gray-900">$30K</div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=48&h=48&fit=crop&auto=format" alt="Property" class="w-12 h-12 rounded-lg object-cover mr-3">
                    <div>
                        <div class="font-medium text-gray-900">Booking 987 Villa Street</div>
                        <div class="text-sm text-gray-500">10 Sep 2024, 9:29</div>
                    </div>
                </div>
                <div class="text-lg font-semibold text-gray-900">$10K</div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=48&h=48&fit=crop&auto=format" alt="Property" class="w-12 h-12 rounded-lg object-cover mr-3">
                    <div>
                        <div class="font-medium text-gray-900">Apartment Booking On Garden Street</div>
                        <div class="text-sm text-gray-500">8 Sep 2024, 10:15</div>
                    </div>
                </div>
                <div class="text-lg font-semibold text-gray-900">$20K</div>
            </div>
        </div>
    </div>

    <!-- Maintenance Requests -->
    <div class="dashboard-card">
        <div class="flex justify-between items-center mb-6">
            <h3 class="text-lg font-semibold text-gray-900">Maintenance Requests</h3>
            <button class="text-sm text-gray-500 hover:text-gray-700">See All</button>
        </div>
        <div class="space-y-4">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-blue-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Plumbing | 721 Meadowview</div>
                        <div class="text-sm text-gray-500">Request ID: MR-001</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="text-sm text-gray-900 mr-3">Broken Garbage</div>
                    <img src="https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?w=32&h=32&fit=crop&crop=face&auto=format" alt="Jacob Jones" class="w-8 h-8 rounded-full">
                    <div class="ml-2 text-sm font-medium text-gray-900">Jacob Jones</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-yellow-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">Electrical | 721 Meadowview</div>
                        <div class="text-sm text-gray-500">Request ID: MR-001</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="text-sm text-gray-900 mr-3">No Heat Bathroom</div>
                    <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?w=32&h=32&fit=crop&crop=face&auto=format" alt="Albert Flores" class="w-8 h-8 rounded-full">
                    <div class="ml-2 text-sm font-medium text-gray-900">Albert Flores</div>
                </div>
            </div>
            
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <div class="w-10 h-10 bg-green-100 rounded-lg flex items-center justify-center mr-3">
                        <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 18.657A8 8 0 016.343 7.343S7 9 9 10c0-2 .5-5 2.986-7C14 5 16.09 5.777 17.656 7.343A7.975 7.975 0 0120 13a7.975 7.975 0 01-2.343 5.657z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.879 16.121A3 3 0 1012.015 11L11 14H9c0 .768.293 1.536.879 2.121z"></path>
                        </svg>
                    </div>
                    <div>
                        <div class="font-medium text-gray-900">HVAC | 721 Meadowview</div>
                        <div class="text-sm text-gray-500">Request ID: MR-001</div>
                    </div>
                </div>
                <div class="flex items-center">
                    <div class="text-sm text-gray-900 mr-3">Non Functional Fan</div>
                    <img src="https://images.unsplash.com/photo-1494790108755-2616b612b786?w=32&h=32&fit=crop&crop=face&auto=format" alt="Robert Fox" class="w-8 h-8 rounded-full">
                    <div class="ml-2 text-sm font-medium text-gray-900">Robert Fox</div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Sales Chart
const salesCtx = document.getElementById('salesChart').getContext('2d');
new Chart(salesCtx, {
    type: 'bar',
    data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [{
            data: [3000, 3500, 3200, 4500, 3000, 3200, 3800],
            backgroundColor: ['#e5e7eb', '#e5e7eb', '#e5e7eb', '#059669', '#e5e7eb', '#e5e7eb', '#e5e7eb'],
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
                        return '$' + context.parsed.y.toLocaleString();
                    }
                }
            }
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
                    callback: function(value) {
                        return '$' + (value / 1000) + 'k';
                    }
                }
            }
        }
    }
});

// Cost Breakdown Chart
const costCtx = document.getElementById('costChart').getContext('2d');
new Chart(costCtx, {
    type: 'doughnut',
    data: {
        datasets: [{
            data: [45, 25, 20, 10],
            backgroundColor: ['#6ee7b7', '#fcd34d', '#93c5fd', '#c4b5fd'],
            borderWidth: 0,
            cutout: '70%'
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
                enabled: false
            }
        }
    }
});
</script>
@endsection