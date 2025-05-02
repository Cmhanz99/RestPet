<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Memorial Garden Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('asset/owner.css') }}">
    <link rel="icon" href="{{ asset('logo/logo1.png') }}">
    <link rel="stylesheet" href="{{ asset('asset/addProperty.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        </script>
    @endif
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="profile">
            <div class="profile-img" style="background-image: url({{ asset('profile/' . $user->profile) }});">
            </div>
            <h3>{{ $user->name }}</h3>
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
            <a href="#" class="nav-item">
                <i class="fas fa-calendar"></i>
                <span>Reservations</span>
            </a>
            <a href="#" class="nav-item">
                <i class="fas fa-cog"></i>
                <span>Setting</span>
            </a>
            <a href="/analytics" class="nav-item">
                <i class="fas fa-chart-line"></i>
                <span>Analytics</span>
            </a>
        </nav>

        <div class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </div>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <header class="header">
            <div class="header-title">
                <h1>Update Memorial Garden</h1>
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
                    <div class="user-avatar"></div>
                    <i class="fas fa-chevron-down"></i>
                </div>
            </div>
        </header>

        <div class="add-garden-content">
            <div class="add-garden-form">
                <!-- Simple form with basic fields matching your database schema -->
                <form action="/update/{{ $lot->id }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-sections">
                        <!-- Basic Information Section -->
                        <div class="form-section">
                            <h3 class="section-title">Basic Information</h3>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="title">Garden Title *</label>
                                    <input type="text" id="title" name="title" value="{{ $lot->title }}"
                                        placeholder="Enter garden name" required>
                                </div>
                            </div>

                            <div class="form-row two-columns">
                                <div class="form-group">
                                    <label for="type">Garden Type *</label>
                                    <select id="type" name="type" required>
                                        <option value="Individual"{{ $lot->type == 'Individual' ? 'selected' : '' }}>
                                            Individual</option>
                                        <option value="Communal"{{ $lot->type == 'Communal' ? 'selected' : '' }}>
                                            Communal</option>
                                        <option value="Private"{{ $lot->type == 'Private' ? 'selected' : '' }}>Private
                                        </option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="area">Garden Area *</label>
                                    <select id="area" name="area" required>
                                        <option value="west-location"
                                            {{ $lot->type == 'west-location' ? 'selected' : '' }}>West Location
                                        </option>
                                        <option value="east-location"
                                            {{ $lot->type == 'east-location' ? 'selected' : '' }}>East Location
                                        </option>
                                        <option value="north-location"
                                            {{ $lot->type == 'north-location' ? 'selected' : '' }}>North Location
                                        </option>
                                        <option value="south-location"
                                            {{ $lot->type == 'south-location' ? 'selected' : '' }}>South Location
                                        </option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-row two-columns">
                                <div class="form-group">
                                    <label for="size">Size (sq ft) *</label>
                                    <input type="number" id="size" name="size" value="{{ $lot->size }}"
                                        placeholder="Enter size in sq ft" required>
                                </div>

                                <div class="form-group">
                                    <label for="slots">Number of Slots *</label>
                                    <input type="number" id="slots" name="slots" value="{{ $lot->slots }}"
                                        min="1" placeholder="Enter number of slots" required>
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="price">Price (₱) *</label>
                                    <input type="number" id="price" name="price" value="{{ $lot->price }}"
                                        placeholder="Enter price" required>
                                </div>
                            </div>
                            <div class="form-row two-columns">
                                <div class="form-row">
                                    <div class="form-group">
                                        <select type="text" id="marker" name="marker">
                                            <option value="Includes-Marker"
                                                {{ $lot->marker == 'Includes-Marker' ? 'selected' : '' }}>Inlcudes
                                                Marker</option>
                                            <option value="No-Marker"
                                                {{ $lot->marker == 'No-Marker' ? 'selected' : '' }}>No-Marker</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-row">
                                    <div class="form-group">
                                        <select type="text" id="status" name="status">
                                            <option value="Active" {{ $lot->status == 'Active' ? 'selected' : '' }}>
                                                Active</option>
                                            <option value="Inactive"
                                                {{ $lot->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="image">Garden Image</label>
                                    <input type="file" id="image" name="image" accept="image/*">
                                    <input type="hidden" name="old_image" value="{{ $lot->image }}">
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="form-group">
                                    <label for="description">Garden Description</label>
                                    <textarea id="description" name="description" placeholder="Enter description of the garden...">{{ $lot->description }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="form-actions">
                        <button type="button" onclick="goToDash()" class="btn btn-cancel">Cancel</button>
                        <button type="submit" class="btn btn-primary">Update Garden</button>
                    </div>
                </form>
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

        <div class="contact">
            <div class="contact-avatar"></div>
            <div class="contact-info">
                <p class="contact-name">Maria Rodriguez</p>
                <small>Pet owner</small>
            </div>
        </div>

        <div class="contact">
            <div class="contact-avatar"></div>
            <div class="contact-info">
                <p class="contact-name">David Lee</p>
                <small>Pet owner</small>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
<script>
    function goToDash() {
        window.location.href = "/dashboard";
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
