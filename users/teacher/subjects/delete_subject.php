<!-- users/teacher/subjects/delete_subject.php -->
<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../../auth/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM subjects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: view_subjects.php');
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    header('Location: view_subjects.php');
    exit();
}
?>