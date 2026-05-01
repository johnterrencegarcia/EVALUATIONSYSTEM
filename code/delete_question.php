<?php
include '../assets/connection/connection.php';

if (isset($_POST['questionId'])) {
    $questionId = mysqli_real_escape_string($conn, $_POST['questionId']);
    
    // Query to check the status in active_tbl
    $status_query = "SELECT status FROM active_tbl";
    $status_result = mysqli_query($conn, $status_query);

    if ($status_result) {
        $row = mysqli_fetch_assoc($status_result);
        $status = $row['status'];
        
        if ($status === 'Finished') {
            // If status is 'Finished', allow deletion
            $delete_query = "DELETE FROM questions_tbl WHERE question_id = '$questionId'";
            
            if (mysqli_query($conn, $delete_query)) {
                // Check if any rows are affected by the deletion
                if (mysqli_affected_rows($conn) > 0) {
                    echo 'success'; // Deletion successful
                } else {
                    // If no rows are affected, the question does not exist or has already been deleted
                    echo 'Question does not exist or has already been deleted.';
                }
            } else {
                echo 'error'; // Deletion failed
            }
        } elseif ($status === 'In Progress') {
            // If status is 'In Progress', prevent deletion
            echo 'Cannot delete question. Status is "In Progress".';
        } else {
            // Handle other statuses if needed
            echo 'Status is not recognized.';
        }
    } else {
        // Error retrieving status
        echo 'Error retrieving status.';
    }
} else {
    echo 'invalid';
}
?>
