<?php
session_start(); // Start the session

if (isset($_POST['add-accessid'])) {
    include '../assets/connection/connection.php';

    $accessid = mysqli_real_escape_string($conn, $_POST['studentId']);

    $check_query = "SELECT * FROM accessid_tbl WHERE student_id = '$accessid'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error_message'] = 'Id already exists.';
        header("Location: ../start/adminautorize.php");
        exit();
    } else {
        $insert_query = "INSERT INTO accessid_tbl (student_id) VALUES ('$accessid')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['success_message'] = 'Id added successfully.';
            header("Location: ../start/adminautorize.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Failed to add Id.';
            header("Location: ../start/adminautorize.php");
            exit();
        }
    }

    mysqli_close($conn);
}
?>
