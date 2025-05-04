<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetRest - User</title>
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/user.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<style>
    /* User-specific styles to add to style.css */

    /* User profile dropdown in header */

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
                <a href="/message"><i class="fas fa-message"></i> Messages</a>
                <a onclick="logout()" class="logout">
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

    <section class="hero" id="home">
        <div class="hero-content">
            <h1>Welcome back,<span class="petrest"> {{ $user->name }} </span> !</h1>
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
            <div class="filter-item filter1">
                <select name="burial-filter">
                    <option disabled selected>Burial Type</option>
                    <option value="individual">Individual</option>
                    <option value="communal">Communal</option>
                    <option value="private">Private Garden</option>
                </select>
            </div>
            <div class="filter-item filter2">
                <input type="text" id="search-input" placeholder="Search properties...">
            </div>
            <div class="filter-item filter3">
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
                    <li>Email: hanz@petrest.com</li>
                    <li>Phone: (+639) 456-7890</li>
                    <li>Address: Lahug Cebu City</li>
                </ul>
            </div>
            <div class="footer-column">
                <h3>Social</h3>
                <div class="social-icons">
                    <a href="https://www.facebook.com/hanzchristian.g.magbal"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.facebook.com/hanzchristian.g.magbal"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/hanzchristian.g.magbal"><i class="fab fa-twitter"></i></a>
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
                        <button class="secondary-btn contact-owner-btn" onclick="contact()"
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

        function contact() {
            window.location.href = '/message';
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
<script>
    // Get the elements we need
    const burialFilter = document.querySelector('[name="burial-filter"]');
    const searchInput = document.getElementById('search-input');
    const searchButton = document.getElementById('search-button');
    const propertyCards = document.querySelectorAll('.property-card');

    // Add click event to search button
    searchButton.addEventListener('click', function() {
        // Get the values from filters
        const selectedBurial = burialFilter.value;
        const searchText = searchInput.value.toLowerCase();

        // Loop through each property card
        propertyCards.forEach(function(card) {
            let shouldShow = true;

            // Get the card's title, description and type
            const title = card.querySelector('h3').textContent.toLowerCase();
            const description = card.getAttribute('data-description').toLowerCase();
            const typeElement = card.querySelector('.location-size');
            const type = typeElement ? typeElement.textContent.toLowerCase() : '';

            // Check if the card matches the burial filter
            if (selectedBurial && selectedBurial !== 'Burial Type') {
                if (!type.includes(selectedBurial.toLowerCase())) {
                    shouldShow = false;
                }
            }

            // Check if the card matches the search text
            if (searchText && searchText.trim() !== '') {
                if (!title.includes(searchText) && !description.includes(searchText)) {
                    shouldShow = false;
                }
            }

            // Show or hide the card
            if (shouldShow) {
                card.style.display = '';  // Use default display value
            } else {
                card.style.display = 'none';
            }
        });
    });

    // Add event listener for the search input to work on Enter key
    searchInput.addEventListener('keypress', function(event) {
        if (event.key === 'Enter') {
            searchButton.click();
        }
    });

    // Reset filters when the page loads
    window.addEventListener('load', function() {
        burialFilter.selectedIndex = 0;
        searchInput.value = '';
        propertyCards.forEach(card => card.style.display = '');
    });
</script>
