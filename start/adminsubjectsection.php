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
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php
    session_start();

    include '../assets/connection/connection.php';

    $userID = $_SESSION['user_id'];

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_role'])) {
        header('location:../index.php');
        exit();
    } elseif (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_role']) && $_SESSION['admin_role'] !== 'Admin') {
        header('location:../index.php');
        exit();
    }

    if (isset($_SESSION['success_msg'])) {
        $success_msg = $_SESSION['success_msg'];
        unset($_SESSION['success_msg']);
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

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        if (!isset($_SESSION['section_id'])) {
            $sectionInfo = getSectionInfo($conn, $_GET['id']);
            if ($sectionInfo) {
                $_SESSION['section_id'] = $sectionInfo['section_id']; // Store section ID in session if not already set
                $id = $sectionInfo['section_id'];
                $sectionname = $sectionInfo['section_name'];
            } else {
                $errorMessage = "No records found for the provided section ID.";
            }
        }
    } else {
        $errorMessage = "Invalid or missing section ID.";
    }
    // Function to retrieve section information
    function getSectionInfo($conn, $id)
    {
        $id = mysqli_real_escape_string($conn, $id);
        $sql = "SELECT * FROM section_tbl WHERE section_id = '$id'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }



    // Check if section ID is provided and valid
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $sectionInfo = getSectionInfo($conn, $_GET['id']);
        if ($sectionInfo) {
            $_SESSION['section_id'] = $sectionInfo['section_id']; // Store section ID in session
            $id = $sectionInfo['section_id'];
            $sectionname = $sectionInfo['section_name'];
        } else {
            $errorMessage = "No records found for the provided section ID.";
        }
    } else {
        $errorMessage = "Invalid or missing section ID.";
    }
    ?>
    <?php
    include '../assets/connection/connection.php';

    if (isset($_POST['addsubsec'])) {
        if (!empty($_POST['subject']) && !empty($_POST['faculty'])) {
            if (isset($_SESSION['section_id'])) {
                $section_id = $_SESSION['section_id'];
                $subject_id = mysqli_real_escape_string($conn, $_POST['subject']);
                $faculty_id = mysqli_real_escape_string($conn, $_POST['faculty']);

                // Check if the subject_id is already assigned to this section
                $subject_check_query = "SELECT * FROM subsection_tbl WHERE section_id = '$section_id' AND subject_id = '$subject_id'";
                $subject_check_result = mysqli_query($conn, $subject_check_query);

                // Check if the faculty_id is already assigned to this section
                $faculty_check_query = "SELECT * FROM subsection_tbl WHERE section_id = '$section_id' AND faculty_id = '$faculty_id'";
                $faculty_check_result = mysqli_query($conn, $faculty_check_query);

                if (mysqli_num_rows($subject_check_result) > 0) {
                    $error_message = "This subject is already assigned to this section.";
                } elseif (mysqli_num_rows($faculty_check_result) > 0) {
                    $error_message = "This faculty is already assigned to this section.";
                } else {
                    // Proceed with the insertion
                    $sql = "INSERT INTO subsection_tbl (subsec_id, section_id, subject_id, faculty_id) VALUES (null, '$section_id', '$subject_id', '$faculty_id')";
                    if (mysqli_query($conn, $sql)) {
                        $_SESSION['success_message'] = "Subject added successfully!";
                        header("Location: ../start/adminsubjectsection.php?id=$section_id");
                        exit();
                    } else {
                        $error_message = "Error: " . mysqli_error($conn);
                    }
                }
            } else {
                $error_message = "Session section ID not set.";
            }
        } else {
            $error_message = "Please select both subject and faculty.";
        }

        // Use SweetAlert2 for displaying the error message
        if (isset($error_message)) {
    ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
            <script>
                Swal.fire({
                    title: 'Error!',
                    text: '<?php echo $error_message; ?>',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>
    <?php
        }
    }
    ?>





    <!-- Display error messages -->
    <?php if (isset($errorMessage)) { ?>
        <div><?php echo $errorMessage; ?></div>
    <?php } ?>

    <?php include '../assets/connection/connection.php'; ?>

    <!-- Check if section ID is provided and valid -->
    <?php
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $sectionInfo = getSectionInfo($conn, $_GET['id']);
        if ($sectionInfo) {
            $_SESSION['section_id'] = $sectionInfo['section_id']; // Store section ID in session
            $id = $sectionInfo['section_id'];
            $sectionname = $sectionInfo['section_name'];

            // Retrieve the count of enrolled students for the current section
            $countQuery = "SELECT COUNT(*) AS total_students FROM student_tbl WHERE section_id = '$id'";
            $countResult = mysqli_query($conn, $countQuery);
            if ($countResult) {
                $rowCount = mysqli_fetch_assoc($countResult);
                $totalStudents = $rowCount['total_students'];
            } else {
                // Handle error if count retrieval fails
                $totalStudents = 'Error fetching student count';
            }
        } else {
            $errorMessage = "No records found for the provided section ID.";
        }
    } else {
        $errorMessage = "Invalid or missing section ID.";
    }
    ?>
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
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="admindashboard.php">
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
                <a class="nav-link" href="../start/admindashboard.php">
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
                <a class="nav-link" href="admincourse.php">
                    <i class="fas fa-fw fa fa-book"></i>
                    <span>Course</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminsubject.php">
                    <i class="fas fa-fw fas fa-clipboard"></i>
                    <span>Subject</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminsection.php">
                    <i class="fas fa-fw fa fa-folder"></i>
                    <span>Section</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminfaculty.php">
                    <i class="fas fa-fw fa fa-graduation-cap"></i>
                    <span>Faculty</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminstudents.php">
                    <i class="fas fa-fw fa fa-graduation-cap"></i>
                    <span>Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminquestion.php">
                    <i class="bx bxs-food-menu"></i>
                    <span>Questionaire</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminevalstatus.php">
                    <i class="bx bxs-food-menu"></i>
                    <span>Evaluation Status</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="adminautorize.php">
                    <i class="bx bxs-lock"></i>
                    <span>Access Control</span>
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"> <?php
                                                                                            if (isset($_SESSION['admin_role'])) {
                                                                                                $userName = $_SESSION['admin_role'];
                                                                                                echo 'Welcome, ' . $userName . '!';
                                                                                            }
                                                                                            ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="index.php" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <?php
                if (isset($_SESSION['section_id'])) {
                    // Retrieve section ID from session
                    $section_id = $_SESSION['section_id'];
                    // Optionally, you can use this section_id for any processing you need here
                } else {
                    // Handle the case when section ID is not set
                }

                ?>
                <!-- Include jQuery Library -->
                <div class="modal fade" id="addSUBSECModal" tabindex="-1" role="dialog" aria-labelledby="addSUBSECModalTitle" aria-hidden="true">
                    <div class="modal-dialog modal-md" role="document">
                        <div class="modal-content">
                            <div class="modal-header text-white" style="background-color: #00008B;">
                                <h5 class="modal-title" id="addSUBSECModalLabel">Add Subject</h5>
                                <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" action="" id="subsecForm">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="subject">Subject:</label>
                                                <select class="form-control" id="subject" name="subject">
                                                    <option value="">Select Subject</option>
                                                    <?php
                                                    include '../assets/connection/connection.php';
                                                    $query = "SELECT * FROM Subject_tbl";
                                                    $result = mysqli_query($conn, $query);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        echo '<option value="' . $row['subject_id'] . '">' . $row['discription'] . '</option>';
                                                    }
                                                    mysqli_free_result($result);
                                                    mysqli_close($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="faculty">Faculty:</label>
                                                <select class="form-control" id="faculty" name="faculty">
                                                    <option value="">Select Faculty</option>
                                                    <?php
                                                    include '../assets/connection/connection.php';
                                                    $query = "SELECT * FROM faculty_tbl";
                                                    $result = mysqli_query($conn, $query);
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $fullname = $row['firstname'] . ' ' . $row['lastname'];
                                                        echo '<option value="' . $row['faculty_id'] . '">' . $fullname . '</option>';
                                                    }
                                                    mysqli_free_result($result);
                                                    mysqli_close($conn);
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Hidden input field for section_id -->
                                    <input type="hidden" name="section_id" value="<?php echo isset($_SESSION['section_id']) ? $_SESSION['section_id'] : ''; ?>">

                                    <div class="text-right">
                                        <button type="submit" class="btn btn-primary" name="addsubsec">Add</button>
                                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="container-fluid">

                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Section/Subject Dashboard</h1>
                    </div>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-2 text-primary"><b>Information</b></h5>

                                    <div class="mb-3">
                                        <label for="id" class="form-label">ID Information</label>
                                        <!-- Display section_id here -->
                                        <input type="hidden" name="section_id" value="<?php echo isset($_SESSION['section_id']) ? $_SESSION['section_id'] : ''; ?>">

                                        <input type="text" class="form-control" id="id" value="<?php echo $id; ?>" readonly style="width: 200px;">
                                    </div>

                                    <div class="mb-3">
                                        <label for="sectionName" class="form-label">Section Name</label>
                                        <!-- Display section_name here -->
                                        <input type="text" class="form-control" id="sectionName" value="<?php echo $sectionname; ?>" readonly style="width: 200px;">
                                    </div>

                                    <div class="mb-3">
                                        <label for="student" class="form-label">Student enrolled</label>
                                        <!-- Input field for student -->
                                        <input type="text" class="form-control" id="student" value="<?php echo isset($totalStudents) ? $totalStudents : 'N/A'; ?>" readonly style="width: 200px;">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-10">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-2 text-primary ml-3"><b>Subjects</b></h5>
                                    <div class="col-md-12">
                                        <div class="card mb-4">
                                            <div class="card-body">

                                                <div class="row align-items-center">
                                                    <div class="col-md-3">
                                                        <div class="input-group">
                                                            <div class="input-group-append">
                                                                <span class="input-group-text"><i class='bx bx-search' style="height: 24px;"></i></span>
                                                            </div>
                                                            <input type="text" class="form-control" id="search-Input" name="search" placeholder="Search">
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#addSUBSECModal">
                                                            <i class="bx bxs-user-plus" style="border-radius: 100px;"></i> Add Subject
                                                        </button>
                                                    </div>
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
                                                            <th style="width: 10%; text-align: center;">Faculty ID</th>
                                                            <th style="width: 10%; text-align: center;">Action</th>
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
                                                                <td style='text-align: center;'>$faculty_id</td>
                                                                <td style='text-align: center;'>
                                                                    <a href='#' onclick='deletesubsec($subsec_id);'>
                                                                        <button class='btn btn-danger btn-sm' ><i class='bx bx-trash'> Delete</i></button>
                                                                    </a>
                                                                </td>
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
                                    <style>
                                        .search-results {
                                            max-height: 0;
                                            overflow: hidden;
                                            transition: max-height 0.3s ease-in-out;
                                            /* Smooth transition */
                                        }
                                    </style>
                                    <script>
                                        document.getElementById('search-Input').addEventListener('input', function() {
                                            const searchInputValue = this.value.trim();
                                            const sectionId = <?php echo isset($section_id) ? $section_id : 'null'; ?>; // Get the section ID

                                            // Send an AJAX request to the backend PHP script with the search query and section ID
                                            const xhr = new XMLHttpRequest();
                                            xhr.onreadystatechange = function() {
                                                if (xhr.readyState == 4 && xhr.status == 200) {
                                                    // Update the table body with the search results
                                                    const outputsubsec = document.getElementById('outputsubsec');
                                                    outputsubsec.style.opacity = '0'; // Set opacity to 0 for smooth fade out
                                                    outputsubsec.style.pointerEvents = 'none'; // Disable pointer events during transition

                                                    setTimeout(() => {
                                                        outputsubsec.innerHTML = xhr.responseText;
                                                        outputsubsec.style.opacity = '1'; // Set opacity to 1 for smooth fade in
                                                        outputsubsec.style.pointerEvents = 'auto'; // Enable pointer events after transition
                                                    }, 300); // Adjust the delay as needed for smoother animation
                                                }
                                            };
                                            xhr.open('POST', '../code/search_subsec.php', true);
                                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                            xhr.send('subsecName=' + searchInputValue + '&section_id=' + sectionId); // Pass the section ID
                                        });
                                    </script>
                                    <!-- to get course id validation-->
                                    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

                                    <script>
                                        function deletesubsec(subsecId) {
                                            // Display SweetAlert2 confirmation dialog
                                            Swal.fire({
                                                title: 'Are you sure?',
                                                text: 'You are about to delete this Subject.',
                                                icon: 'warning',
                                                showCancelButton: true,
                                                confirmButtonColor: '#3085d6',
                                                cancelButtonColor: '#d33',
                                                confirmButtonText: 'Yes, delete it!'
                                            }).then((result) => {
                                                if (result.isConfirmed) {
                                                    // Send AJAX request to delete_course.php
                                                    var xhr = new XMLHttpRequest();
                                                    xhr.onreadystatechange = function() {
                                                        if (xhr.readyState === XMLHttpRequest.DONE) {
                                                            if (xhr.status === 200) {
                                                                // Show success message
                                                                Swal.fire({
                                                                    title: 'Deleted!',
                                                                    text: 'The Subject has been deleted.',
                                                                    icon: 'success'
                                                                }).then(() => {
                                                                    // Reload the page after successful deletion
                                                                    window.location.reload();
                                                                });
                                                            } else {
                                                                // Show error message
                                                                Swal.fire({
                                                                    title: 'Error!',
                                                                    text: 'Failed to delete the Subject. Please try again later.',
                                                                    icon: 'error'
                                                                });
                                                            }
                                                        }
                                                    };
                                                    xhr.open('POST', '../code/delete_subsec.php', true);
                                                    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                                    xhr.send('subsec_id=' + subsecId);
                                                }
                                            });
                                        }
                                    </script>
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
                    </div>
                    <!-- Content Row -->
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
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>


</body>

</html>