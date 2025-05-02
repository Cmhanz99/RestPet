<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PetRest - User Profile</title>
    <link rel="stylesheet" href="{{ asset('asset/style.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        /* Simple User Profile Styles */
        .profile-container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }

        .profile-header {
            margin-bottom: 30px;
        }

        .profile-header h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }

        .profile-header p {
            color: #666;
        }

        .profile-card {
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            text-align: center;
            /* Center align content */
        }

        .profile-banner {
            height: 120px;
            background-color: #2196F3;
            position: relative;
        }

        .profile-photo-container {
            position: relative;
            /* Changed from absolute */
            margin: -50px auto 20px;
            /* Center the container and add margin bottom */
            border: 4px solid white;
            border-radius: 50%;
            overflow: hidden;
            width: 120px;
            /* Slightly larger */
            height: 120px;
            /* Slightly larger */
            background-color: #f0f0f0;
        }

        .profile-photo {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .profile-photo-upload {
            position: absolute;
            bottom: 0;
            right: 0;
            background-color: rgba(255, 255, 255, 0.8);
            width: 30px;
            height: 30px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: #333;
        }

        .profile-photo-upload:hover {
            background-color: white;
        }

        .profile-photo-upload input {
            display: none;
        }

        .profile-content {
            padding: 20px 30px 30px;
            /* Adjusted padding */
        }

        .profile-tabs {
            display: flex;
            justify-content: center;
            /* Center the tabs */
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
        }

        .profile-tab {
            padding: 10px 20px;
            cursor: pointer;
            color: #666;
            position: relative;
        }

        .profile-tab.active {
            color: #2196F3;
        }

        .profile-tab.active:after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: #2196F3;
        }

        .profile-section {
            display: none;
        }

        .profile-section.active {
            display: block;
        }

        .profile-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            max-width: 600px;
            margin: 0 auto;
            text-align: left;
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #555;
            font-size: 14px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }

        .form-group input:focus {
            outline: none;
            border-color: #2196F3;
        }

        .form-actions {
            grid-column: span 2;
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .form-actions button {
            padding: 8px 16px;
            border-radius: 4px;
            font-size: 14px;
            cursor: pointer;
        }

        .save-btn {
            background-color: #2196F3;
            color: white;
            border: none;
        }

        .save-btn:hover {
            background-color: #1e88e5;
        }

        .cancel-btn {
            background-color: white;
            color: #333;
            border: 1px solid #ddd;
        }

        .cancel-btn:hover {
            background-color: #f5f5f5;
        }

        .edit-btn {
            position: absolute;
            top: 20px;
            right: 20px;
            background-color: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 4px;
            padding: 8px 16px;
            color: #333;
            display: flex;
            align-items: center;
            gap: 5px;
            cursor: pointer;
            z-index: 1;
        }

        .edit-btn:hover {
            background-color: #e0e0e0;
        }

        .disabled-field {
            background-color: #f5f5f5;
            cursor: not-allowed;
        }

        .profile-info {
            padding: 20px 0;
            max-width: 600px;
            /* Limit the width of information */
            margin: 0 auto;
            /* Center the information */
        }

        .info-row {
            display: flex;
            padding: 12px 20px;
            /* Added horizontal padding */
            border-bottom: 1px solid #f0f0f0;
            text-align: left;
            /* Left align the text */
        }

        .info-label {
            flex: 0 0 150px;
            color: #666;
            font-size: 14px;
        }

        .info-value {
            flex: 1;
            color: #333;
        }

        .password-section,
        .activity-section {
            margin-top: 20px;
        }

        @media (max-width: 768px) {
            .profile-form {
                grid-template-columns: 1fr;
            }

            .form-actions {
                grid-column: 1;
            }

            .profile-photo-container {
                width: 100px;
                height: 100px;
                margin: -40px auto 15px;
            }

            .profile-content {
                padding: 15px;
            }

            .info-row {
                padding: 12px 15px;
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
    </style>
</head>

<body>
    <header>
        <a href="/user" class="logo"><img class="logoImg" src="{{asset ('logo/logo1.png')}}" alt=""> Pet Rest</a>
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
                <a href="/userProfile" class="active"><i class="fas fa-user-circle"></i> My Profile</a>
                <a href="/favorites"><i class="fas fa-heart"></i> My Favorites</a>
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

    <div class="profile-container">
        <div class="profile-header">
            <h1>My Profile</h1>
            <p>View and edit your personal information</p>
        </div>

        <div class="profile-card">
            <div class="profile-banner"></div>
            <div class="profile-photo-container">
                <img src="{{ asset('user-profile/' . $user->image) }}" alt="Profile Photo" class="profile-photo"
                    id="profile-preview">
                <label class="profile-photo-upload" for="profile-upload">
                    <i class="fas fa-camera"></i>
                    <input type="file" id="profile-upload" accept="image/*">
                </label>
            </div>
            <button class="edit-btn" id="edit-profile-btn">
                <i class="fas fa-pencil-alt"></i> Edit Profile
            </button>

            <div class="profile-content">
                <div class="profile-tabs">
                    <div class="profile-tab active" data-tab="personal-info">Personal Information</div>
                    <div class="profile-tab" data-tab="security">Security</div>
                </div>

                <!-- Personal Info Section -->
                <div class="profile-section active" id="personal-info">
                    <!-- View Mode -->
                    <div class="profile-info" id="info-view">
                        <div class="info-row">
                            <div class="info-label">Name</div>
                            <div class="info-value">{{ $user->name }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Email</div>
                            <div class="info-value">{{ $user->email }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Member Since</div>
                            <div class="info-value">{{ date('F j, Y', strtotime($user->created_at)) }}</div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Last Updated</div>
                            <div class="info-value">{{ date('F j, Y', strtotime($user->updated_at)) }}</div>
                        </div>
                    </div>

                    <!-- Edit Mode -->
                    <form class="profile-form" id="info-edit" style="display: none;">
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" id="name" name="name" value="{{ $user->name }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}">
                        </div>
                        <div class="form-group">
                            <label for="created">Member Since</label>
                            <input type="text" id="created"
                                value="{{ date('F j, Y', strtotime($user->created_at)) }}" class="disabled-field"
                                readonly>
                        </div>
                        <div class="form-group">
                            <label for="updated">Last Updated</label>
                            <input type="text" id="updated"
                                value="{{ date('F j, Y', strtotime($user->updated_at)) }}" class="disabled-field"
                                readonly>
                        </div>
                        <div class="form-actions">
                            <button type="button" class="cancel-btn" id="cancel-edit-btn">Cancel</button>
                            <button type="submit" class="save-btn">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Security Section -->
                <div class="profile-section" id="security">
                    <form class="profile-form">
                        <div class="form-group">
                            <label for="current-password">Current Password</label>
                            <input type="password" id="current-password" name="current_password">
                        </div>
                        <div class="form-group">
                            <label for="new-password">New Password</label>
                            <input type="password" id="new-password" name="new_password">
                        </div>
                        <div class="form-group">
                            <label for="confirm-password">Confirm New Password</label>
                            <input type="password" id="confirm-password" name="confirm_password">
                        </div>
                        <div class="form-actions">
                            <button type="submit" class="save-btn">Update Password</button>
                        </div>
                    </form>
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

            // Profile tabs functionality
            const profileTabs = document.querySelectorAll('.profile-tab');
            const profileSections = document.querySelectorAll('.profile-section');

            profileTabs.forEach(tab => {
                tab.addEventListener('click', function() {
                    // Remove active class from all tabs and sections
                    profileTabs.forEach(t => t.classList.remove('active'));
                    profileSections.forEach(s => s.classList.remove('active'));

                    // Add active class to clicked tab
                    this.classList.add('active');

                    // Show corresponding section
                    const tabId = this.getAttribute('data-tab');
                    document.getElementById(tabId).classList.add('active');
                });
            });

            // Edit profile functionality
            const editBtn = document.getElementById('edit-profile-btn');
            const infoView = document.getElementById('info-view');
            const infoEdit = document.getElementById('info-edit');
            const cancelBtn = document.getElementById('cancel-edit-btn');

            editBtn.addEventListener('click', function() {
                infoView.style.display = 'none';
                infoEdit.style.display = 'block';
                this.style.display = 'none';
            });

            cancelBtn.addEventListener('click', function() {
                infoView.style.display = 'block';
                infoEdit.style.display = 'none';
                editBtn.style.display = 'flex';
            });

            // Profile photo upload preview
            const profileUpload = document.getElementById('profile-upload');
            const profilePreview = document.getElementById('profile-preview');

            profileUpload.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();

                    reader.onload = function(e) {
                        profilePreview.src = e.target.result;
                    }

                    reader.readAsDataURL(file);
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
