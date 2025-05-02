<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/owner.css') }}">
    <link rel="stylesheet" href="{{ asset('css/settings.css') }}">
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <div class="profile-img" style="background-image: url('{{ asset('profile/' . $user->profile) }}')"></div>
            <h3>Hanz Christian</h3>
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
            <a href="/settings" class="nav-item active">
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
                <h1>Account Settings</h1>
                <p>Manage your profile and account preferences</p>
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
                    <div class="user-avatar" style="background-image: url('{{ asset('profile/' . $user->profile) }}')">
                    </div>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </header>

        <div class="settings-content">
            <!-- Settings Navigation -->
            <div class="settings-nav">
                <button class="settings-nav-item active">
                    <i class="fas fa-user"></i>
                    <span>Profile Information</span>
                </button>
                <button class="settings-nav-item">
                    <i class="fas fa-lock"></i>
                    <span>Password & Security</span>
                </button>
                <button class="settings-nav-item">
                    <i class="fas fa-bell"></i>
                    <span>Notifications</span>
                </button>
                <button class="settings-nav-item">
                    <i class="fas fa-palette"></i>
                    <span>Appearance</span>
                </button>
            </div>

            <!-- Settings Content Area -->
            <div class="settings-main">
                <!-- Profile Information Section -->
                <div class="settings-section active" id="profile-section">
                    <h2 class="section-title">Profile Information</h2>
                    <p class="section-description">Update your personal information and profile photo</p>

                    <form class="settings-form">
                        <div class="profile-photo-section">
                            <div class="current-photo">
                                <div class="avatar-preview"
                                    style="background-image:url('{{ asset('profile/' . $user->profile) }}') "></div>
                            </div>
                            <div class="photo-actions">
                                <h3>Profile Photo</h3>
                                <p>This photo will be displayed on your profile and dashboard</p>
                                <div class="photo-buttons">
                                    <label for="photo-upload" class="btn btn-outline">
                                        <i class="fas fa-upload"></i> Upload New Photo
                                    </label>
                                    <input type="file" id="photo-upload" hidden accept="image/*">
                                    <button type="button" class="btn btn-text">
                                        <i class="fas fa-trash"></i> Remove
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="first-name">Full Name</label>
                            <input type="text" id="first-name" name="first_name" value="{{ $user->name }}">
                        </div>

                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" id="email" name="email" value="{{ $user->email }}">
                        </div>

                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="+63{{ $user->phone }}">
                        </div>

                        <div class="form-group">
                            <label for="address">Address</label>
                            <textarea id="address" name="address" rows="3">123 Manila Street, Quezon City, Philippines</textarea>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </div>
                    </form>
                </div>

                <!-- Password & Security Section -->
                <div class="settings-section" id="password-section">
                    <h2 class="section-title">Password & Security</h2>
                    <p class="section-description">Manage your password and account security settings</p>

                    <form class="settings-form">
                        <div class="form-group">
                            <label for="current-password">Current Password</label>
                            <div class="password-input">
                                <input type="password" id="current-password" value="{{ $user->password }}"
                                    name="current_password">
                                <button type="button" class="password-toggle">
                                    <i class="fas fa-eye"></i>
                                </button>
                            </div>
                        </div>

                        <div class="form-row two-columns">
                            <div class="form-group">
                                <label for="new-password">New Password</label>
                                <div class="password-input">
                                    <input type="password" id="new-password" name="new_password">
                                    <button type="button" class="password-toggle">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password">Confirm New Password</label>
                                <div class="password-input">
                                    <input type="password" id="confirm-password" name="confirm_password">
                                    <button type="button" class="password-toggle">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <div class="password-strength">
                            <h4>Password Strength</h4>
                            <div class="strength-meter">
                                <div class="strength-segment"></div>
                                <div class="strength-segment"></div>
                                <div class="strength-segment"></div>
                                <div class="strength-segment"></div>
                            </div>
                            <ul class="password-requirements">
                                <li class="passed"><i class="fas fa-check"></i> At least 8 characters</li>
                                <li><i class="fas fa-times"></i> Uppercase letter</li>
                                <li><i class="fas fa-check"></i> Lowercase letter</li>
                                <li><i class="fas fa-check"></i> Number</li>
                                <li><i class="fas fa-times"></i> Special character</li>
                            </ul>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Update Password</button>
                        </div>
                    </form>
                </div>

                <!-- Notifications Section -->
                <div class="settings-section" id="notifications-section">
                    <h2 class="section-title">Notifications</h2>
                    <p class="section-description">Manage how you receive notifications</p>

                    <form class="settings-form">
                        <div class="notification-group">
                            <h3>Email Notifications</h3>

                            <div class="notification-item">
                                <div class="notification-info">
                                    <h4>New Reservation Requests</h4>
                                    <p>Receive email when a new reservation is requested</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="notification-item">
                                <div class="notification-info">
                                    <h4>Memorial Service Reminders</h4>
                                    <p>Receive email reminders about upcoming memorial services</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="notification-item">
                                <div class="notification-info">
                                    <h4>System Updates</h4>
                                    <p>Receive emails about system maintenance and updates</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="notification-group">
                            <h3>SMS Notifications</h3>

                            <div class="notification-item">
                                <div class="notification-info">
                                    <h4>New Reservation Alerts</h4>
                                    <p>Receive SMS when a new reservation is requested</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox" checked>
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>

                            <div class="notification-item">
                                <div class="notification-info">
                                    <h4>Payment Confirmations</h4>
                                    <p>Receive SMS when a payment is processed</p>
                                </div>
                                <label class="toggle-switch">
                                    <input type="checkbox">
                                    <span class="toggle-slider"></span>
                                </label>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </div>
                    </form>
                </div>

                <!-- Appearance Section -->
                <div class="settings-section" id="appearance-section">
                    <h2 class="section-title">Appearance</h2>
                    <p class="section-description">Customize how your dashboard looks</p>

                    <form class="settings-form">
                        <div class="appearance-option">
                            <h3>Theme</h3>
                            <div class="theme-options">
                                <label class="theme-option">
                                    <input type="radio" name="theme" value="light" checked>
                                    <div class="theme-preview light-theme">
                                        <div class="theme-preview-header"></div>
                                        <div class="theme-preview-sidebar"></div>
                                        <div class="theme-preview-content"></div>
                                    </div>
                                    <span>Light</span>
                                </label>

                                <label class="theme-option">
                                    <input type="radio" name="theme" value="dark">
                                    <div class="theme-preview dark-theme">
                                        <div class="theme-preview-header"></div>
                                        <div class="theme-preview-sidebar"></div>
                                        <div class="theme-preview-content"></div>
                                    </div>
                                    <span>Dark</span>
                                </label>

                                <label class="theme-option">
                                    <input type="radio" name="theme" value="system">
                                    <div class="theme-preview system-theme">
                                        <div class="theme-preview-header"></div>
                                        <div class="theme-preview-sidebar"></div>
                                        <div class="theme-preview-content"></div>
                                    </div>
                                    <span>System</span>
                                </label>
                            </div>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Preferences</button>
                        </div>
                    </form>
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
    </div>

    <script>
        // Add this to your existing JavaScript to ensure scrolling works properly
        document.addEventListener('DOMContentLoaded', function() {
            // Original settings navigation functionality
            const navItems = document.querySelectorAll('.settings-nav-item');
            const sections = document.querySelectorAll('.settings-section');

            navItems.forEach((item, index) => {
                item.addEventListener('click', () => {
                    // Remove active class from all items and sections
                    navItems.forEach(i => i.classList.remove('active'));
                    sections.forEach(s => s.classList.remove('active'));

                    // Add active class to clicked item and corresponding section
                    item.classList.add('active');
                    sections[index].classList.add('active');

                    // Scroll the main content area to the top when switching sections
                    document.querySelector('.settings-main').scrollTop = 0;
                });
            });

            // Password visibility toggle (keeping original functionality)
            const toggleButtons = document.querySelectorAll('.password-toggle');
            toggleButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const input = button.previousElementSibling;
                    const icon = button.querySelector('i');

                    if (input.type === 'password') {
                        input.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        input.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        });
    </script>
</body>

</html>
