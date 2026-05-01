<?php
session_start();

if (isset($_POST['faculty_id'])) {
    include '../assets/connection/connection.php'; // Include database connection

    $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty_id']); // Get faculty ID from the form

    // Fetch photo path from database
    $fetch_photo_query = "SELECT photo FROM faculty_tbl WHERE faculty_id = '$faculty_id'";
    $result = mysqli_query($conn, $fetch_photo_query);
    $row = mysqli_fetch_assoc($result);
    $photo_path = $row['photo'];

    // Delete photo file from server
    if (file_exists($photo_path)) {
        unlink($photo_path); // Delete the file
    }

    // Construct the DELETE query
    $delete_query = "DELETE FROM faculty_tbl WHERE faculty_id = '$faculty_id'";

    // Execute the DELETE query
    if (mysqli_query($conn, $delete_query)) {
        $_SESSION['success_message'] = 'Faculty deleted successfully.';
    } else {
        $_SESSION['error_message'] = 'Failed to delete faculty.';
    }

    mysqli_close($conn); // Close database connection

    header("Location: ../start/adminfaculty.php"); // Redirect back to the faculty management page
    exit(); // Stop further execution of the script
}
?>
