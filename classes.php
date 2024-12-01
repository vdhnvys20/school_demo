<?php
include 'db.php';

// Add
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_class'])) {
    $class_name = $_POST['name'];
    if (!empty($class_name)) {
        $stmt = $conn->prepare("INSERT INTO classes (name) VALUES (?)");
        $stmt->bind_param("s", $class_name);
        $stmt->execute();
        header("Location: classes.php");
        exit();
    }
}

//Edit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_class'])) {
    $class_id = $_POST['class_id'];
    $class_name = $_POST['name'];
    if (!empty($class_name)) {
        $stmt = $conn->prepare("UPDATE classes SET name = ? WHERE class_id = ?");
        $stmt->bind_param("si", $class_name, $class_id);
        $stmt->execute();
        header("Location: classes.php");
        exit();
    }
}

//Delete
if (isset($_GET['delete_class'])) {
    $class_id = intval($_GET['delete_class']);
    $stmt = $conn->prepare("DELETE FROM classes WHERE class_id = ?");
    $stmt->bind_param("i", $class_id);
    $stmt->execute();
    header("Location: classes.php");
    exit();
}

//Fetch
$classes = $conn->query("SELECT * FROM classes");
?>
<!DOCTYPE html>
<html lang="en">
<head>

<style>

html {
        font-family:"Trebuchet MS";
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

        button {
            background-color: #663635; 
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 16px;
}

        #list {
  font-family: "Trebuchet MS";
  border-collapse: collapse;
  white-space: nowrap;
}

#list td, #list th {
  border: 1px solid #ddd;
  padding: 8px;
}

#list tr:nth-child(even){background-color: #f2f2f2;}

#list tr:hover {background-color: #ddd;}

#list th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: center;
  background-color: #091235;
  color: white;
}

tml 
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

    <title>Manage Classes</title>
</head>
<body>
    <h1>Manage Classes</h1>
    <a href="index.php">Back to Home</a>
    <hr style= "background:black; height:3px; width:100%;">
    <h2>Add Class</h2>
    <form method="POST">
        <input type="text" name="name" placeholder="Class Name" required>
        <button type="submit" name="add_class">Add</button>
    </form>

    <h2>Edit list</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = $classes->fetch_assoc()): ?>
        <tr>
            <td><?= $row['class_id'] ?></td>
            <td><?= ($row['name']) ?></td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="class_id" value="<?= $row['class_id'] ?>">
                    <input type="text" name="name" value="<?= ($row['name']) ?>" required>
                    <button type="submit" name="edit_class">Save</button>
                </form>
                <a href="classes.php?delete_class=<?= $row['class_id'] ?>" onclick="return confirm('Class deleted')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
