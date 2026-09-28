

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Office Bearers & Roles</title>

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- AOS Animation CSS -->
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet" />

  <style>
    .glass-card {
      background: rgba(255, 255, 255, 0.1);
      backdrop-filter: blur(15px);
      border-radius: 1rem;
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 1.5rem;
    }

    .role-badge {
      background: #8b5cf6;
      padding: 0.25rem 0.75rem;
      border-radius: 9999px;
      font-weight: 600;
      font-size: 0.875rem;
      margin-top: 0.25rem;
      display: inline-block;
      color: white;
    }

    .perspective-1000 {
      perspective: 1000px;
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

    <!-- Static Title Bar -->
    <nav class="bg-gray-800 text-white p-4 text-center text-lg font-semibold">
      NEXUS - Office Bearers & Roles
    </nav>

    <main class="relative z-10 pt-16">

      <!-- Roles Section -->
      <section class="py-20 px-4 sm:px-8 md:px-[3cm] max-w-screen-xl mx-auto" data-aos="fade-up">
        <h2 class="text-4xl font-bold text-center text-purple-400 mb-12">
          Roles & Responsibilities
        </h2>

        <div class="space-y-12">
          <!-- President -->
          <div class="glass-card p-8" data-aos="fade-right">
            <h3 class="text-2xl font-semibold text-white mb-4">President</h3>
            <ul class="list-disc list-inside text-purple-200 space-y-2">
              <li>Lead the association and represent NEXUS at institutional forums.</li>
              <li>Plan and supervise all activities with the office bearers.</li>
              <li>Inspire peers to actively engage in technical, cultural, and social initiatives.</li>
            </ul>
          </div>

          <!-- Vice President -->
          <div class="glass-card p-8" data-aos="fade-left">
            <h3 class="text-2xl font-semibold text-white mb-4">Vice-President</h3>
            <ul class="list-disc list-inside text-purple-200 space-y-2">
              <li>Assist the President in planning and execution of events.</li>
              <li>Take charge in the absence of the President.</li>
              <li>Coordinate with faculty and students.</li>
            </ul>
          </div>

          <!-- Secretary -->
          <div class="glass-card p-8" data-aos="fade-right">
            <h3 class="text-2xl font-semibold text-white mb-4">Secretary</h3>
            <ul class="list-disc list-inside text-purple-200 space-y-2">
              <li>Maintain records of meetings and events.</li>
              <li>Draft circulars, notices, and event proposals.</li>
              <li>Ensure updates on notice boards and digital platforms.</li>
            </ul>
          </div>

          <!-- Joint Secretary -->
          <div class="glass-card p-8" data-aos="fade-left">
            <h3 class="text-2xl font-semibold text-white mb-4">Joint Secretary</h3>
            <ul class="list-disc list-inside text-purple-200 space-y-2">
              <li>Assist the Secretary in documentation and communication.</li>
              <li>Help manage logistics for events.</li>
              <li>Support coordination between students and faculty.</li>
            </ul>
          </div>
        </div>
      </section>

      <!-- Office Bearers Section -->
      <section class="py-20 px-4 sm:px-8 md:px-[3cm] max-w-screen-xl mx-auto">
        <h2 class="text-4xl font-bold text-center text-purple-400 mb-8">
          Office Bearers
        </h2>

        <!-- Year Buttons -->
        <div class="flex justify-center gap-4 mb-12">
          <button class="year-btn px-5 py-2 rounded-full text-purple-300 border border-purple-500 hover:bg-purple-700 hover:text-white transition" data-year="2023" aria-pressed="true">2023 - 2024</button>
          <button class="year-btn px-5 py-2 rounded-full text-purple-300 border border-purple-500 hover:bg-purple-700 hover:text-white transition" data-year="2024" aria-pressed="false">2024 - 2025</button>
          <button class="year-btn px-5 py-2 rounded-full text-purple-300 border border-purple-500 hover:bg-purple-700 hover:text-white transition" data-year="2025" aria-pressed="false">2025 - 2026</button>
          <button class="year-btn px-5 py-2 rounded-full text-purple-300 border border-purple-500 hover:bg-purple-700 hover:text-white transition" data-year="2026" aria-pressed="false">2026 - 2027</button>
        </div>

        <!-- Cards Grid -->
        <div id="bearers-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8 perspective-1000" data-aos="fade-up" data-aos-offset="200">
          <!-- Bearers will be rendered here -->
        </div>
      </section>

    </main>
  </div>

  <!-- AOS Script -->
  <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
  <script>
    AOS.init({
      duration: 1500,
      
      easing: 'ease-in-out'
    });

    const data = {
      2023: [
        {
          name: "Sathya Seelan .M",
          role: "President",
          batch: "2022-2026",
          img: "./assets/img/19 SATHYA SEELAN.jpg"
        },
        {
          name: "Srihari Prasath .A",
          role: "Vice President",
          batch: "2022-2026",
          img: "./assets/img/21 SRI HARI PRASATH.jpg"
        },
        {
          name: "Yamini .S",
          role: "Secretary",
          batch: "2022-2026",
          img: "./assets/img/25 YAMINI.jpg"
        },
        {
          name: "Rana Susmitha.R",
          role: "Joint Secretary",
          batch: "2022-2026",
          img: "./assets/img/17 RANA SUSHMITHA.jpg"
        }
      ],
      2024: [
        {
          name: "Sathya Seelan .M",
          role: "President",
          batch: "2022-2026",
          img: "./assets/img/19 SATHYA SEELAN.jpg"
        },
        {
          name: "Thanushkumar.P",
          role: "Vice President",
          batch: "2023-2027",
          img: "./assets/img/24 Thanushkumar P (IT).jpg"
        },
        {
          name: "Nandhini -S",
          role: "Secretary",
          batch: "2022-2026",
          img: "./assets/img/09 NANDHINI.jpg"
        },
        {
          name: "Anu Darshni -A",
          role: "Joint Secretary",
          batch: "2023-2027",
          img: "./assets/img/02 Anudarshni A (IT).jpg"
        },
        {
          name: "Parameshwar N.s",
          role: "Joint Secretary",
          batch: "2022-2026",
          img: "./assets/img/13 PARAMESHWAR.jpg"
        }
      ],
      2025: [
        {
          name: "Naveen Bharathi.B",
          role: "President",
          batch: "2022-2026",
          img: "./assets/img/11 NAVEEN BHARATHI.jpg"
        },
        {
          name: "Rana Susmitha.R",
          role: "Vice President",
          batch: "2022-2026",
          img: "./assets/img/17 RANA SUSHMITHA.jpg"
        },
        {
          name: "Thanush Kumar.P",
          role: "Secretary",
          batch: "2023-2027",
          img: "./assets/img/24 Thanushkumar P (IT).jpg"
        },
        {
          name: "Lakshmi Priya.G",
          role: "Joint Secretary",
          batch: "2024-2028",
          img: "./assets/img/19 lakshmipriya.jpg"
        }
      ],
      2026: [
        {
          name: "Thanush Kumar.P",
          role: "President",
          batch: "2023-2027",
          img: "./assets/img/24 Thanushkumar P (IT).jpg"
        },
        {
          name: "Archana Devi.C",
          role: "Vice President",
          batch: "2023-2027",
          img: ""
        },
       {
         name: "Sharveshwaran.S.P",
         role: "Vice President",
         batch: "2024-2028",
         img: ""
        },
        {
         name: "Rishikesh.K",
         role: "Secretary",
         batch: "2023-2027",
         img: ""
      },
      {
        name: "Shanmugapriya.N",
        role: "Secretary",
        batch: "2024-2028",
        img: ""
     },
     {
        name: "Charunethra",
        role: "Joint Secretary",
        batch: "2025-2029",
        img: ""
     },
     {
        name: "Nirosh Kumar.R",
        role: "Joint Secretary",
        batch: "2025-2029",
        img: ""
     }
      ]
    };

    const container = document.getElementById('bearers-container');
    const buttons = document.querySelectorAll('.year-btn');

    function renderYear(year) {
      container.innerHTML = '';
      data[year].forEach(bearer => {
        const card = document.createElement('div');
        card.className =
          'bg-white rounded-xl shadow-lg p-6 flex flex-col items-center text-center space-y-3 transform transition-transform duration-[1500ms] hover:-translate-y-2 hover:shadow-2xl';

        card.innerHTML = `
          <div class="overflow-hidden rounded-lg w-24 h-24 sm:w-28 sm:h-28 transform transition-transform duration-[1500ms] ease-in-out hover:scale-110 hover:rotate-1" data-aos="flip-left">
            <img src="${bearer.img}" alt="${bearer.name}" class="w-full h-full object-cover" />
          </div>
          <span class="bg-blue-900 text-white text-sm font-medium px-3 py-1 rounded-full">
            ${bearer.role}
          </span>
          <p class="text-lg font-semibold text-gray-900">${bearer.name}</p>
          <p class="text-sm text-gray-600">Batch: ${bearer.batch}</p>
        `;
        container.appendChild(card);
      });
      AOS.refresh(); // Important to re-trigger AOS on dynamic content
    }

    // Initial load
    renderYear("2025");

    // Button click logic
    buttons.forEach(btn => {
      btn.addEventListener('click', () => {
        buttons.forEach(b => {
          b.classList.remove('bg-purple-700', 'text-white');
          b.classList.add('text-purple-300');
          b.setAttribute('aria-pressed', 'false');
        });

        btn.classList.add('bg-purple-700', 'text-white');
        btn.classList.remove('text-purple-300');
        btn.setAttribute('aria-pressed', 'true');

        renderYear(btn.getAttribute('data-year'));
      });
    });
  </script>

</body>
</html>