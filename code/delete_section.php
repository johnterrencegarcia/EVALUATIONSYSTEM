<?php
// Include the database connection
include '../assets/connection/connection.php';

// Check if the course_id is provided via POST request
if (isset($_POST['section_id'])) {
    // Sanitize the input to prevent SQL injection
    $section_id = mysqli_real_escape_string($conn, $_POST['section_id']);

    // Construct the DELETE query
    $delete_query = "DELETE FROM section_tbl WHERE section_id = '$section_id'";

    // Execute the DELETE query
    if (mysqli_query($conn, $delete_query)) {
        // Deletion successful
        echo 'Section deleted successfully';
        // You can return any message or data you want here
    } else {
        // Error occurred during deletion
        echo 'Error: Unable to delete Section';
        // You can handle the error or return an error message
    }
} else {
    // course_id is not provided
    echo 'Error: section_id is not provided';
    // You can handle this case as per your requirement
}
?>
