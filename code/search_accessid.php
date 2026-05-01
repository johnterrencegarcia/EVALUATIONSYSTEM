<?php
include '../assets/connection/connection.php';

if (isset($_POST['search-id'])) {
    $searchQuery = mysqli_real_escape_string($conn, $_POST['search-id']);

    $searchQueryLower = strtolower($searchQuery);

    if ($searchQueryLower === 'active' || $searchQueryLower === 'inactive') {
        $statusQuery = ($searchQueryLower === 'active') ? 1 : 0;
        $query = "SELECT * FROM accessid_tbl WHERE LOWER(status) = '$statusQuery'";
    } else {
        $query = "SELECT * FROM accessid_tbl WHERE LOWER(student_id) LIKE '%$searchQueryLower%'";
    }

    $query_run = mysqli_query($conn, $query);

    if (mysqli_num_rows($query_run) > 0) {
        foreach ($query_run as $row) {
?>
            <tr>
                <td style="text-align: center; vertical-align: middle;"><?= $row['id']; ?></td>
                <td style="text-align: center; vertical-align: middle;"><?= $row['student_id']; ?></td>
                <td style="text-align: center; vertical-align: middle; color: <?= $row['status'] ? 'green' : 'red'; ?>">
                    <?= $row['status'] ? 'Registered' : 'Not Registered'; ?>
                </td>
                <td style="text-align: center; vertical-align: middle;"><?= $row['time']; ?></td>
                <td style="text-align: center; vertical-align: middle;">
                    <button type="button" class="btn btn-danger btn-sm" onclick="deleteAccessID(<?= $row['id']; ?>)">
                        <i class='bx bx-trash'></i> Delete
                    </button>
                </td>
            </tr>
<?php
        }
    } else {
        echo "<tr><td colspan='5' class='text-center'>No records found.</td></tr>";
    }
} else {
    echo 'Error: Search query not provided';
}
?>