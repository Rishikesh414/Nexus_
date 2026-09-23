<?php

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Achievements | NEXUS </title>
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
    <section class="max-w-7xl mx-auto px-6 py-12">
      <h2 class="text-3xl font-bold text-center mb-10 text-purple-300">Achievements</h2>
      <div >
        <h2 class="text-xl font-semibold mt-6 mb-2">Academic / Technical Achievements</h2>
<div class="overflow-x-auto mb-6">
<table class="min-w-full border border-gray-300 bg-gradient-to-r from-purple-900 to-purple-700 ">
<thead class="">
<tr>
<th class="px-4 py-2 border">S.No</th>
<th class="px-4 py-2 border">Date / Duration</th>
<th class="px-4 py-2 border">Student</th>
<th class="px-4 py-2 border">Year / Dept</th>
<th class="px-4 py-2 border">Activity / Event</th>
<th class="px-4 py-2 border">Achievement / Role</th>
<th class="px-4 py-2 border">Organization / Venue</th>
</tr>
</thead>
<tbody>

<?php
$sno = 1;

while ($row = $academic_result->fetch_assoc()) {
?>

<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">

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
?>

</tbody>
</table>
</div>

<h2 class="text-xl font-semibold mt-6 mb-2">2. Department Activities</h2>
<div class="overflow-x-auto mb-6">
<table class="min-w-full border border-gray-300 bg-gradient-to-r from-purple-900 to-purple-700 ">
<thead class="">
<tr>
<th class="px-4 py-2 border">S.No</th>
<th class="px-4 py-2 border">Date / Duration</th>
<th class="px-4 py-2 border">Activity / Event</th>
<th class="px-4 py-2 border">Department / Joint</th>
<th class="px-4 py-2 border">Guest / Resource</th>
</tr>
</thead>
<tbody>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">1</td>
<td class="px-4 py-2 border">25/10/2024</td>
<td class="px-4 py-2 border">Webinar: Text Web Social Media Analytics</td>
<td class="px-4 py-2 border">IT</td>
<td class="px-4 py-2 border">Dr. R. Lokesh Kumar (VIT Chennai)</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">2</td>
<td class="px-4 py-2 border">09/11/2024</td>
<td class="px-4 py-2 border">Association Inauguration of AIM & NEXUS</td>
<td class="px-4 py-2 border">AI&DS + IT</td>
<td class="px-4 py-2 border">NSCET Management & Principal</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">3</td>
<td class="px-4 py-2 border">08/02/2025–14/02/2025</td>
<td class="px-4 py-2 border">5-Day VAC: Laravel – Building Modern Web Applications</td>
<td class="px-4 py-2 border">AI&DS + IT</td>
<td class="px-4 py-2 border">Mr. K. Anandraj, CEO, TM Innovations</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">4</td>
<td class="px-4 py-2 border">15/02/2025–20/02/2025</td>
<td class="px-4 py-2 border">5-Day VAC: Django and its Frameworks</td>
<td class="px-4 py-2 border">AI&DS + IT</td>
<td class="px-4 py-2 border">Mr. K. Anandraj, CEO, TM Innovations</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">5</td>
<td class="px-4 py-2 border">09/11/2024</td>
<td class="px-4 py-2 border">Seminar: Mastering the job hunt – interview preparation</td>
<td class="px-4 py-2 border">IT</td>
<td class="px-4 py-2 border">Mr. Arasakumar S, Senior Software Engineer, Infosys</td>
</tr>
</tbody>
</table>
</div>

<!-- 3. Hackathons, Expos, Conferences -->
<h2 class="text-xl font-semibold mt-6 mb-2">3. Hackathons, Expos, Conferences</h2>
<div class="overflow-x-auto mb-6">
<table class="min-w-full border border-gray-300 bg-gradient-to-r from-purple-900 to-purple-700 ">
<thead class="">
<tr>
<th class="px-4 py-2 border">S.No</th>
<th class="px-4 py-2 border">Date / Duration</th>
<th class="px-4 py-2 border">Event</th>
<th class="px-4 py-2 border">Student(s)</th>
<th class="px-4 py-2 border">Venue / Organization</th>
</tr>
</thead>
<tbody>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">1</td>
<td class="px-4 py-2 border">20/02/2025–21/02/2025</td>
<td class="px-4 py-2 border">Hack Fest 2025</td>
<td class="px-4 py-2 border">A. Sri Hari Prasath, B. Naveen Bharathi</td>
<td class="px-4 py-2 border">M. Kumarasamy College, Karur</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">2</td>
<td class="px-4 py-2 border">28/02/2025</td>
<td class="px-4 py-2 border">Product Expo 2025</td>
<td class="px-4 py-2 border">Naveen Bharathi B</td>
<td class="px-4 py-2 border">Jerusalem College of Engineering</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">3</td>
<td class="px-4 py-2 border">02/03/2025</td>
<td class="px-4 py-2 border">Ocean Academy Tech Fest (Conference)</td>
<td class="px-4 py-2 border">B. Naveen Bharathi</td>
<td class="px-4 py-2 border">Pondicherry Technological University</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">4</td>
<td class="px-4 py-2 border">03/03/2025–12/03/2025</td>
<td class="px-4 py-2 border">Intel Internship (All III-Year IT Girl Students)</td>
<td class="px-4 py-2 border">III-Year IT Girls</td>
<td class="px-4 py-2 border">Intel</td>
</tr>
</tbody>
</table>
</div>

<!-- 4. Sports Achievements -->
<h2 class="text-xl font-semibold mt-6 mb-2">4. Sports Achievements</h2>
<div class="overflow-x-auto mb-6">
<table class="min-w-full border border-gray-300 bg-gradient-to-r from-purple-900 to-purple-700 ">
<thead class="">
<tr>
<th class="px-4 py-2 border">S.No</th>
<th class="px-4 py-2 border">Date / Duration</th>
<th class="px-4 py-2 border">Sport / Event</th>
<th class="px-4 py-2 border">Student(s)</th>
<th class="px-4 py-2 border">Achievement / Position</th>
</tr>
</thead>
<tbody>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">1</td>
<td class="px-4 py-2 border">07/10/2024–08/10/2024</td>
<td class="px-4 py-2 border">Volleyball (Women), Anna University Zone-17</td>
<td class="px-4 py-2 border">M. Vani Sri</td>
<td class="px-4 py-2 border">IV Position</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">2</td>
<td class="px-4 py-2 border">18/09/2024–19/09/2024</td>
<td class="px-4 py-2 border">Basketball (Women), Anna University Zone-17</td>
<td class="px-4 py-2 border">S. Nandhini</td>
<td class="px-4 py-2 border">II Position</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">3</td>
<td class="px-4 py-2 border">17/09/2024–19/09/2024</td>
<td class="px-4 py-2 border">Basketball (Women), CM Trophy</td>
<td class="px-4 py-2 border">S. Nandhini</td>
<td class="px-4 py-2 border">III Position; Cash Award ₹10,000</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">4</td>
<td class="px-4 py-2 border">08/10/2024–09/10/2024</td>
<td class="px-4 py-2 border">Volleyball (Men), Anna University Zone-17</td>
<td class="px-4 py-2 border">A. Surya Prakash</td>
<td class="px-4 py-2 border">Participated</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">5</td>
<td class="px-4 py-2 border">15/10/2024–16/10/2024</td>
<td class="px-4 py-2 border">Chess (Women), Zone-17</td>
<td class="px-4 py-2 border">M. Priyadharshini</td>
<td class="px-4 py-2 border">Participated</td>
</tr>
</tbody>
</table>
</div>
      </div>
      <h2 class="text-xl font-semibold mt-6 mb-2">6. Internships & Company Projects</h2>
<div class="overflow-x-auto mb-6">
<table class="min-w-full border border-gray-300 bg-gradient-to-r from-purple-900 to-purple-700 ">
<thead class="">
<tr>
<th class="px-4 py-2 border">S.No</th>
<th class="px-4 py-2 border">Company / Organization</th>
<th class="px-4 py-2 border">Project / Role</th>
<th class="px-4 py-2 border">Student(s)</th>
<th class="px-4 py-2 border">Staff Mentor</th>
<th class="px-4 py-2 border">Duration / Notes</th>
</tr>
</thead>
<tbody>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">1</td>
<td class="px-4 py-2 border">Apex Planet Software, Bihar</td>
<td class="px-4 py-2 border">Student Achievement Management System (Web Dev Program)</td>
<td class="px-4 py-2 border">AASWIN JS, SARVAJI M, MOHAMED IRFAN SHEIK K, SURYAPARAKASH A</td>
<td class="px-4 py-2 border">B. Sai</td>
<td class="px-4 py-2 border">AICTE Sponsored Internship</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">2</td>
<td class="px-4 py-2 border">Apex Planet Software, Bihar</td>
<td class="px-4 py-2 border">Secure Blog Management System</td>
<td class="px-4 py-2 border">GOWSIK P, PARAMESWARAN S N, YOHITHKUMAR R, SATHYASEELAN M</td>
<td class="px-4 py-2 border">M. Bhavani</td>
<td class="px-4 py-2 border">AICTE Sponsored Internship</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">3</td>
<td class="px-4 py-2 border">WG TECH, NSCET, Theni</td>
<td class="px-4 py-2 border">Number Plate Recognition with Real-Time Vehicle Detection</td>
<td class="px-4 py-2 border">NAVEEN BHARATHI B, PRAVIN K</td>
<td class="px-4 py-2 border">R. Yogeswari</td>
<td class="px-4 py-2 border">Software Development (Full Stack)</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">4</td>
<td class="px-4 py-2 border">QTL Agri Tech</td>
<td class="px-4 py-2 border">Students Management System using Django REST Framework</td>
<td class="px-4 py-2 border">NAGAJOTHI M, NANDHINI S, NIHILAA K, NATHIYA P, RAMYA PRIYA J</td>
<td class="px-4 py-2 border">S. Mahalakshmi</td>
<td class="px-4 py-2 border">Web Development (Django)</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">5</td>
<td class="px-4 py-2 border">Phoenix Softech, Madurai</td>
<td class="px-4 py-2 border">Gmail Clone using MERN Stack</td>
<td class="px-4 py-2 border">YAMINI S, NAAFIYA SHIRIN A, SWATHI P, RANA SUSMITHA R</td>
<td class="px-4 py-2 border">R. Udhaya Kumar</td>
<td class="px-4 py-2 border">Web Design & Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">6</td>
<td class="px-4 py-2 border">Intel Intelligence</td>
<td class="px-4 py-2 border">Movie API</td>
<td class="px-4 py-2 border">V. PREETHI, P. ABINAYA, P. ABI GAYATHRI</td>
<td class="px-4 py-2 border">R. Udhaya Kumar</td>
<td class="px-4 py-2 border">Java Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">7</td>
<td class="px-4 py-2 border">Diya Robotics, Chennai</td>
<td class="px-4 py-2 border">Health Monitoring</td>
<td class="px-4 py-2 border">SIVASRI V</td>
<td class="px-4 py-2 border">N. Kesavamoorthy</td>
<td class="px-4 py-2 border">Full Stack Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">8</td>
<td class="px-4 py-2 border">InLighnX Global Internship Program</td>
<td class="px-4 py-2 border">Data Analyst (Project not yet confirmed)</td>
<td class="px-4 py-2 border">VIGNESHWAR S</td>
<td class="px-4 py-2 border">S. Arul Jothi</td>
<td class="px-4 py-2 border">–</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">9</td>
<td class="px-4 py-2 border">Unified Mentor, Haryana</td>
<td class="px-4 py-2 border">WiFi Honeypot Detector</td>
<td class="px-4 py-2 border">SRIHARI PRASATH A</td>
<td class="px-4 py-2 border">P. Jasmine Jose</td>
<td class="px-4 py-2 border">Full Stack Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">10</td>
<td class="px-4 py-2 border">Phoenix Softech</td>
<td class="px-4 py-2 border">Tourism Design</td>
<td class="px-4 py-2 border">ABI S</td>
<td class="px-4 py-2 border">P. Jasmine Jose</td>
<td class="px-4 py-2 border">MERN Full Stack</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">11</td>
<td class="px-4 py-2 border">Phoenix Softech</td>
<td class="px-4 py-2 border">Mark Logger using MERN</td>
<td class="px-4 py-2 border">VAITHEESHWARI R</td>
<td class="px-4 py-2 border">R. Yogeswari</td>
<td class="px-4 py-2 border">MERN Full Stack</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">12</td>
<td class="px-4 py-2 border">Phoenix Softech</td>
<td class="px-4 py-2 border">Project Not Yet Confirmed</td>
<td class="px-4 py-2 border">DHIVYA DHARSHINI S, ISMATH FATHIMA J</td>
<td class="px-4 py-2 border">S. Mahalakshmi</td>
<td class="px-4 py-2 border">MERN Full Stack</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">13</td>
<td class="px-4 py-2 border">Hazzino Technologies</td>
<td class="px-4 py-2 border">Portfolio Webpage</td>
<td class="px-4 py-2 border">VANI SRI M, ARCHANA DEVI C, SINDHU S</td>
<td class="px-4 py-2 border">M. Bhavani</td>
<td class="px-4 py-2 border">Web Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">14</td>
<td class="px-4 py-2 border">Yaash Technology</td>
<td class="px-4 py-2 border">CyberSecurity (Project Not Yet Confirmed)</td>
<td class="px-4 py-2 border">SHAHANA V</td>
<td class="px-4 py-2 border">S. Arul Jothi</td>
<td class="px-4 py-2 border">–</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">15</td>
<td class="px-4 py-2 border">Nxdeep Connectz LLP, Madurai</td>
<td class="px-4 py-2 border">Resume Builder (JavaScript)</td>
<td class="px-4 py-2 border">ANUDARSHNI A, DHIVYA DHARSHINI S, MONIKA B, HARINI P</td>
<td class="px-4 py-2 border">R. Udhaya Kumar</td>
<td class="px-4 py-2 border">–</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">16</td>
<td class="px-4 py-2 border">Notasco Technologies, Madurai</td>
<td class="px-4 py-2 border">Responsive Flower Shop (App Development)</td>
<td class="px-4 py-2 border">SONI P, SOWMIYA K, NAVEENA G</td>
<td class="px-4 py-2 border">N. Kesavamoorthy</td>
<td class="px-4 py-2 border">–</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">17</td>
<td class="px-4 py-2 border">Prodigy Infotech, Mumbai</td>
<td class="px-4 py-2 border">Stop-watch Web Application</td>
<td class="px-4 py-2 border">LOGESHWARI S</td>
<td class="px-4 py-2 border">B. Sai</td>
<td class="px-4 py-2 border">Web Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">18</td>
<td class="px-4 py-2 border">Rezilyens Systems Software India Pvt. Ltd., Coimbatore</td>
<td class="px-4 py-2 border">Anon E-Commerce Website</td>
<td class="px-4 py-2 border">JEBANIKITHA N</td>
<td class="px-4 py-2 border">B. Sai</td>
<td class="px-4 py-2 border">Web Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">19</td>
<td class="px-4 py-2 border">Rezilyens Systems Software India Pvt. Ltd., Coimbatore</td>
<td class="px-4 py-2 border">Grilli – Amazing and Delicious Food</td>
<td class="px-4 py-2 border">DIVYASRI P</td>
<td class="px-4 py-2 border">Not Specified</td>
<td class="px-4 py-2 border">Web Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">20</td>
<td class="px-4 py-2 border">Rezilyens Systems Software India Pvt. Ltd., Coimbatore</td>
<td class="px-4 py-2 border">FilmLane – Best Movie Collection</td>
<td class="px-4 py-2 border">SIVAYOGGA K</td>
<td class="px-4 py-2 border">B. Sai</td>
<td class="px-4 py-2 border">Web Development</td>
</tr>
<tr class="hover:bg-black hover:bg-opacity-10 transition-colors">
<td class="px-4 py-2 border">21</td>
<td class="px-4 py-2 border">Anzee Tech Solution, Madurai</td>
<td class="px-4 py-2 border">Internship</td>
<td class="px-4 py-2 border">PANDIYARAJAN K, RISHIKESH K, YOKESH KUMAR R, THANUSHKUMAR P</td>
<td class="px-4 py-2 border">–</td>
<td class="px-4 py-2 border">June–July 2024–25</td>
</tr>
</tbody>
</table>
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
