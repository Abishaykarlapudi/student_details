<?php
session_start();
include("database.php");

header("Localtion: login.php");
// Check if user is logged in as admin
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header('Location: login.php');
    exit;
}

// Handle delete request
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $delete_sql = "DELETE FROM details WHERE id = $delete_id";
    mysqli_query($conn, $delete_sql);
    header("Location: admin.php");
    exit;
}

// Handle update request
if (isset($_POST['update'])) {
    $id = $_POST['id'];
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $pnumber = mysqli_real_escape_string($conn, $_POST['pnumber']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $fathername = mysqli_real_escape_string($conn, $_POST['father_name']);
    $mothername = mysqli_real_escape_string($conn, $_POST['mother_name']);

    $update_sql = "UPDATE details SET 
        first_name='$fname', 
        middle_name='$mname', 
        last_name='$lname', 
        pnumber='$pnumber', 
        email='$email', 
        gender='$gender', 
        dob='$dob', 
        fname='$fathername', 
        mname='$mothername' 
        WHERE id=$id";
    mysqli_query($conn, $update_sql);
    header("Location: admin.php");
    exit;
}

// Handle search request
$search_query = "";
$sql = "SELECT * FROM details";
if (isset($_POST['search'])) {
    $search_query = mysqli_real_escape_string($conn, $_POST['search_query']);
    $sql = "SELECT * FROM details WHERE first_name LIKE '%$search_query%' OR last_name LIKE '%$search_query%' OR email LIKE '%$search_query%'";
}
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Student Records</title>
    <link rel="stylesheet" href="styles.css">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1>Student Management System</h1>
            <nav>
                <ul>
                    <li><a href="admin.php" class="active">Student Records</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <div class="admin-dashboard">
            <h2>Student Records</h2>
            <p>Manage all student records in the system</p>
            
            <!-- Search Form -->
            <form method="POST" class="search-form">
                <div class="search-container">
                    <input type="text" name="search_query" placeholder="Search by name or email" value="<?php echo $search_query; ?>">
                    <button type="submit" name="search">Search</button>
                </div>
            </form>
            
            <div class="table-container">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Middle Name</th>
                            <th>Last Name</th>
                            <th>Phone Number</th>
                            <th>Email</th>
                            <th>Gender</th>
                            <th>DOB</th>
                            <th>Father Name</th>
                            <th>Mother Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (mysqli_num_rows($result) > 0) {
                            while ($row = mysqli_fetch_assoc($result)) {
                                echo "<tr>
                                    <td>{$row['id']}</td>
                                    <td>{$row['first_name']}</td>
                                    <td>{$row['middle_name']}</td>
                                    <td>{$row['last_name']}</td>
                                    <td>{$row['pnumber']}</td>
                                    <td>{$row['email']}</td>
                                    <td>{$row['gender']}</td>
                                    <td>{$row['dob']}</td>
                                    <td>{$row['fname']}</td>
                                    <td>{$row['mname']}</td>
                                    <td class='actions'>
                                        <button class='btn btn-edit' onclick='showEditForm({$row['id']}, \"{$row['first_name']}\", \"{$row['middle_name']}\", \"{$row['last_name']}\", \"{$row['pnumber']}\", \"{$row['email']}\", \"{$row['gender']}\", \"{$row['dob']}\", \"{$row['fname']}\", \"{$row['mname']}\")'>Edit</button>
                                        <a href='admin.php?delete_id={$row['id']}' class='btn btn-delete' onclick='return confirm(\"Are you sure you want to delete this record?\")'>Delete</a>
                                    </td>
                                </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='11' class='no-records'>No records found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System. All rights reserved.</p>
        </div>
    </footer>

    <!-- Edit Form Modal -->
    <div id="overlay" class="overlay" onclick="closeEditForm()"></div>
    <div id="edit-form-modal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Edit Student Details</h3>
                <span class="close-btn" onclick="closeEditForm()">&times;</span>
            </div>
            <div class="modal-body">
                <form method="POST" id="edit-form">
                    <input type="hidden" name="id" id="edit-id">
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-fname">First Name</label>
                            <input type="text" name="fname" id="edit-fname" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-mname">Middle Name</label>
                            <input type="text" name="mname" id="edit-mname">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-lname">Last Name</label>
                            <input type="text" name="lname" id="edit-lname" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-pnumber">Phone Number</label>
                            <input type="text" name="pnumber" id="edit-pnumber" required>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-email">Email</label>
                            <input type="email" name="email" id="edit-email" required>
                        </div>
                        <div class="form-group">
                            <label>Gender</label>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="gender" value="Male" id="edit-gender-male"> Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="Female" id="edit-gender-female"> Female
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="Others" id="edit-gender-others"> Others
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-dob">Date of Birth</label>
                            <input type="date" name="dob" id="edit-dob">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="edit-father-name">Father's Name</label>
                            <input type="text" name="father_name" id="edit-father-name" required>
                        </div>
                        <div class="form-group">
                            <label for="edit-mother-name">Mother's Name</label>
                            <input type="text" name="mother_name" id="edit-mother-name" required>
                        </div>
                    </div>
                    
                    <div class="form-actions">
                        <button type="button" class="btn btn-secondary" onclick="closeEditForm()">Cancel</button>
                        <button type="submit" name="update" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showEditForm(id, fname, mname, lname, pnumber, email, gender, dob, fathername, mothername) {
            document.getElementById("edit-id").value = id;
            document.getElementById("edit-fname").value = fname;
            document.getElementById("edit-mname").value = mname;
            document.getElementById("edit-lname").value = lname;
            document.getElementById("edit-pnumber").value = pnumber;
            document.getElementById("edit-email").value = email;
            
            // Set gender radio button
            if (gender === "Male") {
                document.getElementById("edit-gender-male").checked = true;
            } else if (gender === "Female") {
                document.getElementById("edit-gender-female").checked = true;
            } else {
                document.getElementById("edit-gender-others").checked = true;
            }
            
            document.getElementById("edit-dob").value = dob;
            document.getElementById("edit-father-name").value = fathername;
            document.getElementById("edit-mother-name").value = mothername;

            document.getElementById("overlay").style.display = "block";
            document.getElementById("edit-form-modal").style.display = "block";
        }

        function closeEditForm() {
            document.getElementById("overlay").style.display = "none";
            document.getElementById("edit-form-modal").style.display = "none";
        }
    </script>
</body>
</html>