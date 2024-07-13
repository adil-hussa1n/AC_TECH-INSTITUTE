<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $course_id = $_POST['course_id'];
    $user_id = $_SESSION['user_id'];

    $conn = new mysqli('localhost', 'root', '', 'lms');

    $course_query = "SELECT * FROM courses WHERE id = $course_id";
    $course_result = $conn->query($course_query);

    if ($course_result->num_rows > 0) {
        $course_data = $course_result->fetch_assoc();
        $course_title = $course_data['title'];

        $insert_query = "INSERT INTO user_courses (user_id, course_id, course_title) VALUES ($user_id, $course_id, '$course_title')";
        if ($conn->query($insert_query) === TRUE) {
            header('Location: dashboard.php');
            exit();
        } else {
            echo "Error adding course: " . $conn->error;
        }
    } else {
        echo "Course not found.";
    }

    $conn->close();
} else {
    echo "Invalid request method.";
}
?>
