<?php
// Include the database connection file
include './assets/connection/connection.php';
session_start();

$response = array(); // Initialize response array

if (isset($_POST['login'])) {
    $uid = trim(mysqli_real_escape_string($conn, $_POST['login_id']));
    $password = $_POST['password'];

    // Debugging: Output SQL query
    $select = "SELECT * FROM users WHERE uid = '$uid'";
    echo "SQL Query: $select <br>";

    $result = mysqli_query($conn, $select);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // Verify if the provided password matches the stored hashed password
        if (password_verify($password, $row['password'])) {
            // Password matches
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['success_msg'] = 'Login successful!';
            // Set user role in the response
            $response['success'] = true;
            $response['role'] = $row['role'];
            // Redirect based on user role
            if ($row['role'] == 'Admin') {
                $_SESSION['admin_id'] = $row['uid'];
                $_SESSION['admin_role'] = $row['role'];
                $response['redirect'] = './start/admindashboard.php';
            } elseif ($row['role'] == 'Student') {
                $_SESSION['user_studuid'] = $row['uid'];
                $_SESSION['user_role'] = $row['role'];
                $response['redirect'] = './start/studentdashboard.php';
            }
        } else {
            // Password does not match
            $response['success'] = false;
            $response['message'] = 'Incorrect Student ID or password!';
        }
    } else {
        // User not found
        $response['success'] = false;
        $response['message'] = 'User not found!';
    }
} else {
    // Invalid request
    $response['success'] = false;
    $response['message'] = 'Invalid request!';
}

// Debugging: Output response
$response_json = json_encode($response);
if ($response_json === false) {
    // JSON encoding failed
    $response['success'] = false;
    $response['message'] = 'Error encoding response to JSON';
    $response_json = json_encode($response);
}

echo "Response: " . $response_json . "<br>";

// Send JSON response
header('Content-Type: application/json');
echo $response_json;
?>
