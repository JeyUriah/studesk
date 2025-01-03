<!-- users/teacher/subjects/delete_assignment.php -->
<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../../auth/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM subject_assignments WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: view_assignments.php');
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    header('Location: view_assignments.php');
    exit();
}
?>