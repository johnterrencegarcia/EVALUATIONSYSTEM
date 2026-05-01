<?php
session_start(); // Start the session

if (isset($_POST['addsection'])) {
    include '../assets/connection/connection.php';

    $section_name = strtoupper(mysqli_real_escape_string($conn, $_POST['sectionName']));

    // Check if the section already exists
    $check_query = "SELECT * FROM section_tbl WHERE section_name = '$section_name'";
    $check_result = mysqli_query($conn, $check_query);
    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['error_message'] = 'Section already exists.';
        header("Location: ../start/adminsection.php");
        exit();
    } else {
        // Retrieve the maximum section ID and increment it for the new section
        $max_id_query = "SELECT MAX(section_id) AS max_id FROM section_tbl";
        $max_id_result = mysqli_query($conn, $max_id_query);
        $max_id_row = mysqli_fetch_assoc($max_id_result);
        $next_id = ($max_id_row['max_id'] ?? 0) + 1;

        // Insert the new section into the database
        $insert_query = "INSERT INTO section_tbl (section_id, section_name) VALUES ($next_id, '$section_name')";
        if (mysqli_query($conn, $insert_query)) {
            $_SESSION['success_message'] = 'Section added successfully.';
            header("Location: ../start/adminsection.php");
        exit();
        } else {
            $_SESSION['error_message'] = 'Failed to add Section.';
            header("Location: ../start/adminsection.php");
        exit();
        }
    }

    // Redirect back to the admin section page
    header("Location: ../start/adminsection.php");
    exit();
}
?>
