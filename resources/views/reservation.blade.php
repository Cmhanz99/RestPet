<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Management</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{asset ('asset/owner.css')}}">
    <link rel="stylesheet" href="{{asset ('css/reservation.css')}}">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <div class="profile-img" style="background-image: url({{asset ('profile/'.$user->profile)}});"></div>
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
            <a href="/reservation" class="nav-item active">
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

        <div class="logout" onclick="logout()">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="header">
            <div class="header-title">
                <h1>Reservation Management</h1>
                <p>Approve, reject, and manage pet memorial reservations</p>
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
                    <div class="user-avatar" style="background-image: url({{asset ('profile/' . $user->profile)}})"></div>
                </div>
            </div>
        </header>

        <div class="reservation-content">
            <!-- Stats Summary -->
            <div class="stats-container">
                <div class="stat-card">
                    <div class="stat-icon pending">
                        <i class="fas fa-hourglass-half"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Pending Requests</h3>
                        <p class="stat-value">{{App\Models\Pet::where('status','pending')->count()}}</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon approved">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Approved Reservations</h3>
                        <p class="stat-value">{{App\Models\Pet::where('status','approved')->count()}}</p>
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon rejected">
                        <i class="fas fa-times-circle"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Rejected Requests</h3>
                        <p class="stat-value">{{App\Models\Pet::where('status','rejected')->count()}}</p>
                    </div>
                </div>
            </div>

            <!-- Reservation Tab Navigation -->
            <div class="section-header">
                <div class="tabs">
                    <button class="tab-btn active">Pending ({{App\Models\Pet::where('status','pending')->count()}})</button>
                    <button class="tab-btn">Approved ({{App\Models\Pet::where('status','approved')->count()}})</button>
                    <button class="tab-btn">Rejected ({{App\Models\Pet::where('status','rejected')->count()}})</button>
                    <button class="tab-btn">All Reservations ({{App\Models\Pet::count('status')}})</button>
                </div>
                <div class="filter-search">
                    <div class="search-reservation">
                        <i class="fas fa-search"></i>
                        <input type="text" placeholder="Search by pet name, owner, or booking ID...">
                    </div>
                </div>
            </div>
            <!-- Reservations List Container -->
            <div class="reservations-container">
                <!-- Pending Reservation Item 1 -->
                @foreach ($pets as $pet)
                <div class="reservation-item">
                    <div class="pet-image" style="background-image: url('{{asset('pets/' . $pet->image)}}');">
                    </div>
                    <div class="reservation-info">
                        <div class="reservation-header">
                            <h3>{{$pet->name}}</h3>
                            <span class="status-badge pending">{{$pet->status}}</span>
                        </div>
                        <div class="pet-details">
                            <div class="pet-meta"><i class="fas fa-paw"></i> {{$pet->type}} • 2015-2024</div>
                            <div class="pet-meta"><i class="fas fa-user"></i> Owner: {{$pet->bookings->name}}</div>
                            <div class="lot-info"><i class="fas fa-map-marker-alt"></i> Lot • {{$pet->lots->title}}</div>
                            <div class="booking-date"><i class="fas fa-calendar-alt"></i> Requested: {{$pet->date}}</div>
                        </div>
                    </div>
                    <div class="reservation-actions">
                        <button class="action-btn view-btn"><i class="fas fa-eye"></i> View</button>
                        <a href="/approve/{{$pet->id}}" class="action-btn approve-btn"><i class="fas fa-check"></i>{{$pet->status == 'approved' ? 'Approved' : ''}}</a>
                        <a href='/reject/{{$pet->id}}' class="action-btn reject-btn"><i class="fas fa-times"></i> {{$pet->status == 'rejected' ? 'Rejected' : ''}}</a>
                    </div>
                </div>
                @endforeach
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
                    <div class="contact-avatar"></div>
                    <div class="contact-info">
                        <p class="contact-name">{{ $messageGroup['name'] }}</p>
                        <small>{{ count($messageGroup['messages']) }} messages</small>
                    </div>
                </div>
            @endforeach
         </div>
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
                 window.location.href = '/login';
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
        </div>
    </div>
</body>
</html>
<script>
    function logout(){
        if(confirm('Are you sure you want to logout?')){
            window.location.href = "/login";
        }
    }
</script>
