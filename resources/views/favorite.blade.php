<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetRest - My Favorites</title>
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Favorites Page Styles */
        .favorites-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .favorites-header {
            margin-bottom: 30px;
        }

        .favorites-header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .favorites-header p {
            color: #666;
        }

        .favorites-filters {
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

        .favorites-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 20px;
        }

        .favorite-card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .favorite-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        .favorite-image {
            height: 180px;
            overflow: hidden;
            position: relative;
        }

        .favorite-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .favorite-price {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 10px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 500;
        }

        .remove-favorite {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: rgba(255, 255, 255, 0.9);
            color: #ef4444;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .favorite-card:hover .remove-favorite {
            opacity: 1;
        }

        .favorite-info {
            padding: 15px;
        }

        .favorite-name {
            font-size: 18px;
            font-weight: 600;
            color: #333;
            margin-bottom: 5px;
        }

        .favorite-type {
            color: #666;
            font-size: 14px;
            margin-bottom: 10px;
        }

        .favorite-features {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        .feature {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 13px;
            color: #555;
        }

        .favorite-action {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .view-details-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s ease;
        }

        .view-details-btn:hover {
            background-color: #1e88e5;
        }

        .favorite-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            color: #f59e0b;
            font-weight: 500;
        }

        .favorites-empty {
            text-align: center;
            padding: 50px 20px;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            display: none;
        }

        .favorites-empty i {
            font-size: 50px;
            color: #ddd;
            margin-bottom: 15px;
        }

        .favorites-empty h3 {
            font-size: 20px;
            color: #333;
            margin-bottom: 10px;
        }

        .favorites-empty p {
            color: #666;
            margin-bottom: 20px;
        }

        .browse-btn {
            background-color: #2196F3;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .browse-btn:hover {
            background-color: #1e88e5;
        }

        /* User Dropdown Styles (Same as your existing pages) */
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

        .modal-image {
            width: 100%;
            height: 300px;
            margin-bottom: 20px;
            border-radius: 8px;
            overflow: hidden;
        }

        .modal-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        #modal-title {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .modal-price {
            font-size: 20px;
            color: #2196F3;
            font-weight: 600;
            margin-bottom: 20px;
        }

        .modal-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            width: 100%;
            margin-bottom: 20px;
        }

        .modal-detail-item {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .modal-detail-label {
            color: #666;
            font-size: 14px;
        }

        .modal-detail-value {
            color: #333;
            font-weight: 500;
        }

        .modal-description {
            text-align: left;
            margin-bottom: 20px;
            color: #555;
            line-height: 1.6;
        }

        .modal-actions {
            display: flex;
            gap: 15px;
            margin-top: 20px;
        }

        .modal-btn {
            padding: 10px 20px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .modal-btn-primary {
            background-color: #2196F3;
            color: white;
            border: none;
        }

        .modal-btn-secondary {
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
        }

        @media (max-width: 768px) {
            .favorites-grid {
                grid-template-columns: 1fr;
            }

            .modal-content {
                margin: 20px;
                padding: 20px;
            }

            .modal-details {
                grid-template-columns: 1fr;
            }

            .modal-actions {
                flex-direction: column;
            }
        }

        /* Mobile nav styles */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
        }

        .bar {
            width: 25px;
            height: 3px;
            background-color: #333;
            margin: 3px 0;
            transition: all 0.3s ease;
        }

        @media (max-width: 768px) {
            .hamburger {
                display: flex;
            }

            .nav-links {
                position: fixed;
                left: -100%;
                top: 70px;
                flex-direction: column;
                background-color: white;
                width: 100%;
                text-align: center;
                transition: 0.3s;
                box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
                padding: 20px 0;
            }

            .nav-links.active {
                left: 0;
            }

            .nav-links li {
                margin: 10px 0;
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
                <a href="/favorites" class="active"><i class="fas fa-heart"></i> My Favorites</a>
                <a href="/bookingHistory"><i class="fas fa-history"></i> Booking History</a>
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

    <div class="favorites-container">
        <div class="favorites-header">
            <h1>My Favorite Memorial Gardens</h1>
            <p>View and manage your saved memorial gardens</p>
        </div>

        <div class="favorites-filters">
            <button class="filter-button active" data-filter="all">All Gardens</button>
            <button class="filter-button" data-filter="individual">Individual</button>
            <button class="filter-button" data-filter="communal">Communal</button>
        </div>

        <!-- Empty state (hidden by default, shown when no favorites) -->
        <div class="favorites-empty" id="empty-favorites">
            <i class="fas fa-heart-broken"></i>
            <h3>No Favorites Yet</h3>
            <p>You haven't added any memorial gardens to your favorites yet.</p>
            <button class="browse-btn">Browse Memorial Gardens</button>
        </div>

        <!-- Favorites Grid -->
        <div class="favorites-grid" id="favorites-grid">
            <!-- Paradise Garden -->
            @foreach ($lots as $lot)
            <div class="favorite-card" data-type="individual">
                <div class="favorite-image">
                    <img src="{{asset ('lots/' . $lot->image)}}" alt="Paradise Garden">
                    <div class="favorite-price">₱{{number_format($lot->price)}}</div>
                    <div class="remove-favorite">
                        <i class="fas fa-heart-broken"></i>
                    </div>
                </div>
                <div class="favorite-info">
                    <h3 class="favorite-name">{{$lot->title}}</h3>
                    <p class="favorite-type">{{$lot->type}} - {{$lot->size}} sq ft</p>
                    <div class="favorite-features">
                        <div class="feature">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>{{$lot->area}}</span>
                        </div>
                        <div class="feature">
                            <i class="fas fa-list"></i>
                            <span>Slots: {{$lot->slots}}</span>
                        </div>
                    </div>
                    <div class="favorite-action">
                        <button class="view-details-btn">View Details</button>
                        <div class="favorite-rating">
                            <i class="fas fa-star"></i>
                            <span>4.9</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
    <!-- Property Details Modal -->
    <div id="property-details-modal" class="modal">
        <div class="modal-content">
            <span class="close-modal">&times;</span>
            <div class="modal-body">
                <div class="modal-image">
                    <img id="modal-image" src="" alt="Property Image">
                </div>
                <h2 id="modal-title"></h2>
                <div class="modal-price" id="modal-price"></div>

                <div class="modal-details">
                    <div class="modal-detail-item">
                        <i class="fas fa-ruler-combined"></i>
                        <div>
                            <div class="modal-detail-label">Type & Size</div>
                            <div class="modal-detail-value" id="modal-type-size"></div>
                        </div>
                    </div>
                    <div class="modal-detail-item">
                        <i class="fas fa-map-marker-alt"></i>
                        <div>
                            <div class="modal-detail-label">Location</div>
                            <div class="modal-detail-value" id="modal-location"></div>
                        </div>
                    </div>
                    <div class="modal-detail-item">
                        <i class="fas fa-list"></i>
                        <div>
                            <div class="modal-detail-label">Available Slots</div>
                            <div class="modal-detail-value" id="modal-slots"></div>
                        </div>
                    </div>
                    <div class="modal-detail-item">
                        <i class="fas fa-star"></i>
                        <div>
                            <div class="modal-detail-label">Rating</div>
                            <div class="modal-detail-value" id="modal-rating"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-description" id="modal-description">
                    This beautiful memorial garden provides a peaceful resting place for your beloved pet, surrounded by nature and tranquility.
                </div>

                <div class="modal-actions">
                    <button class="modal-btn modal-btn-secondary" id="remove-favorite-btn">
                        <i class="fas fa-heart-broken"></i> Remove from Favorites
                    </button>
                    <button class="modal-btn modal-btn-primary" id="book-now-btn">
                        <i class="fas fa-calendar-check"></i> Book Now
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
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

            // Filter functionality
            const filterButtons = document.querySelectorAll('.filter-button');
            const favoriteCards = document.querySelectorAll('.favorite-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Remove active class from all buttons
                    filterButtons.forEach(btn => btn.classList.remove('active'));

                    // Add active class to clicked button
                    this.classList.add('active');

                    // Get filter value
                    const filter = this.getAttribute('data-filter');

                    // Filter favorite cards
                    favoriteCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-type') === filter) {
                            card.style.display = 'block';
                        } else {
                            card.style.display = 'none';
                        }
                    });

                    // Check if any cards are visible
                    checkForEmptyState();
                });
            });

            // Remove favorite functionality
            const removeButtons = document.querySelectorAll('.remove-favorite');

            removeButtons.forEach(button => {
                button.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent opening the modal

                    const card = this.closest('.favorite-card');
                    const propertyName = card.querySelector('.favorite-name').textContent;

                    if (confirm(`Remove ${propertyName} from favorites?`)) {
                        // Animation for better UX
                        card.style.opacity = '0';
                        setTimeout(() => {
                            card.remove();
                            checkForEmptyState();
                        }, 300);
                    }
                });
            });

            // Modal functionality
            const modal = document.getElementById('property-details-modal');
            const modalClose = document.querySelector('.close-modal');
            const viewDetailsButtons = document.querySelectorAll('.view-details-btn');

            viewDetailsButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const card = this.closest('.favorite-card');

                    // Get data from the card
                    const image = card.querySelector('.favorite-image img').src;
                    const title = card.querySelector('.favorite-name').textContent;
                    const price = card.querySelector('.favorite-price').textContent;
                    const typeSize = card.querySelector('.favorite-type').textContent;
                    const location = card.querySelector('.feature:nth-child(1) span').textContent;
                    const slots = card.querySelector('.feature:nth-child(2) span').textContent;
                    const rating = card.querySelector('.favorite-rating span').textContent;

                    // Populate modal
                    document.getElementById('modal-image').src = image;
                    document.getElementById('modal-title').textContent = title;
                    document.getElementById('modal-price').textContent = price;
                    document.getElementById('modal-type-size').textContent = typeSize;
                    document.getElementById('modal-location').textContent = location;
                    document.getElementById('modal-slots').textContent = slots;
                    document.getElementById('modal-rating').textContent = rating;

                    // Set description based on property type (just for demo)
                    let description = '';
                    if (title === 'Paradise Garden') {
                        description = 'A beautiful garden with a scenic view of paradise. Perfect for pets who loved nature and open spaces.';
                    } else if (title === 'Ilog Dagat') {
                        description = 'A communal resting place with a waterfront theme. Ideal for pets who loved water and socializing with others.';
                    } else if (title === 'Forest View') {
                        description = 'A serene forest setting perfect for pets who loved exploring outdoors. Private and peaceful atmosphere.';
                    } else if (title === 'Rainbow Bridge') {
                        description = 'A colorful and joyful memorial garden inspired by the Rainbow Bridge poem. A celebration of your pet\'s life.';
                    }
                    document.getElementById('modal-description').textContent = description;

                    // Show modal
                    modal.style.display = 'block';
                });
            });

            // Close modal
            modalClose.addEventListener('click', function() {
                modal.style.display = 'none';
            });

            // Close modal when clicking outside
            window.addEventListener('click', function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            });

            // Remove favorite from modal
            document.getElementById('remove-favorite-btn').addEventListener('click', function() {
                const propertyName = document.getElementById('modal-title').textContent;

                if (confirm(`Remove ${propertyName} from favorites?`)) {
                    // Find and remove the card
                    favoriteCards.forEach(card => {
                        if (card.querySelector('.favorite-name').textContent === propertyName) {
                            card.remove();
                        }
                    });

                    // Close modal
                    modal.style.display = 'none';

                    // Check if any cards remain
                    checkForEmptyState();
                }
            });

            // Book Now button
            document.getElementById('book-now-btn').addEventListener('click', function() {
                const propertyName = document.getElementById('modal-title').textContent;
                alert(`You are about to book ${propertyName}. Redirecting to booking page...`);
                // In a real app, this would redirect to the booking page
                // window.location.href = `/book?property=${propertyName}`;
            });

            // Browse button in empty state
            document.querySelector('.browse-btn').addEventListener('click', function() {
                window.location.href = '/user';
            });

            // Check if there are visible cards
            function checkForEmptyState() {
                let hasVisibleCards = false;

                favoriteCards.forEach(card => {
                    if (card.style.display !== 'none' && document.contains(card)) {
                        hasVisibleCards = true;
                    }
                });

                // Show/hide empty state
                if (!hasVisibleCards) {
                    document.getElementById('empty-favorites').style.display = 'block';
                    document.getElementById('favorites-grid').style.display = 'none';
                } else {
                    document.getElementById('empty-favorites').style.display = 'none';
                    document.getElementById('favorites-grid').style.display = 'grid';
                }
            }

            // Mobile menu toggle
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
