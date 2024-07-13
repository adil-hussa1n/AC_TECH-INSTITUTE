<?php
$conn = new mysqli('localhost', 'root', '', 'lms');

function hasPurchased($conn, $user_id, $course_id) {
    $stmt = $conn->prepare("SELECT * FROM user_courses WHERE user_id = ? AND course_id = ?");
    $stmt->bind_param("ii", $user_id, $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    return $result->num_rows > 0;
}

$sql = "SELECT * FROM courses";
$result = $conn->query($sql);

session_start();

$user = null;
if (isset($_SESSION['user_id'])) {
    $stmt = $conn->prepare("SELECT username, profile_picture FROM users WHERE id = ?");
    $stmt->bind_param("i", $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AC-TECH INSTITUTE</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

    <style>
        body {
            background-color:#F0F8FF;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            
        }

        .card {
            transition: transform 0.2s, box-shadow 0.2s;
            border-radius: 15px;
            overflow: hidden;
        }

        .card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }

        .navbar-brand {
            font-weight: bold;
        }

        .navbar {
            background-color:#0D6FC1 !important;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000; 
        }

        .navbar-nav .nav-link {
            color: #fff !important;
        }

        .footer {
            bottom: 0;
            width: 100%;
            background-color:#0D6FC1;
            color: #fff;
            padding: 20px 0;
        }

        .footer p {
            margin: 0;
        }

        .card-body h5 {
            font-family: 'Arial', sans-serif;
            font-weight: bold;
        }

        .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .navbar-toggler-icon {
            color: white;
        }

        .carousel {
            margin-top: 170px !important;
            margin-bottom: 100px !important;
        }

        #carouselExampleIndicators {
        width: 100%; 
        margin-top: 20px; 
        }

        .carousel-item img {
         height: 600px;
        }
    </style>
</head>

<body>
    

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="index.php">AC-Tech</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#courses">Courses</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#about">About Us</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#contact">Contact Us</a>
                </li>
                <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="user/dashboard.php">Dashboard</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link" href="user/logout.php">Logout</a>
                </li> -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img src="images/profile_pictures/<?php echo $user['profile_picture']; ?>" alt="User Picture" class="rounded-circle" style="width: 30px; height: 30px; object-fit: cover; margin-right: 10px;">
                        <?php echo $user['username']; ?>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item text-danger" href="user/logout.php">
                            <i class="fas fa-sign-out-alt fa-fw mr-2"></i>
                            Logout
                        </a>
                    </div>
                </li>

                <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="user/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user/register.php">Register</a>
                </li>
                <?php endif; ?>
                <li class="nav-item">
                    <a class="nav-link btn-primary" href="https://adilhussa1n.netlify.app/" target="_blank" style="background-color: #2E4053; border-color: #007bff; border-radius: 5px;"
                    onmouseover="this.style.background='#0056b3'; this.style.borderColor='#004085';" onmouseout="this.style.background='#2E4053'; this.style.borderColor='#007bff';">
                        <span style="color: #fff;">Dev Info</span>
                    </a>
                </li>
            </ul>
        </div>
    </nav>


<!-- Welcome Section -->
<div class="container-fluid">
    <div class="row align-items-center">
        <div class="col-md-3">
            <h1 class="mb-4" style="display: inline-block;">
                <span class="typed-text"></span>
                <span id="typed-cursor"></span>
            </h1>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/typed.js/2.0.11/typed.min.js"></script>
            <script>
                var typed = new Typed(".typed-text", {
                    strings: ["Welcome to AC-Tech Institute"],
                    typeSpeed: 100,
                    backSpeed: 40,
                    loop: true
                });
            </script>
            <p class="lead" style="font-size: 20px; font-weight: 500;">
                We are dedicated to providing high-quality education and training to students, <br>helping them to achieve their career goals and make a positive impact in the tech industry.
            </p>
        </div>

        <!-- casousel -->
        <div class="col-md-9">
            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                </ol>
                <div class="carousel-inner" style="border-radius: 10px;">
                    <div class="carousel-item active">
                        <img class="d-block w-100" src="1.png" alt="First slide" style="object-fit: cover; height: 600px; border-radius: 10px;">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-100" src="2.png" alt="Second slide" style="object-fit: cover; height: 600px; border-radius: 10px;">
                    </div>
                    <div class="carousel-item">
                        <img class="d-block w-10" src="3.png" alt="Third slide" style="object-fit: cover; height: 600px; border-radius: 10px;">
                    </div>
                </div>
                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="sr-only">Previous</span>
                </a>
                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="sr-only">Next</span>
                </a>
            </div>
            <style>
                .carousel-item {
                    transition: transform 0.2s, box-shadow 0.2s;
                }
                .carousel-item:hover {
                    transform: scale(1.05);
                }
            </style>
        </div>
    </div>
</div>


    <!-- Main content -->
    <div class="container mt-5">
        <div class="text-center" id="courses">
            <h2 class="mb-4 align-self-center" style="background-color:#0D6FC1; color: #fff; border-radius: 10px; padding: 10px">Available Courses</h2>
        </div>
        <div class="row">
            <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="images/course_images/<?php echo $row['image']; ?>" class="card-img-top"
                        alt="<?php echo $row['title']; ?>">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <p class="card-text"><strong>Price:</strong> $<?php echo $row['price']; ?></p>
                        <?php if(isset($_SESSION['user_id'])): ?>
                            <?php if(!hasPurchased($conn, $_SESSION['user_id'], $row['id'])): ?>
                            <form action="user/buy_course.php" method="POST">
                                <input type="hidden" name="course_id" value="<?php echo $row['id']; ?>">
                                <button type="submit" class="btn btn-primary btn-sm">Buy Now</button>
                            </form>
                            <?php else: ?>
                            <button class="btn btn-secondary btn-sm" disabled>Purchased</button>
                            <?php endif; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>

<div id="about" >
<h2 class="mt-15 text-center"  style="background-color:#0D6FC1; color: #fff; border-radius: 10px; padding: 10px; margin-top: 50px; margin-bottom: 50px">About AC-Tech</h2>
</div>
        <!-- About the Tech Institute -->
        <div class="" >
            <div class="row">
                <div class="col-md-8 offset-md-2">
                    <div class="card text-center mb-3">
                        <div class="card-body">
                            <h5 class="card-title">AC-Tech</h5>
                            <p class="card-text">Welcome to AC Tech Institute, where we specialize in providing cutting-edge digital computer-based technical courses.</p>
                            <p class="card-text">Our institute is dedicated to equipping students with the skills and knowledge needed to thrive in today's rapidly evolving tech industry.</p>
                            <p class="card-text">At AC Tech Institute, we understand the importance of staying ahead of the curve in the digital age. That's why our curriculum is carefully designed to cover the latest trends and technologies in computer science, information technology, and related fields. Whether you're interested in software development, cybersecurity, data science, or any other area of technology, we have a course for you.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container mt-5">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card">
                        <div class="card-body text-center">
                            <img src="ac.jpg" class="img-fluid rounded-circle mb-3" alt="Founder" style="max-width: 200px;">
                            <h2 class="card-title">Founder</h2>
                            <p class="card-text">Our founder, Mr. John Doe, is a highly experienced and knowledgeable computer professional with over 10 years of experience in the field. He has a passion for teaching and a deep understanding of the ever-evolving tech landscape. Under his leadership, AC Tech Institute is committed to providing top-notch education and training to aspiring tech enthusiasts.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- YouTube Video Section -->
        <div class="container mt-5">
            <div class="row justify-content-center">
                <div class="col-md-6">
                    <div class="embed-responsive embed-responsive-16by9">
                        <iframe class="embed-responsive-item rounded" src="https://www.youtube.com/embed/AMMvSEBPQgY" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        </div>

        <!-- Contact Us Section -->
        <div class="container mt-5" id="contact">
            <h2 class="text-center mb-4" style="background-color:#0D6FC1; color: #fff; border-radius: 10px; padding: 10px">Contact Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Get in Touch</h5>
                            <form action="https://sheetdb.io/api/v1/hj3wi6nkkuqmy" method="POST" target="_blank">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name" required>
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                                </div>
                                <div class="form-group">
                                    <label for="message">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="3" placeholder="Enter your message" required></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Send</button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Mini Map Card -->
                <div class="col-md-6">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">Find Us</h5>
                        <div style="height: 345px;">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5117.9398190790425!2d91.87573229655085!3d24.90037087612418!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x375054d6b9d9076d%3A0x86917f7de300bb40!2sThe%20Mad%20Grill!5e0!3m2!1sen!2sbd!4v1720535635804!5m2!1sen!2sbd" width="480" height="350" style="border:0; border-radius: 10px" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>

    <!-- Social Media Card -->
    <div class="container mt-5 mb-5">
            <div class="row justify-content-center">
                <div class="col-md-12 text-center">
                    <div class="card p-3 border-0 shadow">
                        
                        <h4 class="mb-3">Follow us on social media</h4>
                        <div class="d-flex justify-content-center">
                            <a href="https://www.facebook.com/" target="_blank"><img src="https://img.icons8.com/color/32/000000/facebook-circled--v1.png" /></a>
                            <a href="https://www.instagram.com/" target="_blank"><img src="https://img.icons8.com/color/30/000000/instagram-new.png" /></a>
                            <a href="https://twitter.com/" target="_blank"><img src="https://img.icons8.com/color/30/000000/twitter.png" /></a>
                            <a href="https://www.youtube.com/" target="_blank"><img src="https://img.icons8.com/color/30/000000/youtube-play.png" /></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2024 AC-Tech Institute. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
