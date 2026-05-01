<?php
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include the database connection file
    include '../assets/connection/connection.php';
    
    // Escape user inputs for security
    $firstname = mysqli_real_escape_string($conn, $_POST['firstname']);
    $lastname = mysqli_real_escape_string($conn, $_POST['lastname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $yearlevel = mysqli_real_escape_string($conn, $_POST['yearlevel']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    $course_id = mysqli_real_escape_string($conn, $_POST['course']);
    $section_id = mysqli_real_escape_string($conn, $_POST['section']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $student_id = mysqli_real_escape_string($conn, $_POST['uid']);
    $role = "Student";

    // Check if the student_id already exists
    $check_query = "SELECT * FROM student_tbl WHERE student_id = '$student_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error_message'] = "ERROR: Student ID already exists. Please choose a different student ID.";
        header("Location: ../start/adminstudents.php");
        exit();
    }

    // Check if passwords match
    if ($password != $cpassword) {
        $_SESSION['error_message'] = "ERROR: Passwords do not match.";
        header("Location: ../start/adminstudents.php");
        exit();
    }

    // Check if the file is uploaded and no errors occurred
    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
        // Directory where you want to store uploaded files
        $target_dir = "../uploads/students/";

        // Ensure the directory exists
        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true); // Create directory recursively
        }

        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if image file is a valid image
        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            // File is an image
            $uploadOk = 1;
        } else {
            $_SESSION['error_message'] = "ERROR: File is not an image.";
            $uploadOk = 0;
        }

        // Check file size
        if ($_FILES["photo"]["size"] > 500000) {
            $_SESSION['error_message'] = "ERROR: File is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['error_message'] = "ERROR: Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 0) {
            $_SESSION['error_message'] = "ERROR: File was not uploaded.";
        } else {
            // Attempt to move the uploaded file to the target directory
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                // File uploaded successfully, proceed with database insertion
                $photo = $target_file;

                // Attempt insert query execution for student_tbl
                $sql_student = "INSERT INTO student_tbl (firstname, lastname, email, gender, yearlevel, status, photo, course_id, section_id, password, student_id) 
                        VALUES ('$firstname', '$lastname', '$email', '$gender', '$yearlevel', '$status', '$photo', '$course_id', '$section_id', '$password', '$student_id')";

                // Attempt insert query execution for login_tbl
                $sql_login = "INSERT INTO login_tbl (uid, password, role) VALUES ('$student_id', '$password', '$role')";

                // Execute both queries
                if (mysqli_query($conn, $sql_student) && mysqli_query($conn, $sql_login)) {
                    $_SESSION['success_message'] = "Records added successfully.";
                } else {
                    $_SESSION['error_message'] = "ERROR: Could not able to execute queries. " . mysqli_error($conn);
                }
            } else {
                $_SESSION['error_message'] = "ERROR: There was an error uploading your file.";
            }
        }
    } else {
        $_SESSION['error_message'] = "ERROR: No file uploaded or an error occurred during file upload.";
    }

    // Close connection
    mysqli_close($conn);

    // Redirect back to the students admin page
    header("Location: ../start/adminstudents.php");
    exit();
} else {
    $_SESSION['error_message'] = "ERROR: Form submission method not allowed.";
    // Redirect back to the students admin page
    header("Location: ../start/adminstudents.php");
    exit();
}
?>
