<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetRest</title>
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <header>
        <div class="logo"><img src="{{asset ('logo/logo1.png')}}" class="logoImg" alt=""> Pet Rest</div>
        <nav>
            <ul class="nav-links">
                <li><a href="#home" class="active">Home</a></li>
                <li><a href="#li">Listing</a></li>
                <li><a href="#ma">Map</a></li>
                <li><a href="#con">Contact</a></li>
                <li><a href="/login" class="login-btn">Login</a></li>
            </ul>
        </nav>
        <div class="hamburger">
            <div class="bar"></div>
            <div class="bar"></div>
            <div class="bar"></div>
        </div>
    </header>

    <section class="hero" id="home">
        <div class="hero-content">
            <h1><span class="petrest">PetRest</span> will help you to find a better space for your pet.</h1>
            <p>Looking for best properties? Check this out!</p>
            <div class="cta-buttons">
                <button onclick="goMap()" class="primary-btn">Map View</button>
                <button onclick="goSeeMore()" class="secondary-btn">See more</button>
            </div>
        </div>
    </section>

    <section class="listing" id="li">
        <h2>Memorial Gardens</h2>
        <p>Looking for best memorial gardens? check this out!</p>

        <div class="filter">
            <div class="filter-item filter1">
                <select id="burialTypeSelect">
                    <option disabled selected>Burial Type</option>
                    <option value="individual">Individual</option>
                    <option value="communal">Communal</option>
                    <option value="private">Private Garden</option>
                </select>
            </div>
            <div class="filter-item filter2">
                <input type="text" placeholder="Search properties...">
            </div>
            <div class="filter-item filter3">
                <button class="search-btn">Search</button>
            </div>
        </div>
        <div class="properties-grid" id="properties-grid">
            <!-- Property Card 1 -->
            @foreach ($lots as $lot)
                <div class="property-card" data-id="{{ $lot->id }}" data-description="{{ $lot->description }}">
                    <div class="property-image"
                        style="background-image: url('{{ asset('lots/' . $lot->image) }}'); background-size: cover; background-position: center;">
                        <span class="price">₱ {{ number_format($lot->price) }}</span>
                    </div>
                    <div class="property-details">
                        <h3>{{ $lot->title }}</h3>
                        <p>{{ $lot->type }} - {{ $lot->size }} sq ft</p>
                        <div class="property-features">
                            <span><i class="fas fa-location"></i> {{ $lot->area }}</span>
                            <span><i class="fas fa-cross"></i> {{ $lot->marker }}</span>
                            <span><i class="fas fa-list"></i> Slots {{ $lot->slots }}</span>
                        </div>
                        <div class="property-buttons">
                            <button class="details-btn" onclick="detailsLogin()">Details</button>
                            <span class="rating"><i class="fas fa-star"></i> 4.9</span>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="view-all">
                <button class="view-all-btn" id="view-more-btn">View More</button>
                <button class="view-less-btn" id="view-less-btn">Show Less</button>
            </div>
    </section>

    <section class="map-section" id="ma">
        <h2>Map View</h2>
        <p>Looking for best properties? check this out!</p>
        <div id="map"></div>
    </section>

    <section class="contact" id="con">
        <div class="contact-image">
            <img src="{{ asset('images/pet-img.jpg') }}" alt="Contact Image">
        </div>
        <div class="contact-form">
            <h2>Contacts</h2>
            <input type="text" placeholder="Name">
            <input type="email" placeholder="Email">
            <input type="tel" placeholder="Phone">
            <textarea placeholder="Message"></textarea>
            <button class="submit-btn" onclick="detailsLogin()">Send Message</button>
        </div>
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
                Hello! How can I help you find the perfect pet-friendly property today?
            </div>
        </div>
        <div class="chatbot-input">
            <input type="text" placeholder="Type your message..." id="user-input">
            <button id="send-message"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
    <!-- JavaScript Files -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.js"></script>
    <script src="{{ asset('asset/main.js') }}"></script>
    <script src="{{ asset('asset/map.js') }}"></script>
    <script src="{{ asset('asset/modal.js') }}"></script>
    <script src="{{ asset('asset/chatbot.js') }}"></script>

    <script>
        function goMap() {
            window.location.href = '#ma';
        }

        function goSeeMore() {
            window.location.href = '#li';
        }

        function book(id) {
            if (id) {
                window.location.href = '/book/' + id;
            }
        }

        function contact(id) {
            if (id) {
                window.location.href = '/contact';
            }
        }
        function detailsLogin(){
            Swal.fire({
                icon: 'error',
                title: 'You must logged in first',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        }
        function viewLogin(){
            Swal.fire({
                icon: 'error',
                title: 'You must logged in first',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        }
    </script>
   <script>
    // Get all the necessary elements
    const burialTypeSelect = document.getElementById('burialTypeSelect'); // Changed to get by ID
    const searchInput = document.querySelector('.filter-item input[type="text"]');
    const searchButton = document.querySelector('.search-btn');
    const propertyCards = document.querySelectorAll('.property-card');

    // Add click event to search button
    searchButton.addEventListener('click', filterProperties);

    // Main filter function
    function filterProperties() {
        // Get the selected burial type and search text
        const selectedBurialType = burialTypeSelect.value.toLowerCase();
        const searchText = searchInput.value.toLowerCase();

        // Loop through all property cards
        propertyCards.forEach(card => {
            // Get the burial type from the card
            const cardBurialType = card.querySelector('.property-details p').textContent.split('-')[0].trim().toLowerCase();
            // Get the title for text search
            const cardTitle = card.querySelector('.property-details h3').textContent.toLowerCase();

            // Check if card matches both burial type and search criteria
            let showCard = true;

            // Only apply burial type filter if an option is selected (not the disabled one)
            if (selectedBurialType && selectedBurialType !== 'burial type') {
                showCard = cardBurialType.includes(selectedBurialType);
            }

            // Apply text search filter if there is search text
            if (searchText !== '') {
                showCard = showCard && cardTitle.includes(searchText);
            }

            // Show or hide the card based on filters
            if (showCard) {
                card.style.display = '';  // Use default display value
            } else {
                card.style.display = 'none';
            }
        });
    }

    // Clear filters when page loads
    window.addEventListener('load', function() {
        burialTypeSelect.selectedIndex = 0;
        searchInput.value = '';
        propertyCards.forEach(card => {
            card.style.display = ''; // Use default display value
        });
    });
</script>
</body>
</html>
