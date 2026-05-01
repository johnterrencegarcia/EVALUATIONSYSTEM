<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include '../assets/connection/connection.php';
    
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
    $student_id = mysqli_real_escape_string($conn, $_POST['student']);
    $role = "Student";

    $check_query = "SELECT * FROM student_tbl WHERE student_id = '$student_id'";
    $check_result = mysqli_query($conn, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error_message'] = "ERROR: Student ID already exists. Please choose a different student ID.";
        header("Location: ../start/adminstudents.php");
        exit();
    }

    if ($password != $cpassword) {
        $_SESSION['error_message'] = "ERROR: Passwords do not match.";
        header("Location: ../start/adminstudents.php");
        exit();
    }

    if (isset($_FILES["photo"]) && $_FILES["photo"]["error"] == UPLOAD_ERR_OK) {
        $target_dir = "../uploads/students/";

        if (!file_exists($target_dir)) {
            mkdir($target_dir, 0777, true);
        }

        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            $uploadOk = 1;
        } else {
            $_SESSION['error_message'] = "ERROR: File is not an image.";
            $uploadOk = 0;
        }

        if ($_FILES["photo"]["size"] > 500000) {
            $_SESSION['error_message'] = "ERROR: File is too large.";
            $uploadOk = 0;
        }

        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            $_SESSION['error_message'] = "ERROR: Only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            $_SESSION['error_message'] = "ERROR: File was not uploaded.";
        } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                $photo = $target_file;

                $sql_student = "INSERT INTO student_tbl (firstname, lastname, email, gender, yearlevel, status, photo, course_id, section_id, password, student_id) 
                        VALUES ('$firstname', '$lastname', '$email', '$gender', '$yearlevel', '$status', '$photo', '$course_id', '$section_id', '$password', '$student_id')";

                $sql_login = "INSERT INTO login_tbl (uid, password, role) VALUES ('$student_id', '$password', '$role')";

                if (mysqli_query($conn, $sql_student) && mysqli_query($conn, $sql_login)) {
                    $insertAccessIdQuery = "INSERT INTO accessid_tbl (student_id, status, time) VALUES ('$student_id', 1, NOW())";
                    mysqli_query($conn, $insertAccessIdQuery);

                    $_SESSION['success_message'] = "You have successfully registered.";
                } else {
                    $_SESSION['error_message'] = "ERROR: Could not execute queries. " . mysqli_error($conn);
                }
            } else {
                $_SESSION['error_message'] = "ERROR: There was an error uploading your file.";
            }
        }
    } else {
        $_SESSION['error_message'] = "ERROR: No file uploaded or an error occurred during file upload.";
    }

    mysqli_close($conn);

    header("Location: ../start/adminstudents.php");
    exit();
} else {
    $_SESSION['error_message'] = "ERROR: Form submission method not allowed.";
    header("Location: ../start/adminstudents.php");
    exit();
}
?>
