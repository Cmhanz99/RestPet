<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Analytics Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset ('css/analytics.css')}}">
    <!-- Chart.js CDN for chart visualization -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <div class="profile-img" style="background-image: url({{asset ('profile/'.$user->profile)}});">
            </div>
            <h3>{{$user->name}}</h3>
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
                <div class="stat-info">
                    @php
                    $totalRevenue = App\Models\Payment::whereHas('petPay', function ($query) use ($user) {
                        $query
                            ->where('status', 'approved')
                            ->whereIn('lots_id', function ($subquery) use ($user) {
                                $subquery->select('id')->from('lots')->where('owner_id', $user->id);
                            });
                    })->sum('payment');
                    @endphp
                    <h3>Total Revenue</h3>
                    <div class="value">{{ number_format($totalRevenue, 2) }}</div>
                    <div class="trend positive">
                        <i class="fas fa-arrow-up"></i> +12% vs last period
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon bookings-icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Bookings</h3>
                    <div class="value">
                        {{ App\Models\Pet::whereHas('lots', function ($query) use ($user) {
                            $query->where('owner_id', $user->id);
                        })->count() }}
                    </div>
                    <div class="trend positive">
                        <i class="fas fa-arrow-up"></i> +8% vs last period
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
                        $totalStatuses = App\Models\Status::whereHas('lotsActive', function($query) use ($user) {
                            $query->where('owner_id', $user->id);
                        })->count();

                        // occupied statuses for this owner's lots
                        $occupiedStatuses = App\Models\Status::whereHas('lotsActive', function($query) use ($user) {
                            $query->where('owner_id', $user->id);
                        })->where('status_acitve', 'Occupied')->count();

                        $percentage = $totalStatuses > 0 ? ($occupiedStatuses / $totalStatuses) * 100 : 0;
                    @endphp
                    {{ number_format($percentage) }}%
                    </div>
                    <div class="trend positive">
                        <i class="fas fa-arrow-up"></i> +5% vs last period
                    </div>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon avg-value-icon">
                    <i class="fas fa-peso-sign"></i>
                </div>
                <div class="stat-info">
                    <h3>Avg. Booking Value</h3>
                    <div class="value">₱1,120</div>
                    <div class="trend negative">
                        <i class="fas fa-arrow-down"></i> -2% vs last period
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
    <script src="{{asset ('asset/analytics.js')}}"></script>
</body>
</html>
