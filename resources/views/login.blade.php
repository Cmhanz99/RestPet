    <!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Login Owner</title>
        <link rel="icon" href="{{asset ('logo/logo1.png')}}">
        <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body class="flex items-center justify-center min-h-screen bg-gray-100">
        <div class="w-full relative max-w-md p-8 bg-white rounded shadow-[1px_1px_2px_rgba(0,0,0,0.5)]">
            <h2 class="text-2xl font-bold text-center mb-6">Login Owner</h2>
            <a href="/" class="absolute top-3 left-8
            "><i class="fa fa-arrow-left"></i></a>
            <form action="/login" method="post">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block mb-2 text-sm font-medium">Email</label>
                    <input type="email" name="email" placeholder="Email" value="{{old('email')}}" class="w-full p-2 bg-gray-200 rounded"
                        required>
                </div>

                <div class="mb-6">
                    <label for="password" class="block mb-2 text-sm font-medium">Password</label>
                    <input type="password" name="password" placeholder="Password" class="w-full p-2 bg-gray-200 rounded"
                        required>
                </div>

                <button type="submit"
                    class="w-full p-2 bg-blue-500 text-white rounded cursor-pointer hover:bg-blue-400 transition-colors">Login</button>

                <div class="mt-4 text-center text-sm">
                    <span>Have account? </span>
                    <a href="/register" class="text-blue-600 hover:underline">register here</a>
                </div>
                <div class="mt-4 text-center text-sm">
                    <a href="/loginUser" class="text-white px-10 py-2 bg-black rounded">User Login</a>
                </div>
            </form>
        </div>
    </body>
    <script>
        @if (session('error'))

            Swal.fire({
                icon: 'error',
                title: 'Cannot found the user!',
                text: '{{ session('error') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        @endif
    </script>
    <script>
        @if (session('password'))

            Swal.fire({
                icon: 'error',
                title: 'Password is incorrect!',
                text: '{{ session('password') }}',
                confirmButtonText: 'OK',
                confirmButtonColor: '#3085d6'
            });
        @endif
    </script>
    </html>
