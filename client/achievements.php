<?php

include "../server/config/db.php";

/* =========================================================
   YEAR FILTER
   ========================================================= */

$allowed_years = ['2024', '2025', '2026'];

$selected_year = $_GET['year'] ?? '2026';

if (!in_array($selected_year, $allowed_years, true)) {
    $selected_year = '2026';
}

/*
 * We search the actual date_duration field.
 * Example:
 * 21-09-2025
 * 17-01-2026
 * 05-01-2026
 *
 * LIKE %2025% / %2026% matches the year appearing
 * inside the actual date/duration text.
 */
$year_search = '%' . $selected_year . '%';


/* =========================================================
   HELPER FUNCTION
   Used only for tables which contain date_duration
   ========================================================= */

function getYearWiseData($conn, $table, $year_search)
{
    $allowed_tables = [
        'academic_achievements',
        'department_activities',
        'hackathons_expos_conferences',
        'sports_achievements'
    ];

    if (!in_array($table, $allowed_tables, true)) {
        return false;
    }

    $sql = "
        SELECT *
        FROM `$table`
        WHERE date_duration LIKE ?
        ORDER BY id ASC
    ";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die(
            ucfirst($table) .
            " Query preparation failed: " .
            $conn->error
        );
    }

    $stmt->bind_param("s", $year_search);

    if (!$stmt->execute()) {
        die(
            ucfirst($table) .
            " Query failed: " .
            $stmt->error
        );
    }

    return $stmt->get_result();
}


/* =========================================================
   1. ACADEMIC / TECHNICAL ACHIEVEMENTS
   ========================================================= */

$academic_result = getYearWiseData(
    $conn,
    'academic_achievements',
    $year_search
);

if ($academic_result === false) {
    die("Academic Query failed.");
}


/* =========================================================
   2. DEPARTMENT ACTIVITIES
   ========================================================= */

$department_result = getYearWiseData(
    $conn,
    'department_activities',
    $year_search
);

if ($department_result === false) {
    die("Department Query failed.");
}


/* =========================================================
   3. HACKATHONS / EXPOS / CONFERENCES
   ========================================================= */

$hackathon_result = getYearWiseData(
    $conn,
    'hackathons_expos_conferences',
    $year_search
);

if ($hackathon_result === false) {
    die("Hackathon Query failed.");
}


/* =========================================================
   4. SPORTS ACHIEVEMENTS
   ========================================================= */

$sports_result = getYearWiseData(
    $conn,
    'sports_achievements',
    $year_search
);

if ($sports_result === false) {
    die("Sports Query failed.");
}


/* =========================================================
   5. INTERNSHIPS & COMPANY PROJECTS
   =========================================================

   IMPORTANT:
   internships_company_projects does NOT have date_duration.

   Columns available:
   company_organization
   project_role
   students
   staff_mentor
   duration_notes
   created_at
   academic_year

   Therefore we DO NOT use created_at as the internship year.
   The existing internship records are displayed separately.
   ========================================================= */

