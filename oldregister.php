<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./style/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.12.1/css/all.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" charset="utf-8"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <title>Sign In | Evaluation System</title>
    <link rel="icon" type="image/png" href="/images/systems-plus-computer-college-logo.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .navigation-buttons {
            display: flex;
            justify-content: space-between;
        }

        .prev,
        .next {
            padding: 10px 20px;
            background-color: #007bff;
            border: none;
            color: white;
            cursor: pointer;
        }

        .prev[disabled],
        .next[disabled] {
            background-color: #cccccc;
            cursor: not-allowed;
        }

        .back {
            appearance: button;
            backface-visibility: hidden;
            background-color: red;
            border-radius: 6px;
            border-width: 0;
            box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset, rgba(50, 50, 93, .1) 0 2px 5px 0, rgba(0, 0, 0, .07) 0 1px 1px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            font-family: -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", Ubuntu, sans-serif;
            font-size: 100%;
            height: 44px;
            line-height: 1.15;
            margin: 12px 0 0;
            outline: none;
            overflow: hidden;
            padding: 0 25px;
            position: relative;
            text-align: center;
            text-transform: none;
            transform: translateZ(0);
            transition: all .2s, box-shadow .08s ease-in;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            width: 25%;
        }

        .back:disabled {
            cursor: default;
        }

        .back:focus {
            box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset, rgba(50, 50, 93, .2) 0 6px 15px 0, rgba(0, 0, 0, .1) 0 2px 2px 0, rgba(50, 151, 211, .3) 0 0 0 4px;
        }

        .button-9 {
            appearance: button;
            backface-visibility: hidden;
            background-color: #405cf5;
            border-radius: 6px;
            border-width: 0;
            box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset, rgba(50, 50, 93, .1) 0 2px 5px 0, rgba(0, 0, 0, .07) 0 1px 1px 0;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            font-family: -apple-system, system-ui, "Segoe UI", Roboto, "Helvetica Neue", Ubuntu, sans-serif;
            font-size: 100%;
            height: 44px;
            line-height: 1.15;
            margin: 12px 0 0;
            outline: none;
            overflow: hidden;
            padding: 0 25px;
            position: relative;
            text-align: center;
            text-transform: none;
            transform: translateZ(0);
            transition: all .2s, box-shadow .08s ease-in;
            user-select: none;
            -webkit-user-select: none;
            touch-action: manipulation;
            width: 25%;
        }

        .button-9:disabled {
            cursor: default;
        }

        .button-9:focus {
            box-shadow: rgba(50, 50, 93, .1) 0 0 0 1px inset, rgba(50, 50, 93, .2) 0 6px 15px 0, rgba(0, 0, 0, .1) 0 2px 2px 0, rgba(50, 151, 211, .3) 0 0 0 4px;
        }

        .login-items input[type=number],
        .login-items input[name=password],
        .login-items input[name=cpassword],
        .login-items input[name=firstname],
        .login-items input[name=lastname],
        .login-items input[name=email],
        .login-items select[name=gender],
        .login-items select[name=yearlevel],
        .login-items select[name=status],
        .login-items select[name=course],
        .login-items select[name=section] {
            height: 2.7rem;
            font-size: 15px;
            border-style: hidden hidden solid;
            width: 100%;
            margin-bottom: 3px;
            outline: none;
        }

        .login-items input[type=file] {
            height: 2.7rem;
            font-size: 15px;
            border-style: hidden hidden solid;
            width: 100%;
            margin-bottom: 3px;
            outline: none;
        }

        input[type="file"] {
            outline: none;
            padding: 4px;
            margin: -4px;
        }

        input[type="file"]:focus-within::file-selector-button,
        input[type="file"]:focus::file-selector-button {
            outline: 2px solid #0964b0;
            outline-offset: 2px;
        }

        input[type="file"]::before {
            top: 16px;
        }

        input[type="file"]::after {
            top: 14px;
        }

        /* ------- From Step 2 ------- */

        input[type="file"] {
            position: relative;
        }

        input[type="file"]::file-selector-button {
            width: 136px;
            color: transparent;
        }

        /* Faked label styles and icon */
        input[type="file"]::before {
            position: absolute;
            pointer-events: none;
            /*   top: 11px; */
            left: 40px;
            color: #0964b0;
            content: "Upload File";
        }

        input[type="file"]::after {
            position: absolute;
            pointer-events: none;
            /*   top: 10px; */
            left: 16px;
            height: 20px;
            width: 20px;
            content: "";
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%230964B0'%3E%3Cpath d='M18 15v3H6v-3H4v3c0 1.1.9 2 2 2h12c1.1 0 2-.9 2-2v-3h-2zM7 9l1.41 1.41L11 7.83V16h2V7.83l2.59 2.58L17 9l-5-5-5 5z'/%3E%3C/svg%3E");
        }

        /* ------- From Step 1 ------- */

        /* file upload button */
        input[type="file"]::file-selector-button {
            border-radius: 4px;
            padding: 0 16px;
            height: 40px;
            cursor: pointer;
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.16);
            box-shadow: 0px 1px 0px rgba(0, 0, 0, 0.05);
            margin-right: 16px;
            transition: background-color 200ms;
        }

        /* file upload button hover state */
        input[type="file"]::file-selector-button:hover {
            background-color: #f3f4f6;
        }

        /* file upload button active state */
        input[type="file"]::file-selector-button:active {
            background-color: #e5e7eb;
        }
    </style>
