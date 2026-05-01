<?php
// Include the database connection
include '../assets/connection/connection.php';

if (isset($_POST['accessid'])) {
   
    $accessid = mysqli_real_escape_string($conn, $_POST['accessid']);

    // Query to delete the access ID from accessid_tbl
    $delete_query = "DELETE FROM accessid_tbl WHERE id = '$accessid'";

    // Execute the delete query
    if (mysqli_query($conn, $delete_query)) {
        // If deletion is successful
        echo 'ID deleted successfully';
    } else {
        // If deletion fails
        echo 'Failed to delete ID';
    }
} else {
    // If access ID is not provided in the request
    echo 'Error: ID is not provided';
}
?>
