<?php
// Include the database connection file
include '../assets/connection/connection.php';

// Get the search term from the AJAX request
$searchTerm = mysqli_real_escape_string($conn, $_POST['subjectName']);

// Query to search for courses matching the search term
$query = "SELECT * FROM subject_tbl WHERE subject_name LIKE '%$searchTerm%' OR discription LIKE '%$searchTerm%'";


// Execute the query
$query_run = mysqli_query($conn, $query);

// Check if any courses are found
if (mysqli_num_rows($query_run) > 0) {
    // Output the search results in HTML format
?>
    <div class="search-results"> <!-- Add a container for search results -->
        <?php
        foreach ($query_run as $row) {
        ?>
            <tr>
                <td style="text-align: center;"><?= $row['subject_id']; ?></td>
                <td style="text-align: center;"><?= $row['subject_name']; ?></td>
                <td style="text-align: center;"><?= $row['discription']; ?></td>
                <td style="text-align: center;"><?= $row['units']; ?></td>
                <td style="text-align: center;">

                    <a href="../codes/view_subject.php?id=<?= $row['subject_id']; ?>">
                        <button type="button" name="view-subject" value="<?= $row['subject_id']; ?>" class="btn btn-primary btn-sm">
                            <i class='bx bx-show'></i> <!-- View icon -->
                        </button>
                    </a>


                    <button type="button" name="delete-course" value="<?= $row['subject_id']; ?>" class="btn btn-danger btn-sm" onclick="deletesubject(<?= $row['subject_id']; ?>)">
                        <i class='bx bx-trash'></i> <!-- Delete icon -->
                    </button>

                </td>
            </tr>
        <?php
        }
        ?>
    </div>
<?php
} else {
    // If no courses are found, display a message
    echo "<tr><td colspan='6' class='text-center'>No records found.</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>