</head>

<body>

<?php
@include '../evalsys/assets/connection/connection.php';

if (isset($_POST['Submit-R'])) {
    $uid = mysqli_real_escape_string($conn, $_POST['uid']);
    $pass = $_POST['password'];
    $cpass = $_POST['cpassword'];
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $yearlevel = mysqli_real_escape_string($conn, $_POST['yearlevel']);
    $course_id = mysqli_real_escape_string($conn, $_POST['course']);
    $section_id = mysqli_real_escape_string($conn, $_POST['section']);
    $role = "Student";

    // Check if the user already exists
    $select = "SELECT * FROM login_tbl WHERE uid = '$uid'";
    $result = mysqli_query($conn, $select);

    if (mysqli_num_rows($result) > 0) {
        showErrorAndRedirect('User already exists!');
    } else {
        // Check if the student ID exists and is not registered
        $checkStudentIdQuery = "SELECT * FROM accessid_tbl WHERE student_id = '$uid' AND status = 0";
        $checkStudentIdResult = mysqli_query($conn, $checkStudentIdQuery);

        if (mysqli_num_rows($checkStudentIdResult) == 0) {
            showErrorAndRedirect('Invalid or already registered student ID!');
        } elseif ($pass != $cpass) {
            showErrorAndRedirect('Passwords do not match!');
        } else {
            // Check if the file is uploaded and no errors occurred
            if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
                $target_dir = "../uploads/students/";
                $target_file = $target_dir . basename($_FILES["photo"]["name"]);
                $uploadOk = 1;
                $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

                // Check if image file is a valid image
                $check = getimagesize($_FILES["photo"]["tmp_name"]);
                if ($check !== false) {
                    // File is an image
                    $uploadOk = 1;
                } else {
                    showErrorAndRedirect('File is not an image.');
                }

                // Check file size
                if ($_FILES["photo"]["size"] > 500000) {
                    showErrorAndRedirect('File is too large.');
                }

                // Allow certain file formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                    showErrorAndRedirect('Only JPG, JPEG, PNG & GIF files are allowed.');
                }

                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    showErrorAndRedirect('File was not uploaded.');
                } else {
                    // Attempt to move the uploaded file to the target directory
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                        // File uploaded successfully, proceed with database insertion
                        $photo = $target_file;

                        $sql_student = "INSERT INTO student_tbl (firstname, lastname, email, gender, yearlevel, photo, course_id, section_id, password, student_id) 
                        VALUES ('$firstname', '$lastname', '$email', '$gender', '$yearlevel', '$photo', '$course_id', '$section_id', '$pass', '$uid')";

                        // Attempt insert query execution for login_tbl
                        $sql_login = "INSERT INTO login_tbl (uid, password, role) VALUES ('$uid', '$pass', '$role')";

                        if (mysqli_query($conn, $sql_student) && mysqli_query($conn, $sql_login)) {
                            // Update the status in accessid_tbl
                            $updateStatusQuery = "UPDATE accessid_tbl SET status = 1 WHERE student_id = '$uid'";
                            mysqli_query($conn, $updateStatusQuery);

                            // Display success message using SweetAlert2 and redirect
                            showSuccessAndRedirect('You have successfully registered.');
                        } else {
                            showErrorAndRedirect("ERROR: Could not execute queries. " . mysqli_error($conn));
                        }
                    } else {
                        showErrorAndRedirect('There was an error uploading your file.');
                    }
                }
            } else {
                showErrorAndRedirect('No file uploaded or an error occurred during file upload.');
            }
        }
    }
}

