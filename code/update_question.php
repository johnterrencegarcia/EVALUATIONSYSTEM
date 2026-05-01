
<?php
// Include your database connection file
include '../assets/connection/connection.php';

if (isset($_POST['updatequestion'])) {
    // Check if both question ID and updated question text are provided
    if (isset($_POST['question_id'], $_POST['editedQuestion'])) {
        $question_id = $_POST['question_id'];
        $updated_question = $_POST['editedQuestion'];

        // Prepare and execute the update query
        $query = "UPDATE questions_tbl SET question = ? WHERE id = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "si", $updated_question, $question_id);
        $success = mysqli_stmt_execute($stmt);

        if ($success) {
            // If update is successful, display success message using SweetAlert2
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Question updated successfully",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location = "../start/adminevaluation.php"; // Redirect to admin evaluation page
                    });
                  </script>';
        } else {
            // If update fails, display error message using SweetAlert2
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to update question",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                  </script>';
        }
    } else {
        // If question ID or updated question text is not provided, display an error message using SweetAlert2
        echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
        echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "Question ID or updated question text not provided",
                    icon: "error",
                    confirmButtonText: "OK"
                });
              </script>';
    }
}
?>
