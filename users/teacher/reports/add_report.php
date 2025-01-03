<!-- users/teacher/reports/add_report.php -->
<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../../auth/login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = $_POST['student_id'];
    $subject_id = $_POST['subject_id'];
    $exam_score = $_POST['exam_score'];
    $class_score = $_POST['class_score'];
    $total_score = $exam_score * 0.7 + $class_score * 0.3;
    $remarks = $_POST['remarks'];

    $sql = "INSERT INTO reports (student_id, subject_id, exam_score, class_score, total_score, remarks) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('iiddss', $student_id, $subject_id, $exam_score, $class_score, $total_score, $remarks);

    if ($stmt->execute()) {
        header('Location: view_reports.php');
    } else {
        $error = "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Report - StuDesk</title>
    <link rel="stylesheet" href="../../../assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <?php include '../../../templates/header.php'; ?>
    <div class="container">
        <div class="row mt-4">
            <div class="col-md-3">
                <?php include '../../../templates/sidebar.php'; ?>
            </div>
            <div class="col-md-9">
                <h2>Add Report</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="student_id">Student ID</label>
                        <input type="text" class="form-control" id="student_id" name="student_id" required>
                    </div>
                    <div class="form-group">
                        <label for="subject_id">Subject ID</label>
                        <input type="text" class="form-control" id="subject_id" name="subject_id" required>
                    </div>
                    <div class="form-group">
                        <label for="exam_score">Exam Score (70%)</label>
                        <input type="number" step="0.01" class="form-control" id="exam_score" name="exam_score" required>
                    </div>
                    <div class="form-group">
                        <label for="class_score">Class Score (30%)</label>
                        <input type="number" step="0.01" class="form-control" id="class_score" name="class_score" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="4"></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Report</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="../../../assets/js/scripts.js"></script>
</body>
</html>