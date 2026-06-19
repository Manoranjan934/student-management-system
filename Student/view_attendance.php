<?php
// Include database connection
include 'student_init.php';

// Start session
session_start();
if(!isset($_SESSION['student_email'])) {
    header("Location: student_login.php");
    exit();
}

$student_mno = $_SESSION['student_mno'];

// Get attendance records
$sql = "SELECT * FROM student_attendance 
        WHERE student_mno = '$student_mno' 
        ORDER BY attendance_date DESC";
$result = mysqli_query($con, $sql);

// Calculate statistics
$total = mysqli_num_rows($result);
$present = 0;
$absent = 0;
$late = 0;

$attendance_data = [];
while($row = mysqli_fetch_assoc($result)) {
    $attendance_data[] = $row;
    if($row['attendance_status'] == 'present') $present++;
    elseif($row['attendance_status'] == 'absent') $absent++;
    else $late++;
}

$percentage = ($total > 0) ? round(($present / $total) * 100, 2) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Attendance</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        table { border-collapse: collapse; width: 80%; margin: 20px auto; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #4CAF50; color: white; }
        tr:nth-child(even) { background-color: #f2f2f2; }
        .present { color: green; font-weight: bold; }
        .absent { color: red; font-weight: bold; }
        .late { color: orange; font-weight: bold; }
        .stats { background: #f9f9f9; padding: 20px; margin: 20px auto; width: 80%; border-radius: 10px; }
        .stat-box { display: inline-block; margin: 10px; padding: 15px; background: white; border-radius: 5px; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">My Attendance Record</h2>
    
    <div class="stats" style="text-align: center;">
        <div class="stat-box">
            <strong>Total Classes:</strong> <?php echo $total; ?>
        </div>
        <div class="stat-box" style="color: green;">
            <strong>Present:</strong> <?php echo $present; ?>
        </div>
        <div class="stat-box" style="color: red;">
            <strong>Absent:</strong> <?php echo $absent; ?>
        </div>
        <div class="stat-box" style="color: orange;">
            <strong>Late:</strong> <?php echo $late; ?>
        </div>
        <div class="stat-box" style="color: blue;">
            <strong>Attendance %:</strong> <?php echo $percentage; ?>%
        </div>
    </div>

    <table>
        <tr>
            <th>Date</th>
            <th>Subject</th>
            <th>Status</th>
            <th>Faculty</th>
        </tr>
        
        <?php foreach($attendance_data as $row) { ?>
        <tr>
            <td><?php echo $row['attendance_date']; ?></td>
            <td><?php echo $row['subject']; ?></td>
            <td class="<?php echo $row['attendance_status']; ?>">
                <?php echo ucfirst($row['attendance_status']); ?>
            </td>
            <td><?php echo $row['faculty_email']; ?></td>
        </tr>
        <?php } ?>
        
        <?php if($total == 0) { ?>
        <tr>
            <td colspan="4" style="text-align: center;">No attendance records found.</td>
        </tr>
        <?php } ?>
        
    </table>

    <div style="text-align: center;">
        <a href="student_panel.php">Back to Panel</a>
    </div>

</body>
</html>