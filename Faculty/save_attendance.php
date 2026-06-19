<?php
// Include database connection
include 'faculty_init.php';

// Start session
session_start();
if(!isset($_SESSION['faculty_email'])) {
    header("Location: faculty_login.php");
    exit();
}

$faculty_email = $_SESSION['faculty_email'];
$date = $_POST['attendance_date'];
$subject = $_POST['subject'];
$statuses = $_POST['status']; // array: student_mno => status

$success_count = 0;

foreach($statuses as $mno => $status) {
    // Check if attendance already exists for this student on this date
    $check_sql = "SELECT * FROM student_attendance 
                  WHERE student_mno = '$mno' 
                  AND attendance_date = '$date'
                  AND subject = '$subject'";
    $check_result = mysqli_query($con, $check_sql);
    
    if(mysqli_num_rows($check_result) > 0) {
        // Update existing record
        $update_sql = "UPDATE student_attendance 
                       SET attendance_status = '$status',
                           faculty_email = '$faculty_email'
                       WHERE student_mno = '$mno' 
                       AND attendance_date = '$date'
                       AND subject = '$subject'";
        mysqli_query($con, $update_sql);
    } else {
        // Insert new record
        $insert_sql = "INSERT INTO student_attendance 
                       (student_mno, attendance_date, attendance_status, subject, faculty_email) 
                       VALUES ('$mno', '$date', '$status', '$subject', '$faculty_email')";
        mysqli_query($con, $insert_sql);
    }
    $success_count++;
}

?>

<!DOCTYPE html>
<html>
<head>
    <title>Attendance Saved</title>
    <style>
        body { font-family: Arial; margin: 50px; text-align: center; }
        .success { color: green; font-size: 24px; }
        a { display: inline-block; margin-top: 20px; padding: 10px 20px; background: #4CAF50; color: white; text-decoration: none; }
    </style>
</head>
<body>
    <h2 class="success">✅ Attendance Saved Successfully!</h2>
    <p>Total students marked: <?php echo $success_count; ?></p>
    <p>Date: <?php echo $date; ?></p>
    <p>Subject: <?php echo $subject; ?></p>
    
    <a href="mark_attendance.php">Mark More Attendance</a>
    <a href="faculty_panel.php" style="margin-left: 10px;">Back to Panel</a>
</body>
</html>