@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 flex">

    <!-- Main Content -->
    <div class="flex-1 ml-0  min-h-screen transition-all duration-300 ease-in-out">


        <!-- Dashboard Content -->
        <main class="p-4 md:p-6 max-w-full overflow-x-hidden">
            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- Total Property Card -->
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 min-w-0">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-green-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalProperties) }}</div>
                    <div class="flex items-center text-xs md:text-sm">
                        <span class="px-2 py-1 bg-green-100 text-green-600 rounded-md text-xs font-medium">~20%</span>
                        <span class="text-gray-500 ml-2 truncate">Last month total {{ number_format(max(0, $totalProperties - 50)) }}</span>
                    </div>
                </div>

                <!-- Number of Sales Card -->
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 min-w-0">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">{{ number_format($totalBookings) }}</div>
                    <div class="flex items-center text-xs md:text-sm">
                        <span class="px-2 py-1 bg-red-100 text-red-600 rounded-md text-xs font-medium">~20%</span>
                        <span class="text-gray-500 ml-2 truncate">Last month total {{ number_format(max(0, $totalBookings - 20)) }}</span>
                    </div>
                </div>

                <!-- Total Sales Card -->
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 min-w-0">
                    <div class="flex justify-between items-start mb-4">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-orange-100 rounded-xl flex items-center justify-center mr-4">
                                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                    <div class="text-2xl md:text-3xl font-bold text-gray-900 mb-2">${{ number_format($totalRevenue/1000, 0) }}k</div>
                    <div class="flex items-center text-xs md:text-sm">
                        <span class="px-2 py-1 bg-red-100 text-red-600 rounded-md text-xs font-medium">~20%</span>
                        <span class="text-gray-500 ml-2 truncate">Last month total {{ number_format(max(0, ($totalRevenue - 20000)/1000), 1) }}k</span>
                    </div>
                </div>
            </div>

            <!-- Charts and Tables Row -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-4 md:gap-6 mb-6 md:mb-8">
                <!-- Report Sales Chart -->
                <div class="lg:col-span-2 bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 min-w-0">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Report Sales</h3>
                        <div class="flex items-center space-x-2">
                            <div class="flex items-center space-x-1 bg-gray-100 rounded-lg p-1">
                                <button class="px-3 py-1 text-sm text-white bg-gray-800 rounded-md">Weekday</button>
                            </div>
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="relative h-48 md:h-64 w-full">
                        <canvas id="salesChart" class="w-full h-full"></canvas>
                    </div>
                </div>

                <!-- Cost Breakdown -->
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 min-w-0">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Cost Breakdown</h3>
                        <button class="text-sm text-blue-600 hover:text-blue-700">See Details</button>
                    </div>
                    <div class="relative h-32 md:h-48 flex items-center justify-center">
                        <canvas id="doughnutChart" class="max-w-full max-h-full"></canvas>
                        <div class="absolute inset-0 flex items-center justify-center pointer-events-none">
                            <div class="text-center">
                                <div class="text-lg md:text-2xl font-bold text-gray-900">$ 4,750</div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 space-y-2">
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-green-500 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Maintenance</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-orange-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Repair</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-blue-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Taxes</span>
                        </div>
                        <div class="flex items-center">
                            <div class="w-3 h-3 bg-purple-400 rounded-full mr-2"></div>
                            <span class="text-sm text-gray-600">Saving</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Transactions and Maintenance Row -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 md:gap-6">
                <!-- Last Transactions -->
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 min-w-0">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Last Transactions</h3>
                        <button class="text-sm text-blue-600 hover:text-blue-700">See All</button>
                    </div>
                    <div class="space-y-4">
                        @if($recentTransactions && $recentTransactions->count() > 0)
                            @foreach($recentTransactions as $transaction)
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg mr-3 flex items-center justify-center">
                                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 text-sm md:text-base">{{ Str::limit($transaction->property->title ?? 'Property Booking', 25) }}</div>
                                            <div class="text-xs md:text-sm text-gray-500">{{ $transaction->created_at->format('d M Y, H:i') }}</div>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        <div class="font-bold text-gray-900 text-sm md:text-base">${{ number_format($transaction->total_amount/1000, 0) }}K</div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg mr-3"></div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm md:text-base">123 Maple Avenue Springfield</div>
                                        <div class="text-xs md:text-sm text-gray-500">12 Sep 2024, 9:29</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900 text-sm md:text-base">$30K</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg mr-3"></div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm md:text-base">Booking 987 Villa Street</div>
                                        <div class="text-xs md:text-sm text-gray-500">10 Sep 2024, 9:29</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900 text-sm md:text-base">$10K</div>
                                </div>
                            </div>
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg mr-3"></div>
                                    <div>
                                        <div class="font-medium text-gray-900 text-sm md:text-base">Apartment Booking On Garden Street</div>
                                        <div class="text-xs md:text-sm text-gray-500">8 Sep 2024, 9:29</div>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <div class="font-bold text-gray-900 text-sm md:text-base">$20K</div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Maintenance Requests -->
                <div class="bg-white rounded-2xl p-4 md:p-6 shadow-sm border border-gray-100 min-w-0">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-semibold text-gray-900">Maintenance Requests</h3>
                        <button class="text-sm text-blue-600 hover:text-blue-700">See All</button>
                    </div>
                    <div class="space-y-4">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg mr-3 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-gray-900 text-sm md:text-base">Plumbing | 721 Meadowview</div>
                                    <div class="text-xs md:text-sm text-gray-500">Request ID: MR-001</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs md:text-sm text-gray-600 mr-2 md:mr-3 truncate">Broken Garbage</span>
                                <img class="w-6 h-6 md:w-8 md:h-8 rounded-full flex-shrink-0" src="https://ui-avatars.com/api/?name=Jacob+Jones&background=3b82f6&color=fff" alt="Jacob Jones">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-yellow-100 rounded-lg mr-3 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-gray-900 text-sm md:text-base">Electrical | 721 Meadowview</div>
                                    <div class="text-xs md:text-sm text-gray-500">Request ID: MR-001</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs md:text-sm text-gray-600 mr-2 md:mr-3 truncate">No Heat Bathroom</span>
                                <img class="w-6 h-6 md:w-8 md:h-8 rounded-full flex-shrink-0" src="https://ui-avatars.com/api/?name=Albert+Flores&background=10b981&color=fff" alt="Albert Flores">
                            </div>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-green-100 rounded-lg mr-3 flex items-center justify-center">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-medium text-gray-900 text-sm md:text-base">HVAC | 721 Meadowview</div>
                                    <div class="text-xs md:text-sm text-gray-500">Request ID: MR-001</div>
                                </div>
                            </div>
                            <div class="flex items-center">
                                <span class="text-xs md:text-sm text-gray-600 mr-2 md:mr-3 truncate">Non Functional Fan</span>
                                <img class="w-6 h-6 md:w-8 md:h-8 rounded-full flex-shrink-0" src="https://ui-avatars.com/api/?name=Robert+Fox&background=8b5cf6&color=fff" alt="Robert Fox">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<!-- Chart.js Scripts -->
