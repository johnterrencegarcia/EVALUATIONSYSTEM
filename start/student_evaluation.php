<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">


    <title>eval Dashboard</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel=" stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php
    session_start();
    $userID = $_SESSION['user_id'];
    $Studentid = $_SESSION['user_studuid'];
    if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'Student') {
        // Redirect to index.php if the user is not logged in as a student
        header('location:../index.php');
        exit();
    }

    if (isset($_SESSION['success_msg'])) {
        $success_msg = $_SESSION['success_msg'];
        // Unset session variable to prevent displaying the message again on page refresh
        unset($_SESSION['success_msg']);
        // Display success message using SweetAlert JS
    ?>


        <script src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
        <script>
            const Toast = Swal.mixin({
                toast: true,
                position: 'bottom-end', // Bottom right
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            });

            Toast.fire({
                icon: 'success',
                title: 'Signed in successfully'
            });
        </script>
    <?php
    }
    ?>
    <?php
    // Include database connection file
    include '../assets/connection/connection.php';

    // Retrieve the student's information from the database
    $selectQuery = "SELECT * FROM student_tbl WHERE student_id = $Studentid";
    $selectResult = mysqli_query($conn, $selectQuery);

    // Check if the query executed successfully and if there is a matching record
    if ($selectResult && mysqli_num_rows($selectResult) > 0) {
        // Fetch the data from the result set
        $studentData = mysqli_fetch_assoc($selectResult);

        // Function to check if the value is empty and return blank if true
        function formatValue($value)
        {
            return (!empty($value)) ? $value : '';
        }

        // Store the student data in variables
        $student_id = formatValue($studentData['student_id']);
        $firstname = formatValue($studentData['firstname']);
        $lastname = formatValue($studentData['lastname']);
        $email = formatValue($studentData['email']);
        $gender = formatValue($studentData['gender']);
        $yearlevel = formatValue($studentData['yearlevel']);
        $status = formatValue($studentData['status']);
        $photo = formatValue($studentData['photo']);
        $course_id = formatValue($studentData['course_id']);
        $section_id = formatValue($studentData['section_id']);
        $password = formatValue($studentData['password']);

        // Set student_id and section_id in session
        $_SESSION['student_id'] = $student_id;
        $_SESSION['section_id'] = $section_id;
    } else {
        // If no data found, initialize all variables with empty values
        $student_id = '';
        $firstname = '';
        $lastname = '';
        $email = '';
        $gender = '';
        $yearlevel = '';
        $status = '';
        $photo = '';
        $course_id = '';
        $section_id = '';
        $password = '';
    }
    ?>
      <?php
    // Assuming you have established a database connection already
    include '../assets/connection/connection.php';

    // SQL query to select data from the active_tbl
    $query = "SELECT * FROM active_tbl LIMIT 1"; // Assuming you only have one active record

    $result = mysqli_query($conn, $query);

    // Check if the query was successful
    if ($result) {
        // Fetch the data as an associative array
        $row = mysqli_fetch_assoc($result);

        // Assign fetched data to variables
        $school_year = $row['school_year'];
        $semester = $row['semester'];
        $status = $row['status'];

        // Check if status is 'Finished'
        if ($status === 'Finished') {
            // Use JavaScript to display SweetAlert and redirect
            echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
            echo "<script>";
            echo "Swal.fire({";
            echo "  icon: 'error',";
            echo "  title: 'Access Denied',";
            echo "  text: 'The Voting has finished. You cannot access this page.',";
            echo "}).then(() => {";
            echo "  window.location.href = 'studentdashboard.php';";
            echo "});";
            echo "</script>";
            exit(); // Stop further execution
        }
    } else {
        // Handle error if the query fails
        echo "Error fetching data: " . mysqli_error($conn);
    }
    ?>

    <?php if ($status === 'In Progress') : ?>
        <div class="h6 mb-0 font-weight-bold text-success blink">


        </div>
    <?php else : ?>
        <div class="h6 mb-0 font-weight-bold text-gray-800">

        </div>
    <?php endif; ?>
 <style>
        #content-wrapper {
            overflow-y: auto;
            /* Enable vertical scrolling */
            max-height: calc(100vh - 56px);
            /* Adjust the maximum height to fit the viewport minus the height of the top bar */
        }
    </style>
    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar" style="background-color: #00008B;">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon ">
                    <!-- Insert your logo here -->
                    <img src="../assets/img/logo.png" alt="Logo" style="width: 60px; height: 60px;">
                </div>
                <div class="sidebar-brand-text mx-2">AISAT DAU <sup></sup></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="../start/studentdashboard.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

            <!-- Nav Items -->

            <li class="nav-item">
                <a class="nav-link" href="../start/studentprofile.php">
                    <i class="fa-solid fa-address-card"></i>
                    <span>Profile</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="../start/studentevaluation.php">
                    <i class="fa-solid fa-square-poll-horizontal"></i>
                    <span>Evaluation</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="../start/studentabout.php">
                    <i class="fa-solid fa-info"></i>
                    <span>About</span>
                </a>
            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">
            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->



                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">Hello <?php echo $firstname ?><?php echo $lastname ?></span>
                                <img class="img-profile rounded-circle profile-size" src="<?php echo $photo; ?>" alt="Profile Picture">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#Changepass">
                                    <i class="fa-solid fa-lock fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Change password
                                </a>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                                <div class="dropdown-divider"></div>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Evaluation Form</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Rating Legend -->
                        <div class="col-md-12 mb-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-4 text-primary">Rating Legend</h5>
                                    <div class="row">
                                        <div class="col-md-3 mb-3">
                                            <div class="card bg-danger text-white shadow">
                                                <div class="card-body">
                                                    1. STRONGLY AGREE
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="card bg-warning text-white shadow">
                                                <div class="card-body">
                                                    2. DISAGREE
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="card bg-info text-white shadow">
                                                <div class="card-body">
                                                    3. UNCERTAIN
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mb-3">
                                            <div class="card bg-primary text-white shadow">
                                                <div class="card-body">
                                                    4. AGREE
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3 mb-3">
                                            <div class="card bg-success text-white shadow">
                                                <div class="card-body">
                                                    5. STRONGLY AGREE
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php
                        // Retrieve faculty_id and subject_id from URL parameters
                        if (isset($_GET['faculty_id']) && isset($_GET['subject_id'])) {
                            $faculty_id = $_GET['faculty_id'];
                            $subject_id = $_GET['subject_id'];

                            include '../assets/connection/connection.php';

                            // Retrieve faculty information
                            $sql = "SELECT firstname, lastname, photo FROM faculty_tbl WHERE faculty_id = $faculty_id ORDER BY faculty_id";
                            $result = mysqli_query($conn, $sql);

                            $count = mysqli_num_rows($result);

                            while ($faculty_row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                $firstname = $faculty_row["firstname"];
                                $lastname = $faculty_row["lastname"];
                                $photo = $faculty_row["photo"];

                                // Get Subject Name
                                $sql_subject = "SELECT subject_name, discription FROM subject_tbl WHERE subject_id = $subject_id";
                                $result_subject = mysqli_query($conn, $sql_subject);

                                while ($subject_row = mysqli_fetch_array($result_subject, MYSQLI_ASSOC)) {
                                    $subject_code = $subject_row["subject_name"];
                                    $subject_name = $subject_row["discription"];
                                }
                            }

                            mysqli_close($conn);
                        } else {
                            // Handle case when faculty_id or subject_id is not provided
                            echo "Error: Faculty ID or Subject ID not provided.";
                        }
                        ?>


                        <!-- Question Form -->
                        <div class="col-md-3 mb-3">
                            <div class="card border-1 shadow">
                                <img src="<?php echo $photo; ?>" class="card-img-top " alt="Faculty Photo">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0"><strong><?php echo $firstname . ' ' . $lastname; ?></strong></h5>
                                    <div class="card-text text-muted mb-3">
                                        <strong>Subject Code:</strong> <?php echo $subject_code; ?>
                                    </div>
                                    <p class="card-text"><?php echo $subject_name; ?></p>
                                </div>
                            </div>
                        </div>



                        <!-- Questionnaire -->
                        <div class="col-md-9">
                            <style>
                                /* Custom radio button style */
                                .custom-radio input[type="radio"] {
                                    display: none;
                                    /* Hide the default radio button */
                                }

                                .custom-radio label {
                                    display: inline-block;
                                    width: 20px;
                                    /* Set the width of the square */
                                    height: 20px;
                                    /* Set the height of the square */
                                    background-color: #fff;
                                    /* Set the background color */
                                    border: 1px solid #ccc;
                                    /* Add border for the square */
                                    cursor: pointer;
                                }

                                /* When the radio button is checked, change the background color */
                                .custom-radio input[type="radio"]:checked+label {
                                    background-color: #007bff;
                                    /* Change the background color */
                                }
                            </style>
                            <div class="col-md-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-primary">Questionnaire</h5>
                                        <form id="questionnaireForm" action="" method="POST">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th style="max-width: 550px; width: 600px;">Question</th>
                                                        <th>Strongly Disagree</th>
                                                        <th>Disagree</th>
                                                        <th>Uncertain</th>
                                                        <th>Agree</th>
                                                        <th>Strongly Agree</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                    include '../assets/connection/connection.php';
                                                    $sql = "SELECT question_id, question FROM questions_tbl ORDER BY question_id";
                                                    $result = mysqli_query($conn, $sql);
                                                    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                                        $primary_id = $row["question_id"];
                                                        $question = $row["question"];
                                                        echo "<tr>";
                                                        echo "<td>$question</td>"; // Display the question text
                                                        echo "<td data-label='Stongly Disagree'><input type='radio' name='question$primary_id' value='1' required></td>";
                                                        echo "<td data-label='Disagree'><input type='radio' name='question$primary_id' value='2'></td>";
                                                        echo "<td data-label='Uncertain'><input type='radio' name='question$primary_id' value='3'></td>";
                                                        echo "<td data-label='Agree'><input type='radio' name='question$primary_id' value='4'></td>";
                                                        echo "<td data-label='Strongly Agree'><input type='radio' name='question$primary_id' value='5'></td>";
                                                        echo "</tr>";
                                                    }
                                                    mysqli_close($conn);
                                                    ?>
                                                </tbody>
                                            </table>
                                            <div class="form-group">
                                                <label for="comment" class="label-question">Do you have any suggestions or opinions? Write your feedback.</label>
                                                <textarea id="comment" name="comment" class="form-control" rows="3" required></textarea>
                                            </div>
                                            <button type="submit" name="submitevaluation" class="btn btn-primary">Submit</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <?php
                            // Assuming session_start() is called earlier in your script if you're using $_SESSION

                            // Check if the form was submitted
                            if (isset($_POST['submitevaluation'])) {
                                include '../assets/connection/connection.php'; // Database connection

                                $comment = mysqli_real_escape_string($conn, $_POST["comment"]);
                                $student_id = $_SESSION['user_studuid'];
                                $faculty_id = $_GET['faculty_id'];
                                // Assuming $section_id and $subject_id are retrieved similarly

                                // Prepare an insert statement for feedback_tbl
                                $sql = "INSERT INTO feedback_tbl (answer, date, question, question_id, student_id, faculty_id, subject_id, evaluation_id) VALUES (?, CURDATE(), ?, ?, ?, ?, ?, 0)";

                                if ($stmt = mysqli_prepare($conn, $sql)) {
                                    // Iterate through each question
                                    $question_count = "SELECT question_id, question FROM questions_tbl ORDER BY question_id";
                                    $result = mysqli_query($conn, $question_count);

                                    if ($result) {
                                        while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                                            $question_id = $row["question_id"];
                                            $question = $row["question"];

                                            // Check if an answer was provided for this question
                                            if (isset($_POST["question$question_id"])) {
                                                $answer = $_POST["question$question_id"];
                                                mysqli_stmt_bind_param($stmt, 'ssiiii', $answer, $question, $question_id, $student_id, $faculty_id, $subject_id);

                                                mysqli_stmt_execute($stmt);
                                            } else {
                                                // Handle the case where no answer was provided for this question
                                                // e.g., skip or record it as unanswered in your database
                                            }
                                        }
                                    } else {
                                        echo "Error fetching questions: " . mysqli_error($conn);
                                        // handle the error or exit the script
                                        exit();
                                    }

                                    // Close statement
                                    mysqli_stmt_close($stmt);

                                    // Fetch current school year and semester
                                    $sql_sysem = "SELECT school_year, semester FROM active_tbl WHERE active_id='1'";
                                    $sysemres = mysqli_query($conn, $sql_sysem);
                                    if ($sysemres && mysqli_num_rows($sysemres) > 0) {
                                        while ($row = mysqli_fetch_array($sysemres, MYSQLI_ASSOC)) {
                                            $schoolyear = $row["school_year"];
                                            $semester = $row["semester"];
                                        }
                                    } else {
                                        echo "Error fetching school year and semester: " . mysqli_error($conn);
                                        // handle the error or exit the script
                                        exit();
                                    }

                                    // Calculate average rating
                                    $sql_avg = "SELECT ROUND(AVG(answer),1) AS rating_avg FROM feedback_tbl WHERE student_id = $student_id AND faculty_id = $faculty_id AND subject_id = $subject_id AND date = CURDATE()";
                                    $avgres = mysqli_query($conn, $sql_avg);
                                    if ($avgres && mysqli_num_rows($avgres) > 0) {
                                        while ($row = mysqli_fetch_array($avgres, MYSQLI_ASSOC)) {
                                            $rating_avg = $row["rating_avg"];
                                        }
                                    } else {
                                        echo "Error calculating average rating: " . mysqli_error($conn);
                                        // handle the error or exit the script
                                        exit();
                                    }

                                    // Submit the whole evaluation data to evaluation_tbl
                                    $sql2 = "INSERT INTO evaluation_tbl (rating_avg, comment, date, schoolyear, semester, student_id, faculty_id, subject_id) VALUES ('$rating_avg', '$comment', CURDATE(), '$schoolyear', '$semester', $student_id, $faculty_id, $subject_id)";
                                    if (mysqli_query($conn, $sql2)) {
                                        // Get ID of the latest inserted evaluation
                                        $evaluation_id = mysqli_insert_id($conn);

                                        // Update feedback_tbl with evaluation ID
                                        $update_feedback = "UPDATE feedback_tbl SET evaluation_id='$evaluation_id' WHERE student_id = $student_id AND faculty_id = $faculty_id AND subject_id = $subject_id AND date = CURDATE()";
                                        if (!mysqli_query($conn, $update_feedback)) {
                                            echo "Error updating feedback with evaluation ID: " . mysqli_error($conn);
                                            // handle the error or exit the script
                                            exit();
                                        }

                                        // Redirect or inform the user of successful submission
                                        echo "<script>alert('Thank you for your feedback!'); window.location.href='studentevaluation.php';</script>";
                                    } else {
                                        echo "Error submitting evaluation data: " . mysqli_error($conn);
                                        // handle the error or exit the script
                                        exit();
                                    }
                                } else {
                                    echo "Error preparing statement: " . mysqli_error($conn);
                                    // handle the error or exit the script
                                    exit();
                                }

                                // Close connection
                                mysqli_close($conn);
                            } else {
                                // Form not submitted
                            }
                            ?>

                            <!-- Content Row -->

                            <div class="row">

                                <!-- Area Chart -->
                                <div class="col-xl-8 col-lg-7">

                                </div>

                                <!-- Pie Chart -->

                            </div>

                            <!-- Content Row -->
                            <div class="row">

                                <!-- Content Column -->



                            </div>

                        </div>
                        <!-- /.container-fluid -->


                    </div>
                    <!-- End of Main Content -->

                    <!-- Footer -->

                    <!-- End of Footer -->

                </div>
                <!-- End of Content Wrapper -->

            </div>
            <!-- End of Page Wrapper -->

            <!-- Scroll to Top Button-->
            <a class="scroll-to-top rounded" href="#page-top">
                <i class="fas fa-angle-up"></i>
            </a>

            <!-- Logout Modal-->
            <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">×</span>
                            </button>
                        </div>
                        <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <a class="btn btn-primary" href="../logout.php">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal fade" id="Changepass" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header bg-primary text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Change Password</h5>
                            <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" action="../code/studentchange.php?source=evaluation">
                                <div class="form-group">
                                    <label for="currentPassword">Current Password</label>
                                    <input type="password" class="form-control" id="currentPassword" name="currentPassword" placeholder="Enter current password" required>
                                </div>
                                <div class="form-group row">
                                    <div class="col">
                                        <label for="newPassword">New Password</label>
                                        <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="Enter new password" required>
                                    </div>
                                    <div class="col">
                                        <label for="confirmPassword">Confirm New Password</label>
                                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" placeholder="Confirm new password" required>
                                        
                                    </div>
                                </div>

                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                            <button class="btn btn-primary" type="submit" name="changepass" value="changepass" id="changePasswordBtn">Change Password</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <?php
            // Check for messages from studentchange.php
            if (isset($_SESSION['message'])) {
                if ($_SESSION['message'] == "success") {
                    echo "<script>
                Swal.fire({
                  icon: 'success',
                  title: 'Password updated successfully',
                  showConfirmButton: false,
                  timer: 1500
                });
              </script>";
                } elseif ($_SESSION['message'] == "error") {
                    echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Error updating password',
                  text: '" . mysqli_error($conn) . "'
                });
              </script>";
                } elseif ($_SESSION['message'] == "incorrect_password") {
                    echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Incorrect old password',
                  showConfirmButton: false,
                  timer: 2000
                });
              </script>";
                } elseif ($_SESSION['message'] == "query_failed") {
                    echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Query failed',
                  text: '" . mysqli_error($conn) . "'
                });
              </script>";
                } elseif ($_SESSION['message'] == "password_mismatch") {
                    echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'New password & Confirm New Password do not match',
                  showConfirmButton: false,
                  timer: 2000
                });
              </script>";
                } elseif ($_SESSION['message'] == "user_not_found") {
                    echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'User ID not found in session',
                  showConfirmButton: false,
                  timer: 2000
                });
              </script>";
                } elseif ($_SESSION['message'] == "evaluation_message") {
                    echo "<script>
                Swal.fire({
                  icon: 'error',
                  title: 'Password change is not allowed while on the evaluation page',
                  showConfirmButton: false,
                  timer: 2000
                });
              </script>";
                }
                // Unset the session variable after displaying the message
                unset($_SESSION['message']);
            }
            ?>


            <!-- Bootstrap core JavaScript-->
            <script src="vendor/jquery/jquery.min.js"></script>
            <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

            <!-- Core plugin JavaScript-->
            <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

            <!-- Custom scripts for all pages-->
            <script src="js/sb-admin-2.min.js"></script>



</body>

</html>