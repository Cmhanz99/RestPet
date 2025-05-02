<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetRest - Booking History</title>
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Simple Booking History Styles */
        .booking-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .booking-header {
            margin-bottom: 30px;
        }

        .booking-header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .booking-header p {
            color: #666;
        }

        .booking-filters {
            display: flex;
            margin-bottom: 20px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .filter-button {
            background: none;
            border: none;
            padding: 8px 15px;
            margin-right: 10px;
            border-radius: 20px;
            cursor: pointer;
            font-size: 14px;
            color: #555;
        }

        .filter-button.active {
            background-color: #2196F3;
            color: white;
        }

        .booking-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .booking-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            display: flex;
            align-items: center;
        }

        .pet-image {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            overflow: hidden;
            margin-right: 20px;
        }

        .pet-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .booking-info {
            flex: 1;
        }

        .booking-info-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 10px;
        }

        .pet-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
        }

        .booking-status {
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            margin-right: 10px;
            font-weight: 500;
            transform: translateY(115%);
        }

        .status-approved {
            background-color: #e6f7ed;
            color: #10b981;
        }

        .status-pending {
            background-color: #fff7e6;
            color: #f59e0b;
        }

        .status-rejected {
            background-color: #fee2e2;
            color: #ef4444;
        }

        .booking-details {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
            margin-bottom: 8px;
        }

        .booking-detail {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 14px;
            color: #555;
        }

        .booking-date {
            font-size: 13px;
            color: #777;
        }

        .view-details {
            margin-left: auto;
            background: none;
            border: 1px solid #2196F3;
            color: #2196F3;
            padding: 6px 15px;
            border-radius: 4px;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .view-details:hover {
            background-color: #2196F3;
            color: white;
        }

        @media (max-width: 768px) {
            .booking-card {
                flex-direction: column;
                align-items: flex-start;
            }

            .pet-image {
                margin-bottom: 15px;
            }

            .view-details {
                margin-left: 0;
                margin-top: 15px;
                align-self: flex-end;
            }
        }

        .user-profile {
            display: flex;
            align-items: center;
            position: relative;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: #3b82f6;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 10px;
            font-weight: bold;
        }

        .user-name {
            font-size: 16px;
            color: #4b5563;
            cursor: pointer;
            display: flex;
            align-items: center;
        }

        .user-name i {
            margin-left: 5px;
        }

        .user-dropdown {
            position: absolute;
            top: 50px;
            right: 0;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            padding: 10px 0;
            min-width: 180px;
            z-index: 1001;
            display: none;
        }

        .user-dropdown a {
            display: block;
            padding: 10px 20px;
            color: #4b5563;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .user-dropdown a:hover {
            background-color: #f3f4f6;
        }

        .user-dropdown a.logout {
            color: #ef4444;
            border-top: 1px solid #e5e7eb;
            margin-top: 5px;
        }

        .user-profile:hover .user-dropdown {
            display: block;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 1000;
        }

        .modal-content {
            position: relative;
            background-color: #fff;
            margin: 50px auto;
            padding: 30px;
            width: 90%;
            max-width: 600px;
            border-radius: 12px;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
        }

        .close-modal {
            position: absolute;
            right: 20px;
            top: 20px;
            font-size: 24px;
            cursor: pointer;
            color: #666;
            transition: color 0.3s ease;
        }

        .close-modal:hover {
            color: #333;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .modal-pet-image {
            width: 50%;
            margin-bottom: 20px;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .modal-pet-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            display: block;
        }

        #modal-pet-name {
            font-size: 24px;
            color: #333;
            margin: 0 0 10px;
        }

        .modal-body p {
            margin: 8px 0;
            color: #666;
            font-size: 16px;
            width: 100%;
            text-align: left;
            padding: 0 20px;
        }

        .modal-body p span {
            color: #333;
            font-weight: 500;
            margin-left: 5px;
        }

        #modal-booking-status {
            margin: 10px 0 20px;
            display: inline-block;
        }

        @media (max-width: 768px) {
            .modal-content {
                margin: 20px;
                padding: 20px;
            }

            .modal-pet-image {
                width: 70%;
            }

            .modal-body p {
                padding: 0;
            }
        }
    </style>
</head>

