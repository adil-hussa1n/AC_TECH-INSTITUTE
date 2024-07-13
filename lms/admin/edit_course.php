<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'lms');

$course = [
    'id' => '',
    'title' => '',
    'description' => '',
    'price' => '',
    'image' => ''
];

if (isset($_GET['id'])) {
    $course_id = $_GET['id'];

    $sql = "SELECT * FROM courses WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $course_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $course = $result->fetch_assoc();
    }
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['edit_course'])) {
    $course_id = $_POST['course_id'];
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    if ($_FILES['image']['name']) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "../images/course_images/";
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $sql = "UPDATE courses SET title=?, description=?, price=?, image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssdsi', $title, $description, $price, $image_name, $course_id);
            if ($stmt->execute()) {
                header('Location: manage_courses.php');
                exit();
            } else {
                echo "Error updating course: " . $conn->error;
            }
        } else {
            echo "Error uploading image.";
            exit();
        }
    } else {
        $sql = "UPDATE courses SET title=?, description=?, price=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssdi', $title, $description, $price, $course_id);
        if ($stmt->execute()) {
            header('Location: manage_courses.php');
            exit();
        } else {
            echo "Error updating course: " . $conn->error;
        }
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Course</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #F0F8FF;
            font-family: Arial, sans-serif;
        }

        .container {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            background-color: #ffffff;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 20px;
        }
        .navbar {
            background-color: #0D6FC1 !important;
        }
        .navbar-brand {
            font-weight: bold;
            color: #fff !important;
        }

        .navbar-nav .nav-link {
            color: #fff !important;
        }

        .form-group {
            margin-bottom: 20px;
        }

        label {
            font-weight: bold;
        }

        .custom-file-label::after {
            content: "Choose file";
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-primary:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="dashboard.php">Admin Dashboard</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav"
            aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="dashboard.php">Home</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="manage_courses.php">Manage Courses</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <h3 class="text-center mb-4">Edit Course</h3>
    <form action="edit_course.php" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="course_id" value="<?php echo htmlspecialchars($course['id']); ?>">
        
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($course['title']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="description">Description</label>
            <textarea class="form-control" id="description" name="description" rows="4" required><?php echo htmlspecialchars($course['description']); ?></textarea>
        </div>
        
        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" class="form-control" id="price" name="price" value="<?php echo htmlspecialchars($course['price']); ?>" required>
        </div>
        
        <div class="form-group">
            <label for="image">Image</label>
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="image" name="image">
                <label class="custom-file-label" for="image">Choose file...</label>
            </div>
            <small class="form-text text-muted">Current Image: <?php echo htmlspecialchars($course['image']); ?></small>
        </div>
        
        <button type="submit" name="edit_course" class="btn btn-primary btn-block">Save changes</button>
    </form>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
