
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>NEXUS Events</title>
  <!-- AOS for Scroll Animations -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

  <!-- VanillaTilt for 3D Tilt Effect -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js"></script>

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    @keyframes float {
      0%,
      100% {
        transform: translateY(0);
      }

      50% {
        transform: translateY(-15px);
      }
    }

    .animate-float {
      animation: float 4s ease-in-out infinite;
    }

    /* Flip card styles */
    .flip-card {
      perspective: 1000px;
      width: 100%;
      height: 250px;
    }

    .flip-card-inner {
      position: relative;
      width: 100%;
      height: 100%;
      transition: transform 0.8s;
      transform-style: preserve-3d;
    }

    .flip-card:hover .flip-card-inner {
      transform: rotateY(180deg);
    }

    .flip-card-front,
    .flip-card-back {
      position: absolute;
      width: 100%;
      height: 100%;
      border-radius: 1rem;
      overflow: hidden;
      -webkit-backface-visibility: hidden;
      backface-visibility: hidden;
    }

    .flip-card-front img {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }

    .flip-card-back {
      background: linear-gradient(135deg, rgba(10, 10, 30, 0.95), rgba(20, 0, 50, 0.95));
      transform: rotateY(180deg);
      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;
      padding: 1rem;
      border: 1px solid rgba(0, 255, 255, 0.3);
      box-shadow: 0 0 20px rgba(0, 255, 255, 0.2);
    }

    .flip-card-back h3 {
      font-size: 1.2rem;
      font-weight: bold;
      color: cyan;
      margin-bottom: 0.5rem;
      text-shadow: 0 0 8px purple, 0 0 15px cyan;
      padding: 0 0.5rem;
      word-break: break-word;
    }

    .flip-card-back p {
      font-size: 0.95rem;
      color: #eee;
      margin: 0.2rem 0;
    }

    /* Card container hover effect & pull-up */
    .tilt-card {
      background-color: #1f2937; /* Tailwind's gray-800 */
      transition: transform 0.3s ease, background-color 0.3s ease, box-shadow 0.3s ease;
      border-radius: 0.75rem; /* match rounded-xl */
      overflow: hidden;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
      cursor: pointer;
    }

    .tilt-card:hover {
      transform: translateY(-12px) scale(1.05);
      background-color: #404246ff; /* Tailwind blue-500 */
      box-shadow: 0 15px 25px rgba(59, 130, 246, 0.5);
      z-index: 10;
    }

  </style>
</head>

