<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'lms');

if (isset($_GET['delete_course_id'])) {
    $delete_id = $_GET['delete_course_id'];
    $conn->query("DELETE FROM courses WHERE id=$delete_id");
    header('Location: manage_courses.php');
    exit();
}


$courses_result = $conn->query("SELECT * FROM courses");


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = '';

    if ($_FILES['image']['name']) {
        $image_name = basename($_FILES['image']['name']);
        $target_dir = "../images/course_images/";
        $target_file = $target_dir . $image_name;

        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $image = $image_name;
        } else {
            echo "Error uploading image.";
            exit();
        }
    }

    if (isset($_POST['course_id'])) {
        $course_id = $_POST['course_id'];
        if ($image) {
            $sql = "UPDATE courses SET title=?, description=?, price=?, image=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssdsi', $title, $description, $price, $image, $course_id);
        } else {
            $sql = "UPDATE courses SET title=?, description=?, price=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param('ssdi', $title, $description, $price, $course_id);
        }
    } else {
        $sql = "INSERT INTO courses (title, description, price, image) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssds', $title, $description, $price, $image);
    }

    if ($stmt->execute()) {
        header('Location: manage_courses.php');
        exit();
    } else {
        echo "Error: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Courses</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #F0F8FF;
        }

        .container {
            padding: 30px;
        }
        .navbar {
            background-color: #0D6FC1 !important;
        }
        .navbar-brand, .nav-link, .dropdown-item {
            color: #fff !important;
        }
    
        .btn-custom {
            background-color: #007bff;
            border-color: #007bff;
        }

        .btn-custom:hover {
            background-color: #0069d9;
            border-color: #0062cc;
        }

        .table th,
        .table td {
            vertical-align: middle;
        }
    </style>
</head>
<body>

<?php include 'navbar.php'; ?>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <h3>Manage Courses</h3>
        </div>
        <div class="col-md-4 text-right">
            <a href="#" class="btn btn-success mb-3" data-toggle="modal" data-target="#addCourseModal">Add Course</a>
        </div>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $courses_result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['id']; ?></td>
                        <td><?php echo htmlspecialchars($row['title']); ?></td>
                        <td><?php echo htmlspecialchars($row['description']); ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td><img src="../images/course_images/<?php echo $row['image']; ?>" alt="Course Image" width="50"></td>
                        <td>
                            <a href="edit_course.php?id=<?php echo $row['id']; ?>" class="btn btn-warning btn-sm">Edit</a>
                            <a href="manage_courses.php?delete_course_id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Add Course -->
<div class="modal fade" id="addCourseModal" tabindex="-1" aria-labelledby="addCourseModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addCourseModalLabel">Add Course</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" required>
                    </div>
                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control" id="image" name="image" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save changes</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
