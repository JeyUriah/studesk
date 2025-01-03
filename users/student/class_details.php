<!-- users/student/class_details.php -->
<?php
session_start();
require_once '../../config/database.php';

if (!isset($_SESSION['username'])) {
    header('Location: ../auth/login.php');
    exit();
}

// Fetch class details from the database
$sql = "SELECT * FROM classes WHERE student_username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('s', $_SESSION['username']);
$stmt->execute();
$result = $stmt->get_result();
$class = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Class Details - StuDesk</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../../templates/header.php'; ?>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-3">
                <?php include '../../templates/sidebar.php'; ?>
            </div>
            <div class="col-md-9">
                <h2>Class Details</h2>
                <?php if ($class): ?>
                    <table class="table table-bordered">
                        <tr>
                            <th>Class ID</th>
                            <td><?php echo $class['id']; ?></td>
                        </tr>
                        <tr>
                            <th>Class Name</th>
                            <td><?php echo $class['name']; ?></td>
                        </tr>
                        <tr>
                            <th>Teacher</th>
                            <td><?php echo $class['teacher']; ?></td>
                        </tr>
                        <tr>
                            <th>Schedule</th>
                            <td><?php echo $class['schedule']; ?></td>
                        </tr>
                    </table>
                <?php else: ?>
                    <p>No class details found for your account.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../assets/js/scripts.js"></script>
</body>
</html>