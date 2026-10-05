<!-- includes/navbar.php -->

<nav class="bg-gradient-to-r from-black via-purple-900 to-black backdrop-blur-md shadow-lg fixed top-0 w-full z-50">

  <div class="max-w-7xl mx-auto px-6">

    <div class="flex justify-between items-center h-16">

      <!-- Left: Association Name -->
      <div class="flex-shrink-0">
        <a href="index.php"
           class="text-2xl font-extrabold text-purple-400 tracking-wide drop-shadow-md">
          NEXUS
        </a>
      </div>


      <!-- Right: Menu Links -->
      <div class="hidden md:flex items-center space-x-6 text-gray-200 font-medium">

        <!-- Home -->
        <a href="index.php" class="relative group">
          Home
          <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-purple-500 transition-all group-hover:w-full"></span>
        </a>


        <!-- Events -->
        <a href="events.php" class="relative group">
          Events
          <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-purple-500 transition-all group-hover:w-full"></span>
        </a>


        <!-- Achievements -->
        <a href="achievements.php" class="relative group">
          Achievements
          <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-purple-500 transition-all group-hover:w-full"></span>
        </a>


        <!-- Gallery -->
        <a href="gallery.php" class="relative group">
          Gallery
          <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-purple-500 transition-all group-hover:w-full"></span>
        </a>


        <!-- Office Bearers -->
        <a href="officebearers.php" class="relative group">
          Office Bearers
          <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-purple-500 transition-all group-hover:w-full"></span>
        </a>


        <!-- Register -->
        <a href="placement.php" class="relative group">
          Placement
          <span class="absolute left-0 -bottom-1 w-0 h-0.5 bg-purple-500 transition-all group-hover:w-full"></span>
        </a>


        <!-- Admin Button -->
        <a href="../admin/index.php"
           class="flex items-center gap-2 px-4 py-2 bg-purple-700 hover:bg-purple-800 text-white rounded-full shadow-lg shadow-purple-500/30 transition transform hover:scale-105">

          <span>Admin</span>

        </a>

      </div>


      <!-- Mobile Menu Button -->
      <div class="md:hidden">

        <button id="menu-btn" class="focus:outline-none">

          <svg class="w-7 h-7 text-gray-200"
               fill="none"
               stroke="currentColor"
               viewBox="0 0 24 24">

            <path stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="M4 6h16M4 12h16M4 18h16"/>

          </svg>

        </button>

      </div>

    </div>

  </div>


  <!-- Center Logo -->
  <div class="absolute left-1/2 bottom-0 transform -translate-x-1/2 translate-y-1/2">

    <div class="w-24 h-24 rounded-full bg-purple-500 shadow-lg
                flex items-center justify-center
                ring-4 ring-purple-500/40
                transition hover:scale-110 hover:ring-purple-400">

      <img src="./assets/img/ne.png"
           alt="Logo"
           class="w-22 h-22 object-contain rounded-full">

    </div>

  </div>


  <!-- Mobile Menu -->
  <div id="mobile-menu"
       class="hidden md:hidden px-6 pb-4 space-y-3
              bg-gradient-to-r from-black via-purple-900 to-black
              shadow-md text-gray-200 font-medium">


    <!-- Home -->
    <a href="index.php"
       class="block hover:text-purple-400">
      Home
    </a>


    <!-- About -->
    <a href="about.php"
       class="block hover:text-purple-400">
      About
    </a>


    <!-- Events -->
    <a href="events.php"
       class="block hover:text-purple-400">
      Events
    </a>


    <!-- Achievements -->
    <a href="achievements.php"
       class="block hover:text-purple-400">
      Achievements
    </a>


    <!-- Gallery -->
    <a href="gallery.php"
       class="block hover:text-purple-400">
      Gallery
    </a>


    <!-- Office Bearers -->
    <a href="officebearers.php"
       class="block hover:text-purple-400">
      Office Bearers
    </a>


    <!-- Register -->
    <a href="placement.php"
       class="block hover:text-purple-400">
      placement
    </a>


    <!-- Mobile Admin Button -->
    <a href="../admin/index.php"
       class="block w-fit px-5 py-2 mt-2
              bg-purple-700 hover:bg-purple-800
              text-white rounded-full
              shadow-lg shadow-purple-500/30
              transition transform hover:scale-105">

      Admin

    </a>

  </div>

</nav>


<script>

  const menuBtn = document.getElementById('menu-btn');
  const mobileMenu = document.getElementById('mobile-menu');

  menuBtn.addEventListener('click', () => {

    mobileMenu.classList.toggle('hidden');

  });

</script>