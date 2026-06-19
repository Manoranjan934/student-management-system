<?php
// Include database connection
include 'faculty_init.php';

// Start session to check if faculty is logged in
session_start();
if(!isset($_SESSION['faculty_email'])) {
    header("Location: faculty_login.php");
    exit();
}

// Get all students from database
$sql = "SELECT * FROM student_add ORDER BY student_name";
$result = mysqli_query($con, $sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Mark Attendance</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .present { color: green; font-weight: bold; }
        .absent { color: red; font-weight: bold; }
        .late { color: orange; font-weight: bold; }
        button { background-color: #4CAF50; color: white; padding: 10px 20px; border: none; cursor: pointer; }
        button:hover { background-color: #45a049; }
        input[type="date"] { padding: 8px; margin: 10px; }
        select { padding: 8px; margin: 10px; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Mark Student Attendance</h2>
    
    <form action="save_attendance.php" method="post">
        
        <div style="text-align: center; margin: 20px;">
            <label><strong>Date:</strong></label>
            <input type="date" name="attendance_date" required value="<?php echo date('Y-m-d'); ?>">
            
            <label><strong>Subject:</strong></label>
            <select name="subject" required>
                <option value="">Select Subject</option>
                <option value="Java">Java</option>
                <option value="Python">Python</option>
                <option value="Kotlin">Kotlin</option>
                <option value="C">C</option>
                <option value="PHP">PHP</option>
                <option value="CS">CS</option>
            </select>
        </div>

        <table>
            <tr>
                <th>S.No</th>
                <th>Student Name</th>
                <th>Mobile No</th>
                <th>Present</th>
                <th>Absent</th>
                <th>Late</th>
            </tr>
            
            <?php 
            $i = 1;
            while($row = mysqli_fetch_assoc($result)) { 
            ?>
            <tr>
                <td><?php echo $i++; ?></td>
                <td><?php echo $row['student_name']; ?></td>
                <td><?php echo $row['student_mno']; ?></td>
                <td>
                    <input type="radio" name="status[<?php echo $row['student_mno']; ?>]" value="present" checked>
                </td>
                <td>
                    <input type="radio" name="status[<?php echo $row['student_mno']; ?>]" value="absent">
                </td>
                <td>
                    <input type="radio" name="status[<?php echo $row['student_mno']; ?>]" value="late">
                </td>
            </tr>
            <?php } ?>
            
        </table>

        <div style="text-align: center;">
            <button type="submit">Save Attendance</button>
            <a href="faculty_panel.php" style="margin-left: 20px;">Back to Panel</a>
        </div>

    </form>

</body>
</html>