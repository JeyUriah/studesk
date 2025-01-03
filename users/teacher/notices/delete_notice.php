<!-- users/teacher/notices/delete_notice.php -->
<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../../auth/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM notices WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);

    if ($stmt->execute()) {
        header('Location: view_notices.php');
    } else {
        echo "Error: " . $stmt->error;
    }
} else {
    header('Location: view_notices.php');
    exit();
}
?>