<?php
// Include database connection
include '../assets/connection/connection.php';

// Check if the search term and section ID are provided via POST
if(isset($_POST['subsecName']) && isset($_POST['section_id'])) {
    // Sanitize the search term and section ID to prevent SQL injection
    $searchTerm = mysqli_real_escape_string($conn, $_POST['subsecName']);
    $section_id = mysqli_real_escape_string($conn, $_POST['section_id']);

    // Query to search for subjects based on subject name, description, and faculty name, and section ID
    $query = "SELECT subsec_id, subsection_tbl.subject_id, subsection_tbl.faculty_id, subject_name, discription, lastname, firstname 
              FROM subsection_tbl 
              INNER JOIN subject_tbl ON subsection_tbl.subject_id = subject_tbl.subject_id 
              INNER JOIN faculty_tbl ON subsection_tbl.faculty_id = faculty_tbl.faculty_id 
              WHERE section_id = $section_id 
              AND (subject_name LIKE '%$searchTerm%' OR discription LIKE '%$searchTerm%' OR lastname LIKE '%$searchTerm%' OR firstname LIKE '%$searchTerm%' OR subsection_tbl.faculty_id = '$searchTerm')
              ORDER BY subsec_id";
    
    $result = mysqli_query($conn, $query);

    if($result) {
        // Check if any records are found
        if(mysqli_num_rows($result) > 0) {
            // Output table rows for the search results
            while($row = mysqli_fetch_assoc($result)) {
                $subsec_id = $row['subsec_id'];
                $subject_id = $row['subject_id'];
                $faculty_id = $row['faculty_id'];
                $subject_name = $row['subject_name'];
                $description = $row['discription'];
                $faculty_name = $row['lastname'] . ' ' . $row['firstname'];

                // Output table row
                echo "
                    <tr>
                        <td style='text-align: center;'>$subsec_id</td>
                        <td style='text-align: center;'>$subject_name</td>
                        <td style='text-align: center;'>$description</td>
                        <td style='text-align: center;'>$faculty_name</td>
                        <td style='text-align: center;'>$faculty_id</td>
                        <td style='text-align: center;'>
                            <a href='#' onclick='deletesubsec($subsec_id);'>
                                <button class='btn btn-danger btn-sm' ><i class='bx bx-trash'> Delete</i></button>
                            </a>
                        </td>
                    </tr>";
            }
        } else {
            // No matching records found
            echo "<tr><td colspan='6' class='text-center'>No records found.</td></tr>";
        }
    } else {
        // Error in executing the query
        echo "<tr><td colspan='6' class='text-center'>Error: " . mysqli_error($conn) . "</td></tr>";
    }
} else {
    // No search term or section ID provided
    echo "<tr><td colspan='6' class='text-center'>Please enter a search term.</td></tr>";
}

// Close database connection
mysqli_close($conn);
?>
