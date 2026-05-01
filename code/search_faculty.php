<?php
// Include the database connection file
include '../assets/connection/connection.php';

// Get the search term from the AJAX request
$searchTerm = mysqli_real_escape_string($conn, $_POST['facultyName']);

// Query to search for courses matching the search term
$query = "SELECT * FROM faculty_tbl WHERE firstname LIKE '%$searchTerm%' OR lastname LIKE '%$searchTerm%' OR email LIKE '%$searchTerm%'
 OR gender LIKE '%$searchTerm%'";

// Execute the query
$query_run = mysqli_query($conn, $query);

// Check if any faculty members are found
if (mysqli_num_rows($query_run) > 0) {
    // Output the search results in HTML format
?>
    <div class="search-results"> <!-- Add a container for search results -->
        <?php
        foreach ($query_run as $row) {
        ?>
            <tr>
                <td style="text-align: center; vertical-align: middle;"><?= $row['faculty_id']; ?></td>
                <td style="text-align: center; vertical-align: middle;"><img src="<?= $row['photo']; ?>" alt="Faculty Photo" width="100" height="100"></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row['firstname']; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row['lastname']; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row['email']; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row['gender']; ?></td>

                <td style="text-align: center; vertical-align: middle;">
                    <a href="../start/get_eval.php?= $row['faculty_id']; ?>">
                        <button type="button" name="view-course" value="<?= $row['faculty_id']; ?>" class="btn btn-primary btn-sm">
                            <i class='bx bx-show'></i> View Evaluation <!-- View icon -->
                        </button>
                    </a>
                    <button type="button" name="delete-course" value="<?= $row['faculty_id']; ?>" class="btn btn-danger btn-sm" onclick="deletefaculty(<?= $row['faculty_id']; ?>)">
                        <i class='bx bx-trash'></i> Delete <!-- Delete icon -->
                    </button>
                </td>
            </tr>
        <?php
        }
        ?>
    </div>
<?php
} else {
    // If no faculty members are found, display a message
    echo "<tr><td colspan='9' class='text-center'>No records found.</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>
