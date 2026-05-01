<?php
session_start(); // Start the session

if (isset($_POST['addsubject'])) {
    include '../assets/connection/connection.php';

    $subject_name = mysqli_real_escape_string($conn, $_POST['subjectName']);
    $discription = mysqli_real_escape_string($conn, $_POST['discription']);
    $units = mysqli_real_escape_string($conn, $_POST['units']);

    $check_query = "SELECT * FROM subject_tbl WHERE subject_name = '$subject_name'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error_message'] = 'subject already exists.';
        header("Location: ../start/adminsubject.php");
        exit();
    } else {
        $max_id_query = "SELECT MAX(subject_id) AS max_id FROM subject_tbl";
        $max_id_result = mysqli_query($conn, $max_id_query);
        $max_id_row = mysqli_fetch_assoc($max_id_result);
        $next_id = ($max_id_row['max_id'] ?? 100) + 1;

        $insert_query = "INSERT INTO subject_tbl (subject_id, subject_name , discription , units) VALUES ($next_id, '$subject_name','$discription','$units')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['success_message'] = 'Subject added successfully.';
            header("Location: ../start/adminsubject.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Failed to add subject.';
            header("Location: ../start/adminsubject.php");
            exit();
        }
    }

    mysqli_close($conn);
}
?>
