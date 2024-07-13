<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #F0F8FF;
        }
        .navbar {
            background-color: #0D6FC1;
        }
        .navbar-brand, .nav-link, .dropdown-item {
            color: #fff !important;
        }
        .card {
            margin-top: 20px;
        }
        .card-title {
            font-size: 1.5rem;
            font-weight: bold;
        }
        .card-text {
            font-size: 1rem;
        }
        .footer {
            background-color: #0D6FC1;
            color: #fff;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            bottom: 0;
            width: 100%;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="dashboard.php"><strong>AC-Tech Admin</strong></a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">  
                <div class="dropdown-menu" aria-labelledby="courseDropdown">
                    <a class="dropdown-item" href="show_courses.php">Show Courses</a>
                    <a class="dropdown-item" href="add_course.php">Add Course</a>
                </div>
            </li>
                                                
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div style="background-color: #0D6FC1; text-align: center; padding: 10px; border-radius: 10px;">
        <h3 style="color: #fff;">Admin Dashboard</h3>
    </div>
    <div class="row">
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">Add, edit, or remove users.</p>
                    <a href="manage_users.php" class="btn btn-primary">Go to Manage Users</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Manage Courses</h5>
                    <p class="card-text">Add, edit, or remove courses.</p>
                    <a href="show_courses.php" class="btn btn-primary">Go to Manage Courses</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Reports</h5>
                    <p class="card-text">Generate and view reports.</p>
                    <a href="" class="btn btn-primary" onclick="return alert('This feature is currently under development.')">Go to Reports</a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="footer">
    &copy; 2024 AC-Tech Admin Dashboard
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
