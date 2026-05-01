<?php
session_start(); // Start the session

if (isset($_POST['addCourse'])) {
    include '../assets/connection/connection.php';

    $course_name = mysqli_real_escape_string($conn, $_POST['courseName']);
    $discription = mysqli_real_escape_string($conn, $_POST['discription']);

    $check_query = "SELECT * FROM course_tbl WHERE course_name = '$course_name'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error_message'] = 'Course already exists.';
        header("Location: ../start/admincourse.php");
        exit();
    } else {
        $max_id_query = "SELECT MAX(course_id) AS max_id FROM course_tbl";
        $max_id_result = mysqli_query($conn, $max_id_query);
        $max_id_row = mysqli_fetch_assoc($max_id_result);
        $next_id = ($max_id_row['max_id'] ?? 999) + 1;

        $insert_query = "INSERT INTO course_tbl (course_id, course_name , discription) VALUES ($next_id, '$course_name','$discription')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['success_message'] = 'Course added successfully.';
            header("Location: ../start/admincourse.php");
            exit();
        } else {
            $_SESSION['error_message'] = 'Failed to add course.';
            header("Location: ../start/admincourse.php");
            exit();
        }
    }

    mysqli_close($conn);
}
?>
