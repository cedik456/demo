<?php
// dashboard_students.php
session_start();
// Database connection

$conn = new mysqli("localhost", "root", "", "school_db");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_SESSION['reg_id'])) {
    // Prepare and execute statement to fetch user data
    $stmt = $conn->prepare("SELECT * FROM Users WHERE reg_id = ?");
    if (!$stmt) {
        die("Statement preparation failed: " . $conn->error);
    }
    $stmt->bind_param("i", $_SESSION['reg_id']);
    if (!$stmt->execute()) {
        die("Statement execution failed: " . $stmt->error);
    }
    $users = $stmt->get_result()->fetch_assoc();
    $stmt->close();
} else {
    die("Session 'reg_id' is not set.");
}
$sql = "SELECT * FROM Students";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Students</title>
    <link rel="stylesheet" href="../css/dashboard.css">
</head>
<body>
        <div class="hero">
         <nav>
            <div class="logo-wrapper">
                <a href="#"><img src="../assets/dwcl-logo.png" alt="" class="logo"></a>
            </div>
            <ul>
                <li><a href="../users/dashboard.php">Dashboard</a></li>
                <li><a href="./dashboard_students.php">Add Students</a></li>
            </ul>
            <img src="../assets/blank-profile-picture-973460_960_720.webp" class="user-pic" onclick="toggleMenu()">

            <div class="sub-menu-wrap" id="subMenu">
                <div class="sub-menu">
                    <div class="user-info">
                        <img src="../assets/blank-profile-picture-973460_960_720.webp" alt="" class="blank-profile">
                        <h3 id="full-name"
                            data-first-name="<?php echo htmlspecialchars($users['first_name'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-middle-name="<?php echo htmlspecialchars($users['mid_name'], ENT_QUOTES, 'UTF-8'); ?>"
                            data-last-name="<?php echo htmlspecialchars($users['last_name'], ENT_QUOTES, 'UTF-8'); ?>">
                        </h3>
                    </div>
                    <hr>
                    <a href="#" class="sub-menu-link">
                        <img src="../assets/profile.png" alt="">
                        <p>Edit profile</p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-link">
                        <img src="../assets/setting.png" alt="">
                        <p>Settings & Privacy</p>
                        <span>></span>
                    </a>
                    <a href="#" class="sub-menu-link">
                        <img src="../assets/help.png" alt="">
                        <p>Help & Support</p>
                        <span>></span>
                    </a>
                    <a href="../users/logout.php" class="sub-menu-link">
                        <img src="../assets/logout.png" alt="">
                        <p>Logout</p>
                        <span>></span>
                    </a>
                </div>
            </div>
        </nav>

        <div class="container">

         <button type="button" class="btn btn-primary" onclick="openModal()">Add Student</button>

              <table class="custom-table">
                <thead>
                    <tr>
                        <th>Student ID</th>
                        <th>Name</th>
                        <th>School ID</th>
                        <th>Birthday</th>
                        <th>Age</th>
                        <th>Course</th>
                        <th>Year Level</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr>
                                    <td>{$row['student_id']}</td>
                                    <td>{$row['name']}</td>
                                    <td>{$row['school_id']}</td>
                                    <td>{$row['bday']}</td>
                                    <td>{$row['age']}</td>
                                    <td>{$row['course']}</td>
                                    <td>{$row['year_level']}</td>
                                   <td>
                                    <button type='button' class='btn btn-secondary' onclick='openEditModal( 
                                        {$row['student_id']}, 
                                        \"{$row['name']}\", 
                                        \"{$row['school_id']}\", 
                                        \"{$row['bday']}\", 
                                        {$row['age']}, 
                                        \"{$row['course']}\", 
                                        {$row['year_level']}
                                    )'>Edit</button>
                                    <a href='delete_students.php?id={$row['student_id']}' class='btn delete-link'>Delete</a>
                                </td>
                                </tr>";
                        }
                    } else {
                        echo "<tr><td colspan='8'>No results</td></tr>";
                    }
                    ?>

                    
                </tbody>
            </table>

            <!-- Add Student Modal -->
            <div id="addStudentModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3>Add Student</h3>
                    <form id="addStudentForm" method="POST" action="add_students.php">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="school_id">School ID</label>
                            <input type="text" id="school_id" name="school_id" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="bday">Birthday</label>
                            <input type="date" id="bday" name="bday" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="age">Age</label>
                            <input type="number" id="age" name="age" autocomplete="off" required>
                        </div>
                        <div class="form-group">
                            <label for="course">Course</label>
                            <input type="text" id="course" name="course" required>
                        </div>
                        <div class="form-group">
                            <label for="year_level">Year Level</label>
                            <input type="number" id="year_level" name="year_level" autocomplete="off" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Student</button>
                    </form>
                </div>
            </div>

            <!-- Edit Student Modal -->
            <div id="editStudentModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeEditModal()">&times;</span>
                    <h3>Edit Student</h3>
                    <form id="editStudentForm" method="POST" action="edit_students.php">
                        <input type="hidden" id="editStudentId" name="student_id"> <!-- Hidden field to store student ID -->
                        <div class="form-group">
                            <label for="editName">Name</label>
                            <input type="text" id="editName" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="editSchoolId">School ID</label>
                            <input type="text" id="editSchoolId" name="school_id" required>
                        </div>
                        <div class="form-group">
                            <label for="editBday">Birthday</label>
                            <input type="date" id="editBday" name="bday" required>
                        </div>
                        <div class="form-group">
                            <label for="editAge">Age</label>
                            <input type="number" id="editAge" name="age" required>
                        </div>
                        <div class="form-group">
                            <label for="editCourse">Course</label>
                            <input type="text" id="editCourse" name="course" required>
                        </div>
                        <div class="form-group">
                            <label for="editYearLevel">Year Level</label>
                            <input type="number" id="editYearLevel" name="year_level" required>
                        </div>
                        <button type="submit" class="btn btn-secondary">Update Student</button>
                    </form>
                </div>
            </div>

    </div>
    <script src="../js/openModals.js"></script>
    <script src="../js/toggleMenu.js"></script>
    <script src="../js/modals.js"></script>
    <script src="../js/formatFullName.js"></script>
</body>
</html>
