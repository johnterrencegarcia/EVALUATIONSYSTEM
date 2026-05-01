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
                $target_dir = "./uploads/students/";
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
                        VALUES ('$firstname', '$lastname', '$email', '$gender', '$yearlevel', '$status', '$photo', '$course_id', '$section_id', '$pass', '$uid')";

                        // Attempt insert query execution for login_tbl
                        $sql_login = "INSERT INTO login_tbl (uid, password, role) VALUES ('$uid', '$pass', '$role')";

                        // Display success message using SweetAlert2 and redirect
                        if (mysqli_query($conn, $sql_student) && mysqli_query($conn, $sql_login)) {
                            showSuccessAndRedirect('Records added successfully.');
                        } else {
                            showErrorAndRedirect("ERROR: Could not able to execute queries. " . mysqli_error($conn));
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
    echo "  timer: 1500";
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
    echo "  timer: 1500";
    echo "}).then(() => {";
    echo "  window.location.href = 'index.php';";
    echo "});";
    echo "</script>";
    exit();
}
?>