<?php
include '../assets/connection/connection.php';

if (isset($_POST['insert_question'])) {
    $question = mysqli_real_escape_string($conn, $_POST['question']);
   
    $query = "INSERT INTO questions_tbl (question) 
              VALUES ('$question')";
    $query_run = mysqli_query($conn, $query);

    if ($query_run) {
        mysqli_close($conn);
        header('Location: ../start/adminevaluation.php');
        exit();
    } else {
        $error = mysqli_error($conn);
        mysqli_close($conn);
        echo "Failed to insert question. Error: " . $error;
        exit();
    }
}
?>
