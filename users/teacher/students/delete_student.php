<!-- users/teacher/students/delete_student.php -->
<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../../auth/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM students WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: view_students.php');
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    header('Location: view_students.php');
    exit();
}
?>