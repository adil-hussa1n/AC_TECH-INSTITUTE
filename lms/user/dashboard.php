<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'lms');
$user_id = $_SESSION['user_id'];

$sql = "SELECT user_courses.id as enrollment_id, courses.title, courses.description, courses.image, courses.price 
        FROM user_courses
        JOIN courses ON user_courses.course_id = courses.id
        WHERE user_courses.user_id = $user_id";
$result = $conn->query($sql);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'leave_course') {
    if (isset($_POST['enrollment_id'])) {
        $enrollment_id = $_POST['enrollment_id'];
        $delete_sql = "DELETE FROM user_courses WHERE id = $enrollment_id AND user_id = $user_id";
        if ($conn->query($delete_sql) === TRUE) {
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Dashboard</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #F0F8FF;
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
            font-family: 'Courier New', Courier, monospace;
            font-weight: bold;
        }

        .navbar {
            background-color: #0D6FC1 !important;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
        }

        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: #0D6FC1;
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
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark">
    <a class="navbar-brand" href="../index.php">AC-Tech</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="../index.php">Home</a>
            </li>
            <?php if(isset($_SESSION['user_id'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="dashboard.php">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            <?php else: ?>
                <li class="nav-item">
                    <a class="nav-link" href="user/login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="user/register.php">Register</a>
                </li>
            <?php endif; ?>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <div class="text-center" id="courses">
        <h2 class="mb-4 align-self-center" style="background-color: #0D6FC1; color: #fff; border-radius: 10px; padding: 10px">Dashboard</h2>
        <h4 class="mb-4 align-self-center" style="background-color: #f5f5f5; color: #0D6FC1; border-radius: 10px; padding: 10px">Explore Your Enrolled Courses</h4>
    </div>
    <div class="row">
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 shadow-sm border-0">
                    <img src="../images/course_images/<?php echo $row['image']; ?>" class="card-img-top" alt="...">
                    <div class="card-body">
                        <h5 class="card-title"><?php echo $row['title']; ?></h5>
                        <p class="card-text"><?php echo $row['description']; ?></p>
                        <p class="card-text"><strong>Price:</strong> $<?php echo $row['price']; ?></p>
                        <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                            <input type="hidden" name="enrollment_id" value="<?php echo $row['enrollment_id']; ?>">
                            <input type="hidden" name="action" value="leave_course">
                            <button type="submit" class="btn btn-danger">Leave Course</button>
                        </form>
                    </div>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    <div class="mt-3">
        <a href="../index.php" class="btn btn-primary">Back to Home</a>
    </div>
</div>

<footer class="footer text-center text-lg-start mt-5">
    <div class="container">
        <p>&copy; 2024 AC-TECH</p>
    </div>
</footer>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