<body>
    <header>
        <a href="/" class="logo">Pet Rest</a>
        <nav>
            <ul class="nav-links">
                <li><a href="/user">Home</a></li>
                <li><a href="/#li">Listing</a></li>
                <li><a href="/#ma">Map</a></li>
                <li><a href="/#con">Contact</a></li>
            </ul>
        </nav>
        <div class="user-profile">
            <div class="user-name">
                {{ $user->name }} <i class="fas fa-chevron-down"></i>
            </div>
            <div class="user-dropdown">
                <a href="/userProfile"><i class="fas fa-user-circle"></i> My Profile</a>
                <a href="/favorites"><i class="fas fa-heart"></i> My Favorites</a>
                <a href="/bookingHistory" class="active"><i class="fas fa-history"></i> Booking History</a>
                <a href=""><i class="fas fa-cog"></i> Settings</a>
                <a href="/loginUser" class="logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        <div class="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </header>

    <div class="booking-container">
        <div class="booking-header">
            <h1>My Pet Memorial Reservations</h1>
            <p>View and manage your memorial garden reservations</p>
        </div>

        <div class="booking-filters">
            <button class="filter-button active" data-filter="all">All Reservations</button>
            <button class="filter-button" data-filter="approved">Approved</button>
            <button class="filter-button" data-filter="pending">Pending</button>
            <button class="filter-button" data-filter="rejected">Rejected</button>
        </div>

        <div class="booking-list">
            <!-- Approved Booking - Chase -->
            @foreach ($pets as $pet)
                <div class="booking-card" data-status="{{ $pet->status }}">
                    <div class="pet-image">
                        <img src="{{ asset('pets/' . $pet->image) }}" alt="Chase">
                    </div>
                    <div class="booking-info">
                        <div class="booking-info-header">
                            <h3 class="pet-name">{{ $pet->name }}</h3>
                            <span class="booking-status status-approved">{{ $pet->status }}</span>
                        </div>
                        <div class="booking-details">
                            <div class="booking-detail">
                                <i class="fas fa-paw"></i>
                                <span>{{ $pet->type }} • {{ $pet->death_year }}</span>
                            </div>
                            <div class="booking-detail">
                                <i class="fas fa-map-marker-alt"></i>
                                <span>{{ $pet->lots->title }} • Lot A7</span>
                            </div>
                        </div>
                        <div class="booking-date">
                            <i class="far fa-calendar-alt"></i>
                            <span>Requested: {{ \Carbon\Carbon::parse($pet->date)->format('Y-F-D') }}</span>
                        </div>
                    </div>
                    <button class="view-details">View Details</button>
                </div>
            @endforeach
        </div>
    </div>

    <div id="booking-details-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-body">
                <div class="modal-pet-image">
                    <img id="modal-pet-image" src="" alt="Pet Image">
                </div>
                <h2 id="modal-pet-name"></h2>
                <span id="modal-booking-status" class="booking-status"></span>
                <p>Type: <span id="modal-pet-type"></span></p>
                <p>Death Year: <span id="modal-death-year"></span></p>
                <p>Location: <span id="modal-location"></span></p>
                <p>Booking Date: <span id="modal-booking-date"></span></p>
            </div>
        </div>
    </div>

    <script>
        // Simple dropdown toggle for user menu
        document.addEventListener('DOMContentLoaded', function() {
            // User dropdown toggle
            const userProfile = document.querySelector('.user-profile');
            const userDropdown = document.querySelector('.user-dropdown');

            userProfile.addEventListener('click', function(e) {
                e.stopPropagation();
                userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
            });

            // Close dropdown when clicking elsewhere
            document.addEventListener('click', function() {
                userDropdown.style.display = 'none';
            });

            // Simple filter functionality
            const filterButtons = document.querySelectorAll('.filter-button');
            const bookingCards = document.querySelectorAll('.booking-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Get filter value
                    const filter = this.getAttribute('data-filter');

                    // Show/hide booking cards based on filter
                    bookingCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-status') ===
                            filter) {
                            card.style.display = 'flex';
                        } else {
                            card.style.display = 'none';
                        }
                    });
                });
            });

            // Simple view details functionality
            const viewDetailsButtons = document.querySelectorAll('.view-details');

            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const bookingCard = this.closest('.booking-card');
                    const modal = document.getElementById('booking-details-modal');

                    // Get all the data from the booking card
                    const petImage = bookingCard.querySelector('.pet-image img').src;
                    const petName = bookingCard.querySelector('.pet-name').textContent;
                    const status = bookingCard.querySelector('.booking-status').textContent;
                    const petInfo = bookingCard.querySelector('.booking-detail:first-child span')
                        .textContent;
                    const [petType, deathYear] = petInfo.split(' • ');
                    const locationInfo = bookingCard.querySelector(
                        '.booking-detail:nth-child(2) span').textContent;
                    const bookingDate = bookingCard.querySelector('.booking-date span').textContent;

                    // Populate modal with data
                    document.getElementById('modal-pet-image').src = petImage;
                    document.getElementById('modal-pet-name').textContent = petName;
                    document.getElementById('modal-booking-status').textContent = status;
                    document.getElementById('modal-booking-status').className =
                        `booking-status status-${status.toLowerCase()}`;
                    document.getElementById('modal-pet-type').textContent = petType;
                    document.getElementById('modal-death-year').textContent = deathYear;
                    document.getElementById('modal-location').textContent = locationInfo;
                    document.getElementById('modal-booking-date').textContent = bookingDate;

                    // Show the modal
                    modal.style.display = 'block';
                });
            });

            // Close modal when clicking the close button
            document.querySelector('.close-modal').addEventListener('click', function() {
                document.getElementById('booking-details-modal').style.display = 'none';
            });

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                const modal = document.getElementById('booking-details-modal');
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Simple mobile menu toggle
            const hamburger = document.querySelector('.hamburger');
            const navLinks = document.querySelector('.nav-links');

            hamburger.addEventListener('click', function() {
                navLinks.classList.toggle('active');
                this.classList.toggle('active');
            });
        });
    </script>
</body>

</html>
