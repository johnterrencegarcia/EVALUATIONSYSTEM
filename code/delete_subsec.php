<?php
// Include the database connection
include '../assets/connection/connection.php';

// Check if the course_id is provided via POST request
if (isset($_POST['subsec_id'])) {
    // Sanitize the input to prevent SQL injection
    $subsec_id = mysqli_real_escape_string($conn, $_POST['subsec_id']);

    // Construct the DELETE query
    $delete_query = "DELETE FROM subsection_tbl WHERE subsec_id = '$subsec_id'";

    // Execute the DELETE query
    if (mysqli_query($conn, $delete_query)) {
        // Deletion successful
        echo 'subject deleted successfully';
        // You can return any message or data you want here
    } else {
        // Error occurred during deletion
        echo 'Error: Unable to delete subject';
        // You can handle the error or return an error message
    }
} else {
    // course_id is not provided
    echo 'Error: subsec_id is not provided';
    // You can handle this case as per your requirement
}
?>
