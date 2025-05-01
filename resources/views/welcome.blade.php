<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetRest</title>
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.3/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>

<body>
    <header>
        <div class="logo">Pet Rest</div>
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
            <h1>PetRest will help you to find a better space for your pet.</h1>
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
            <div class="filter-item">
                <select>
                    <option disabled selected>Pet</option>
                    <option>Dog</option>
                    <option>Cat</option>
                    <option>Dinasaur</option>
                    <option>Hamster</option>
                    <option>Bird</option>
                </select>
            </div>
            <div class="filter-item">
                <select>
                    <option disabled selected>Burial Type</option>
                    <option>Individual</option>
                    <option>Communal</option>
                    <option>Private Garden</option>
                    <option>Memorial Wall</option>
                    <option>Cremation Service</option>
                </select>
            </div>
            <div class="filter-item">
                <input type="text" placeholder="Search properties...">
            </div>
            <div class="filter-item">
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
                            <button class="details-btn" data-id="{{ $lot->id }}">Details</button>
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
            <button class="submit-btn">Send Message</button>
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
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Listings</a></li>
                    <li><a href="#">Map</a></li>
                    <li><a href="#">Contact</a></li>
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
                Hello! How can I help you find the perfect pet-friendly property today?
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
                    <img src="https://placehold.co/600x400" alt="Property Image" id="modal-image">
                </div>
                <div class="property-info">
                    <h2 id="modal-title">Property Name</h2>
                    <p id="modal-location">Location</p>
                    <div class="property-price" id="modal-price">$150/night</div>
                    <div class="property-rating">
                        <span class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </span>
                        <span id="modal-rating">4.8</span>
                    </div>
                    <div class="property-details-wrapper">
                        <h3>Details</h3>
                        <div class="property-features-detailed">
                            <div class="feature">
                                <i class="fas fa-location"></i>
                                <span><strong>Location:</strong> <span id="modal-beds"></span></span>
                            </div>
                            <div class="feature">
                                <i class="fas fa-cross"></i>
                                <span><strong>Includes Marker:</strong> <span id="modal-baths"></span></span>
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
                        <button class="primary-btn book-now-btn" id="book-now-btn">Book Now</button>
                        <button class="secondary-btn contact-owner-btn" id="contact-owner-btn">Contact Owner</button>
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
    </script>
</body>

</html>
