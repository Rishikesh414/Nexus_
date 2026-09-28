 
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NEXUS Gallery</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    /* Floating animation for nodes */
    @keyframes float {
      0%,100%{transform: translateY(0);}
      50%{transform: translateY(-10px);}
    }
    .animate-float { animation: float 4s ease-in-out infinite; }

    /* Image hover effect */
    .gallery-card img {
      transition: transform 0.5s ease, filter 0.5s ease;
    }
    .gallery-card:hover img {
      transform: scale(1.1) rotate(1deg);
      filter: brightness(1.1);
    }
  </style>
</head>
<body class="bg-gray-900 relative text-white">

  <!-- 3D Background -->
  <div class="fixed inset-0 z-0 pointer-events-none">
    <?php include("includes/3d.php"); ?>
  </div>

  <!-- Main Content -->
  <div class="relative z-10">

    <!-- Navbar -->
    <?php include("includes/navbar.php"); ?>

    <!-- Hero Section -->
    <section class="text-center py-16 px-6">
      <div class="inline-flex items-center justify-center w-28 h-28 mb-6 mx-auto">
            </div>
      <h1 class="text-5xl md:text-6xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-300 to-purple-300">
        NEXUS Gallery
      </h1>
      <p class="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed text-gray-200">
        Explore moments from our workshops, hackathons, and events.
      </p>
    </section>


