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

    // Retrieve section information from the database
    $selectQuery1 = "SELECT * FROM section_tbl WHERE section_id = $section_id";
    $selectResult1 = mysqli_query($conn, $selectQuery1);

    // Check if the query executed successfully and if there is a matching record
    if ($selectResult1 && mysqli_num_rows($selectResult1) > 0) {
        // Fetch the data from the result set
        $sectionData = mysqli_fetch_assoc($selectResult1);

        // Function to check if the value is empty and return blank if true
        function formatValueSection($value)
        {
            return (!empty($value)) ? $value : '';
        }

        // Store the section data in variables
        $section_id = formatValueSection($sectionData['section_id']);
        $section_name = formatValueSection($sectionData['section_name']);
    } else {
        // If no data found, initialize all variables with empty values
        $section_id = '';
        $section_name = '';
    }

    // Retrieve course information from the database
    $selectQuery2 = "SELECT * FROM course_tbl WHERE course_id = $course_id";
    $selectResult2 = mysqli_query($conn, $selectQuery2);

    // Check if the query executed successfully and if there is a matching record
    if ($selectResult2 && mysqli_num_rows($selectResult2) > 0) {
        // Fetch the data from the result set
        $courseData = mysqli_fetch_assoc($selectResult2);

        // Function to check if the value is empty and return blank if true
        function formatValueCourse($value)
        {
            return (!empty($value)) ? $value : '';
        }

        // Store the course data in variables
        $course_id_result = formatValueCourse($courseData['course_id']);
        $course_name = formatValueCourse($courseData['course_name']);
        $description = formatValueCourse($courseData['discription']);
    } else {
        // If no data found, initialize all variables with empty values
        $course_id_result = '';
        $course_name = '';
        $description = '';
    }
    ?>

