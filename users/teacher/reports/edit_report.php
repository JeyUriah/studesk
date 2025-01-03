<!-- users/teacher/reports/edit_report.php -->
<?php
session_start();
require_once '../../../config/database.php';

if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'teacher') {
    header('Location: ../../auth/login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $exam_score = $_POST['exam_score'];
        $class_score = $_POST['class_score'];
        $total_score = $exam_score * 0.7 + $class_score * 0.3;
        $remarks = $_POST['remarks'];

        $sql = "UPDATE reports SET exam_score = ?, class_score = ?, total_score = ?, remarks = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('dddsi', $exam_score, $class_score, $total_score, $remarks, $id);

        if ($stmt->execute()) {
            header('Location: view_reports.php');
        } else {
            $error = "Error: " . $stmt->error;
        }
    } else {
        $sql = "SELECT * FROM reports WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        $report = $result->fetch_assoc();
    }
} else {
    header('Location: view_reports.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Report - StuDesk</title>
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
                <h2>Edit Report</h2>
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <form method="POST" action="">
                    <div class="form-group">
                        <label for="exam_score">Exam Score (70%)</label>
                        <input type="number" step="0.01" class="form-control" id="exam_score" name="exam_score" value="<?php echo htmlspecialchars($report['exam_score']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="class_score">Class Score (30%)</label>
                        <input type="number" step="0.01" class="form-control" id="class_score" name="class_score" value="<?php echo htmlspecialchars($report['class_score']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="remarks">Remarks</label>
                        <textarea class="form-control" id="remarks" name="remarks" rows="4"><?php echo htmlspecialchars($report['remarks']); ?></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Report</button>
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