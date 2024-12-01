<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $address = $_POST['address'];
    $class_id = $_POST['class_id'];
    $image = $_FILES['image'];

    if (!empty($name) && in_array(pathinfo($image['name'], PATHINFO_EXTENSION), ['jpg', 'png'])) {
        $imagePath = 'uploads/' . uniqid() . '_' . $image['name'];
        move_uploaded_file($image['tmp_name'], $imagePath);

        $stmt = $conn->prepare("INSERT INTO student (name, email, address, class_id, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssds", $name, $email, $address, $class_id, $imagePath);
        $stmt->execute();

        header("Location: index.php");
        exit();
    }
}

$classes = $conn->query("SELECT * FROM classes");
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
</head>
<body>
<h1>Add Student</h1>
<a href="index.php">Back to Home</a>
<hr style= "background:black; height:3px; width:100%;">
<form method="POST" enctype="multipart/form-data">
    <input type="text" name="name" placeholder="Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="text" name="address" placeholder="Address" required><br>
    <select name="class_id" required>
    <option value="">Select class</option>
        <?php while($row = $classes->fetch_assoc()): ?>  
        <option value="<?= $row['class_id'] ?>"><?= ($row['name']) ?></option>
        <?php endwhile; ?>
    </select><br>
    <input type="file" id="imgup" name="image" accept="image/png, image/jpeg" required>
    <br><button type="submit">Add</button>
</form>
</body>
</html>