<style>
    #content-wrapper {
        overflow-y: auto; /* Enable vertical scrolling */
        max-height: calc(100vh - 56px); /* Adjust the maximum height to fit the viewport minus the height of the top bar */
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
                        <h1 class="h3 mb-0 text-gray-800">Dashboard Profile</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">

                        <!-- Profile Info -->
                        <style>
                            /* Custom CSS for profile card */
                            .profile-card {
                                border: none;
                                border-radius: 15px;
                                transition: all 0.3s ease;
                            }

                            .profile-image {
                                width: 350px;
                                height: 380px;
                                object-fit: cover;
                                position: relative;
                                border: 5px solid #fff;
                                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                            }

                            .profile-details p {
                                margin-bottom: 5px;
                            }

                            .card-body {
                                padding: 20px;
                            }

                            .card {
                                border: none;
                                border-radius: 15px;
                                transition: all 0.3s ease;
                            }

                            .card:hover {
                                transform: translateY(-5px);
                                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
                            }
                        </style>
                        <div class="col-lg-6 mb-4">
                            <div class="card shadow profile-card">
                                <div class="row no-gutters">
                                    <!-- Profile Image -->
                                    <div class="col-md-5">
                                        <img class="img-fluid  profile-image" src="<?php echo $photo; ?>" alt="Profile Picture">
                                    </div>
                                    <!-- Profile Information -->
                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <!-- Student Name -->
                                            <h2 class="text-primary"><?php echo $firstname . " " . $lastname; ?></h2>
                                            <!-- Student ID -->
                                            <p class="text-muted small mt-1">Student ID: <?php echo $student_id; ?></p>
                                            <!-- Divider -->
                                            <hr>
                                            <!-- Profile Details -->
                                            <div class="text-left profile-details">
                                                <!-- Email -->
                                                <p class="text-muted mb-2"><i class="fas fa-envelope mr-2"></i><?php echo $email; ?></p>
                                                <!-- Gender -->
                                                <p class="text-muted mb-2"><i class="fas fa-venus-mars mr-2"></i><?php echo $gender; ?></p>
                                                <!-- Year Level -->
                                                <p class="text-muted mb-2"><i class="fas fa-graduation-cap mr-2"></i><?php echo $yearlevel; ?></p>
                                                <!-- Course -->
                                                <p class="text-muted mb-2"><i class="fas fa-book mr-2"></i><?php echo $description; ?></p>
                                                <!-- Section -->
                                                <p class="text-muted mb-2"><i class="fas fa-users mr-2"></i><?php echo $section_name; ?></p>
                                                <!-- Status -->
                                                <p class="text-muted mb-0"><i class="fas fa-info-circle mr-2"></i>Status: <?php echo $status; ?></p>
                                            </div>
                                        </div>
                                    </div>  
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-2 text-primary ml-3"><b>Subjects Information</b></h5>
                                    <div class="col-md-12">
                                        <div class="card mb-4">
                                            <div class="card-body">

                                                <div class="row align-items-center">
                                                                   
                                                </div>
                                                <?php
                                                include '../assets/connection/connection.php';

                                                // Pagination parameters
                                                $records_per_page = 5; // Number of records per page
                                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

                                                // Calculate the starting record index for the current page
                                                $start_from = ($current_page - 1) * $records_per_page;

                                                // Query to retrieve records for the current page
                                                $query = "SELECT * FROM course_tbl LIMIT $start_from, $records_per_page";
                                                $query_run = mysqli_query($conn, $query);
                                                ?>

                                                <?php


                                                include '../assets/connection/connection.php';

                                                // Check if section ID is provided and valid
                                                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                                                    $section_id = $_GET['id']; // Store section ID
                                                    // Debugging: Echo out section ID to verify its value

                                                } else {
                                                    $errorMessage = "Invalid or missing section ID.";
                                                }

                                                // Display the table
                                                ?>
                                                <table class="table table-bordered table-striped table-no-border" style="margin-top: 10px; width: 100%;">
                                                    <thead>
                                                        <tr style="color: black; border-radius: 100px;">
                                                            <th style="width: 5%; text-align: center;">ID</th>
                                                            <th style="width: 10%; text-align: center;">Subject Code</th>
                                                            <th style="width: 10%; text-align: center;">Description</th>
                                                            <th style="width: 10%; text-align: center;">Faculty</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="outputsubsec">
                                                        <?php
                                                        if (isset($section_id)) {
                                                            showSectionsRelation($section_id); // Call the function to populate table rows with subject-faculty relations
                                                        } else {
                                                            echo "<tr><td colspan='6' class='text-center'>Section ID not provided.</td></tr>";
                                                        }
                                                        ?>
                                                    </tbody>
                                                </table>
                                                <?php
                                                function showSectionsRelation($section_id)
                                                {
                                                    include '../assets/connection/connection.php';

                                                    $sql = "SELECT subsec_id, subject_id, faculty_id FROM subsection_tbl WHERE section_id = $section_id ORDER BY subsec_id";
                                                    $result = mysqli_query($conn, $sql);

                                                    if ($result) {
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            $subsec_id = $row['subsec_id'];
                                                            $subject_id = $row['subject_id'];
                                                            $faculty_id = $row['faculty_id'];

                                                            // Get Subject details
                                                            $subject_query = "SELECT subject_name, discription FROM subject_tbl WHERE subject_id = $subject_id";
                                                            $subject_result = mysqli_query($conn, $subject_query);
                                                            if ($subject_result && mysqli_num_rows($subject_result) > 0) {
                                                                $subject_row = mysqli_fetch_assoc($subject_result);
                                                                $subject_name = $subject_row['subject_name'];
                                                                $discription = $subject_row['discription'];
                                                            } else {
                                                                $subject_name = "N/A";
                                                                $discription = "N/A";
                                                            }

                                                            // Get Faculty details
                                                            $faculty_query = "SELECT firstname, lastname FROM faculty_tbl WHERE faculty_id = $faculty_id";
                                                            $faculty_result = mysqli_query($conn, $faculty_query);
                                                            if ($faculty_result && mysqli_num_rows($faculty_result) > 0) {
                                                                $faculty_row = mysqli_fetch_assoc($faculty_result);
                                                                $faculty_name = $faculty_row['lastname'] . ' ' . $faculty_row['firstname'];
                                                            } else {
                                                                $faculty_name = "N/A";
                                                            }

                                                            echo "
                                                            <tr>
                                                                <td style='text-align: center;'>$subsec_id</td>
                                                                <td style='text-align: center;'>$subject_name</td>
                                                                <td style='text-align: center;'>$discription</td>
                                                                <td style='text-align: center;'>$faculty_name</td>
                                                               
                                                               
                                                            </tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                }

                                                ?>
                                                <!-- Pagination links -->
                                                <!-- Pagination links -->
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <ul class="pagination justify-content-center">
                                                            <?php
                                                            $total_records_query = "SELECT COUNT(*) AS total_records FROM subsection_tbl WHERE section_id = $section_id"; // Count total records for the specific section
                                                            $total_records_result = mysqli_query($conn, $total_records_query);
                                                            $total_records = mysqli_fetch_assoc($total_records_result)['total_records'];
                                                            $total_pages = ceil($total_records / $records_per_page);

                                                            // Previous page link
                                                            if ($current_page > 1) {
                                                                echo '<li class="page-item"><a class="page-link" href="?id=' . $section_id . '&page=' . ($current_page - 1) . '">Previous</a></li>';
                                                            }

                                                            // Page numbers
                                                            for ($i = 1; $i <= $total_pages; $i++) {
                                                                echo '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '"><a class="page-link" href="?id=' . $section_id . '&page=' . $i . '">' . $i . '</a></li>';
                                                            }

                                                            // Next page link
                                                            if ($current_page < $total_pages) {
                                                                echo '<li class="page-item"><a class="page-link" href="?id=' . $section_id . '&page=' . ($current_page + 1) . '">Next</a></li>';
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                   
                                    <!-- to get course id validation-->
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                                   
                                    <?php
                                    if (isset($_SESSION['error_message'])) {
                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                        <script>
                                            Swal.fire({
                                                title: 'Error!',
                                                text: '<?php echo $_SESSION['error_message']; ?>',
                                                icon: 'error',
                                                confirmButtonText: 'OK'
                                            });
                                        </script>
                                    <?php
                                        unset($_SESSION['error_message']); // Clear the session variable
                                    }

                                    // Display success message if exists
                                    if (isset($_SESSION['success_message'])) {
                                    ?>
                                        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                                        <script>
                                            Swal.fire({
                                                title: 'Success!',
                                                text: '<?php echo $_SESSION['success_message']; ?>',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            });
                                        </script>
                                    <?php
                                        unset($_SESSION['success_message']); // Clear the session variable
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>




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
                        <form method="post" action="../code/studentchange.php?source=profile" >
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
                                    <?php echo "User ID: " . $userID;

                                    ?>
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