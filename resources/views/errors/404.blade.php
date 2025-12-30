<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>404 | Lost in the Cosmos</title>
  <link rel="icon" href="{{ asset('images/3albal.ico') }}" type="image/x-icon" sizes="32x32">

  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
  <style>
    body {
      margin: 0;
      background: radial-gradient(ellipse at bottom, #0d1b2a 0%, #000000 100%);
      overflow: hidden;
      font-family: 'Segoe UI', sans-serif;
      color: white;
    }

    .stars, .meteors {
      position: absolute;
      top: 0;
      left: 0;
      width: 200%;
      height: 200%;
      background: transparent url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Ccircle cx='1' cy='1' r='1' fill='white'/%3E%3C/svg%3E") repeat;
      animation: moveStars 150s linear infinite;
    }

    @keyframes moveStars {
      0% { transform: translate(0, 0); }
      100% { transform: translate(-50%, -50%); }
    }

    .meteor {
      position: absolute;
      width: 2px;
      height: 100px;
      background: linear-gradient(180deg, white, transparent);
      animation: meteor 6s linear infinite;
      opacity: 0.6;
    }

    @keyframes meteor {
      0% {
        transform: translateY(-200px) translateX(0);
        opacity: 0;
      }
      10% {
        opacity: 1;
      }
      100% {
        transform: translateY(120vh) translateX(30vw);
        opacity: 0;
      }
    }

    .glow-text {
      text-shadow: 0 0 20px rgba(255,255,255,0.8), 0 0 30px rgba(99,102,241,0.8);
    }

    .floating {
      animation: float 4s ease-in-out infinite;
    }

    @keyframes float {
      0%, 100% { transform: translateY(0); }
      50% { transform: translateY(-12px); }
    }

    .planet {
      width: 50px;
      height: 50px;
      background: radial-gradient(circle, #00c6ff, #0072ff);
      border-radius: 50%;
      position: absolute;
      bottom: 60px;
      left: 40px;
      box-shadow: 0 0 20px rgba(0, 183, 255, 0.6);
      transition: transform 0.3s ease-in-out;
    }

    .planet:hover {
      transform: scale(1.2) rotate(20deg);
    }

    .astronaut {
      width: 60px;
      height: 60px;
      background: url('https://cdn-icons-png.flaticon.com/512/785/785116.png') no-repeat center center;
      background-size: contain;
      position: absolute;
      top: 20%;
      right: 10%;
      animation: float 6s ease-in-out infinite;
    }

    .backdrop {
      background-color: rgba(0, 0, 0, 0.5);
      backdrop-filter: blur(10px);
      border-radius: 1rem;
      padding: 2rem;
      z-index: 10;
    }
  </style>
</head>
<body class="flex items-center justify-center min-h-screen relative">

  {{-- ✨ Starfield --}}
  <div class="stars z-0"></div>

  {{-- ☄️ Random meteors --}}
  <div class="meteor" style="top: 0; left: 20%; animation-delay: 0s;"></div>
  <div class="meteor" style="top: -200px; left: 70%; animation-delay: 2s;"></div>
  <div class="meteor" style="top: -400px; left: 40%; animation-delay: 4s;"></div>

  {{-- 🪐 Hoverable planet --}}
  <div class="planet"></div>

  {{-- 🧑‍🚀 Astronaut --}}
  <div class="astronaut"></div>

  {{-- 🔥 Content --}}
  <div class="backdrop relative z-10 text-center max-w-md px-6">
    <img src="{{ asset('images/3albal.jpg') }}" alt="Logo" class="mx-auto mb-6 w-20 h-20 rounded-full shadow-lg floating">

    <h1 class="text-6xl font-extrabold text-indigo-300 glow-text">404</h1>
    <h2 class="mt-4 text-xl font-bold">Lost in the Cosmos</h2>
    <p class="mt-2 text-gray-300">This galaxy doesn't contain the page you're looking for.</p>

    <a href="{{ url('/') }}" class="mt-6 inline-block px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl transition-all duration-300 shadow-lg">
      🚀 Return to Base
    </a>
  </div>

</body>
</html>
