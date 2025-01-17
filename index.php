<?php
// database.php - Connection to MySQL
$servername = "localhost";
$username = "root";  // Your database username
$password = "";      // Your database password
$dbname = "worldcup";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch stadium data
$sql = "SELECT name, description, url FROM gallery_images";
$result = $conn->query($sql);

// Check if there are any results
if ($result->num_rows > 0) {
    $stadiums = [];
    while ($row = $result->fetch_assoc()) {
        $stadiums[] = $row;
    }
} else {
    $stadiums = [];
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>قصة ملعب | الصفحة الرئيسية</title>
    <link rel="icon" type="image/png" href="Stadium Story.png">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<header dir="ltr">
    <div class="logo">
        <img src="Stadium Story.png" alt="Stadium Story icon">
    </div>
    <nav class="nav">
        <ul>
            <li><a href="about.html#contact">تواصل معنا</a></li>
            <li><a href="about.html"><strong>عن الموقع</strong></a></li>
            <li><a href="index.php #gallery"><strong>المعرض</strong></a></li>
            <li><a href="index.php"><strong>الصفحة الرئيسية</strong></a></li>
            <li><a href="index.php#info"><strong>حقائق عامة</strong></a></li>
        </ul>
    </nav>
</header>

<main>
    <section class="hero">
        <h1>مرحباً بكم في كأس العالم 2034 في السعودية</h1>
        <p><strong>اكــتـشـف مـستـقبـل كـرة الـقدم فـي قـلـب الـممـلكـة الـعربـيـة الـسعـوديـة</strong></p>
        <video controls>
            <source src="قصة ملعب.mp4" type="video/mp4">
            متصفحك لا يدعم تنسيق الفيديو.
        </video>
    </section>

    <section id="info" class="info">
        <h2>حقائق عامة</h2>
        <table dir="rtl">
            <tr>
                <th>الحدث</th>
                <th>التفاصيل</th>
            </tr>
            <tr>
                <td>البلد المضيف</td>
                <td>المملكة العربية السعودية</td>
            </tr>
            <tr>
                <td>السنة</td>
                <td>2034</td>
            </tr>
            <tr>
                <td>عدد الملاعب</td>
                <td>15 ملعب في 5 اماكن مميزة</td>
            </tr>
        </table>
    </section>

    <section id="gallery" class="gallery">
        <h2>المعرض</h2>
        <ul class="image-list">
            <?php
                // Loop through the fetched stadiums and display them
                foreach ($stadiums as $stadium) {
                    echo '<li class="image-item">';
                    echo '<img src="' . $stadium['url'] . '" alt="' . $stadium['name'] . '" class="stadium-image" data-description="' . $stadium['description'] . '">';
                    echo '<p><b>' . $stadium['name'] . '</b></p>';
                    echo '<div class="stadium-description">' . $stadium['description'] . '</div>';
                    echo '</li>';
                }
            ?>
        </ul>
    </section>
</main>

<footer>
    <p>&copy; JUC students | المملكة العربية السعودية | <a href="about.html #contact" class="highlight">تواصل معنا</a></p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        const images = document.querySelectorAll(".stadium-image");
        
        images.forEach(image => {
            image.addEventListener("click", () => {
                const descriptionDiv = image.nextElementSibling.nextElementSibling;
                
                // Toggle description visibility with fade-in and collapse behavior
                descriptionDiv.classList.toggle("visible");
                
                // Apply smooth transition for collapse and expansion
                if (descriptionDiv.classList.contains("visible")) {
                    descriptionDiv.style.maxHeight = descriptionDiv.scrollHeight + "px"; // Open the description
                } else {
                    descriptionDiv.style.maxHeight = "0"; // Collapse the description
                }
            });
        });
    });
</script>
</body>
</html>

<style>
    /* Global Styles */
    body {
        font-family: 'Arial', sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f3f3f3;
        color: #333;
        margin-top: 80px; /* Add padding to the body to avoid content being hidden behind the header */
    }

    header {
        background: linear-gradient(to right, #004c54, #004c54);
        color: white;
        padding: 10px 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        position: fixed; /* Make the header fixed at the top */
        top: 0; /* Position it at the top of the page */
        left: 0; /* Align to the left edge */
        right: 0; /* Align to the right edge */
        z-index: 9999; /* Ensure it's above other content */
        width: 100%; /* Take up full width */
    }

    header .logo img {
        height: 50px;
        margin-left: 50px;
    }

    h2 {
        text-align: center;
        color: #004c54;
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    .info {
        padding: 20px;
    }

    .info table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: white;
    }

    .info table th, .info table td {
        border: 1px solid #ddd;
        text-align: left;
        padding: 10px;
    }

    .info table th {
        background-color: #004c54;
        color: white;
    }

    nav ul {
        list-style: none;
        margin: 0;
        padding: 0;
        display: flex;
        gap: 20px;
    }

    nav ul li {
        display: inline;
    }

    nav ul li a {
        color: white;
        text-decoration: none;
        font-size: 18px;
    }

    nav ul li a:hover {
        text-decoration: underline;
        transition: color 0.3s ease;
    }

    .hero {
        text-align: center;
        padding: 60px 20px;
        background: linear-gradient(to bottom, rgb(1, 90, 100), rgb(255, 255, 255));
        color: white;
    }

    .hero h1 {
        font-size: 3.5em;
        font-weight: bold;
        margin-bottom: 20px;
    }

    .hero p {
        font-size: 1.5em;
        margin-bottom: 20px;
    }

    .hero video {
        margin-top: 20px;
        width: 70%;
        border-radius: 10px;
        border: 3px solid white;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
    }

    .gallery {
        padding: 40px 20px;
        background: linear-gradient(to bottom, rgb(255, 255, 255), rgba(0, 77, 83, 0.46));
    }

    .gallery h2 {
        text-align: center;
        color: #004c54;
        font-size: 2.5em;
        margin-bottom: 20px;
    }

    .image-list {
        list-style: none;
        display: grid;
        grid-template-columns: repeat(5, 1fr); /* 5 images per row */
        gap: 20px;
        padding: 0;
    }

    .image-item {
        text-align: center;
        position: relative;
        transition: transform 0.3s ease;
    }

    .stadium-image {
        width: 100%;
        aspect-ratio: 16/9;
        border-radius: 10px;  
        border: 5px solid rgb(235, 252, 254) ;  
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        cursor: pointer;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.9);
    }

    .stadium-image:hover {
        transform: scale(1.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.9);
    }

    .stadium-description {
        display: block;
        font-size: 16px;
        color: #444;
        background-color: #ffffff;
        padding: 15px;
        border-radius: 8px;
        margin-top: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transform: translateY(20px);
        transition: opacity 0.5s ease, transform 0.5s ease, max-height 0.5s ease;
    }

    .stadium-description.visible {
        opacity: 1;
        max-height: 500px; 
        transform: translateY(0);
    }

    footer {
        background-color: #004c54;
        color: white;
        text-align: center;
        padding: 15px;
    }

    footer a {
        color: #ffdd00;
        text-decoration: none;
        font-weight: bold;
    }

    footer a:hover {
        text-decoration: underline;
    }

    /* Responsive Styling */
    @media (max-width: 1200px) {
        .image-list {
            grid-template-columns: repeat(4, 1fr); /* 4 columns on medium screens */
        }
    }

    @media (max-width: 768px) {
        .image-list {
            grid-template-columns: repeat(3, 1fr); /* 3 columns on smaller screens */
        }
    }

    @media (max-width: 480px) {
        .image-list {
            grid-template-columns: repeat(2, 1fr); /* 2 columns on mobile screens */
        }
    }
</style>
