<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Memorial Garden Dashboard</title>
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-SgOJa3DmI69IUzQ2PVdRZhwQ+dy64/BUtbMJw1MZ8t5HZApcHrRKUc4W0kG879m7" crossorigin="anonymous">
    <link rel="stylesheet" href="{{ asset('asset/owner.css') }}">
    <link rel="stylesheet" href="{{ asset('asset/memorial.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
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
            <a href="/memorial" class="nav-item active">
                <i class="fas fa-monument"></i>
                <span>Memorial Gardens</span>
            </a>
            <a href="/reservation" class="nav-item">
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

        <div onclick="logout()" class="logout">
            <i class="fas fa-sign-out-alt"></i>
            <span>Logout</span>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <header class="header">
            <div class="header-title">
                @foreach ($lots as $lot)
                    <h1>{{ empty($lot->title) ? 'No Properties' : $lot->title }}</h1>
                @endforeach
                <p>Memorial Garden Details</p>
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

        <div class="garden-content">
            <!-- Garden Overview Section -->
            @foreach ($lots as $lot)
                <div class="garden-overview">
                    <div class="garden-image">
                        <img src="{{ asset('lots/' . $lot->image) }}" alt="Bahay Kubo">
                    </div>

                    <div class="garden-details-card">
                        <div class="garden-header">
                            <div>
                                <h2>{{ $lot->title }}</h2>
                                <p class="garden-type">{{ $lot->type }}</p>
                                <div class="garden-tags">
                                    <span class="tag premium">{{ $lot->area }}</span>
                                    <span class="tag">{{ $lot->marker }}</span>
                                </div>
                            </div>
                            <div class="garden-actions">
                                <a href="{{ url('editLot/' . $lot->id) }}" class="btn btn-primary">
                                    <i class="fas fa-edit"></i> Edit Garden
                                </a>
                                <a href="#" class="btn btn-danger">
                                    <i class="fas fa-trash"></i> Delete
                                </a>
                            </div>
                        </div>

                        <div class="garden-info-grid">
                            <div class="info-item">
                                <i class="fas fa-ruler-combined"></i>
                                <div>
                                    <h4>Total Area</h4>
                                    <p>{{ $lot->size }} sq ft</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-bone"></i>
                                <div>
                                    <h4>Total Slots</h4>
                                    <p>{{ $lot->slots }} plots</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-paw"></i>
                                <div>
                                    <h4>Price</h4>
                                    <p>₱ {{ number_format($lot->price) }}</p>
                                </div>
                            </div>
                            <div class="info-item">
                                <i class="fas fa-calendar"></i>
                                <div>
                                    <h4>Created</h4>
                                    <p>{{ $lot->created_at }}</p>
                                </div>
                            </div>
                        </div>
            @endforeach
            <div class="garden-stats">
                <div class="stat-summary">
                    <h3>Booking Status</h3>
                    <div class="stat-boxes">
                        <div class="stat-box occupied-stat">
                            <h4>{{ App\Models\Status::whereHas('lotsActive', function($query){
                                $query->where('owner_id', session('owner_id'));
                            })->count() }}</h4>
                            <p>Occupied</p>
                        </div>
                        <div class="stat-box reserved-stat">
                            <h4>0</h4>
                            <p>Reserved</p>
                        </div>
                        <div class="stat-box available-stat">
                            <h4>{{ App\Models\Status::where('status_acitve', 'Available')
                                ->whereHas('lotsActive', function($query){
                                    $query->where('owner_id', session('owner_id'));
                                })->count() }}</h4>
                            <p>Available</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bookings Management Section -->
    <div class="section-header with-filter">
        <h2>Plot Bookings</h2>
        <div class="filter-options">
            <select class="filter-select">
                <option value="all">All Plots</option>
                <option value="available">Available</option>
                <option value="occupied">Occupied</option>
                <option value="reserved">Reserved</option>
            </select>
        </div>
    </div>

    @foreach ($lots as $lot)
        <div class="plots-grid">
            @for ($i = 1; $i <= $lot->slots; $i++)
                @php
                    $occupy = $pet
                        ->where('lots_id', $lot->id)
                        ->skip($i - 1)
                        ->first();
                @endphp

                @if ($occupy)
                    <div class="plot-card occupied">
                        <div class="plot-badge">{{ $occupy->status == 'approved' ? 'Occupied' : '' }}</div>
                        <div class="plot-number">{{ $lot->title }}</div>
                        <div class="pet-info">
                            <div class="pet-photo"
                                style="background-image: url('{{ asset('pets/' . $occupy->image) }}')"></div>
                            <div class="pet-details">
                                <h4>{{ $occupy->name }}</h4>
                                <p>{{ $occupy->type }}</p>
                                <p>{{ $occupy->description }}</p>
                                <span class="memorial-date">{{ $occupy->date }}</span>
                            </div>
                        </div>
                        <div class="amenity-item">
                            {{ $occupy->bookings->name }}
                            <div>
                                <a href="#" data-bs-toggle="modal"
                                    data-bs-target="#editPetModal-{{ $occupy->id }}">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="deletePet/{{ $occupy->id }}"><i class="fa fa-trash trash"></i></a>
                            </div>
                        </div>
                    </div>

                    <!-- Add the modal here for each occupied plot -->
                    <div class="modal fade" id="editPetModal-{{ $occupy->id }}" tabindex="-1"
                        aria-labelledby="editPetModalLabel-{{ $occupy->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <form method="POST" action="{{ url('editPet/' . $occupy->id) }}"
                                enctype="multipart/form-data" class="modal-content">
                                @csrf
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editPetModalLabel-{{ $occupy->id }}">Edit Pet Info
                                    </h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3 text-center">
                                        <img src="{{ asset('pets/' . $occupy->image) }}" alt="Pet Photo"
                                            class="rounded-circle" width="80" height="80">
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Pet Name</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $occupy->name }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Type</label>
                                        <input type="text" name="type" class="form-control"
                                            value="{{ $occupy->type }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" required>{{ $occupy->description }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Date</label>
                                        <input type="date" name="date" class="form-control"
                                            value="{{ $occupy->date }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Change Photo</label>
                                        <input type="file" name="image" class="form-control">
                                        <input type="hidden" name="old_image" value="{{ $occupy->image }}">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Cancel</button>
                                    <button type="submit" class="btn btn-primary">Save Changes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="plot-card available">
                        <div class="plot-badge">

                            Available
                        </div>
                        <div class="plot-number">{{ $lot->title }}</div>
                        <div class="pet-info">
                            <p>No pet booked here yet.</p>
                        </div>
                    </div>
                @endif
            @endfor
        </div>
    @endforeach
    <!-- Pagination -->
    {{ $lots->links() }}
    </div>
    </div>

    <!-- Replace the existing Messages Sidebar section with this -->
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
</body>

<!-- Move scripts here, before closing </html> tag -->
<!-- Bootstrap Bundle with Popper -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- Your custom scripts -->
<script>
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

    // Modal handling
    // Modal handling
    document.addEventListener('DOMContentLoaded', function() {
        // Edit button click handler
        document.querySelectorAll('.fa-edit.edit').forEach(function(btn) {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                var id = this.closest('a').getAttribute('href').split('/').pop();
                var modal = document.getElementById('editPetModal-' + id);
                if (modal) {
                    var bsModal = new bootstrap.Modal(modal);
                    bsModal.show();
                }
            });
        });
    });


    // Delete button click handler
    document.querySelectorAll('.fa-trash.trash').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const deleteUrl = this.closest('a').getAttribute('href');

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = deleteUrl;
                }
            });
        });
    });

    // Success messages handling
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('success') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif

    @if (session('message'))
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '{{ session('message') }}',
            timer: 2000,
            showConfirmButton: false
        });
    @endif
</script>

</html>
