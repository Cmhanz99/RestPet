<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/owner.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
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
            <a href="#" class="nav-item active">
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
            <a href="/analytics" class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </nav>

        <div onclick="logout()" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="header">
            <div class="header-title">
                <h1>Dashboard Overview</h1>
                <p>Welcome back! Here's the summary of your memorial gardens</p>
            </div>
            <div class="header-actions">
                <div class="search-container">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Search...">
                </div>
                <div class="notification">
                    <i class="fas fa-bell"></i>
                    <span class="notification-dot"></span>
                </div>
                <div class="user-menu">
                    <div class="user-avatar" style="background-image: url({{ asset('profile/' . $user->profile) }});">
                    </div>
                </div>
            </div>
        </header>

        <div class="dashboard-content">
            <!-- Stats Cards - These will remain visible and not scroll -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-paw"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Memorials</h3>
                        <p class="stat-value green-text">
                            {{ App\Models\Lots::where('owner_id', $user->id)->where('status', 'active')->count() }}</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-monument"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Gardens</h3>
                        <p class="stat-value blue-text">{{ App\Models\Lots::where('owner_id', $user->id)->count() }}</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-coins"></i>
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
                        <p class="stat-value purple-text">₱ {{ number_format($totalRevenue, 2) }}</p>
                    </div>
                </div>
            </div>

            <!-- Properties Section -->
            <div class="section-header">
                <h2>Memorial Gardens</h2>
                <a href="/addProperty" class="add-property-btn">
                    <i class="fas fa-plus"></i>
                    <span>Add Garden</span>
                </a>
            </div>

            <!-- Added properties-container for scrolling -->
            <div class="properties-container">
                <div class="properties-grid">
                    @foreach ($properties as $lots)
                        <!-- Garden Card -->
                        <div class="property-card">
                            <div class="property-image">
                                <img src="{{ asset('lots/' . $lots->image) }}" alt="{{ $lots->title }}">
                                <div class="property-badge">{{ $lots->status }}</div>
                            </div>
                            <div class="property-details">
                                <div class="property-header">
                                    <div>
                                        <h3>{{ $lots->title }}</h3>
                                        <p class="property-type">Outdoor Garden</p>
                                    </div>
                                    <div class="property-actions">
                                        <button onclick="editLot({{ $lots->id }})"><i
                                                class="fas fa-edit"></i></button>
                                        <button onclick="deleteLot({{ $lots->id }})"><i
                                                class="fas fa-trash"></i></button>
                                        <button><i class="fas fa-ellipsis-h"></i></button>
                                    </div>
                                </div>

                                <div class="property-pricing">
                                    <span class="price">₱ {{ number_format($lots->price) }}</span>
                                    <span class="area"><i class="fas fa-ruler-combined"></i> {{ $lots->size }} sq
                                        ft</span>
                                </div>

                                <div class="property-features">
                                    <div class="feature">
                                        <i class="fas fa-user"></i>
                                        <span>{{ $lots->owner->name }}</span>
                                    </div>
                                    <div class="feature">
                                        <i class="fas fa-check-square"></i>
                                        <span>{{ $lots->marker }}</span>
                                    </div>
                                    <div class="feature">
                                        <i class="fas fa-bone"></i>
                                        <span>Slots {{ $lots->slots }}</span>
                                    </div>
                                    <div class="feature">
                                        <i class="fas fa-arrow-up-right-from-square"></i>
                                        <span>{{ $lots->type }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <!-- Messages Sidebar -->
    <div class="messages-sidebar">
        <div class="messages-header">
            <h3>Messages</h3>
        </div>

        <div class="message-contacts">
            @foreach ($groupedMessages as $messageGroup)
                <div class="contact"
                    onclick="showGroupedMessages('{{ $messageGroup['name'] }}', {{ json_encode($messageGroup['messages']) }})">
                    <div class="contact-avatar" style="background-image: url('{{asset ('user-profile/' . $messageGroup['image'])}}')"></div>
                    <div class="contact-info">
                        <p class="contact-name">{{ $messageGroup['name'] }}</p>
                        <small>{{ count($messageGroup['messages']) }} messages</small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Message Dialog -->
    <div class="overlay" id="overlay"></div>
    <div class="message-dialog" id="messageDialog">
        <div class="message-dialog-header">
            <h3 id="dialogName"></h3>
            <span class="message-dialog-close" onclick="closeMessage()">&times;</span>
        </div>
        <div class="message-dialog-content">
            <div id="dialogMessages"></div>
        </div>
    </div>

    <script>
        function deleteLot(id) {
            if (confirm('Are you sure to delete this lot?')) {
                window.location.href = '/delete/' + id;
            }
        }

        function editLot(id) {
            window.location.href = '/editLot/' + id;
        }

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

        function showMessage(name, message) {
            document.getElementById('dialogName').innerText = name;
            document.getElementById('dialogMessage').innerText = message;
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('messageDialog').style.display = 'block';
        }

        function showGroupedMessages(name, messages) {
            document.getElementById('dialogName').innerText = name;
            const messagesContainer = document.getElementById('dialogMessages');
            messagesContainer.innerHTML = ''; // Clear previous messages

            messages.forEach(message => {
                const messageElement = document.createElement('p');
                messageElement.className = 'message-item';
                messageElement.style.borderBottom = '1px solid #eee';
                messageElement.style.padding = '10px 0';
                messageElement.style.margin = '5px 0';
                messageElement.textContent = message;
                messagesContainer.appendChild(messageElement);
            });

            document.getElementById('overlay').style.display = 'block';
            document.getElementById('messageDialog').style.display = 'block';
        }

        function closeMessage() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('messageDialog').style.display = 'none';
        }
    </script>
</body>

</html>
