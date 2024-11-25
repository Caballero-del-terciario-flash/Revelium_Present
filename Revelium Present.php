<?php
// Configuration
$db_host = 'localhost';
$db_username = 'root';
$db_password = '';
$db_name = 'revelium_present';

// Connect to database
$conn = new mysqli($db_host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to mark attendance
function markAttendance($student_id, $class_id, $present) {
    $sql = "INSERT INTO attendance (student_id, class_id, state, attendance_date) VALUES (?, ?, NOW(), ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $student_id, $class_id, $present);
    $stmt->execute();
    $stmt->close();
}

// Function to display attendance records
function getAttendanceRecords($class_id) {
    $sql = "SELECT s.name, a.attendance_date, a.present FROM students s JOIN attendance a ON s.id = a.student_id WHERE a.class_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $attendance_records = array();
    while ($row = $result->fetch_assoc()) {
        $attendance_records[] = $row;
    }
    $stmt->close();
    return $attendance_records;
}

// Example usage
$student_id = 1; // Replace with actual student ID
$class_id = 1; // Replace with actual class ID
$present = 1; // 1 for present, 0 for absent
markAttendance($student_id, $class_id, $present);

$attendance_records = getAttendanceRecords($class_id);
foreach ($attendance_records as $record) {
    echo "Student: " . $record['name'] . ", Date: " . $record['attendance_date'] . ", Present: " . ($record['present'] ? 'Yes' : 'No') . "<br>";
}

// Close database connection
$conn->close();
?>