<!-- Gallery Section -->
<section class="max-w-6xl mx-auto px-6 py-12">
  <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
    <?php
    // Gallery items with multiple images for slider
    $gallery = [
      [
        "title" => "2023 Inauguration Images",
        "images" => [
          "../frontend/img/2023_inaug/IMG_8697.JPG",
          "../frontend/img/2023_inaug/IMG_8699.JPG",
          "../frontend/img/2023_inaug/IMG_8731.JPG",
          "../frontend/img/2023_inaug/IMG_8736.JPG",
          "../frontend/img/2023_inaug/IMG_8743.JPG",
          "../frontend/img/2023_inaug/IMG_8748.JPG",
          "../frontend/img/2023_inaug/IMG_8786.JPG",
          "../frontend/img/2023_inaug/IMG_8787.JPG",
          "../frontend/img/2023_inaug/IMG_8808.JPG",
          "../frontend/img/2023_inaug/IMG_8823.JPG",
          "../frontend/img/2023_inaug/IMG_8838.JPG"
        ]
      ],
      [
        "title" => "2024 Inauguration Images",
        "images" => [
          "../frontend/img/2024_inaug/1.jpg",
          "../frontend/img/2024_inaug/2.jpg",
          "../frontend/img/2024_inaug/3.jpg",
          "../frontend/img/2024_inaug/4.jpg",
          "../frontend/img/2024_inaug/5.jpg",
          "../frontend/img/2024_inaug/6.jpg",
          "../frontend/img/2024_inaug/7.jpg",
          "../frontend/img/2024_inaug/8.jpg",
          "../frontend/img/2024_inaug/9.jpg",
          "../frontend/img/2024_inaug/10.jpg",
          "../frontend/img/2024_inaug/11.jpg",
          "../frontend/img/2024_inaug/12.jpg",
          "../frontend/img/2024_inaug/13.jpg",
          "../frontend/img/2024_inaug/14.jpeg",
          "../frontend/img/2024_inaug/15.jpeg",
          "../frontend/img/2024_inaug/16.jpeg",
          "../frontend/img/2024_inaug/17.jpeg",
          "../frontend/img/2024_inaug/18.jpeg",
          "../frontend/img/2024_inaug/19.jpeg"
        ]
      ],
      [
        "title" => "Workshop on Django",
        "images" => [
          "../frontend/img/workshop_django/21.jpeg",
          "../frontend/img/workshop_django/22.jpeg",
          "../frontend/img/workshop_django/23.jpeg",
          "../frontend/img/workshop_django/24.jpeg",
        ]
      ],
      [
        "title" => "Workshop on Angular-js",
        "images" => [
          "../frontend/img/workshop_on_angular_js/31.jpeg",
          "../frontend/img/workshop_on_angular_js/32.jpeg",
          "../frontend/img/workshop_on_angular_js/34.jpeg",
          "../frontend/img/workshop_on_angular_js/35.png",
        ]
      ],
      [
        "title" => "Power seminar on Cyber Security",
        "images" => [
          "../frontend/img/cybersecurity/41.jpeg",
          "../frontend/img/cybersecurity/42.jpeg",
          "../frontend/img/cybersecurity/43.jpeg",
          "../frontend/img/cybersecurity/44.jpeg",
        ]
      ],
      [
        "title" => "Text Web Social Media Analytics",
        "images" => [
          "../frontend/img/text_social_media/51.jpeg",
          "../frontend/img/text_social_media/52.jpeg",
          "../frontend/img/text_social_media/53.jpeg"
        ]
      ],
      [
        "title" => "Sports",
        "images" => [
          "../frontend/img/sports/71.jpeg",
          "../frontend/img/sports/72.jpg"
        ]
      ],
      [
    "title" => "Conference",
    "images" => [
        "../frontend/img/conference/1.jpeg",
        "../frontend/img/conference/2.jpeg",
        "../frontend/img/conference/3.jpeg",
        "../frontend/img/conference/4.jpeg",
    ]
],
[
"title" => "symposium",
    "images" => [
        "../frontend/img/symposium/1.jpg",
        "../frontend/img/symposium/2.jpg",
        "../frontend/img/symposium/3.jpg",
        "../frontend/img/symposium/4.jpg",
         "../frontend/img/symposium/5.jpg",
         "../frontend/img/symposium/6.jpg",
          "../frontend/img/symposium/7.jpg",
           "../frontend/img/symposium/8.jpg",
            "../frontend/img/symposium/9.jpg",
             "../frontend/img/symposium/10.jpeg",
              "../frontend/img/symposium/11.jpeg",
               "../frontend/img/symposium/12.jpeg",
    ]
    ],
    [
    "title" => "2025 Inauguration",
    "images" => [
        "../frontend/img/2025_inaug/1.jpg",
        "../frontend/img/2025_inaug/2.jpg",
        "../frontend/img/2025_inaug/3.jpg",
        "../frontend/img/2025_inaug/4.jpg",
        "../frontend/img/2025_inaug/5.jpg",
        "../frontend/img/2025_inaug/6.jpg",
        "../frontend/img/2025_inaug/7.jpg",
        "../frontend/img/2025_inaug/8.jpg",
    ]
],
[
    "title" => "IT Workshop",
    "images" => [
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/1.jpeg",
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/2.jpeg",
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/3.jpeg",
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/4.jpeg",
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/5.jpeg",
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/6.jpg",
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/7.jpg",
        "../frontend/img/IT - WORKSHOP - 10.09 (1)/IT - WORKSHOP - 10.09/Selected/8.jpg",
    ]
],
[
    "title" => "Guest Lecture",
    "images" => [
        "../frontend/img/guest lecture/1.jpeg",
        "../frontend/img/guest lecture/2.jpeg",
    ]
],
     [
    "title" => "Value Added Course",
    "images" => [
        "../frontend/img/value added course/Selected/1.jpg",
        "../frontend/img/value added course/Selected/2.jpg",
        "../frontend/img/value added course/Selected/3.jpg",
        "../frontend/img/value added course/Selected/4.jpg",
        "../frontend/img/value added course/Selected/5.jpg",
    ]
],
    ];

    foreach($gallery as $index => $item) {
      // Card
      echo '
        <div class="gallery-card relative bg-white/5 rounded-2xl shadow-lg overflow-hidden transition transform hover:scale-105 cursor-pointer"
             onclick="openModal('.$index.')">
          <img src="'.$item["images"][0].'" alt="'.$item["title"].'" class="w-full h-60 object-cover">

          <!-- Overlay -->
          <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-3">
            <h3 class="text-base font-semibold text-white">'.$item["title"].'</h3>
          </div>
        </div>

        <!-- Modal -->
        <div id="modal-'.$index.'" class="fixed inset-0 bg-black/80 hidden justify-center items-center z-50">
          <div class="relative max-w-4xl w-full p-4">
           <!-- Close Button -->
<button onclick="closeModal('.$index.')" 
  class="absolute top-4 right-4 text-white text-5xl font-bold z-50 
         hover:text-red-500 transition-all duration-300">
  &times;
</button>



            <!-- Swiper Slider -->
            <div class="swiper mySwiper-'.$index.' rounded-2xl overflow-hidden">
              <div class="swiper-wrapper">';
                foreach($item["images"] as $img) {
                  echo '<div class="swiper-slide">
                          <img src="'.$img.'" class="w-full h-[500px] object-contain bg-black" />
                        </div>';
                }
      echo '    </div>
              <!-- Navigation -->
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
              <div class="swiper-pagination"></div>
            </div>
          </div>
        </div>
      ';
    }
    ?>
  </div>
</section>

<!-- Footer -->
<?php include("includes/footer.php"); ?>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

<script>
function openModal(index) {
  let modal = document.getElementById("modal-" + index);
  modal.classList.remove("hidden");
  modal.classList.add("flex");

  // Initialize Swiper only once per modal
  if (!modal.dataset.initiated) {
   new Swiper(".mySwiper-" + index, {
  loop: true,
  pagination: { el: ".swiper-pagination", clickable: true },
  navigation: { nextEl: ".swiper-button-next", prevEl: ".swiper-button-prev" },
  keyboard: {
    enabled: true,       // allow keyboard navigation
    onlyInViewport: true // optional: works only if modal is visible
  }
});

    modal.dataset.initiated = true;
  }
}

function closeModal(index) {
  let modal = document.getElementById("modal-" + index);
  modal.classList.remove("flex");
  modal.classList.add("hidden");
}
</script>


</body>
</html>
