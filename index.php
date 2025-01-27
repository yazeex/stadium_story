<?php
    $servername = "localhost";
    $username = "root"; 
    $password = ""; 
    $dbname = "worldcup"; 

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error)
    {die("Connection failed: " . $conn->connect_error);}

    $sql = "SELECT name, description, url FROM gallery_images";
    $result = $conn->query($sql);

    if ($result->num_rows > 0)
    {
        $stadiums = [];
        while ($row = $result->fetch_assoc())
        {$stadiums[] = $row;}
    }
    else
    {$stadiums = [];}
    $conn->close();
?>

<!DOCTYPE html>
<html lang="en" dir="rtl">
    <head>
        <meta charset="UTF-8">
        <title>قصة ملعب | الصفحة الرئيسية</title>
        <link rel="icon" type="image/png" href="Stadium Story.png">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="about.css">
        <style>
            h2 
            {
                text-align: center;
                color: #004c54;
                font-size: 2.5em;
                margin-bottom: 20px;
            }

            .info
            {padding: 20px;}

            .info table 
            {
                width: 100%;
                border-collapse: collapse;
                margin-top: 20px;
                background-color: white;
            }

            .info table th, .info table td 
            {
                border: 1px solid #ddd;
                text-align: left;
                padding: 10px;
            }

            .info table th 
            {
                background-color: #004c54;
                color: white;
            }

            .hero 
            {
                text-align: center;
                padding: 60px 20px;
                background: linear-gradient(to bottom, rgb(1, 90, 100), rgb(255, 255, 255));
                color: white;
            }

            .hero h1 
            {
                font-size: 3.5em;
                font-weight: bold;
                margin-bottom: 20px;
            }

            .hero p 
            {
                font-size: 1.5em;
                margin-bottom: 20px;
            }

            .hero video 
            {
                margin-top: 20px;
                width: 70%;
                border-radius: 10px;
                border: 3px solid white;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.3);
            }

            .gallery 
            {
                padding: 40px 20px;
                background: linear-gradient(to bottom, rgb(255, 255, 255), rgba(0, 77, 83, 0.46));
            }

            .gallery h2 
            {
                text-align: center;
                color: #004c54;
                font-size: 2.5em;
                margin-bottom: 20px;
            }

            .image-list 
            {
                list-style: none;
                display: grid;
                grid-template-columns: repeat(5, 1fr);
                gap: 20px;
                padding: 0;
            }

            .image-item 
            {
                text-align: center;
                position: relative;
                transition: transform 0.3s ease;
            }

            .stadium-image 
            {
                width: 100%;
                aspect-ratio: 16/9;
                border-radius: 10px;  
                border: 5px solid rgb(235, 252, 254);  
                transition: transform 0.3s ease, box-shadow 0.3s ease;
                cursor: pointer;
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.9);
            }

            .stadium-image:hover 
            {
                transform: scale(1.1);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.9);
            }

            .modal 
            {
                display: none;
                position: fixed;
                z-index: 10000;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background-color: rgba(0, 0, 0, 0.7);
                backdrop-filter: blur(5px);
            }

            .modal-content 
            {
                position: relative;
                background-color: #fefefe;
                margin: 5% auto;
                padding: 20px;
                width: 80%;
                max-width: 800px;
                border-radius: 10px;
                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
                transform: scale(0.7);
                opacity: 0;
                transition: all 0.3s ease-in-out;
            }

            .modal.show .modal-content 
            {
                transform: scale(1);
                opacity: 1;
            }

            .modal-header 
            {
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-bottom: 2px solid #004c54;
                padding-bottom: 10px;
                margin-bottom: 20px;
            }

            .modal-title 
            {
                color: #004c54;
                font-size: 24px;
                margin: 0;
            }

            .close-button 
            {
                color: #004c54;
                font-size: 28px;
                font-weight: bold;
                cursor: pointer;
                border: none;
                background: none;
                padding: 5px 10px;
                transition: color 0.3s ease;
            }

            .close-button:hover 
            {color: #002a2e;}

            .modal-body 
            {padding: 20px 0;}

            .modal-image 
            {
                width: 100%;
                max-height: 400px;
                object-fit: cover;
                border-radius: 8px;
                margin-bottom: 20px;
            }

            .modal-description 
            {
                font-size: 18px;
                line-height: 1.6;
                color: #333;
                text-align: right;
            }

            footer 
            {
                background-color: #004c54;
                color: white;
                text-align: center;
                padding: 15px;
            }

            footer a 
            {
                color: #ffdd00;
                text-decoration: none;
                font-weight: bold;
            }

            footer a:hover
            {text-decoration: underline;}

            /* Responsive Styling */
            @media (max-width: 1200px)
            {
                .image-list 
                {grid-template-columns: repeat(4, 1fr);}
            }

            @media (max-width: 768px) 
            {
                .image-list 
                {grid-template-columns: repeat(3, 1fr);}
                .modal-content 
                {
                    width: 95%;
                    margin: 10% auto;
                }
            }

            @media (max-width: 480px) 
            {
                .image-list 
                {grid-template-columns: repeat(2, 1fr);}
                .modal-content
                {margin: 15% auto;}
            }
        </style>
    </head>
    <body >
        <header dir="ltr">
            <div class="logo">
                <img src="Stadium Story.png" alt="Stadium Story icon">
            </div>
            <nav class="nav">
                <ul>
                    <li><a href="about.html#contact">تواصل معنا</a></li>
                    <li><a href="about.html"><strong>عن الموقع</strong></a></li>
                    <li><a href="index.php #gallery"><strong>المعرض</strong></a></li>
                    <li><a href="index.php#info"><strong>حقائق عامة</strong></a></li>
                    <li><a href="index.php"><strong>الصفحة الرئيسية</strong></a></li>
                </ul>
            </nav>
        </header>

        <main>
            <section class="hero">
                <h1>مرحباً بكم في موقع قصة ملعب</h1>
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
                        foreach ($stadiums as $stadium) 
                        {
                            echo '<li class="image-item">';
                            echo '<img src="'.$stadium['url'].'" alt="' . $stadium['name'] . '" class="stadium-image" data-name="' . $stadium['name'] . '"data-description="' . $stadium['description'] . '"data-image="' . $stadium['url'] . '">';
                            echo '<p><b>' . $stadium['name'] . '</b></p>';
                            echo '</li>';
                        }
                    ?>
                </ul>
            </section>
        </main>

        <div id="stadiumModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title"></h3>
                    <button class="close-button">&times;</button>
                </div>
                <div class="modal-body">
                    <img class="modal-image" src="" alt="">
                    <div class="modal-description"></div>
                </div>
            </div>
        </div>

        <footer>
            <p>&copy; JUC students | المملكة العربية السعودية | <a href="about.html #contact" class="highlight">تواصل معنا</a></p>
        </footer>

        <script>
            document.addEventListener("DOMContentLoaded", () =>
            {
                const modal = document.getElementById("stadiumModal");
                const modalTitle = modal.querySelector(".modal-title");
                const modalImage = modal.querySelector(".modal-image");
                const modalDescription = modal.querySelector(".modal-description");
                const closeButton = modal.querySelector(".close-button");

                // Function to open modal
                function openModal(name, description, imageUrl) 
                {
                    modalTitle.textContent = name;
                    modalDescription.textContent = description;
                    modalImage.src = imageUrl;
                    modalImage.alt = name;
                    modal.style.display = "block";
                    void modal.offsetWidth;
                    modal.classList.add("show");
                }

                function closeModal() 
                {
                    modal.classList.remove("show");
                    setTimeout(() => 
                    {modal.style.display = "none";}, 300);
                }

                const images = document.querySelectorAll(".stadium-image");
                images.forEach(image => 
                {
                    image.addEventListener("click", () => 
                    {
                        const name = image.getAttribute("data-name");
                        const description = image.getAttribute("data-description");
                        const imageUrl = image.getAttribute("data-image");
                        openModal(name, description, imageUrl);
                    });
                });

                closeButton.addEventListener("click", closeModal);
                window.addEventListener("click", (event) => 
                {
                    if (event.target === modal) 
                    {closeModal();}
                });

                document.addEventListener("keydown", (event) => 
                {
                    if (event.key === "Escape" && modal.style.display === "block") 
                    {closeModal();}
                });
            });
        </script>
    </body>
</html>