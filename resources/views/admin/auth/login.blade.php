<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - 3albal</title>
    <link rel="icon" href="{{ asset('images/3albal.ico') }}" type="image/x-icon" sizes="32x32">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white p-8 rounded-lg shadow-lg w-96">
            <h2 class="text-2xl font-semibold text-center mb-6">Admin Login</h2>

            <form action="{{ route('admin.login') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-gray-700">Email Address</label>
                    <input type="email" name="email" id="email" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700">Password</label>
                    <input type="password" name="password" id="password" class="w-full p-3 border border-gray-300 rounded-lg" required>
                </div>

                @if ($errors->any())
                    <div class="text-red-500 text-sm mb-4">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <div class="flex justify-center">
                    <button type="submit" class="bg-blue-600 text-white p-3 w-full rounded-lg">Login</button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>
