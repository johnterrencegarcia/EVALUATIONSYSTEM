<?php
session_start();
@include '../assets/connection/connection.php';

// Check if source parameter is set in the URL
if (isset($_GET['source'])) {
    $source = $_GET['source'];
    $redirect_url = "../start/studentdashboard.php"; // Default redirect URL

    if ($source === "profile") {
        $redirect_url = "../start/studentprofile.php";
    }

    // Check if the source is not 'evaluation'
    if ($source !== "evaluation") {
        // Check if the form is submitted
        if (!empty($_POST['changepass'])) {
            $oldpass = $_POST['currentPassword'];
            $newpass = $_POST['newPassword'];
            $conpass = $_POST['confirmPassword'];

            // Retrieve the userID from the session
            if (isset($_SESSION['user_id'])) {
                $userid = $_SESSION['user_id'];
                if ($newpass == $conpass) {
                    // Query to check if the old password matches
                    $query = "SELECT * FROM login_tbl WHERE login_id='$userid' AND password='$oldpass'";
                    $result = mysqli_query($conn, $query);

                    if ($result) {
                        $count = mysqli_num_rows($result);

                        if ($count > 0) {
                            // Update the password
                            $update_query = "UPDATE login_tbl SET password='$newpass' WHERE login_id='$userid'";
                            $update_result = mysqli_query($conn, $update_query);

                            if ($update_result) {
                                // Password updated successfully
                                $_SESSION['message'] = "success";
                            } else {
                                // Error updating password
                                $_SESSION['message'] = "error";
                            }
                        } else {
                            // Incorrect old password
                            $_SESSION['message'] = "incorrect_password";
                        }
                    } else {
                        // Query failed
                        $_SESSION['message'] = "query_failed";
                    }
                } else {
                    // New password & Confirm New Password do not match
                    $_SESSION['message'] = "password_mismatch";
                }
            } else {
                // User ID not found in session
                $_SESSION['message'] = "user_not_found";
            }

            // Redirect the user back to the source page
            header("Location: " . $redirect_url);
            exit();
        }
    } else {
        // Display message if the source is 'evaluation'
        $_SESSION['message'] = "evaluation_message";
        $redirect_url = "../start/studentevaluation.php";
        header("Location: " . $redirect_url);
        exit();
    }
} else {
    // If source parameter is not set, redirect to a default page
    header("Location: ../start/studentdashboard.php");
    exit();
}
?>
