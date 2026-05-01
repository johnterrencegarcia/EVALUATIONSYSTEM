<?php
// Include your database connection file
include '../assets/connection/connection.php';

if (isset($_POST['question_id'])) {
    $question_id = $_POST['question_id'];
    
    // Fetch question text from the database
    $query = "SELECT question FROM questions_tbl WHERE question_id = $question_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $question_text = $row['question'];
        echo $question_text; // Return the question text as the AJAX response
        exit; // Stop further execution
    } else {
        echo "Question not found";
        exit;
    }
}
?>
