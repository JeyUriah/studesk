<!-- users/auth/register.php -->
<?php
session_start();
require_once '../../config/database.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $role = $_POST['role'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $profile_picture = $_POST['profile_picture'];

    if ($role === 'teacher') {
        $teacher_id = $_POST['teacher_id'];
        $department = $_POST['department'];
        $subjects_taught = $_POST['subjects_taught'];

        $sql = "INSERT INTO users (teacher_id, role, name, email, password, phone, address, profile_picture, department, subjects_taught) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssssss', $teacher_id, $role, $name, $email, $password, $phone, $address, $profile_picture, $department, $subjects_taught);
    } else {
        $student_id = $_POST['student_id'];
        $class_grade = $_POST['class_grade'];
        $subjects_enrolled = $_POST['subjects_enrolled'];
        $enrollment_id = $_POST['enrollment_id'];
        $guardian_name = $_POST['guardian_name'];
        $relation = $_POST['relation'];
        $emergency_contact = $_POST['emergency_contact'];

        $sql = "INSERT INTO users (student_id, role, name, email, password, phone, address, profile_picture, class_grade, subjects_enrolled, enrollment_id, guardian_name, relation, emergency_contact) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ssssssssssssss', $student_id, $role, $name, $email, $password, $phone, $address, $profile_picture, $class_grade, $subjects_enrolled, $enrollment_id, $guardian_name, $relation, $emergency_contact);
    }

    if ($stmt->execute()) {
        $_SESSION['username'] = $email;
        $_SESSION['role'] = $role;
        if ($role === 'teacher') {
            header('Location: ../teacher/index.php');
        } else {
            header('Location: ../student/index.php');
        }
        exit();
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
    <title>Register - StuDesk</title>
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2 class="mt-4">Register</h2>
        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>
        <form method="POST" action="">
            <div class="form-group">
                <label for="role">Role</label>
                <select class="form-control" id="role" name="role" required>
                    <option value="teacher">Teacher</option>
                    <option value="student">Student</option>
                </select>
            </div>
            <div class="form-group">
                <label for="name">Name</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="phone">Phone Number</label>
                <input type="text" class="form-control" id="phone" name="phone" required>
            </div>
            <div class="form-group">
                <label for="address">Address</label>
                <textarea class="form-control" id="address" name="address" required></textarea>
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture URL</label>
                <input type="text" class="form-control" id="profile_picture" name="profile_picture">
            </div>
            <div id="teacher-fields" style="display: none;">
                <div class="form-group">
                    <label for="teacher_id">Teacher ID</label>
                    <input type="text" class="form-control" id="teacher_id" name="teacher_id">
                </div>
                <div class="form-group">
                    <label for="department">Department</label>
                    <input type="text" class="form-control" id="department" name="department">
                </div>
                <div class="form-group">
                    <label for="subjects_taught">Subjects Taught</label>
                    <textarea class="form-control" id="subjects_taught" name="subjects_taught"></textarea>
                </div>
            </div>
            <div id="student-fields" style="display: none;">
                <div class="form-group">
                    <label for="student_id">Student ID</label>
                    <input type="text" class="form-control" id="student_id" name="student_id">
                </div>
                <div class="form-group">
                    <label for="class_grade">Class/Grade</label>
                    <input type="text" class="form-control" id="class_grade" name="class_grade">
                </div>
                <div class="form-group">
                    <label for="subjects_enrolled">Subjects Enrolled</label>
                    <textarea class="form-control" id="subjects_enrolled" name="subjects_enrolled"></textarea>
                </div>
                <div class="form-group">
                    <label for="enrollment_id">Enrollment ID</label>
                    <input type="text" class="form-control" id="enrollment_id" name="enrollment_id">
                </div>
                <div class="form-group">
                    <label for="guardian_name">Guardian Name</label>
                    <input type="text" class="form-control" id="guardian_name" name="guardian_name">
                </div>
                <div class="form-group">
                    <label for="relation">Relation</label>
                    <input type="text" class="form-control" id="relation" name="relation">
                </div>
                <div class="form-group">
                    <label for="emergency_contact">Emergency Contact</label>
                    <input type="text" class="form-control" id="emergency_contact" name="emergency_contact">
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        const roleField = document.getElementById('role');
        const teacherFields = document.getElementById('teacher-fields');
        const studentFields = document.getElementById('student-fields');

        roleField.addEventListener('change', function() {
            if (this.value === 'teacher') {
                teacherFields.style.display = 'block';
                studentFields.style.display = 'none';
            } else {
                teacherFields.style.display = 'none';
                studentFields.style.display = 'block';
            }
        });
    </script>
</body>
</html>