<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

$conn = new mysqli('localhost', 'root', '', 'lms');

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $course_id = $_GET['id'];

    $sql = "DELETE FROM courses WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $course_id);

    if ($stmt->execute()) {
        header('Location: manage_courses.php');
        exit();
    } else {
        echo "Error deleting course: " . $conn->error;
    }

    $stmt->close();
}

$conn->close();
?>
