<?php
include 'db.php';

if (!isset($_GET['id']) || empty($_GET['id'])) {
    die("Student ID is missing.");
}

$student_id = intval($_GET['id']);

//get th student details
$query = "SELECT * FROM student WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows === 0) {
    die("Student not found.");
}
$student = $result->fetch_assoc();

//fetch classes
$classes = $conn->query("SELECT * FROM classes");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    // new image check
    if (!empty($image['name']) && in_array(pathinfo($image['name'], PATHINFO_EXTENSION), ['jpg', 'png'])) {
        $imagePath = 'uploads/' . uniqid() . '_' . $image['name'];
        move_uploaded_file($image['tmp_name'], $imagePath);

        if (!empty($student['image']) && file_exists('uploads/' . $student['image'])) {
            unlink('uploads/' . $student['image']);
        }
    } else {
        $imagePath = $student['image']; 
    }

    // update
    $stmt = $conn->prepare("UPDATE student SET name = ?, email = ?, address = ?, class_id = ?, image = ? WHERE id = ?");
    $stmt->bind_param("sssisi", $name, $email, $address, $class_id, $imagePath, $student_id);
    $stmt->execute();

    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>

<style>
  html 
{
  font-family: "Trebuchet MS";
}

a {
background-color: #663635; 
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

body {
  background: #F2F3EB;
}


form {
  padding: 37.5px;
  margin: 50px 0;
  border:1px solid black;
  width:30%;
}

h1 {
  color: black;
  font-size: 32px;
  font-weight: 700;
  letter-spacing: 7px;
  text-align: center;
  text-transform: uppercase;
}



input, select {
  padding: 12px 20px;
  margin: 8px 0;
  display: inline-block;
  border: 1px solid grey;
  border-radius: 4px;
  box-sizing: border-box;
}

button {
  background-color: #663635;
  color: white;
  padding: 14px 20px;
  margin: 8px 0;
  border: none;
  border-radius: 4px;
  cursor: pointer;
}

</style>
    <title>Edit Student</title>
</head>
<body>
    
    <a href="index.php">Back to Home</a>
    <hr style= "background:black; height:3px; width:100%;">
    <h2>Edit Student</h2>
    <form method="POST" enctype="multipart/form-data">
        <input type="text" name="name" value="<?= htmlspecialchars($student['name']) ?>" required>
        <input type="email" name="email" value="<?= htmlspecialchars($student['email']) ?>" required>
        <input type="text" name="address" value="<?= htmlspecialchars($student['address']) ?>" required>
        <select name="class_id">
            <?php while ($row = $classes->fetch_assoc()): ?>
            <option value="<?= $row['class_id'] ?>" <?= $row['class_id'] == $student['class_id'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['name']) ?>
            </option>
            <?php endwhile; ?>
        </select>
        <input type="file" name="image" accept="image/png, image/jpeg">
        <button type="submit">Save</button>
    </form>
</body>
</html>