<script>
// Mobile menu functionality
document.addEventListener('DOMContentLoaded', function() {
    const mobileMenuButton = document.querySelector('.md\\:hidden button');
    const sidebar = document.getElementById('sidebar');
    
    if (mobileMenuButton && sidebar) {
        mobileMenuButton.addEventListener('click', function() {
            sidebar.classList.toggle('-translate-x-full');
        });
        
        // Close sidebar when clicking outside
        document.addEventListener('click', function(event) {
            if (!sidebar.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                sidebar.classList.add('-translate-x-full');
            }
        });
    }
});

// Sales Chart
const salesCtx = document.getElementById('salesChart');
if (salesCtx) {
    const salesChart = new Chart(salesCtx.getContext('2d'), {
        type: 'bar',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                data: [3000, 3200, 3800, 4000, 3600, 3400, 3700],
                backgroundColor: function(context) {
                    return context.dataIndex === 3 ? '#10b981' : '#e5e7eb';
                },
                borderRadius: 8,
                barThickness: 40
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        display: false
                    },
                    ticks: {
                        callback: function(value) {
                            return '$' + (value / 1000) + 'k';
                        }
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
}

// Doughnut Chart
const doughnutCtx = document.getElementById('doughnutChart');
if (doughnutCtx) {
    const doughnutChart = new Chart(doughnutCtx.getContext('2d'), {
        type: 'doughnut',
        data: {
            datasets: [{
                data: [35, 25, 25, 15],
                backgroundColor: ['#10b981', '#f59e0b', '#3b82f6', '#8b5cf6'],
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
                }
            }
        }
    });
}
</script>
@endsection