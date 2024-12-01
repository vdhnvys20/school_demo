<?php
include 'db.php'; 

$student_id = intval($_GET['id']);

// Fetch details
$query = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Student not found.");
}
$student = $result->fetch_assoc();

// Delete the image
if (!empty($student['image']) && file_exists('uploads/' . $student['image'])) {
    unlink('uploads/' . $student['image']);
}

// Delete the details
$stmt = $conn->prepare("DELETE FROM student WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();

header("Location: index.php");
exit();
?>