function showErrorAndRedirect($errorMessage)
{
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>";
    echo "Swal.fire({";
    echo "  icon: 'error',";
    echo "  title: 'Registration failed!',";
    echo "  text: '$errorMessage',";
    echo "  position: 'top',";
    echo "  showConfirmButton: false,";
    echo "  timer: 2000";
    echo "}).then(() => {";
    echo "  window.location.href = 'register.php';";
    echo "});";
    echo "</script>";
    exit();
}

function showSuccessAndRedirect($successMessage)
{
    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>";
    echo "<script>";
    echo "Swal.fire({";
    echo "  icon: 'success',";
    echo "  title: 'Registration successful!',";
    echo "  text: '$successMessage',";
    echo "  position: 'top',";
    echo "  showConfirmButton: false,";
    echo "  timer: 2000";
    echo "}).then(() => {";
    echo "  window.location.href = 'index.php';";
    echo "});";
    echo "</script>";
    exit();
}
?>




    <img src="./assets/img/logo.png" style="width: 100px; position: absolute; margin: 20px" class="animate__animated animate__fadeInLeft">

    <form id="registration-form" action="" method="POST" enctype="multipart/form-data">
        <div class="login-container">
            <div class="login-left">
                <p class="login-title animate__animated animate__fadeInLeft" style="color: white;">AISAT <a style="color: blue;">CENTRAL</a> INK DAU </p>
                <p class="login-quote animate__animated animate__fadeInLeft" style="color: white;">Empowering minds through excellence, our institution stands as a global beacon of learning, seamlessly blending service and innovation to shape leaders of tomorrow</p>
            </div>

            <div class="login-right animate__animated animate__fadeIn">
                <div class="login-box">
                    <div class="login-content">
                        <!-- Step 1 -->
                        <div class="step step-1 active animate__animated animate__fadeIn">
                            <div class="login-header">
                                <h2>Step 1: User ID</h2>
                            </div>
                            <div class="login-items">
                                <label for="uid">User ID</label>
                                <input type="number" name="uid" required placeholder="Enter Student Number">
                            </div>
                            <div class="d-flex justify-content-end">
                                <button type="button" class="button-9" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 2 -->
                        <div class="step step-2 animate__animated animate__fadeIn">
                            <div class="login-header">
                                <h2>Step 2: Password</h2>
                            </div>
                            <div class="login-items marg-b">
                                <label for="password">Password</label>
                                <input type="password" name="password" required placeholder="Enter Password">
                            </div>
                            <div class="login-items marg-b">
                                <label for="cpassword">Confirm Password</label>
                                <input type="password" name="cpassword" required placeholder="Confirm Password">
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="back" onclick="prevStep()">Back</button>
                                <button type="button" class="button-9" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 3 -->
                        <div class="step step-3 animate__animated animate__fadeIn">
                            <div class="login-header">
                                <h2>Step 3: Basic Information</h2>
                            </div>
                            <div class="login-items marg-b">
                                <label for="firstname">First Name</label>
                                <input type="text" name="firstname" required placeholder="Enter First Name">
                            </div>
                            <div class="login-items marg-b">
                                <label for="lastname">Last Name</label>
                                <input type="text" name="lastname" required placeholder="Enter Last Name">
                            </div>
                            <div class="login-items marg-b">
                                <label for="email">Email</label>
                                <input type="email" name="email" required placeholder="Enter Email">
                            </div>
                            <div class="login-items marg-b">
                                <label for="gender">Gender</label>
                                <select name="gender" required>
                                    <option value="">Choose...</option>
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="back" onclick="prevStep()">Back</button>
                                <button type="button" class="button-9" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 4 -->
                        <div class="step step-4 animate__animated animate__fadeIn">
                            <div class="login-header">
                                <h2>Step 4: Academic Information</h2>
                            </div>
                            <div class="login-items marg-b">
                                <label for="yearlevel">Year Level</label>
                                <select name="yearlevel" required>
                                    <option value="">Select Year Level</option>
                                    <?php
                                    include '../assets/connection/connection.php';
                                    $query = "SELECT * FROM yearlevel_tbl";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . htmlspecialchars($row['yearlevel']) . '">' . htmlspecialchars($row['yearlevel']) . '</option>';
                                    }
                                    mysqli_free_result($result);
                                    ?>
                                </select>
                            </div>
                            <div class="login-items marg-b">
                                <label for="course">Course</label>
                                <select name="course" required>
                                    <option value="">Select Course</option>
                                    <?php
                                    $query = "SELECT * FROM course_tbl";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['course_id'] . '">' . $row['discription'] . '</option>';
                                    }
                                    mysqli_free_result($result);
                                    ?>
                                </select>
                            </div>
                            <div class="login-items marg-b">
                                <label for="section">Section</label>
                                <select name="section" required>
                                    <option value="">Select Section</option>
                                    <?php
                                    $query = "SELECT * FROM section_tbl";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        echo '<option value="' . $row['section_id'] . '">' . $row['section_name'] . '</option>';
                                    }
                                    mysqli_free_result($result);
                                    mysqli_close($conn);
                                    ?>
                                </select>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="back" onclick="prevStep()">Back</button>
                                <button type="button" class="button-9" onclick="nextStep()">Next</button>
                            </div>
                        </div>

                        <!-- Step 5 -->
                        <div class="step step-5 animate__animated animate__fadeIn">
                            <div class="login-header">
                                <h2>Step 5: Upload Photo</h2>
                            </div>
                            <div class="login-items marg-b">
                                <label for="photo" style="margin-bottom: 10px;">Photo</label>
                                <input type="file" id="photo" name="photo" accept="image/*" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button type="button" class="back" onclick="prevStep()">Back</button>
                                <input class="add-main btn btn-primary button-9" id="add-button" type="submit" name="Submit-R" value="Register">
                            </div>
                        </div>

                        <p>Already have an account? <a href="./index.php">Login now</a></p>
                    </div>
                </div>
            </div>
        </div>
    </form>


    <script>
        // Form validation

        const inputs = form.querySelectorAll('input, select');

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            let isValid = true;

            // Validate each input field
            inputs.forEach((input) => {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    isValid = false;
                }
            });

            // Validate file upload
            const fileInput = document.getElementById('photo');
            if (fileInput.files.length === 0) {
                alert('Please select a file to upload.');
                isValid = false;
            } else {
                const file = fileInput.files[0];
                const fileSize = file.size;
                const fileType = file.type;

                if (fileSize > 500000) {
                    alert('File is too large. Maximum file size is 500KB.');
                    isValid = false;
                }

                if (!['image/jpeg', 'image/png', 'image/gif'].includes(fileType)) {
                    alert('Only JPG, JPEG, PNG & GIF files are allowed.');
                    isValid = false;
                }
            }

            if (isValid) {
                // Form is valid, submit it
                form.submit();
            }
        });
    </script>
    <script>
        let currentStep = 0;

        function showStep(step) {
            const steps = document.querySelectorAll('.step');
            steps.forEach((stepElement, index) => {
                stepElement.classList.remove('active');
                if (index === step) {
                    stepElement.classList.add('active');
                }
            });
        }

        function nextStep() {
            const currentForm = document.querySelectorAll('.step')[currentStep];
            if (validateStep(currentForm)) {
                currentStep++;
                showStep(currentStep);
            }
        }

        function prevStep() {
            currentStep--;
            showStep(currentStep);
        }

        function validateStep(form) {
            const inputs = form.querySelectorAll('input, select');
            for (let input of inputs) {
                if (!input.checkValidity()) {
                    input.reportValidity();
                    return false;
                }
            }
            return true;
        }

        document.addEventListener('DOMContentLoaded', () => {
            showStep(currentStep);
        });
    </script>
</body>

</html>