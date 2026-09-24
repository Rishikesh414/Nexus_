<?php

include "../server/config/db.php";

/* =========================================================
   1. ACADEMIC / TECHNICAL ACHIEVEMENTS
   ========================================================= */

$academic_result = $conn->query("
    SELECT *
    FROM academic_achievements
    ORDER BY id ASC
");

if (!$academic_result) {
    die("Academic Query failed: " . $conn->error);
}


/* =========================================================
   2. DEPARTMENT ACTIVITIES
   ========================================================= */

$department_result = $conn->query("
    SELECT *
    FROM department_activities
    ORDER BY id ASC
");

if (!$department_result) {
    die("Department Query failed: " . $conn->error);
}


/* =========================================================
   3. HACKATHONS / EXPOS / CONFERENCES
   ========================================================= */

$hackathon_result = $conn->query("
    SELECT *
    FROM hackathons_expos_conferences
    ORDER BY id ASC
");

if (!$hackathon_result) {
    die("Hackathon Query failed: " . $conn->error);
}


/* =========================================================
   4. SPORTS ACHIEVEMENTS
   ========================================================= */

$sports_result = $conn->query("
    SELECT *
    FROM sports_achievements
    ORDER BY id ASC
");

if (!$sports_result) {
    die("Sports Query failed: " . $conn->error);
}


/* =========================================================
   5. INTERNSHIPS & COMPANY PROJECTS
   ========================================================= */

$internship_result = $conn->query("
    SELECT *
    FROM internships_company_projects
    ORDER BY id ASC
");

if (!$internship_result) {
    die("Internship Query failed: " . $conn->error);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8" />

  <meta
    name="viewport"
    content="width=device-width, initial-scale=1"
  />

  <title>Achievements | NEXUS</title>


  <!-- AOS for Scroll Animations -->

  <link
    href="https://unpkg.com/aos@2.3.1/dist/aos.css"
    rel="stylesheet"
  >

  <script
    src="https://unpkg.com/aos@2.3.1/dist/aos.js">
  </script>


  <!-- VanillaTilt for 3D Tilt Effect -->

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js">
  </script>


  <!-- Font Awesome -->

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />


  <!-- Tailwind CSS -->

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

      background: linear-gradient(
        135deg,
        rgba(10, 10, 30, 0.95),
        rgba(20, 0, 50, 0.95)
      );

      transform: rotateY(180deg);

      display: flex;
      flex-direction: column;
      justify-content: center;
      align-items: center;
      text-align: center;

      padding: 1rem;

      border: 1px solid rgba(0, 255, 255, 0.3);

      box-shadow:
        0 0 20px rgba(0, 255, 255, 0.2);

    }


    .flip-card-back h3 {

      font-size: 1.2rem;
      font-weight: bold;
      color: cyan;
      margin-bottom: 0.5rem;

      text-shadow:
        0 0 8px purple,
        0 0 15px cyan;

      padding: 0 0.5rem;

      word-break: break-word;

    }


    .flip-card-back p {

      font-size: 0.95rem;
      color: #eee;
      margin: 0.2rem 0;

    }


    /* Card container hover effect */

    .tilt-card {

      background-color: #1f2937;

      transition:
        transform 0.3s ease,
        background-color 0.3s ease,
        box-shadow 0.3s ease;

      border-radius: 0.75rem;

      overflow: hidden;

      box-shadow:
        0 2px 10px rgba(0, 0, 0, 0.3);

      cursor: pointer;

    }


    .tilt-card:hover {

      transform:
        translateY(-12px)
        scale(1.05);

      background-color: #404246ff;

      box-shadow:
        0 15px 25px rgba(59, 130, 246, 0.5);

      z-index: 10;

    }

  </style>

</head>


<body class="bg-gray-900 text-white relative">


  <!-- =====================================================
       3D BACKGROUND
       ===================================================== -->

  <div class="fixed inset-0 z-0 pointer-events-none">

    <?php include("includes/3d.php"); ?>

  </div>


  <!-- =====================================================
       MAIN CONTENT
       ===================================================== -->

  <div class="relative z-10">


    <!-- ===================================================
         NAVBAR
         =================================================== -->

    <?php include("includes/navbar.php"); ?>


    <!-- ===================================================
         HERO SECTION
         =================================================== -->

    <section
      class="text-center py-16 px-6"
    >

      <div
        class="inline-flex items-center justify-center w-28 h-28 mb-6 mx-auto"
      >

        <img
          src="./img/ne.png"
          alt=""
          class="rounded-2xl animate-float"
        />

      </div>


      <h1
        class="text-5xl md:text-6xl font-bold mb-4
        bg-clip-text text-transparent
        bg-gradient-to-r from-blue-300 to-purple-300"
      >
        NEXUS
      </h1>


      <p
        class="text-xl md:text-2xl
        max-w-3xl mx-auto
        leading-relaxed text-gray-200"
      >
        Connecting minds, fostering innovation,
        and building the future together
      </p>

    </section>



    <!-- ===================================================
         ACHIEVEMENTS SECTION
         =================================================== -->

    <section
      class="max-w-7xl mx-auto px-6 py-12"
    >


      <h2
        class="text-3xl font-bold text-center mb-10 text-purple-300"
      >
        Achievements
      </h2>



      <!-- =================================================
           1. ACADEMIC / TECHNICAL ACHIEVEMENTS
           ================================================= -->

      <div>

        <h2
          class="text-xl font-semibold mt-6 mb-2"
        >
          1. Academic / Technical Achievements
        </h2>


        <div
          class="overflow-x-auto mb-6"
        >

          <table
            class="min-w-full border border-gray-300
            bg-gradient-to-r from-purple-900 to-purple-700"
          >

            <thead>

              <tr>

                <th class="px-4 py-2 border">
                  S.No
                </th>

                <th class="px-4 py-2 border">
                  Date / Duration
                </th>

                <th class="px-4 py-2 border">
                  Student
                </th>

                <th class="px-4 py-2 border">
                  Year / Dept
                </th>

                <th class="px-4 py-2 border">
                  Activity / Event
                </th>

                <th class="px-4 py-2 border">
                  Achievement / Role
                </th>

                <th class="px-4 py-2 border">
                  Organization / Venue
                </th>

              </tr>

            </thead>


            <tbody>

              <?php

              $sno = 1;

              if ($academic_result->num_rows > 0) {

                  while ($row = $academic_result->fetch_assoc()) {

              ?>

              <tr
                class="hover:bg-black hover:bg-opacity-10
                transition-colors"
              >

                <td class="px-4 py-2 border">
                  <?= $sno++ ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['date_duration']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['student']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['year_department']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['activity_event']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['achievement_role']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['organization_venue']) ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="7"
                  class="px-4 py-4 border text-center"
                >
                  No academic achievements available.
                </td>

              </tr>

              <?php

              }

              ?>

            </tbody>

          </table>

        </div>



        <!-- =================================================
             2. DEPARTMENT ACTIVITIES
             ================================================= -->

        <h2
          class="text-xl font-semibold mt-6 mb-2"
        >
          2. Department Activities
        </h2>


        <div
          class="overflow-x-auto mb-6"
        >

          <table
            class="min-w-full border border-gray-300
            bg-gradient-to-r from-purple-900 to-purple-700"
          >

            <thead>

              <tr>

                <th class="px-4 py-2 border">
                  S.No
                </th>

                <th class="px-4 py-2 border">
                  Date / Duration
                </th>

                <th class="px-4 py-2 border">
                  Activity / Event
                </th>

                <th class="px-4 py-2 border">
                  Department / Joint
                </th>

                <th class="px-4 py-2 border">
                  Guest / Resource
                </th>

              </tr>

            </thead>


            <tbody>

              <?php

              $department_sno = 1;

              if ($department_result->num_rows > 0) {

                  while ($row = $department_result->fetch_assoc()) {

              ?>

              <tr
                class="hover:bg-black hover:bg-opacity-10
                transition-colors"
              >

                <td class="px-4 py-2 border">
                  <?= $department_sno++ ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['date_duration']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['activity_event']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['department_joint']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['guest_resource']) ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="5"
                  class="px-4 py-4 border text-center"
                >
                  No department activities available.
                </td>

              </tr>

              <?php

              }

              ?>

            </tbody>

          </table>

        </div>



        <!-- =================================================
             3. HACKATHONS / EXPOS / CONFERENCES
             ================================================= -->

        <h2
          class="text-xl font-semibold mt-6 mb-2"
        >
          3. Hackathons, Expos, Conferences
        </h2>


        <div
          class="overflow-x-auto mb-6"
        >

          <table
            class="min-w-full border border-gray-300
            bg-gradient-to-r from-purple-900 to-purple-700"
          >

            <thead>

              <tr>

                <th class="px-4 py-2 border">
                  S.No
                </th>

                <th class="px-4 py-2 border">
                  Date / Duration
                </th>

                <th class="px-4 py-2 border">
                  Event
                </th>

                <th class="px-4 py-2 border">
                  Student(s)
                </th>

                <th class="px-4 py-2 border">
                  Venue / Organization
                </th>

              </tr>

            </thead>


            <tbody>

              <?php

              $hackathon_sno = 1;

              if ($hackathon_result->num_rows > 0) {

                  while ($row = $hackathon_result->fetch_assoc()) {

              ?>

              <tr
                class="hover:bg-black hover:bg-opacity-10
                transition-colors"
              >

                <td class="px-4 py-2 border">
                  <?= $hackathon_sno++ ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['date_duration']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['event']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['students']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['venue_organization']) ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="5"
                  class="px-4 py-4 border text-center"
                >
                  No hackathons, expos or conferences available.
                </td>

              </tr>

              <?php

              }

              ?>

            </tbody>

          </table>

        </div>



        <!-- =================================================
             4. SPORTS ACHIEVEMENTS
             ================================================= -->

        <h2
          class="text-xl font-semibold mt-6 mb-2"
        >
          4. Sports Achievements
        </h2>


        <div
          class="overflow-x-auto mb-6"
        >

          <table
            class="min-w-full border border-gray-300
            bg-gradient-to-r from-purple-900 to-purple-700"
          >

            <thead>

              <tr>

                <th class="px-4 py-2 border">
                  S.No
                </th>

                <th class="px-4 py-2 border">
                  Date / Duration
                </th>

                <th class="px-4 py-2 border">
                  Sport / Event
                </th>

                <th class="px-4 py-2 border">
                  Student(s)
                </th>

                <th class="px-4 py-2 border">
                  Achievement / Position
                </th>

              </tr>

            </thead>


            <tbody>

              <?php

              $sports_sno = 1;

              if ($sports_result->num_rows > 0) {

                  while ($row = $sports_result->fetch_assoc()) {

              ?>

              <tr
                class="hover:bg-black hover:bg-opacity-10
                transition-colors"
              >

                <td class="px-4 py-2 border">
                  <?= $sports_sno++ ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['date_duration']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['sport_event']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['students']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['achievement_position']) ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="5"
                  class="px-4 py-4 border text-center"
                >
                  No sports achievements available.
                </td>

              </tr>

              <?php

              }

              ?>

            </tbody>

          </table>

        </div>



        <!-- =================================================
             6. INTERNSHIPS & COMPANY PROJECTS
             ================================================= -->

        <h2
          class="text-xl font-semibold mt-6 mb-2"
        >
          6. Internships & Company Projects
        </h2>


        <div
          class="overflow-x-auto mb-6"
        >

          <table
            class="min-w-full border border-gray-300
            bg-gradient-to-r from-purple-900 to-purple-700"
          >

            <thead>

              <tr>

                <th class="px-4 py-2 border">
                  S.No
                </th>

                <th class="px-4 py-2 border">
                  Company / Organization
                </th>

                <th class="px-4 py-2 border">
                  Project / Role
                </th>

                <th class="px-4 py-2 border">
                  Student(s)
                </th>

                <th class="px-4 py-2 border">
                  Staff Mentor
                </th>

                <th class="px-4 py-2 border">
                  Duration / Notes
                </th>

              </tr>

            </thead>


            <tbody>

              <?php

              $internship_sno = 1;

              if ($internship_result->num_rows > 0) {

                  while ($row = $internship_result->fetch_assoc()) {

              ?>

              <tr
                class="hover:bg-black hover:bg-opacity-10
                transition-colors"
              >

                <td class="px-4 py-2 border">
                  <?= $internship_sno++ ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['company_organization']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['project_role']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['students']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['staff_mentor']) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['duration_notes']) ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="6"
                  class="px-4 py-4 border text-center"
                >
                  No internships or company projects available.
                </td>

              </tr>

              <?php

              }

              ?>

            </tbody>

          </table>

        </div>


      </div>

    </section>


  </div>


  <!-- =====================================================
       JAVASCRIPT
       ===================================================== -->

  <script>

    AOS.init({

      duration: 700,

      easing: 'ease-in-out',

      mirror: false

    });


    VanillaTilt.init(
      document.querySelectorAll(".tilt-card"),
      {

        max: 15,

        speed: 400,

        glare: true,

        "max-glare": 0.2,

      }
    );

  </script>


</body>

</html>