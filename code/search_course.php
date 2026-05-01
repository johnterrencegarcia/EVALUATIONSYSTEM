<?php
// Include the database connection file
include '../assets/connection/connection.php';

// Get the search term from the AJAX request
$searchTerm = mysqli_real_escape_string($conn, $_POST['courseName']);

// Query to search for courses matching the search term
$query = "SELECT * FROM course_tbl WHERE course_name LIKE '%$searchTerm%'  OR discription LIKE '%$searchTerm%' ";

// Execute the query
$query_run = mysqli_query($conn, $query);

// Check if any courses are found
if (mysqli_num_rows($query_run) > 0) {
    foreach ($query_run as $row) {
        // Get the course ID
        $course_id = $row['course_id'];

        // Query to count the number of students enrolled in this course
        $count_query = "SELECT COUNT(student_id) AS studentCount FROM student_tbl WHERE course_id = $course_id";
        $count_result = mysqli_query($conn, $count_query);
        $student_count = mysqli_fetch_assoc($count_result)['studentCount'];

        // Output the table row for the course
        echo "<tr>";
        echo "<td style='text-align: center;'>{$row['course_id']}</td>";
        echo "<td style='text-align: center;'>{$row['course_name']}</td>";
        echo "<td style='text-align: center;'>{$row['discription']}</td>"; // Fixed: Use 'description' instead of '$description'
        echo "<td style='text-align: center;'>{$student_count}</td>";
        echo "<td style='text-align: center;'>";
       
        echo "<button type='button' name='delete-course' value='{$row['course_id']}' class='btn btn-danger btn-sm' onclick='deleteCourse({$row['course_id']})'><i class='bx bx-trash'></i> Delete</button>";
        echo "</td>";
        echo "</tr>";
    }
} else {
    // If no courses are found, display a message
    echo "<tr><td colspan='5' class='text-center'>No records found.</td></tr>";
}

// Close the database connection
mysqli_close($conn);
?>