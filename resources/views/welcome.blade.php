


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>3albal - Send Gifts with Heart</title>
  
  <script src="https://cdn.jsdelivr.net/npm/alpinejs@2.8.2" defer></script>
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/swiper/swiper-bundle.min.css" rel="stylesheet" />
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;700&display=swap" rel="stylesheet" />
  
  <link rel="icon" href="{{ asset('images/3albal.ico') }}" type="image/x-icon" sizes="32x32">
  <style>
    html { scroll-behavior: smooth; }
    body { font-family: 'DM Sans', sans-serif; }
    .btn-primary {
      background: linear-gradient(to right, #34c1a1, #216ed6);
      color: white; font-weight: 600;
      padding: 0.75rem 1.5rem; border-radius: 9999px;
      box-shadow: 0 10px 20px rgba(52, 193, 161, 0.3);
      transition: all 0.3s ease;
    }
    .btn-primary:hover {
      transform: translateY(-2px);
      box-shadow: 0 15px 30px rgba(33, 110, 214, 0.4);
    }
    .btn-secondary {
      background-color: #f0f4f8;
      color: #1f2937; font-weight: 500;
      padding: 0.75rem 1.5rem; border-radius: 9999px;
      box-shadow: 0 2px 6px rgba(0,0,0,0.1);
      transition: background 0.3s ease;
    }
    .btn-secondary:hover { background-color: #e5e7eb; }
    .animate-fade-in-down {
      animation: fade-in-down 0.3s ease-out;
    }
    .transform-style-3d {
    transform-style: preserve-3d;
    perspective: 1000px;
  }

  @keyframes fade-slide-up {
    from {
      opacity: 0;
      transform: translateY(12px);
    }
    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fade-slide-up {
    animation: fade-slide-up 0.8s ease-out;
  }
  @keyframes bounce-slow {
      0%, 100% {
        transform: translateY(0);
      }
      50% {
        transform: translateY(-10px);
      }
    }
    .animate-bounce-slow {
      animation: bounce-slow 4s infinite ease-in-out;
    }
  </style>
</head>
<body class="bg-white text-gray-900" x-data="{ open: false }" x-init="AOS.init()">

<header class="fixed top-0 w-full z-50 bg-white shadow-xl">
  <div class="max-w-7xl mx-auto px-6 py-4 flex items-center justify-between">
    
    <!-- Logo Section -->
    <div class="flex items-center space-x-4 group transform-style-3d animate-fade-slide-up transition duration-700">
  <div class="relative w-10 h-10 rounded-full overflow-hidden shadow-lg transform group-hover:rotate-y-12 group-hover:scale-110 transition-all duration-700">
    <img src="/images/3albal.jpg" alt="3albal Logo" class="w-full h-full object-cover" />
  </div>
  <h1 class="text-2xl font-extrabold bg-gradient-to-r from-teal-500 via-blue-500 to-purple-600 bg-clip-text text-transparent transform group-hover:-rotate-x-3 group-hover:scale-105 transition-all duration-700">
    3albal
  </h1>
</div>

<!-- Add this CSS somewhere in your style block or <style> -->



    <!-- Desktop Nav -->
    <nav class="space-x-6 text-sm font-medium hidden sm:flex">
      <a href="#features" class="hover:text-blue-500 transition">Features</a>
      <a href="#screenshots" class="hover:text-blue-500 transition">Screenshots</a>
      <a href="#testimonials" class="hover:text-blue-500 transition">Testimonials</a>
      <a href="/store-login" class="hover:text-blue-500 transition">Store login</a>
      <a href="#contact" class="hover:text-blue-500 transition">Contact</a>
    </nav>

    <!-- Mobile Toggle -->
    <div class="sm:hidden">
      <button @click="open = !open" class="relative z-50 focus:outline-none">
        <div class="bg-gradient-to-r from-blue-500 to-teal-400 p-2 rounded-full shadow-lg transition-all duration-300 transform hover:scale-110">
          <svg x-show="!open" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
          </svg>
          <svg x-show="open" x-cloak xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
          </svg>
        </div>
      </button>
    </div>

  </div> <!-- end inner flex -->

  <!-- Mobile Menu -->
  <div class="sm:hidden fixed inset-0 z-40 flex items-start justify-end px-4 pt-24 bg-black bg-opacity-30 backdrop-blur-sm"
       x-show="open"
       @click.away="open = false"
       x-transition:enter="transition ease-out duration-300"
       x-transition:enter-start="opacity-0 -translate-y-6"
       x-transition:enter-end="opacity-100 translate-y-0"
       x-transition:leave="transition ease-in duration-200"
       x-transition:leave-start="opacity-100 translate-y-0"
       x-transition:leave-end="opacity-0 -translate-y-6">
    <div class="bg-white rounded-3xl shadow-2xl w-full max-w-xs py-6 px-6 space-y-6 text-lg font-semibold text-gray-800 transform animate-fade-in-down border border-blue-100 relative">
      <a href="#features" class="block hover:text-blue-600 transition duration-300 flex items-center gap-2">Features</a>
      <a href="#screenshots" class="block hover:text-blue-600 transition duration-300 flex items-center gap-2">Screenshots</a>
      <a href="#testimonials" class="block hover:text-blue-600 transition duration-300 flex items-center gap-2">Testimonials</a>
      <a href="#store-manager" class="block hover:text-blue-600 transition duration-300 flex items-center gap-2">Store Login</a>
      <a href="#contact" class="block hover:text-blue-600 transition duration-300 flex items-center gap-2">Contact</a>
    </div>
  </div>
</header>


  <body x-data="{ open: false }" x-init="AOS.init()" class="bg-white text-gray-900">

  <!-- Hero Section -->
  <section class="pt-28 pb-16 bg-gradient-to-tr from-blue-100 to-white relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-12 items-center">
      <div data-aos="fade-right">
        <p class="text-blue-600 font-medium uppercase mb-2">Gift Delivery Made Easy</p>
        <h1 class="text-4xl sm:text-5xl font-bold leading-tight mb-4 text-gray-900">
          Send thoughtful gifts with ❤️ to your loved ones
        </h1>
        <p class="text-lg text-gray-600 mb-6">We connect you with the best gift stores in Amman. Choose, personalize, and deliver in just a few taps.</p>
        <div class="flex flex-wrap gap-4">
          <a href="#" class="btn-primary">Download the App</a>
          <a href="#features" class="btn-secondary">See How it Works</a>
        </div>
      </div>
      <div data-aos="fade-left">
        <img src="/images/welcome-removebg-preview.png" alt="App Preview" class="w-full max-w-sm mx-auto shadow-2xl rounded-3xl transform rotate-6 hover:rotate-3 transition duration-500" />
      </div>
    </div>
  </section>

  <!-- Features Section -->
<section id="features" class="py-20 bg-white relative scroll-mt-24">
  <div class="absolute top-0 left-0 w-full h-40 bg-gradient-to-r from-blue-50 to-teal-50 rounded-b-full"></div>
  <div class="text-center mb-12 relative z-10" data-aos="fade-up">
    <h2 class="text-4xl font-bold text-gray-800 mb-2">Amazing Features</h2>
    <p class="text-gray-500 text-lg">Take advantage of a modern, intuitive design that helps you gift better.</p>
  </div>
  <div class="max-w-7xl mx-auto px-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 relative z-10">
    @foreach ([
      ['🎁', 'Real-Time Tracking', 'Know when your gift is prepared, dispatched, and delivered.'],
      ['🛍️', 'Store Dashboard', 'Store managers can easily add products, track orders, and view stats.'],
      ['🌐', 'Multilingual Support', '3albal supports both Arabic and English.'],
      ['📦', 'Verified Stores', 'We manually review every store to ensure quality.'],
      ['📸', 'Photo Approval', 'Customers approve gift photo before it ships.'],
      ['💳', 'Secure Payments', 'Supports Bank Transfer, Apple Pay, Google Pay.'],
    ] as [$icon, $title, $desc])
    <div class="bg-white p-6 rounded-2xl shadow-xl transform hover:scale-105 transition" data-aos="zoom-in">
      <h3 class="font-semibold text-lg mb-2 text-blue-700">{{ $icon }} {{ $title }}</h3>
      <p class="text-gray-600">{{ $desc }}</p>
    </div>
    @endforeach
  </div>
</section>
<!-- Store Manager CTA -->
<section id="store-manager" class="py-20 bg-gradient-to-br from-blue-50 to-white text-center" data-aos="fade-up">
  <div class="max-w-3xl mx-auto px-6">
    <h2 class="text-4xl font-bold text-gray-800 mb-4">Are You a Store Manager?</h2>
    <p class="text-lg text-gray-600 mb-6">Join our platform and showcase your products to thousands of gift buyers across Amman.</p>
    <a href="/store-login" class="btn-primary inline-block">Store Panel Login</a>
  </div>
</section>


<section id="screenshots" class="py-24 bg-gradient-to-b from-white to-blue-50 scroll-mt-24">
  <div class="text-center mb-16" data-aos="fade-up">
    <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-900 tracking-tight">📸 App Screenshots</h2>
    <p class="text-gray-500 text-lg mt-2">A look inside the elegant 3albal experience</p>
  </div>

  <div class="max-w-7xl mx-auto px-4 relative">
    <div class="flex items-center justify-center gap-6 md:gap-12 flex-wrap md:flex-nowrap perspective-[1500px]">

      <!-- Left Phone -->
      <div class="w-[280px] md:w-[300px] h-[600px] relative transform scale-[0.9] rotate-[-6deg] md:-rotate-y-12 transition-transform duration-700 ease-out hover:rotate-0 hover:scale-100"
           style="transform-style: preserve-3d;" data-aos="fade-right">
        <div class="bg-white rounded-[2.5rem] shadow-[0_30px_80px_rgba(0,0,0,0.2)] border border-gray-200 overflow-hidden h-full w-full relative">
          <img src="/images/checkout.png" alt="Checkout Screen" class="w-full h-full object-cover rounded-[2.5rem]">
        </div>
      </div>

      <!-- Center Phone -->
      <div class="w-[300px] md:w-[340px] h-[620px] relative z-10 animate-bounce-slow hover:scale-110 transition-transform duration-700 ease-in-out"
           style="transform-style: preserve-3d;" data-aos="zoom-in">
        <div class="bg-white rounded-[2.5rem] border-[3px] border-blue-300 shadow-[0_80px_160px_rgba(0,0,0,0.35)] overflow-hidden h-full w-full relative">
          <img src="/images/camp_page.png" alt="Campaigns Screen" class="w-full h-full object-cover rounded-[2.5rem]">
          <!-- Glow Effect -->
          <div class="absolute -inset-1 rounded-[2.5rem] bg-blue-300/20 blur-xl animate-pulse pointer-events-none"></div>
        </div>
        <p class="mt-6 text-center text-blue-900 font-bold text-lg tracking-wide">🎉 Campaigns</p>
      </div>

      <!-- Right Phone -->
      <div class="w-[280px] md:w-[300px] h-[600px] relative transform scale-[0.9] rotate-[6deg] md:rotate-y-12 transition-transform duration-700 ease-out hover:rotate-0 hover:scale-100"
           style="transform-style: preserve-3d;" data-aos="fade-left">
        <div class="bg-white rounded-[2.5rem] shadow-[0_30px_80px_rgba(0,0,0,0.2)] border border-gray-200 overflow-hidden h-full w-full relative">
          <img src="/images/myacc.png" alt="My Account Screen" class="w-full h-full object-cover rounded-[2.5rem]">
        </div>
      </div>

    </div>
  </div>

 
  
</section>



<!-- Testimonials -->
<!-- Testimonials Carousel -->
<section id="testimonials" class="py-24 bg-gradient-to-b from-gray-100 to-white scroll-mt-24">
  <div class="text-center mb-16" data-aos="fade-up">
    <h2 class="text-4xl sm:text-5xl font-extrabold text-gray-800">💬 What Our Users Say</h2>
    <p class="text-gray-500 text-lg mt-2">Voices from our amazing gift community</p>
  </div>

  <div class="max-w-4xl mx-auto px-4" data-aos="fade-up">
    <div class="bg-white rounded-3xl shadow-2xl p-10 border border-blue-100 relative overflow-hidden">
      <div class="swiper-container">
        <div class="swiper-wrapper">
          @foreach([
            ['Sarah', '👧', 'Customer', 'Absolutely love it. So easy to send gifts!', 'avatar1.jpg'],
          ['Fadi', '👦', 'Florist', 'Sales doubled after joining 3albal!', 'avatar2.jpg'],
          ['رنا', '👧', 'عميلة', 'منصة سهلة ومميزة لشراء الهدايا.', 'avatar3.jpg'],
          ['Ahmad', '👦', 'Store Owner', 'Great dashboard, super easy to manage.', 'avatar4.jpg'],
          ['Maha', '👧', 'Customer', 'وصلت الهدية في نفس اليوم!', 'avatar5.jpg'],
          ['Zaid', '👦', 'User', 'I love the approval photo step.', 'avatar6.jpg'],
          ['Abeer', '👧', 'Customer', 'تم الطلب بسهولة وكل شيء ممتاز.', 'avatar7.jpg'],
          ['Omar', '👦', 'Gifter', 'Simple and beautiful experience.', 'avatar8.jpg'],
          ['Mona', '👧', 'Florist', 'Product uploads and sales tracking are perfect.', 'avatar9.jpg'],
          ['Tariq', '👦', 'Customer', 'Best gift platform I’ve tried.', 'avatar10.jpg'],
          ['Lina', '👧', 'عميلة', 'واجهة سهلة جدًا وسرعة رائعة.', 'avatar11.jpg'],
          ['Daniel', '👦', 'Customer', 'Support team answered in 2 minutes!', 'avatar12.jpg'],
          ['Nada', '👧', 'User', 'I love the Arabic/English support.', 'avatar13.jpg'],
          ['Sami', '👦', 'Florist', 'أدوات الإدارة مرنة جدًا وسهلة.', 'avatar14.jpg'],
          ['Yasmin', '👧', 'Customer', 'I sent a gift to Irbid from Amman smoothly.', 'avatar15.jpg'],
          ['Khaled', '👦', 'Store Manager', 'More sales than my physical shop.', 'avatar16.jpg'],
          ['Leen', '👧', 'عميلة', 'أبسط تجربة شراء مرّت عليّ.', 'avatar17.jpg'],
          ['Nour', '👧', 'Customer', 'Gift tracking was on point!', 'avatar18.jpg'],
          ['Tamer', '👦', 'Florist', 'Simple, powerful, and efficient.', 'avatar19.jpg'],
          ['Yara', '👧', 'User', 'Sent a teddy bear, arrived perfectly packaged.', 'avatar20.jpg'],
          ['Bilal', '👦', 'Gifter', 'واجهة احترافية وسريعة.', 'avatar21.jpg'],
          ['Dina', '👧', 'Customer', 'Love the design and speed.', 'avatar22.jpg'],
          ['Walid', '👦', 'Customer', 'It’s now my go-to gift app.', 'avatar23.jpg'],
          ['Salma', '👧', 'Customer', 'جربت التطبيق ٣ مرات وكل مرة ممتازة.', 'avatar24.jpg'],
          ['Adel', '👦', 'User', 'Clean UI and no bugs. Love it.', 'avatar25.jpg'],
        ] as [$name, $icon, $role, $quote, $image])
          <div class="swiper-slide">
            <div class="flex flex-col items-center text-center space-y-4">
            <img src="https://api.dicebear.com/9.x/micah/svg?seed=Rana&rotate=0&backgroundColor=ffe0b3&radius=50"   alt="{{ $name }}" class="w-16 h-16 rounded-full border-2 border-blue-400 shadow-md object-cover">
              <p class="text-lg text-gray-700 italic max-w-xl">“{{ $quote }}”</p>
              <div class="flex items-center gap-2 text-sm font-semibold text-gray-800">
                <span>{{ $icon }}</span>
                <span>{{ $name }}</span>
              </div>
              <p class="text-xs text-gray-400">{{ $role }}</p>
            </div>
          </div>
          @endforeach
        </div>
        <div class="swiper-pagination mt-6h hidden"></div>
      </div>
    </div>
  </div>
</section>



<!-- Final CTA -->
<section id="contact" class="py-20 bg-gradient-to-tr from-blue-600 to-teal-500 text-white text-center" data-aos="fade-up">
  <div class="max-w-3xl mx-auto px-6">
    <h2 class="text-4xl font-bold mb-4">Download the App for Free Today</h2>
    <p class="mb-6 text-lg">Become a better gift-giver and improve someone's day with just one click.</p>
    <div class="flex justify-center space-x-4 flex-wrap">
      <a href="#" class="btn-primary bg-white text-blue-600 hover:text-white hover:bg-blue-700">App Store</a>
      <a href="#" class="btn-primary bg-white text-blue-600 hover:text-white hover:bg-blue-700">Google Play</a>
    </div>
  </div>
</section>
<!-- Footer -->
<footer class="bg-gray-900 text-white py-8">
  <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row justify-between items-center text-center sm:text-left">
    <p class="text-sm mb-2 sm:mb-0">© 2025 3albal. All rights reserved.</p>
    <div class="flex items-center space-x-2">
      <span class="text-sm">Developed by</span>
      <a href="https://codeela.com" target="_blank" class="flex items-center space-x-1 hover:underline">
        <img src="/images/codeela-logo.png" alt="Codeela" class="w-5 h-5"> 
        <span class="text-sm font-medium">Codeela</span>
      </a>
    </div>
  </div>
</footer>


  <!-- Swiper & ScrollSpy Scripts -->
  <script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
  <script>
    const swiper = new Swiper('.swiper-container', {
      loop: true,
      pagination: { el: '.swiper-pagination', clickable: true },
      autoplay: { delay: 3000 },
      effect: 'coverflow',
      coverflowEffect: { rotate: 30, slideShadows: false }
    });
  </script>
  <script>
    window.addEventListener('scroll', () => {
      const links = document.querySelectorAll('nav a');
      const sections = [...links].map(link => document.querySelector(link.getAttribute('href')));
      const scrollY = window.scrollY + 150;
      sections.forEach((section, i) => {
        if (section && scrollY >= section.offsetTop && scrollY < section.offsetTop + section.offsetHeight) {
          links.forEach(l => l.classList.remove('text-blue-500'));
          links[i].classList.add('text-blue-500');
        }
      });
    });
  </script>
  
</body>
</html>
