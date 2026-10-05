```php
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>NEXUS - Placements</title>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS Animation -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">

  <style>

    .placement-card {
      background: rgba(255, 255, 255, 0.96);
      border-radius: 20px;
      padding: 20px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.20);
      transition: all 0.4s ease;
    }

    .placement-card:hover {
      transform: translateY(-8px);
      box-shadow: 0 18px 40px rgba(0, 0, 0, 0.30);
    }

    .photo-box {
      width: 180px;
      height: 210px;
      overflow: hidden;
      border-radius: 14px;
      margin: 0 auto 18px;
      background: #f3f3f3;
    }

    .photo-box img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.4s ease;
    }

    .placement-card:hover .photo-box img {
      transform: scale(1.05);
    }

    .year-btn.active {
      background: #7c3aed;
      color: white;
      border-color: #7c3aed;
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


    <!-- Title -->
    <nav class="bg-gray-800 text-white p-4 text-center text-lg font-semibold">
      NEXUS - Placements
    </nav>


    <main class="relative z-10 pt-16">


      <!-- Placement Section -->
      <section class="py-16 px-4 sm:px-8 md:px-[3cm] max-w-screen-xl mx-auto">


        <!-- Heading -->
        <h2
          class="text-4xl font-bold text-center text-purple-400 mb-10"
          data-aos="fade-up">
          Placement
        </h2>


        <!-- Year Buttons -->
        <div
          class="flex justify-center gap-4 mb-12 flex-wrap"
          data-aos="fade-up">


          <!-- 2027 FIRST -->
          <button
            class="year-btn active px-7 py-3 rounded-full text-purple-300 border border-purple-500 hover:bg-purple-700 hover:text-white transition"
            data-year="2026">
            2026
          </button>


          <!-- 2026 SECOND -->
          <button
            class="year-btn px-7 py-3 rounded-full text-purple-300 border border-purple-500 hover:bg-purple-700 hover:text-white transition"
            data-year="2025">
            2025
          </button>


        </div>


        <!-- Placement Cards -->
        <div
          id="placement-container"
          class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
        </div>


      </section>


    </main>

  </div>


  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>


  <script>

    AOS.init({
      duration: 1000,
      easing: 'ease-in-out'
    });


    /* =========================
       PLACEMENT DATA
    ========================= */

    const data = {


      /* =========================
         2025
      ========================= */

      2025:[
        {
          name: "Naveen Bharathi.B",
          company: "WG TECH",
          place: "Bangalore",
          salary:"8LPA",
          img: "./assets/img/11 NAVEEN BHARATHI.jpg"
        },

        {
          name: "Pravin.K",
          company: "WG TECH",
          place: "Bangalore",
           salary:"2.5LPA",
          img: "./assets/img/PRAVIN.jpg"
        },

        {
          name: "Aaswin.",
          company: "WG TECH",
          place: "COIMBATORE",
           salary:"3LPA",
          img: "./assets/img/AASWIN.jpg"
        },

        {
          name: "Abi Gayathri.",
          company: "PRAMON",
          place: "Chennai",
           salary:"2.5LPA",
          img: "./assets/img/ABI GAYATHRI.jpg"
        },
         {
          name: "Sri Hari Prasath.A",
          company:"LearLike",
          place: "Coimbatore",
           salary:"3LPA",
          img: "./assets/img/21 SRI HARI PRASATH.jpg"
        }

      ],


      /* =========================
         2026
      ========================= */

      2026:[

        {
          name: "Sindhu.S",
          company: "ILAN TECH",
          place: "THENI",
          salary:"STIPEND INTERSHIP ",
          img: "./assets/img/Sindhu s.JPG"
        },

        {
          name: "Harini.P",
          company: "ILAN TECH",
          place: "THENI",
          salary:"STIPEND INTERSHIP ",
          img: "./assets/img/Harini p.JPG"
        },

       

      ]

    };


    /* =========================
       ELEMENTS
    ========================= */

    const container =
      document.getElementById("placement-container");

    const buttons =
      document.querySelectorAll(".year-btn");


    /* =========================
       RENDER YEAR
    ========================= */

    function renderYear(year) {

      container.innerHTML = "";


      data[year].forEach((student, index) => {

        const card =
          document.createElement("div");


        card.className =
          "placement-card text-center";


        card.setAttribute(
          "data-aos",
          "fade-up"
        );


        card.setAttribute(
          "data-aos-delay",
          index * 100
        );


        card.innerHTML = `

          <!-- Photo -->
          <div class="photo-box">

            <img
              src="${student.img}"
              alt="${student.name}"
            >

          </div>


          <!-- Name -->
          <h3
            class="text-xl font-bold text-gray-900 mb-2">
            ${student.name}
          </h3>


          <!-- Company -->
          <p
            class="text-purple-700 font-bold text-lg mb-1">
            ${student.company}
          </p>


          <!-- Place -->
<p
  class="text-gray-700 text-base font-bold">
  ${student.place}
</p>

<!-- Salary -->
<p
  class="text-gray-900 text-base font-bold">
  ${student.salary}
</p>


        `;


        container.appendChild(card);

      });


      AOS.refresh();

    }


    /* =========================
       YEAR BUTTON CLICK
    ========================= */

    buttons.forEach(button => {

      button.addEventListener("click", () => {


        buttons.forEach(btn => {

          btn.classList.remove("active");

        });


        button.classList.add("active");


        const year =
          button.getAttribute("data-year");


        renderYear(year);

      });

    });


    /* =========================
       DEFAULT = 2027
    ========================= */

    renderYear("2026");

  </script>


</body>

</html>
```
