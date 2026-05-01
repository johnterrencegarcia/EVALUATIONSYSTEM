<?php
session_start();

if (isset($_POST['addFaculty'])) {
    include '../assets/connection/connection.php';

    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $gender = mysqli_real_escape_string($conn, $_POST['sex']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // Check if the photo already exists in the uploads directory
    $target_dir = "../uploads/";
    $target_file = $target_dir . basename($_FILES["photoUpload"]["name"]);
    if (file_exists($target_file)) {
        $_SESSION['error_message'] = "Sorry, a file with this name already exists.";
        header("Location: ../start/adminfaculty.php");
        exit(); // Fix: Added exit() after setting session message and header
    }

    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $check = getimagesize($_FILES["photoUpload"]["tmp_name"]);
    if ($check !== false) {
        $uploadOk = 1;
    } else {
        $_SESSION['error_message'] = "File is not an image.";
        $uploadOk = 0;
        header("Location: ../start/adminfaculty.php");
        exit(); // Fix: Added exit() after setting session message and header
    }

    if ($_FILES["photoUpload"]["size"] > 500000) {
        $_SESSION['error_message'] = "Sorry, your file is too large.";
        $uploadOk = 0;
        header("Location: ../start/adminfaculty.php");
        exit(); // Fix: Added exit() after setting session message and header
    }

    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        $_SESSION['error_message'] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
        header("Location: ../start/adminfaculty.php");
        exit(); // Fix: Added exit() after setting session message and header
    }

    if ($uploadOk == 0) {
        $_SESSION['error_message'] .= " Your file was not uploaded.";
    } else {
        $max_id_query = "SELECT MAX(faculty_id) AS max_id FROM faculty_tbl";
        $max_id_result = mysqli_query($conn, $max_id_query);
        $max_id_row = mysqli_fetch_assoc($max_id_result);
        $next_id = ($max_id_row['max_id'] ?? 1000) + 1;

        if (move_uploaded_file($_FILES["photoUpload"]["tmp_name"], $target_file)) {
            $insert_query = "INSERT INTO faculty_tbl (faculty_id, firstname, lastname, email, gender, contact_no, address, photo) 
                             VALUES ('$next_id','$fname', '$lname', '$email', '$gender', '$phone', '$address', '$target_file')";

            if (mysqli_query($conn, $insert_query)) {
                $_SESSION['success_message'] = 'Faculty added successfully.';
            } else {
                $_SESSION['error_message'] = 'Failed to add faculty.';
            }
        } else {
            $_SESSION['error_message'] = "Sorry, there was an error uploading your file.";
        }
    }

    mysqli_close($conn);
    header("Location: ../start/adminfaculty.php");
    exit(); // Fix: Added exit() after processing to prevent further execution
}
?>