<body class="bg-gray-900 text-white relative">

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
        <img src="./img/ne.png" alt="" class="rounded-2xl animate-float" />
      </div>
      <h1
        class="text-5xl md:text-6xl font-bold mb-4 bg-clip-text text-transparent bg-gradient-to-r from-blue-300 to-purple-300">
        NEXUS
      </h1>
      <p class="text-xl md:text-2xl max-w-3xl mx-auto leading-relaxed text-gray-200">
        Connecting minds, fostering innovation, and building the future together
      </p>
    </section>

   

    <!-- Upcoming Events Section -->
    <section class="max-w-6xl mx-auto px-6 py-12">
      <h2 class="text-3xl font-bold text-center mb-10 text-purple-300">Upcoming Events</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
        <?php
        $upcoming_events = [
    [
        "title" => "Upcoming Event",
        "description" => "Event details will be updated soon.",
        "date" => "Coming Soon",
        "image" => "./assets/img/placeholder.jpg",
        "badge" => "Coming Soon"
    ],
    [
        "title" => "Upcoming Event",
        "description" => "Event details will be updated soon.",
        "date" => "Coming Soon",
        "image" => "./assets/img/placeholder.jpg",
        "badge" => "Coming Soon"
    ],
    [
        "title" => "Upcoming Event",
        "description" => "Event details will be updated soon.",
        "date" => "Coming Soon",
        "image" => "./assets/img/placeholder.jpg",
        "badge" => "Coming Soon"
    ]
];

        foreach ($upcoming_events as $index => $event) {
          $delay = $index * 180; // slightly slower stagger
          echo '
    <div class="tilt-card" data-aos="fade-up" data-aos-delay="' . $delay . '">
      <img src="' . $event["image"] . '" alt="' . $event["title"] . '" class="w-full h-48 object-cover" />
      <div class="p-4 transition-all duration-500 group-hover:bg-opacity-90">
        <h3 class="text-xl font-bold text-purple-400 mb-1">' . $event["title"] . '</h3>
        <p class="text-sm text-gray-300 mb-2">' . $event["description"] . '</p>
        <p class="text-xs text-purple-200 mb-1">📅 ' . $event["date"] . '</p>';
          if (isset($event["fee"])) {
            echo '<p class="text-xs text-blue-300 mb-1">💸 Fee: ' . $event["fee"] . '</p>';
          }
          if (isset($event["badge"])) {
            echo '<span class="inline-block bg-purple-700 text-xs px-2 py-1 rounded-full text-white">' . $event["badge"] . '</span>';
          }
          if(isset($event['id'])==1) {
            echo '<a href="./workshop.php" class="ml-5"><button class="inline-block bg-purple-700 text-xs px-2 py-1 rounded-full text-white">View</button></a>';
          }
          echo '
          
      </div>
    </div>';
        }
        ?>
      </div>
    </section>

     <!-- Past Events Section -->
    <section class="max-w-6xl mx-auto px-6 py-12">
      <h2 class="text-3xl font-bold text-center mb-10 text-purple-300">Past Events</h2>
      <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
        <?php
       $gallery = [
    [
        "title" => "Text Web Social Media Analytics",
        "guest" => "Dr. R. Lokesh Kumar (VIT Chennai)",
        "date" => "25 Oct 2024",
        "image" => "../frontend/img/text_social_media/51.jpeg",
        "badge" => "Guest Lecture"
    ],
    [
        "title" => "Laravel – Building Modern Web Applications",
        "guest" => "Mr. K. Anandraj, CEO, TM Innovations",
        "date" => "08 Feb 2025 to 14 Feb 2025",
        "image" => "../frontend/img/laravel.jpeg",
        "badge" => "Workshop"
    ],
    [
        "title" => "Django and its Frameworks",
        "guest" => "Mr. K. Anandraj, CEO, TM Innovations",
        "date" => "15 Feb 2025 to 20 Feb 2025",
        "image" => "../frontend/img/workshop_django/24.jpeg",
        "badge" => "Workshop"
    ],
    [
        "title" => "Mastering the job hunt – interview preparation for professional careers",
        "guest" => "Mr. Arasakumar S, Senior Software Engineer, Infosys Pvt. Ltd.",
        "date" => "09 Nov 2024",
        "image" => "../frontend/img/2024_inaug/16.jpeg",
        "badge" => "Career Talk"
    ],

    // Old Upcoming Events moved to Past Events

    [
        "title" => "State-level Hands-on Workshop on “Deploying the Applications on AWS cloud”",
        "guest" => "Association Event",
        "date" => "6th September",
        "image" => "./assets/img/aws.png",
        "badge" => "Workshop"
    ],
    [
        "title" => "Code Crafters Club – 4-Month Association Activities (Team-Based)",
        "guest" => "Association Event",
        "date" => "Duration 4-Month",
        "image" => "./assets/img/C.png",
        "badge" => "Association Activities"
    ],
    [
        "title" => "The Full Stack Approach to SAP Integration and Customization",
        "guest" => "Association Event",
        "date" => "23.08.2025 & Saturday - 12:00pm - 1:30pm",
        "image" => "./assets/img/FSapp.png",
        "badge" => "Tech Talk"
    ],
    [
        "title" => "Build your TechStack: The Digital Toolbox for Future Engineers",
        "guest" => "Association Event",
        "date" => "13.09.2025 & Saturday",
        "image" => "./assets/img/Fe.gif",
        "badge" => "Tech Talk"
    ]
];

        foreach ($gallery as $index => $event) {
          $delay = $index * 150; // stagger delay 150ms
          echo '
      <div class="tilt-card" data-aos="fade-up" data-aos-delay="' . $delay . '">
        <img src="' . $event["image"] . '" alt="' . $event["title"] . '" class="w-full h-48 object-cover" />
        <div class="p-4">
          <h3 class="text-xl font-bold text-purple-400 mb-1">' . $event["title"] . '</h3>
          <p class="text-sm text-gray-300 mb-1"><strong>Chief Guest:</strong> ' . $event["guest"] . '</p>
          <p class="text-xs text-purple-200 mb-1">📅 ' . $event["date"] . '</p>';
          if (isset($event["badge"])) {
            echo '<span class="inline-block bg-purple-700 text-xs px-2 py-1 rounded-full text-white">' . $event["badge"] . '</span>';
          }
          echo '
        </div>
      </div>';
        }
        ?>
      </div>
    </section>

  </div>
  <script>
    AOS.init({
      duration: 700, // snappier animation
      easing: 'ease-in-out',
    
      mirror: false
    });

    VanillaTilt.init(document.querySelectorAll(".tilt-card"), {
      max: 15,
      speed: 400,
      glare: true,
      "max-glare": 0.2,
    });
  </script>

</body>

</html>
