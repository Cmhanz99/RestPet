<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Register User</title>
    <link rel="icon" href="{{asset ('logo/logo1.png')}}">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="flex items-center justify-center min-h-screen bg-gray-100 py-2">
    <div class="w-full max-w-md p-8 bg-white rounded shadow-[1px_1px_2px_rgba(0,0,0,0.5)]">
        <h2 class="text-2xl font-bold text-center mb-6">Register User</h2>
        <form action="/registerUser" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium">Name</label>
                <input type="text" name="name" placeholder="Full name" class="w-full p-2 outline-none bg-gray-200 rounded" required>
            </div>
            <div class="mb-4">
                <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                <input type="email" name="email" placeholder="hanz@gmail.com" class="w-full p-2 outline-none bg-gray-200 rounded" required>
            </div>
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium">Password</label>
                <input type="password" name="password" placeholder="Password" class="w-full p-2  bg-gray-200 rounded" required>
            </div>
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium">Profile</label>
                <input type="file" name="image" class="w-full p-2 bg-gray-200 rounded" required>
            </div>
            <button type="submit" class="w-full p-2  bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-400 transition-colors">Register</button>

            <div class="mt-4 text-center text-sm">
                <span>already have account? </span>
                <a href="/loginUser" class="text-blue-600 hover:underline">login here</a>
            </div>
        </form>
    </div>
</body>
<script>
    @if (session('success'))
    Swal.fire({
        icon: 'success',
        title: 'User registered!',
        text: '{{ session('success') }}',
        confirmButtonText: 'OK',
        confirmButtonColor: '#3085d6'
    });
@endif
</script>
</html>