$internship_result = $conn->query("
    SELECT *
    FROM internships_company_projects
    ORDER BY id ASC
");

if (!$internship_result) {
    die(
        "Internship Query failed: " .
        $conn->error
    );
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


  <!-- =====================================================
       AOS FOR SCROLL ANIMATIONS
       ===================================================== -->

  <link
    href="https://unpkg.com/aos@2.3.1/dist/aos.css"
    rel="stylesheet"
  >

  <script
    src="https://unpkg.com/aos@2.3.1/dist/aos.js">
  </script>


  <!-- =====================================================
       VANILLA TILT
       ===================================================== -->

  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/vanilla-tilt/1.7.0/vanilla-tilt.min.js">
  </script>


  <!-- =====================================================
       FONT AWESOME
       ===================================================== -->

  <link
    rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
  />


  <!-- =====================================================
       TAILWIND CSS
       ===================================================== -->

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


    /* =====================================================
       YEAR BUTTONS
       ===================================================== */

    .year-filter-container {

      display: flex;

      justify-content: center;

      align-items: center;

      gap: 16px;

      flex-wrap: wrap;

      margin-bottom: 45px;

    }


    .year-btn {

      display: inline-flex;

      align-items: center;

      justify-content: center;

      min-width: 110px;

      padding: 12px 28px;

      border-radius: 999px;

      border: 1px solid rgba(168, 85, 247, 0.6);

      background: rgba(31, 41, 55, 0.9);

      color: #e9d5ff;

      font-size: 17px;

      font-weight: 700;

      text-decoration: none;

      transition: all 0.3s ease;

      box-shadow:
        0 5px 15px rgba(0, 0, 0, 0.25);

    }


    .year-btn:hover {

      transform: translateY(-4px) scale(1.04);

      background:
        linear-gradient(
          135deg,
          #581c87,
          #7e22ce
        );

      color: white;

      border-color: #c084fc;

      box-shadow:
        0 10px 25px rgba(147, 51, 234, 0.45);

    }


    .year-btn.active {

      background:
        linear-gradient(
          135deg,
          #7e22ce,
          #9333ea
        );

      color: white;

      border-color: #d8b4fe;

      box-shadow:
        0 0 20px rgba(168, 85, 247, 0.55);

    }


    .selected-year-text {

      text-align: center;

      color: #d8b4fe;

      font-size: 18px;

      margin-top: -25px;

      margin-bottom: 35px;

    }


    /* =====================================================
       FLIP CARD STYLES
       ===================================================== */

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

      background:
        linear-gradient(
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

      border:
        1px solid
        rgba(0, 255, 255, 0.3);

      box-shadow:
        0 0 20px
        rgba(0, 255, 255, 0.2);

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


    /* =====================================================
       CARD CONTAINER HOVER EFFECT
       ===================================================== */

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
        0 15px 25px
        rgba(59, 130, 246, 0.5);

      z-index: 10;

    }


    /* =====================================================
       TABLE RESPONSIVE TEXT
       ===================================================== */

    table {

      font-size: 14px;

    }


    th {

      color: white;

      font-weight: 700;

    }


    td {

      color: #f3f4f6;

      vertical-align: top;

    }


    /* =====================================================
       NO DATA MESSAGE
       ===================================================== */

    .no-data {

      color: #ddd6fe;

      padding: 20px !important;

      font-style: italic;

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
        class="text-3xl font-bold text-center mb-8 text-purple-300"
      >
        Achievements
      </h2>


      <!-- =================================================
           YEAR FILTER BUTTONS
           ================================================= -->

      <div class="year-filter-container">

        <a
          href="?year=2024"
          class="year-btn <?= $selected_year === '2024' ? 'active' : '' ?>"
        >
          2024
        </a>


        <a
          href="?year=2025"
          class="year-btn <?= $selected_year === '2025' ? 'active' : '' ?>"
        >
          2025
        </a>


        <a
          href="?year=2026"
          class="year-btn <?= $selected_year === '2026' ? 'active' : '' ?>"
        >
          2026
        </a>

      </div>


      <p class="selected-year-text">

        Showing achievements and activities for

        <strong>
          <?= htmlspecialchars($selected_year) ?>
        </strong>

      </p>



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
                  <?= htmlspecialchars($row['date_duration'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['student'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['year_department'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['activity_event'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['achievement_role'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['organization_venue'] ?? '') ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="7"
                  class="px-4 py-4 border text-center no-data"
                >
                  No academic achievements available for
                  <?= htmlspecialchars($selected_year) ?>.
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
                  <?= htmlspecialchars($row['date_duration'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['activity_event'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['department_joint'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['guest_resource'] ?? '') ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="5"
                  class="px-4 py-4 border text-center no-data"
                >
                  No department activities available for
                  <?= htmlspecialchars($selected_year) ?>.
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
                  <?= htmlspecialchars($row['date_duration'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['event'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['students'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['venue_organization'] ?? '') ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="5"
                  class="px-4 py-4 border text-center no-data"
                >
                  No hackathons, expos or conferences available
                  for <?= htmlspecialchars($selected_year) ?>.
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
                  <?= htmlspecialchars($row['date_duration'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['sport_event'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['students'] ?? '') ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars($row['achievement_position'] ?? '') ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="5"
                  class="px-4 py-4 border text-center no-data"
                >
                  No sports achievements available for
                  <?= htmlspecialchars($selected_year) ?>.
                </td>

              </tr>

              <?php

              }

              ?>

            </tbody>

          </table>

        </div>



        <!-- =================================================
             5. INTERNSHIPS & COMPANY PROJECTS
             ================================================= -->

        <h2
          class="text-xl font-semibold mt-6 mb-2"
        >
          5. Internships & Company Projects
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

              /*
               * Internship table has no actual date field.
               * Therefore existing records are displayed without
               * pretending that created_at represents the internship year.
               */

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
                  <?= htmlspecialchars(
                        $row['company_organization'] ?? ''
                      ) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars(
                        $row['project_role'] ?? ''
                      ) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars(
                        $row['students'] ?? ''
                      ) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars(
                        $row['staff_mentor'] ?? ''
                      ) ?>
                </td>

                <td class="px-4 py-2 border">
                  <?= htmlspecialchars(
                        $row['duration_notes'] ?? ''
                      ) ?>
                </td>

              </tr>

              <?php

                  }

              } else {

              ?>

              <tr>

                <td
                  colspan="6"
                  class="px-4 py-4 border text-center no-data"
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