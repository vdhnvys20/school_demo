<?php
include 'db.php';

$query = "SELECT student.*, classes.name AS class_name FROM student 
          LEFT JOIN classes ON student.class_id = classes.class_id";
$result = $conn->query($query);
?>
<!DOCTYPE html>
<html lang="en">
    <title>Student List</title>
<head>

<style>
   
body {
  background: #F2F3EB;
}   
    
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

h1 {
  color: black;
  font-size: 32px;
  font-weight: 700;
  letter-spacing: 7px;
  text-align: center;
  text-transform: uppercase;
}

        </style>
    
</head>
<body>
<h1>List of the students</h1>


<a href="create.php">Add student</a>
<a href="classes.php">Manage classes</a>
<hr style= "background:black; height:3px; width:100%;">
<br>


<table id ="list">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Class</th>
        <th>Created at</th>
        <th>Image</th>
        <th>Manage list</th>
    </tr>
    <?php while($row = $result->fetch_assoc()): ?>
    <tr>
        <td><?= ($row['name']) ?></td>
        <td><?= ($row['email']) ?></td>
        <td><?= ($row['class_name']) ?></td>
        <td><?= ($row['created_at']) ?></td>
        <td><img src="<?= ($row['image']) ?>" width="80" height="80" alt="Image"></td>
        <td>
            <a href="view.php?id=<?= $row['id'] ?>">View</a>
            <a href="edit.php?id=<?= $row['id'] ?>">Edit</a>
            <a href="delete.php?id=<?= $row['id'] ?>" onclick="return confirm('Deleted successfully')">Delete</a>
        </td>
    </tr>
    <?php endwhile; ?>
</table>
</body>
</html>
