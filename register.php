<?php
session_start();
include("database.php");

// Check if user is logged in
if (!isset($_SESSION['user_role'])) {
    header('Location: login.php');
    exit;
}

$success_message = '';
$error_message = '';

if (isset($_POST["save"])) {
    // Collect form data safely with validation
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $mname = mysqli_real_escape_string($conn, $_POST['mname'] ?? '');
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $s_p_number = mysqli_real_escape_string($conn, $_POST['spnumber']);
    $sanumber = mysqli_real_escape_string($conn, $_POST['sanumber'] ?? '');
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender'] ?? '');
    $dob = mysqli_real_escape_string($conn, $_POST['dob'] ?? '');
    $fathername = mysqli_real_escape_string($conn, $_POST['father_name']);
    $foccupation = mysqli_real_escape_string($conn, $_POST['foccupation'] ?? '');
    $fsalary = mysqli_real_escape_string($conn, $_POST['fsalary'] ?? '');
    $fnumber = mysqli_real_escape_string($conn, $_POST['fphone']);
    $mothername = mysqli_real_escape_string($conn, $_POST['mother_name']);
    $moccupation = mysqli_real_escape_string($conn, $_POST['moccupation'] ?? '');
    $msalary = mysqli_real_escape_string($conn, $_POST['msalary'] ?? '');
    $mnumber = mysqli_real_escape_string($conn, $_POST['mphone']);
    
    // Address fields
    $doorNo = mysqli_real_escape_string($conn, $_POST['dorno'] ?? '');
    $street = mysqli_real_escape_string($conn, $_POST['street'] ?? '');
    $mandal = mysqli_real_escape_string($conn, $_POST['mandal'] ?? '');
    $district = mysqli_real_escape_string($conn, $_POST['district'] ?? '');
    $state = mysqli_real_escape_string($conn, $_POST['state'] ?? '');
    $pincode = mysqli_real_escape_string($conn, $_POST['pincode'] ?? '');
    
    // Education fields
    $schoolName = mysqli_real_escape_string($conn, $_POST['school_name'] ?? '');
    $schoolPercentage = mysqli_real_escape_string($conn, $_POST['school_percentage'] ?? '');
    $collegeName = mysqli_real_escape_string($conn, $_POST['college_name'] ?? '');
    $collegePercentage = mysqli_real_escape_string($conn, $_POST['college_percentage'] ?? '');
    $diplomaName = mysqli_real_escape_string($conn, $_POST['diploma_name'] ?? '');
    $diplomaPercentage = mysqli_real_escape_string($conn, $_POST['diploma_percentage'] ?? '');

    // Basic validation
    if (empty($fname) || empty($lname) || empty($s_p_number) || empty($email) || empty($gender) || 
        empty($fathername) || empty($fnumber) || empty($mothername) || empty($mnumber)) {
        $error_message = "Please fill in all required fields.";
    } else {
        $sql = "INSERT INTO details (
                first_name, middle_name, last_name, pnumber, alt_number, email, gender, dob, 
                fname, foccupation, fsalary, fnumber, mname, moccupation, msalary, mnumber,
                door_no, street, mandal, district, state, pincode,
                school_name, school_percentage, college_name, college_percentage, diploma_name, diploma_percentage
            ) VALUES (
                '$fname', '$mname', '$lname', '$s_p_number', '$sanumber', '$email', '$gender', '$dob', 
                '$fathername', '$foccupation', '$fsalary', '$fnumber', '$mothername', '$moccupation', '$msalary', '$mnumber',
                '$doorNo', '$street', '$mandal', '$district', '$state', '$pincode',
                '$schoolName', '$schoolPercentage', '$collegeName', '$collegePercentage', '$diplomaName', '$diplomaPercentage'
            )";
        
        try {
            if (mysqli_query($conn, $sql)) {
                $success_message = "Student registered successfully!";
                // Clear form data on success
                $_POST = array();
            } else {
                $error_message = "Error: " . mysqli_error($conn);
            }
        } catch (Exception $e) {
            $error_message = "Registration failed: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Registration</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header class="main-header">
        <div class="container">
            <h1>Student Management System</h1>
            <nav>
                <ul>
                    <li><a href="register.php" class="active">Registration</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main class="container">
        <?php if (!empty($success_message)): ?>
            <div class="alert alert-success">
                <?php echo $success_message; ?>
            </div>
        <?php endif; ?>
        
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-error">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        
        <div class="registration-form">
            <h2>STUDENT DETAILS</h2>
            <form action="" method="post">
                <!-- Student Details Section -->
                <section class="form-section">
                    <h3>Student Details</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="fname">First Name <span class="required">*</span></label>
                            <input type="text" name="fname" id="fname" required value="<?php echo $_POST['fname'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="mname">Middle Name</label>
                            <input type="text" name="mname" id="mname" value="<?php echo $_POST['mname'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="lname">Last Name <span class="required">*</span></label>
                            <input type="text" name="lname" id="lname" required value="<?php echo $_POST['lname'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="spnumber">Phone Number <span class="required">*</span></label>
                            <input type="text" name="spnumber" id="spnumber" required value="<?php echo $_POST['spnumber'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="sanumber">Alternate Number</label>
                            <input type="text" name="sanumber" id="sanumber" value="<?php echo $_POST['sanumber'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="required">*</span></label>
                            <input type="email" name="email" id="email" required value="<?php echo $_POST['email'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label>Gender <span class="required">*</span></label>
                            <div class="radio-group">
                                <label>
                                    <input type="radio" name="gender" value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'checked' : ''; ?> required> Male
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?> required> Female
                                </label>
                                <label>
                                    <input type="radio" name="gender" value="Others" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Others') ? 'checked' : ''; ?> required> Others
                                </label>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="dob">Date of Birth</label>
                            <input type="date" name="dob" id="dob" value="<?php echo $_POST['dob'] ?? ''; ?>">
                        </div>
                    </div>
                </section>
                
                <!-- Parents Details Section -->
                <section class="form-section">
                    <h3>Parents Details</h3>
                    <div class="form-columns">
                        <div class="form-column">
                            <h4>Father Details</h4>
                            <div class="form-group">
                                <label for="father_name">Father Name <span class="required">*</span></label>
                                <input type="text" name="father_name" id="father_name" required value="<?php echo $_POST['father_name'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="foccupation">Father Occupation</label>
                                <input type="text" name="foccupation" id="foccupation" value="<?php echo $_POST['foccupation'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="fsalary">Salary</label>
                                <input type="text" name="fsalary" id="fsalary" value="<?php echo $_POST['fsalary'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="fphone">Phone Number <span class="required">*</span></label>
                                <input type="text" name="fphone" id="fphone" required value="<?php echo $_POST['fphone'] ?? ''; ?>">
                            </div>
                        </div>
                        
                        <div class="form-column">
                            <h4>Mother Details</h4>
                            <div class="form-group">
                                <label for="mother_name">Mother Name <span class="required">*</span></label>
                                <input type="text" name="mother_name" id="mother_name" required value="<?php echo $_POST['mother_name'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="moccupation">Mother Occupation</label>
                                <input type="text" name="moccupation" id="moccupation" value="<?php echo $_POST['moccupation'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="msalary">Salary</label>
                                <input type="text" name="msalary" id="msalary" value="<?php echo $_POST['msalary'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="mphone">Phone Number <span class="required">*</span></label>
                                <input type="text" name="mphone" id="mphone" required value="<?php echo $_POST['mphone'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </section>
                
                <!-- Address Section -->
                <section class="form-section">
                    <h3>Address</h3>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="dorno">Door No</label>
                            <input type="text" name="dorno" id="dorno" value="<?php echo $_POST['dorno'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="street">Street</label>
                            <input type="text" name="street" id="street" value="<?php echo $_POST['street'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="mandal">Mandal</label>
                            <input type="text" name="mandal" id="mandal" value="<?php echo $_POST['mandal'] ?? ''; ?>">
                        </div>
                    </div>
                    
                    <div class="form-row">
                        <div class="form-group">
                            <label for="district">District</label>
                            <input type="text" name="district" id="district" value="<?php echo $_POST['district'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="state">State</label>
                            <input type="text" name="state" id="state" value="<?php echo $_POST['state'] ?? ''; ?>">
                        </div>
                        <div class="form-group">
                            <label for="pincode">Pincode</label>
                            <input type="text" name="pincode" id="pincode" value="<?php echo $_POST['pincode'] ?? ''; ?>">
                        </div>
                    </div>
                </section>
                
                <!-- Education Details Section -->
                <section class="form-section">
                    <h3>Education Details</h3>
                    
                    <div class="education-section">
                        <h4>10th Class Details</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="school_name">School Name</label>
                                <input type="text" name="school_name" id="school_name" value="<?php echo $_POST['school_name'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="school_percentage">Marks (%)</label>
                                <input type="text" name="school_percentage" id="school_percentage" value="<?php echo $_POST['school_percentage'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="education-section">
                        <h4>Inter Details</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="college_name">College Name</label>
                                <input type="text" name="college_name" id="college_name" value="<?php echo $_POST['college_name'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="college_percentage">Marks (%)</label>
                                <input type="text" name="college_percentage" id="college_percentage" value="<?php echo $_POST['college_percentage'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="education-section">
                        <h4>Diploma Details</h4>
                        <div class="form-row">
                            <div class="form-group">
                                <label for="diploma_name">Diploma College Name</label>
                                <input type="text" name="diploma_name" id="diploma_name" value="<?php echo $_POST['diploma_name'] ?? ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="diploma_percentage">Marks (%)</label>
                                <input type="text" name="diploma_percentage" id="diploma_percentage" value="<?php echo $_POST['diploma_percentage'] ?? ''; ?>">
                            </div>
                        </div>
                    </div>
                </section>
                
                <div class="form-actions">
                    <button type="submit" name="save" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </main>

    <footer class="main-footer">
        <div class="container">
            <p>&copy; <?php echo date('Y'); ?> Student Management System. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>