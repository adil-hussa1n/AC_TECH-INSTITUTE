<?php
$conn = new mysqli('localhost', 'root', '', 'lms');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = md5($_POST['password']);
    
    $sql = "INSERT INTO admins (username, email, password) VALUES ('$username', '$email', '$password')";
    if ($conn->query($sql)) {
        header('Location: login.php');
    } else {
        echo "<div class='alert alert-danger text-center'>Error: " . $sql . "<br>" . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        /* body {
            background-color: #F0F8FF;
        }
        .registration-container {
            margin-top: 100px;
            padding: 30px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0px 0px 10px 0px #0000001;
        }
        .registration-header {
            margin-bottom: 30px;
        } */
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            text-align: center;
            padding: 10px;
            background-color: #0D6FC1;
            color: #fff;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="login.php">AC-TECH Admin</a>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="login.php">Login</a>
            </li>
        </ul>
    </div>
     </nav>
    <script>alert('Sorry, Admin Registration restricted by AC-TECH')</script>

    <video autoplay muted loop id="background-video" style="position: fixed; top: 0; left: 0; width: 100vw; height: 100vh; object-fit: cover;">
    <source src="adminvdo.mp4" type="video/mp4">
    Your browser does not support the video tag.
    </video>
     <style>
    #background-video {
        z-index: -1;
        filter: blur(10px);
    }

</style>

<!--
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 registration-container">
            <h3 class="text-center registration-header">Admin Registration</h3>
            <form method="POST">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" class="form-control" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <button type="submit" class="btn btn-primary btn-block">Register</button>
                <p class="text-center mt-3">Already have an account? <a href="login.php" class="font-weight-bold">Login</a></p>
            </form>
        </div>
    </div>
</div> -->

<div class="footer">
    © 2024 AC-TECH. All rights reserved.
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
