<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Login - 3albal</title>
    <link rel="icon" href="{{ asset('images/3albal.ico') }}" type="image/x-icon" sizes="32x32">

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* 3D Hover Effects */
        .shadow-3d {
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1), 0 10px 10px rgba(0, 0, 0, 0.2);
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        }

        .shadow-3d:hover {
            transform: translateY(-10px);
            box-shadow: 0 30px 60px rgba(0, 0, 0, 0.3), 0 15px 15px rgba(0, 0, 0, 0.3);
        }

        /* Smooth Animations */
        @keyframes fadeIn {
            0% {
                opacity: 0;
                transform: translateY(20px);
            }

            100% {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fadeIn {
            animation: fadeIn 1.5s ease-in;
        }

        /* 3D Floating Effects for Inputs */
        .input-3d {
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease-out, box-shadow 0.3s ease-out;
        }

        .input-3d:focus {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .input-3d:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .hero-bg {
            background: linear-gradient(45deg, #34c1a1, #216ed6);
        }
    </style>
</head>

<body class="bg-gray-100">

    <!-- Store Login Page -->
    <section class="h-screen flex items-center justify-center hero-bg text-white">
        <div class="w-full max-w-md bg-white p-10 rounded-lg shadow-3d">
        <img src="{{ asset('images/3albal-removebg-preview.png') }}" alt="3albal Logo" class="h-10 md:h-10 animate-logo-spin">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6 fadeIn">Store Panel Login</h2>

            <form id="storeLoginForm" method="POST" action="/store-login">
                @csrf

                <!-- Email Input -->
<div class="mb-6">
    <label for="email" class="block mb-2 text-lg text-gray-700">Email</label>
    <input type="email" name="email" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-gray-900 placeholder-gray-500" placeholder="Enter your email" required>
</div>

<div class="space-y-3">
<!-- Password Input -->
<div class="relative">
    <label for="password" class="block mb-2 text-lg text-gray-700">Password</label>
    <input type="password" id="password" name="password" class="w-full px-4 py-2 border-2 border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500 focus:border-teal-500 text-gray-900 placeholder-gray-500" placeholder="Enter your password" required>

    <!-- Show/Hide Password Icon -->
    <button type="button" onclick="togglePassword()" class="absolute top-1/2 right-3 transform -translate-y-1/2 text-gray-600">
        <i id="toggle-icon" class="fas fa-eye"></i>
    </button>
</div>

<!-- Error Message -->
<div id="login-error"
     class="hidden px-5 py-4 bg-red-50 border border-red-200 rounded-lg text-center shadow-md">
    
    <div class="text-red-700 font-semibold text-sm mb-1">
        Login Failed / فشل تسجيل الدخول
    </div>
    <div id="login-error-msg"
         class="text-red-600 text-sm leading-snug whitespace-pre-line">
    </div>
</div>


<!-- Submit Button -->
<button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-blue-600 text-black rounded-lg shadow-lg transform hover:scale-105 transition-all focus:outline-none focus:ring-4 focus:ring-teal-300 hover:bg-teal-600">
    Login
</button>
</div>
<!-- Submit Button -->
<!--<button type="submit" class="w-full py-3 bg-gradient-to-r from-teal-500 to-blue-600 text-white rounded-lg shadow-lg transform hover:scale-105 transition-all focus:outline-none focus:ring-4 focus:ring-teal-300 hover:bg-teal-600">
    Login
</button> -->


            <!-- Forgot Password & Contact Support Links -->
            <div class="text-center mt-4">
                <a href="#" class="text-sm text-teal-500 hover:underline">Forgot your password?</a>
                <div class="mt-2">
                    <a href="mailto:3albal@codeela.com" class="text-sm text-blue-600 hover:underline">Don’t have an account? Contact Support</a>
                </div>
            </div>
        </div>
    </section>

    <!-- JS to toggle password visibility -->
    <script>
        function togglePassword() {
            var passwordField = document.getElementById("password");
            var toggleIcon = document.getElementById("toggle-icon");

            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.remove("fa-eye");
                toggleIcon.classList.add("fa-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.remove("fa-eye-slash");
                toggleIcon.classList.add("fa-eye");
            }
        }

    const form = document.getElementById('storeLoginForm');
    const box = document.getElementById('login-error');
    const msg = document.getElementById('login-error-msg');

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); // ✅ NO PAGE RELOAD

        box.classList.add('hidden');
        msg.textContent = '';

        const formData = new FormData(form);

        const res = await fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': formData.get('_token'),
            },
            body: formData
        });

        // ✅ success -> redirect
        if (res.ok) {
            const data = await res.json();
            if (data.redirect) window.location.href = data.redirect;
            return;
        }

        let data = {};
        try { data = await res.json(); } catch (err) {}

        box.classList.remove('hidden');

        // ✅ Validation errors (422) from Laravel validator
        if (res.status === 422 && data.errors) {
            // show first error bilingual-ish (Laravel default is English unless you localize validation)
            const firstKey = Object.keys(data.errors)[0];
            const firstMsg = data.errors[firstKey][0];
            msg.textContent = `${firstMsg}\n${translateValidation(firstMsg)}`;
            return;
        }

        // ✅ Custom errors (401/403)
        msg.textContent = data.message || "Something went wrong.\nحدث خطأ. حاول مرة أخرى";
    });

    // Tiny helper so required/email errors also appear bilingual without changing Laravel validation files
    function translateValidation(enMsg) {
        const m = enMsg.toLowerCase();

        if (m.includes('email') && m.includes('required')) return 'البريد الإلكتروني مطلوب';
        if (m.includes('password') && m.includes('required')) return 'كلمة المرور مطلوبة';
        if (m.includes('email') && m.includes('valid')) return 'أدخل بريدًا إلكترونيًا صحيحًا';
        return 'يرجى التحقق من البيانات المدخلة';
    }
    </script>

</body>

</html>
