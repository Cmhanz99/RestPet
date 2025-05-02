<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetRest - User</title>
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    /* User-specific styles to add to style.css */

    /* User profile dropdown in header */
    .user-profile {
        display: flex;
        align-items: center;
        cursor: pointer;
        position: relative;
    }

    .user-avatar {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #2196F3;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        margin-right: 10px;
    }

    .user-name {
        display: flex;
        align-items: center;
        gap: 5px;
        font-weight: 500;
    }

    .user-name i {
        font-size: 12px;
        transition: transform 0.3s ease;
    }

    .user-profile:hover .user-name i {
        transform: rotate(180deg);
    }

    .user-dropdown {
        position: absolute;
        top: 45px;
        right: 0;
        background-color: white;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        border-radius: 8px;
        width: 220px;
        z-index: 1000;
        display: none;
        overflow: hidden;
    }

    .user-dropdown a {
        padding: 12px 15px;
        display: flex;
        align-items: center;
        gap: 10px;
        color: #333;
        transition: background-color 0.3s ease;
    }

    .user-dropdown a:hover {
        background-color: #f0f7ff;
    }

    .user-dropdown a:after {
        display: none;
    }

    .user-dropdown a.logout {
        border-top: 1px solid #eee;
        color: #e53935;
    }

    .user-dropdown a.logout:hover {
        background-color: #ffebee;
    }

    .user-dropdown a i {
        width: 20px;
        text-align: center;
    }

    /* Favorite button on property cards */
    .favorite-btn {
        position: absolute;
        top: 15px;
        left: 15px;
        background-color: rgba(255, 255, 255, 0.9);
        border-radius: 50%;
        width: 36px;
        height: 36px;
        display: flex;
        align-items: center;
        justify-content: center;
        border: none;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 10;
    }

    .favorite-btn:hover {
        transform: scale(1.1);
        background-color: rgba(255, 255, 255, 1);
    }

    .favorite-btn i {
        font-size: 18px;
        color: #ff5252;
    }

    .favorite-btn .far {
        opacity: 0.7;
    }

    .favorite-btn .fas {
        opacity: 1;
    }

    /* Booking modal styles */
    .booking-form {
        padding: 30px;
        max-width: 500px;
        margin: 0 auto;
    }

    .booking-form h2 {
        margin-bottom: 20px;
        text-align: center;
    }

    .booking-form input,
    .booking-form select,
    .booking-form textarea {
        width: 100%;
        padding: 12px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }

    .booking-form textarea {
        min-height: 100px;
        resize: vertical;
    }

    .booking-form .form-group {
        margin-bottom: 15px;
    }

    .booking-form label {
        display: block;
        margin-bottom: 5px;
        font-weight: 500;
    }

    /* Notification system */
    #notification-container {
        position: fixed;
        bottom: 20px;
        right: 20px;
        z-index: 9999;
        display: flex;
        flex-direction: column;
        gap: 10px;
    }

    .notification {
        padding: 12px 20px;
        border-radius: 4px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
        color: white;
        max-width: 300px;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .notification.success {
        background-color: #4CAF50;
    }

    .notification.error {
        background-color: #F44336;
    }

    /* Make property cards clickable */
    .property-card {
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .property-card:after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(33, 150, 243, 0.05);
        opacity: 0;
        transition: opacity 0.3s ease;
        pointer-events: none;
    }

    .property-card:hover:after {
        opacity: 1;
    }

    /* Add badge for newly added properties */
    .property-card.new::before {
        content: 'NEW';
        position: absolute;
        top: 15px;
        right: 15px;
        background-color: #FF9800;
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        font-weight: bold;
        z-index: 10;
    }

    /* Custom styles for the hero section with personalized welcome */
    .hero h1 {
        margin-bottom: 10px;
        font-size: 38px;
        color: white;
        text-shadow: 1px 1px 2px black;
    }

    /* Enhanced property card features */
    .property-details {
        position: relative;
    }

    .property-tag {
        position: absolute;
        top: -12px;
        right: 15px;
        background-color: #4CAF50;
        color: white;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Enhanced filter section */
    .filter {
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .filter-title {
        margin-bottom: 15px;
        font-size: 16px;
        font-weight: 600;
        color: #333;
    }

    .search-btn {
        background: linear-gradient(to right, #2196F3, #0d8aee);
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: linear-gradient(to right, #0d8aee, #0769b3);
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    /* User quick actions panel */
    .user-quick-actions {
        display: flex;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 30px;
    }

    .quick-action-card {
        flex: 1;
        background-color: white;
        border-radius: 8px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        padding: 20px;
        text-align: center;
        transition: all 0.3s ease;
    }

    .quick-action-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }

    .quick-action-card i {
        font-size: 24px;
        color: #2196F3;
        margin-bottom: 10px;
    }

    .quick-action-card h3 {
        font-size: 16px;
        margin-bottom: 5px;
    }

    .quick-action-card p {
        font-size: 14px;
        color: #666;
    }

    /* Fancy scrollbar for the page */
    ::-webkit-scrollbar {
        width: 10px;
    }

    ::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    ::-webkit-scrollbar-thumb {
        background: #2196F3;
        border-radius: 5px;
    }

    ::-webkit-scrollbar-thumb:hover {
        background: #0d8aee;
    }

    /* Enhanced chatbot styling */
    .chatbot-icon {
        background: linear-gradient(135deg, #2196F3, #0d8aee);
    }

    .chatbot-header {
        background: linear-gradient(135deg, #2196F3, #0d8aee);
    }

    .chatbot-input input {
        border-radius: 20px;
        border: 1px solid #e0e0e0;
        padding: 12px 15px;
        transition: all 0.3s ease;
    }

    .chatbot-input input:focus {
        border-color: #2196F3;
        box-shadow: 0 0 0 2px rgba(33, 150, 243, 0.2);
        outline: none;
    }

    .chatbot-input button {
        background: linear-gradient(135deg, #2196F3, #0d8aee);
    }

    /* Tooltip for features in property cards */
    .property-features span {
        position: relative;
    }

    .property-features span:hover::after {
        content: attr(data-tooltip);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background-color: rgba(0, 0, 0, 0.8);
        color: white;
        padding: 5px 10px;
        border-radius: 4px;
        font-size: 12px;
        white-space: nowrap;
        z-index: 100;
        margin-bottom: 5px;
    }

    /* Responsiveness for user profile dropdown */
    @media (max-width: 768px) {
        .user-profile {
            margin-right: 50px;
        }

        .user-dropdown {
            width: 100%;
            position: fixed;
            left: 0;
            top: 65px;
            border-radius: 0;
        }

        .user-quick-actions {
            flex-direction: column;
        }

        .quick-action-card {
            padding: 15px;
        }
    }

    /* Loading indicators */
    .loading-spinner {
        width: 24px;
        height: 24px;
        border: 3px solid rgba(33, 150, 243, 0.3);
        border-radius: 50%;
        border-top-color: #2196F3;
        animation: spin 1s ease-in-out infinite;
        margin: 0 auto;
    }

    @keyframes spin {
        to {
            transform: rotate(360deg);
        }
    }

    .loading-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(255, 255, 255, 0.8);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 20;
    }

    .loading-text {
        margin-top: 10px;
        color: #2196F3;
        font-weight: 500;
    }

    /* Property filters chips */
    .filter-chips {
        display: flex;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 15px;
    }

    .filter-chip {
        background-color: #e3f2fd;
        color: #2196F3;
        padding: 5px 12px;
        border-radius: 16px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .filter-chip i {
        font-size: 12px;
        cursor: pointer;
    }

    .filter-chip:hover {
        background-color: #bbdefb;
    }
</style>

<body>
    <header>
        <a href="#" class="logo"><img src="{{asset ('logo/logo1.png')}}" class="logoImg" alt="">Pet Rest</a>
        <nav>
            <ul class="nav-links">
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="#li">Listing</a></li>
                <li><a href="#ma">Map</a></li>
                <li><a href="#con">Contact</a></li>
            </ul>
        </nav>
        <div class="user-profile">
            <div class="user-name">
                {{ $user->name }} <i class="fas fa-chevron-down"></i>
            </div>
            <div class="user-dropdown">
                <a href="/userProfile"><i class="fas fa-user-circle"></i> My Profile</a>
                <a href="/favorites"><i class="fas fa-heart"></i> My Favorites</a>
                <a href="/bookingHistory"><i class="fas fa-history"></i> Booking History</a>
                <a href=""><i class="fas fa-cog"></i> Settings</a>
                <a onclick="logout()" class="logout">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                {{-- <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form> --}}
            </div>
        </div>
        <div class="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Welcome back, {{ $user->name }}!</h1>
            <p>Find the perfect memorial space for your beloved pet.</p>
            <div class="cta-buttons">
                <button onclick="goMap()" class="primary-btn">Map View</button>
                <button onclick="goSeeMore()" class="secondary-btn">See More</button>
            </div>
        </div>
    </section>

    <section class="listing" id="li">
        <h2>Memorial Gardens</h2>
        <p>Browse our selection of beautiful memorial spaces for your pet</p>

        <div class="filter">
            <div class="filter-item">
                <select id="pet-filter">
                    <option disabled selected>Pet</option>
                    <option value="dog">Dog</option>
                    <option value="cat">Cat</option>
                    <option value="bird">Bird</option>
                    <option value="hamster">Hamster</option>
                    <option value="other">Other</option>
                </select>
            </div>
            <div class="filter-item">
                <select id="burial-filter">
                    <option disabled selected>Burial Type</option>
                    <option value="individual">Individual</option>
                    <option value="communal">Communal</option>
                    <option value="private">Private Garden</option>
                </select>
            </div>
            <div class="filter-item">
                <input type="text" id="search-input" placeholder="Search properties...">
            </div>
            <div class="filter-item">
                <button class="search-btn" id="search-button">Search</button>
            </div>
        </div>

        <div class="properties-grid" id="properties-grid">
            @foreach ($lots as $lot)
                <div class="property-card" data-id="{{ $lot->id }}" data-description="{{ $lot->description }}">
                    <div class="property-image" style="background-image: url('{{ asset('lots/' . $lot->image) }}');">
                        <span class="price">₱ {{ number_format($lot->price) }}</span>
                        <button class="favorite-btn" data-id="{{ $lot->id }}">
                            @if (in_array($lot->id, $favorites ?? []))
                                <i class="fas fa-heart"></i>
                            @else
                                <i class="far fa-heart"></i>
                            @endif
                        </button>
                    </div>
                    <div class="property-details">
                        <h3>{{ $lot->title }}</h3>
                        <p class="location-size">{{ $lot->type }} - {{ $lot->size }} sq ft</p>
                        <div class="property-features">
                            <span class="location" data-tooltip="Location"><i class="fas fa-location-dot"></i>
                                {{ $lot->area }}</span>
                            <span class="marker" data-tooltip="Marker Type"><i class="fas fa-cross"></i>
                                {{ $lot->marker }}</span>
                            <span class="slots" data-tooltip="Available Slots"><i class="fas fa-list"></i> Slots
                                {{ $lot->slots }}</span>
                        </div>
                        <div class="property-buttons">
                            <button type="button" class="details-btn" data-id="{{ $lot->id }}">Details</button>
                            <span class="rating"><i class="fas fa-star"></i> 4.9</span>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="view-all">
            <button class="view-all-btn" id="view-more-btn">View More</button>
            <button class="view-less-btn" id="view-less-btn">Show Less</button>
        </div>
    </section>

    <section class="map-section" id="ma">
        <h2>Map View</h2>
        <p>Explore memorial garden locations on the map</p>
        <div id="map"></div>
    </section>

    <section class="contact" id="con">
        <div class="contact-image">
            <img src="{{ asset('images/pet-img.jpg') }}" alt="Contact Image">
        </div>
        <form action="/form" method="post" class="contact-form">
            @csrf
            <h2>Contact Us</h2>
            <input type="text" id="contact-name" name="name" placeholder="Name" value="{{ $user->name }}"
                readonly>
            <input type="email" id="contact-email" name="email" placeholder="Email"
                value="{{ $user->email }}" readonly>
            <input type="text" id="contact-phone" name="phone" placeholder="Phone" value="">
            <textarea id="contact-message" name="message" placeholder="Message"></textarea>
            <input type="hidden" id="contact-property-id" value="">
            <button class="submit-btn" type="submit" id="send-message-btn">Send Message</button>
        </form>
    </section>

    <footer>
        <div class="footer-links">
            <div class="footer-column">
                <h3>PetRest</h3>
                <p>Find the perfect space for your pet</p>
            </div>
            <div class="footer-column">
                <h3>Quick Links</h3>
                <ul>
                    <li><a href="#home">Home</a></li>
                    <li><a href="#li">Listings</a></li>
                    <li><a href="#ma">Map</a></li>
                    <li><a href="#con">Contact</a></li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Contact</h3>
                <ul>
                    <li>Email: info@petrest.com</li>
                    <li>Phone: (123) 456-7890</li>
                    <li>Address: 123 Pet Street</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Social</h3>
                <div class="social-icons">
                    <a href="#"><i class="fab fa-facebook"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                </div>
            </div>
        </div>
        <div class="copyright">
            &copy; 2025 PetRest. All rights reserved.
        </div>
    </footer>

    <!-- Chatbot Icon -->
    <div class="chatbot-icon" id="chatbot-icon">
        <i class="fas fa-comments"></i>
    </div>

    <!-- Chatbot Container -->
    <div class="chatbot-container" id="chatbot-container">
        <div class="chatbot-header">
            <h3>PetRest Assistant</h3>
            <button id="close-chatbot"><i class="fas fa-times"></i></button>
        </div>
        <div class="chatbot-messages">
            <div class="message bot">
                Hello {{ $user->name }}! How can I help you find the perfect pet memorial today?
            </div>
        </div>
        <div class="chatbot-input">
            <input type="text" placeholder="Type your message..." id="user-input">
            <button id="send-message"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>

    <!-- Property Details Modal -->
    <div class="modal" id="property-modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-body">
                <div class="property-gallery">
                    <img src="" alt="Property Image" id="modal-image">
                </div>
                <div class="property-info">
                    <h2 id="modal-title"></h2>
                    <p id="modal-location"></p>
                    <div class="property-price" id="modal-price"></div>
                    <div class="property-rating">
                        <span class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </span>
                        <span id="modal-rating"></span>
                    </div>
                    <div class="property-details-wrapper">
                        <h3>Details</h3>
                        <div class="property-features-detailed">
                            <div class="feature">
                                <i class="fas fa-location-dot"></i>
                                <span><strong>Location:</strong> <span id="modal-location-detail"></span></span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-cross"></i>
                                <span><strong>Includes Marker:</strong> <span id="modal-marker"></span></span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-ruler-combined"></i>
                                <span><strong>Size:</strong> <span id="modal-size"></span></span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-paw"></i>
                                <span><strong>Pet Policy:</strong> <span id="modal-pet-policy"></span></span>
                            </div>
                        </div>
                    </div>
                    <div class="property-description">
                        <h3>Description</h3>
                        <p id="modal-description"></p>
                    </div>
                    <div class="modal-buttons">
                        <button class="primary-btn book-now-btn" onclick="book({{ $lot->id }})"
                            id="book-now-btn">Book Now</button>
                        <button class="secondary-btn contact-owner-btn" onclick="contact({{ $lot->id }})"
                            id="contact-owner-btn">Contact Owner</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.js"></script>
    <script src="{{ asset('asset/main.js') }}"></script>
    <script src="{{ asset('asset/map.js') }}"></script>
    <script src="{{ asset('asset/modal.js') }}"></script>
    <script src="{{ asset('asset/chatbot.js') }}"></script>
    <script src="{{ asset('asset/user.js') }}"></script>

    <script>
        // Navigation functions

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

        function goMap() {
            window.location.href = '#ma';
        }

        function goSeeMore() {
            window.location.href = '#li';
        }

        function book(id) {
            window.location.href = '/book/' + id;
        }

        function contact(id) {
            if (id) {
                document.getElementById('contact-property-id').value = id;
                window.location.href = '#con';
                document.getElementById('property-modal').style.display = 'none';
            }
        }
    </script>
</body>

</html>
<script>
    @if (session('success'))

        Swal.fire({
            icon: 'success',
            title: 'Message send successfully!',
            text: '{{ session('message') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#3085d6'
        });
    @endif
</script>
