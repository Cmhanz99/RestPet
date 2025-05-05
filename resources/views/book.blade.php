<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pet Memorial Booking</title>
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <link rel="stylesheet" href="{{asset ('css/booking.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    @if(session('success'))
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
    <div class="container">
        <div class="form-header">
            <h1>Pet Memorial Booking</h1>
            <p>Please fill in the details of your beloved pet for memorial reservation</p>
        </div>
        <form class="booking-form" action="/pets/{{$data->id}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="pet_name">Pet Name *</label>
                <input type="text" id="pet_name" name="name" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="pet_type">Pet Type *</label>
                <select id="pet_type" name="type" class="pet-type-select" required>
                    <option value="">Select pet type</option>
                    <option value="Dog">Dog</option>
                    <option value="Cat">Cat</option>
                    <option value="Bird">Bird</option>
                    <option value="Rabbit">Rabbit</option>
                    <option value="Hamster">Hamster</option>
                    <option value="Guinea Pig">Guinea Pig</option>
                    <option value="Fish">Fish</option>
                    <option value="Reptile">Reptile</option>
                    <option value="Other">Other</option>
                </select>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="birth_year">Birth Year</label>
                    <input type="date" id="birth_year" name="birth_year" max="2025-05-06" class="form-control" onchange="updateDeathMin()" required>
                </div>

                <div class="form-group">
                    <label for="death_year">Death Year</label>
                    <input type="date" id="death_year" name="death_year" class="form-control" required>
                </div>
            </div>

            <div class="form-group">
                <label for="pet_image">Pet Image</label>
                <div class="file-upload">
                    <label for="pet_image" class="file-upload-label">
                        <i>📷</i>
                        <span>Click to upload an image</span>
                        <p class="text-muted">Recommended size: 300x300 pixels</p>
                    </label>
                    <input type="file" id="pet_image" name="image" accept="image/*" required>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description / Memorial Message</label>
                <textarea id="description" name="description" class="form-control" rows="5" placeholder="Share a special memory or message about your pet..." required></textarea>
            </div>

            <div class="form-group">
                <label for="service_date">Service Date (for reservations)</label>
                <input type="date" id="service_date" name="date" class="form-control" required>
            </div>

            {{-- <input type="hidden" name="status" value="pending">
            <input type="hidden" name="lot_id" value="1"> <!-- You'll populate this dynamically -->
            <input type="hidden" name="slot_number" value="1"> <!-- You'll populate this dynamically --> --}}

            <div class="btn-booking">
                <button type="submit" class="submit-btn">Submit Booking Request</button>
                <a href="/user" class="back-btn">Back</a>
            </div>

            <div class="note">
                <p><strong>Note:</strong> Your booking request will be reviewed by the property owner. You will receive a confirmation once approved.</p>
            </div>
        </form>
    </div>
</body>
<script>
    function updateDeathMin(){
        var birthDate = document.querySelector('#birth_year').value;

        document.querySelector('#death_year').min = birthDate;
    }
</script>
</html>
