<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/analytics.css') }}">
    <link rel="icon" href="{{ asset('logo/logo1.png') }}">
    <!-- Chart.js CDN for chart visualization -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <div class="profile-img" style="background-image: url({{ asset('profile/' . $user->profile) }});">
            </div>
            <h3>{{ $user->name }}</h3>
            <p>Garden Manager</p>
        </div>

        <nav class="nav-menu">
            <a href="/dashboard" class="nav-item">
                <i class="fas fa-home"></i>
                <span>Dashboard</span>
            </a>
            <a href="/memorial" class="nav-item">
                <i class="fas fa-monument"></i>
                <span>Memorial Gardens</span>
            </a>
            <a href="/reservation" class="nav-item">
                <i class="fas fa-calendar"></i>
                <span>Reservations</span>
            </a>
            <a href="/setting" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Setting</span>
            </a>
            <a href="/analytics" class="nav-item active">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </nav>

        <div class="logout" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Header -->
        <div class="header">
            <div>
                <h1>Analytics Dashboard</h1>
                <p>Performance metrics and insights for your properties</p>
            </div>
            <button class="export-btn">
                <i class="fas fa-download"></i>
                Export Report
            </button>
        </div>

        <!-- Filter Section -->
        <div class="filter-section">
            <form class="filter-form">
                <div class="filter-group">
                    <label for="time-period">Time Period:</label>
                    <select id="time-period" name="time-period">
                        <option value="last30days">Last 30 days</option>
                        <option value="last90days">Last 90 days</option>
                        <option value="thisyear">This year</option>
                        <option value="custom">Custom range</option>
                    </select>
                </div>
                <div class="filter-group">
                    <label for="date-from">From:</label>
                    <input type="date" id="date-from" name="date-from" value="2025-03-21">
                </div>
                <div class="filter-group">
                    <label for="date-to">To:</label>
                    <input type="date" id="date-to" name="date-to" value="2025-04-20">
                </div>
                <button type="button" class="apply-btn">Apply</button>
            </form>
        </div>

        <!-- Stats Cards -->
        <div class="stats-container">
            <div class="stat-card">
                <div class="stat-icon revenue-icon">
                    <i class="fas fa-peso-sign"></i>
                </div>
                @php
                    // get total revenue for this owner
                    $totalRevenue = App\Models\Payment::whereHas('petPay', function ($query) use ($user) {
                        $query->where('status', 'approved')->whereIn('lots_id', function ($subquery) use ($user) {
                            $subquery->select('id')->from('lots')->where('owner_id', $user->id);
                        });
                    })->sum('payment');

                    // set your target revenue for now (example: ₱50000)
                    $targetRevenue = 50000;

                    // compute the trend percentage
                    $trendRevenue = $targetRevenue > 0
                        ? (($totalRevenue - $targetRevenue) / $targetRevenue) * 100
                        : 0;
                @endphp
                <div class="stat-info">
                    <h3>Total Revenue</h3>
                    <div class="value">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="trend {{ $trendRevenue >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $trendRevenue >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format($trendRevenue, 2) }}% vs target
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bookings-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                  @php
                    // current total bookings for this owner
                    $totalBookings = App\Models\Pet::whereHas('lots', function ($query) use ($user) {
                        $query->where('owner_id', $user->id);
                    })->count();

                    // set your target bookings for now (example: 20 bookings)
                    $targetBookings = 20;

                    // compute the trend percentage
                    $trendBookings = $targetBookings > 0
                        ? (($totalBookings - $targetBookings) / $targetBookings) * 100
                        : 0;
                    @endphp
                <div class="stat-info">
                    <h3>Bookings</h3>
                    <div class="value">{{ $totalBookings }}</div>
                    <div class="trend {{ $trendBookings >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $trendBookings >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format($trendBookings, 2) }}% vs target
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon occupancy-icon">
                    <i class="fas fa-percentage"></i>
                </div>
                <div class="stat-info">
                    <h3>Occupancy Rate</h3>
                    <div class="value">
                        @php
                            $ownerId = session('owner_id');
                            $user = App\Models\Owner::find($ownerId);

                            // total statuses for this owner's lots
                            $totalStatuses = App\Models\Status::whereHas('lotsActive', function ($query) use ($user) {
                                $query->where('owner_id', $user->id);
                            })->count();

                            // occupied statuses for this owner's lots
                            $occupiedStatuses = App\Models\Status::whereHas('lotsActive', function ($query) use ($user) {
                                $query->where('owner_id', $user->id);
                            })->where('status_acitve', 'Occupied')->count();

                            // occupancy percentage
                            $percentage = $totalStatuses > 0 ? ($occupiedStatuses / $totalStatuses) * 100 : 0;

                            // let's say your target occupancy is 60%
                            $targetOccupancy = 60;

                            // compute the trend percentage (difference)
                            $trendPercentage = $targetOccupancy > 0
                                ? (($percentage - $targetOccupancy) / $targetOccupancy) * 100
                                : 0;
                        @endphp

                        {{ number_format($percentage) }}%
                    </div>
                    <div class="trend {{ $trendPercentage >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $trendPercentage >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format($trendPercentage, 2) }}% vs target
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon avg-value-icon">
                    <i class="fas fa-peso-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>Avg. Booking Value</h3>
                    @php
                        $totalRevenue = App\Models\Payment::whereHas('petPay', function ($query) use ($user) {
                            $query->where('status', 'approved')
                                ->whereIn('lots_id', function ($subquery) use ($user) {
                                    $subquery->select('id')->from('lots')->where('owner_id', $user->id);
                                });
                        })->sum('payment');

                        // let’s say your target is ₱50,000
                        $targetRevenue = 50000;

                        // compute percentage
                        $percentageChange = $targetRevenue > 0
                            ? (($totalRevenue - $targetRevenue) / $targetRevenue) * 100
                            : 0;
                    @endphp
                    <div class="value">₱{{ number_format($totalRevenue, 2) }}</div>
                    <div class="trend {{ $percentageChange >= 0 ? 'positive' : 'negative' }}">
                        <i class="fas fa-arrow-{{ $percentageChange >= 0 ? 'up' : 'down' }}"></i>
                        {{ number_format($percentageChange, 2) }}% vs ₱{{ number_format($targetRevenue) }}
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-container">
            <div class="chart-card">
                <div class="chart-header">
                    <h2>Revenue & Bookings</h2>
                    <div class="chart-tabs" data-chart="revenue-chart">
                        <div class="chart-tab active" data-period="week">Week</div>
                        <div class="chart-tab" data-period="month">Month</div>
                        <div class="chart-tab" data-period="quarter">Quarter</div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="revenue-chart"></canvas>
                </div>
            </div>
            <div class="chart-card">
                <div class="chart-header">
                    <h2>Property Distribution</h2>
                    <div class="chart-tabs" data-chart="distribution-chart">
                        <div class="chart-tab active" data-type="revenue">Revenue</div>
                        <div class="chart-tab" data-type="bookings">Bookings</div>
                    </div>
                </div>
                <div class="chart-container">
                    <canvas id="distribution-chart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript -->
    <script src="{{ asset('asset/analytics.js') }}"></script>
    <script>
        function logout() {
            Swal.fire({
                title: 'Are you sure?',
                text: "You will be logged out!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, logout!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/login';
                }
            });
        }
    </script>
</body>

</html>
