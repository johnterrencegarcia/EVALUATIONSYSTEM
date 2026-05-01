<?php
// Include the database connection file
include '../assets/connection/connection.php';

// Get the search term from the AJAX request
$searchTerm = mysqli_real_escape_string($conn, $_POST['outputSection']);

// Query to search for sections matching the search term and count the number of students for each section
$query = "SELECT section_tbl.section_id, section_tbl.section_name, COUNT(student_tbl.student_id) AS student_count
          FROM section_tbl
          LEFT JOIN student_tbl ON section_tbl.section_id = student_tbl.section_id
          WHERE section_tbl.section_name LIKE '%$searchTerm%'
          GROUP BY section_tbl.section_id";

// Execute the query
$query_run = mysqli_query($conn, $query);

// Check if any sections are found
if (mysqli_num_rows($query_run) > 0) {
    // Output the search results in HTML format
?>
    <div class="search-results"> <!-- Add a container for search results -->
        <?php
        foreach ($query_run as $row) {
        ?>
            <tr>
                <td class="align-middle text-center"><?php echo $row['section_id']; ?></td>
                <td class="align-middle text-center"><?php echo $row['section_name']; ?></td>
                <td class="align-middle text-center"><?php echo $row['student_count']; ?></td>
                <td class="align-middle text-center">
                    <div class="d-flex justify-content-center">
                        <a href="../start/adminsubjectsection.php?id=<?= $row['section_id']; ?>" style="margin-right: 1px;">
                            <button type="button" name="view-section" value="<?= $row['section_id']; ?>" class="btn btn-primary btn-sm">
                                <i class='bx bx-show'></i> Manage Subjects<!-- View icon -->
                            </button>
                        </a>
                        <button type="button" name="delete-section" value="<?= $row['section_id']; ?>" class="btn btn-danger btn-sm" style="margin-left: 5px;" onclick="deleteSection(<?= $row['section_id']; ?>)">
                            <i class='bx bx-trash'></i> Delete<!-- Delete icon -->
                        </button>
                    </div>
                </td>
            </tr>
        <?php
        }
        ?>
    </div>
<?php
} else {
    // If no sections are found, display a message
    echo "<tr><td colspan='4' class='text-center'>No records found.</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>
