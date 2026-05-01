<?php
include '../assets/connection/connection.php';

if (isset($_POST['student_id'])) {
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

    // Fetch photo path from the database
    $fetch_photo_query = "SELECT photo FROM student_tbl WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $fetch_photo_query);
    $row = mysqli_fetch_assoc($result);
    $photo_path = $row['photo'];

    if (file_exists($photo_path)) {
        unlink($photo_path); // Delete the file
    }

    $delete_query = "DELETE FROM student_tbl WHERE student_id = '$student_id'";

    if (mysqli_query($conn, $delete_query)) {
        echo 'Student deleted successfully';
    } else {
        echo 'Error: Unable to delete student';
    }
} else {
    echo 'Error: student_id is not provided';
}
?>
