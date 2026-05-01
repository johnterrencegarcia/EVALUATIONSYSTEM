<?php
// Include the database connection file
include '../assets/connection/connection.php';

// Get the search term from the AJAX request
$searchTerm = mysqli_real_escape_string($conn, $_POST['studentName']);

// Adjusted query with JOINs to include course and section names
$query = "SELECT st.*, c.course_name, s.section_name 
FROM student_tbl st
LEFT JOIN course_tbl c ON st.course_id = c.course_id
LEFT JOIN section_tbl s ON st.section_id = s.section_id
WHERE st.firstname LIKE '%$searchTerm%' 
OR st.lastname LIKE '%$searchTerm%' 
OR st.email LIKE '%$searchTerm%'
OR st.gender LIKE '%$searchTerm%' 
OR c.course_name LIKE '%$searchTerm%' 
OR s.section_name LIKE '%$searchTerm%'
OR st.yearlevel LIKE '%$searchTerm%'";

// Execute the query
$query_run = mysqli_query($conn, $query);

// Check if any records are found
if (mysqli_num_rows($query_run) > 0) {
    // Output the search results in HTML format (directly as <tr> elements)
    foreach ($query_run as $row) {
?>
        <tr>
            <td style="text-align: center;"><?= $row['student_id']; ?></td>
            <td style="text-align: center; vertical-align: middle;"><img src="<?= $row['photo']; ?>" alt="Student Photo" width="100" height="100"></td>
            <td style="text-align: center;"><?= $row['firstname']; ?></td>
            <td style="text-align: center;"><?= $row['lastname']; ?></td>
            <td style="text-align: center;"><?= $row['email']; ?></td>
            <td style="text-align: center;"><?= $row['gender']; ?></td>
            <td style="text-align: center;"><?= $row['yearlevel']; ?></td>           
            <td style="text-align: center; text-transform: uppercase;"><?= $row['course_name']; ?></td>
            <td style="text-align: center;"><?= $row['section_name']; ?></td>
            <td style="text-align: center;">
               
                <button type="button" class="btn btn-danger btn-sm" onclick="deletestudent(<?= $row['student_id']; ?>)">
                    <i class='bx bx-trash'></i> Delete<!-- Delete icon -->
                </button>
            </td>
        </tr>
<?php
    }
} else {
    // If no records are found, display a message
    echo "<tr><td colspan='13' class='text-center'>No records found.</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>