<?php
include 'db.php';

// Get student ID from URL
$student_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch student details
$query = "SELECT student.*, classes.name AS class_name 
          FROM student 
          LEFT JOIN classes ON student.class_id = classes.class_id 
          WHERE student.id = $student_id";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $student = $result->fetch_assoc();
} else {
    die("Student not found.");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Details</title>
    <style>
        html {
        font-family:"Trebuchet MS";
    }
        body {
            background: #F2F3EB;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 15px;
            background: #fff;
            border-radius: 10px;
        }
        .card {
            display: flex;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 10px;
            overflow: hidden;
        }
        .card img {
            width: 300px;
            height: 100%;
            object-fit: cover;
        }
        .viewcard {
            padding: 20px;
            flex: 1;
        }
        .viewcard h2 {
            margin-top: 0;
            font-size: 1.5rem;
            color: black;
        }
        .viewcard p {
            margin: 5px 0;
            color: black;
        }

        h1 {
  color: black;
  font-size: 32px;
  font-weight: 700;
  letter-spacing: 7px;
  text-align: center;
  text-transform: uppercase;
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

 
    </style>
</head>
<body>
<h1>Student Profile</h1>
<a href="index.php">Back to Home</a>
<hr style= "background:black; height:3px; width:100%;">
    <div class="container">
        <div class="card">
        
            <div>
                <?php if (!empty($student['image']) && file_exists("uploads/" . $student['image'])): ?>
                    <img src="<?= ($student['image']) ?>" alt="Student Image">
                <?php else: ?>
                    <img src="<?= ($student['image']) ?>" alt="No Image">
                <?php endif; ?>
            </div>
            <!-- Student Details -->
            <div class="viewcard">
                <h2>
                    <?= ($student['name']) ?>   
                </h2>
                <p><strong>Email:</strong> <?= ($student['email']) ?></p><br>
                <p><strong>Address:</strong> <?= ($student['address']) ?></p><br>
                <p><strong>Class:</strong> <?= ($student['class_name'] ?? 'No Class') ?></p><br>
                <p><strong>Created At:</strong> <?= ($student['created_at']) ?></p>
            </div>
        </div>
</body>
</html>
