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
    <link href="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.min.js" rel=" stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" rel=" stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/boxicons@latest/css/boxicons.min.css">
    <!-- or -->
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link href="../start/js/chartmaker.js" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">
    <?php
    session_start();
    $userID = $_SESSION['user_id'];

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_role'])) {
        header('location:../index.php');
        exit();
    } else {
    }

    if (!isset($_SESSION['admin_id']) && !isset($_SESSION['admin_role']) && $_SESSION['admin_role'] !== 'Admin') {
        header('location:../index.php');
        exit();
    } else {
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
    <style>
        #content-wrapper {
            overflow-y: auto;
            /* Enable vertical scrolling */
            max-height: calc(100vh - 56px);
            /* Adjust the maximum height to fit the viewport minus the height of the top bar */
        }
    </style>
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
                <nav class="navbar navbar-expand navbar-light bg-light topbar mb-4 static-top shadow">

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

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Questionaire </h1>
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
                        <div class="col-md-3 mb-3">
                            <div class="card border-1 shadow">
                                <div class="card-body text-center">
                                    <h5 class="card-title mb-0">
                                        <strong>Submit a Question</strong>
                                    </h5>
                                    <div class="card-text text-muted mb-3">
                                        Please enter your question below:
                                    </div>
                                    <form method="post" action="" enctype="multipart/form-data">
                                        <div class="form-group">
                                            <textarea class="form-control" name="question" id="questionTextarea" rows="3" placeholder="Enter your question"></textarea>
                                        </div>
                                        <button type="submit" name="submitquestion" class="btn btn-primary" style="width: 200px;">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <?php
                        @include '../assets/connection/connection.php';

                        if (isset($_POST["submitquestion"]) && !empty($_POST["question"])) {
                            $status_query = "SELECT status FROM active_tbl";
                            $status_result = mysqli_query($conn, $status_query);

                            if ($status_result) {
                                $row = mysqli_fetch_assoc($status_result);
                                $status = $row['status'];

                                if ($status === 'In Progress') {
                                    $errorMessage = "Cannot add question. Status is 'In Progress'.";
                                    echo "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>";
                                    echo "<script>";
                                    echo "Swal.fire({";
                                    echo "icon: 'error',";
                                    echo "title: 'Oops...',";
                                    echo "text: '" . $errorMessage . "',";
                                    echo "position: 'top',";
                                    echo "showConfirmButton: false,";
                                    echo "timer: 1500";
                                    echo "});";
                                    echo "</script>";
                                } elseif ($status === 'Finished') {
                                    $question = $_POST["question"];
                                    $sql = "INSERT INTO questions_tbl (question) VALUES ('$question')";
                                    if (mysqli_query($conn, $sql)) {
                                        $lastInsertedId = mysqli_insert_id($conn);
                                        $successMessage = "Your question has been submitted successfully!";
                                        echo "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>";
                                        echo "<script>";
                                        echo "Swal.fire({";
                                        echo "icon: 'success',";
                                        echo "title: 'Success!',";
                                        echo "text: '" . $successMessage . "',";
                                        echo "position: 'top',";
                                        echo "showConfirmButton: false,";
                                        echo "timer: 1500";
                                        echo "}).then(() => {";
                                        echo "window.location.href = 'adminquestion.php';";
                                        echo "});";
                                        echo "</script>";
                                    } else {
                                        $errorMessage = "Something went wrong! Please try again later.";
                                        echo "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>";
                                        echo "<script>";
                                        echo "Swal.fire({";
                                        echo "icon: 'error',";
                                        echo "title: 'Oops...',";
                                        echo "text: '" . $errorMessage . "',";
                                        echo "position: 'top',";
                                        echo "showConfirmButton: false,";
                                        echo "timer: 1500";
                                        echo "});";
                                        echo "</script>";
                                    }
                                } else {
                                    $errorMessage = "Status is not recognized.";
                                    echo "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>";
                                    echo "<script>";
                                    echo "Swal.fire({";
                                    echo "icon: 'error',";
                                    echo "title: 'Oops...',";
                                    echo "text: '" . $errorMessage . "',";
                                    echo "position: 'top',";
                                    echo "showConfirmButton: false,";
                                    echo "timer: 1500";
                                    echo "});";
                                    echo "</script>";
                                }
                            } else {
                                $errorMessage = "Error retrieving status.";
                                echo "<script src=\"https://cdn.jsdelivr.net/npm/sweetalert2@11\"></script>";
                                echo "<script>";
                                echo "Swal.fire({";
                                echo "icon: 'error',";
                                echo "title: 'Oops...',";
                                echo "text: '" . $errorMessage . "',";
                                echo "position: 'top',";
                                echo "showConfirmButton: false,";
                                echo "timer: 1500";
                                echo "});";
                                echo "</script>";
                            }
                        }

                        ?>






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
                                        <table class="table table-bordered table-striped table-no-border" style="margin-top: 10px; width: 100%;">
                                            <thead>
                                                <tr style="color: black; border-radius: 100px;">
                                                    <th style="width: 15%; text-align: center;">ID</th>
                                                    <th style="width: 70%; text-align: center;">Question</th>
                                                    <th style="width: 15%; text-align: center;">Actions</th> <!-- New column for actions -->
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                include '../assets/connection/connection.php';

                                                // Pagination parameters
                                                $records_per_page = 6; // Number of records per page
                                                $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

                                                // Calculate the starting record index for the current page
                                                $start_from = ($current_page - 1) * $records_per_page;

                                                // Query to retrieve records for the current page
                                                $query = "SELECT * FROM questions_tbl LIMIT $start_from, $records_per_page";
                                                $query_run = mysqli_query($conn, $query);

                                                if (mysqli_num_rows($query_run) > 0) {
                                                    while ($row = mysqli_fetch_assoc($query_run)) {
                                                        // Output the table row for the question
                                                        echo "<tr>";
                                                        echo "<td style='text-align: center;'>{$row['question_id']}</td>";
                                                        echo "<td style='text-align: left;'>{$row['question']}</td>";
                                                        // Add delete button with onclick event to call JavaScript function
                                                        echo "<td style='text-align: center;'>";
                                                        echo "<button type='button' class='btn btn-danger btn-sm' onclick='deletequestion({$row['question_id']})'>";
                                                        echo "<i class='bx bx-trash'></i> Delete <!-- Delete icon -->";
                                                        echo "</button>";
                                                        echo "</td>";
                                                        echo "</tr>";
                                                    }
                                                } else {
                                                    echo "<tr><td colspan='3' class='text-center'>No records found.</td></tr>";
                                                }
                                                ?>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <ul class="pagination justify-content-center">
                                                <?php
                                                $total_records_query = "SELECT COUNT(*) AS total_records FROM questions_tbl";
                                                $total_records_result = mysqli_query($conn, $total_records_query);
                                                $total_records = mysqli_fetch_assoc($total_records_result)['total_records'];
                                                $total_pages = ceil($total_records / $records_per_page);

                                                // Previous page link
                                                if ($current_page > 1) {
                                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page - 1) . '">Previous</a></li>';
                                                }

                                                // Page numbers
                                                for ($i = 1; $i <= $total_pages; $i++) {
                                                    echo '<li class="page-item ' . ($current_page == $i ? 'active' : '') . '"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
                                                }

                                                // Next page link
                                                if ($current_page < $total_pages) {
                                                    echo '<li class="page-item"><a class="page-link" href="?page=' . ($current_page + 1) . '">Next</a></li>';
                                                }
                                                ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
                            <script>
                                function deletequestion(questionId) {
                                    // Display SweetAlert2 confirmation dialog
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: 'You are about to delete this question.',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, delete it!'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            // Send AJAX request to delete_question.php
                                            var xhr = new XMLHttpRequest();
                                            xhr.onreadystatechange = function() {
                                                if (xhr.readyState === XMLHttpRequest.DONE) {
                                                    if (xhr.status === 200) {
                                                        // Check the response from the server
                                                        var response = xhr.responseText;
                                                        if (response === 'success') {
                                                            // Show success message
                                                            Swal.fire({
                                                                title: 'Deleted!',
                                                                text: 'The question has been deleted.',
                                                                icon: 'success'
                                                            }).then(() => {
                                                                // Reload the page after successful deletion
                                                                window.location.reload();
                                                            });
                                                        } else {
                                                            // Show error message
                                                            Swal.fire({
                                                                title: 'Error!',
                                                                text: response, // Display the error message received from the server
                                                                icon: 'error'
                                                            });
                                                        }
                                                    } else {
                                                        // Show error message if status is not 200
                                                        Swal.fire({
                                                            title: 'Error!',
                                                            text: 'Failed to delete the question. Please try again later.',
                                                            icon: 'error'
                                                        });
                                                    }
                                                }
                                            };
                                            xhr.open('POST', '../code/delete_question.php', true);
                                            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                                            xhr.send('questionId=' + questionId);
                                        }
                                    });
                                }
                            </script>





                            <!-- Pagination links -->

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
            </div>
            <!-- End of Main Content -->

            <!-- Footer -->

            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->
    <div class="modal fade" id="addStudentModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background-color: #00008B;">
                    <h5 class="modal-title text-white" id="exampleModalLabel"><i class='bx bx-id-card'></i> Add Student ID</h5>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="../code/add_accessid.php" id="addStudentForm">
                        <div class="form-group">
                            <label for="studentId">Student ID <i class='bx bx-user'></i></label>
                            <input type="text" class="form-control" id="studentId" name="studentId" required placeholder="Enter student ID" onkeypress="return isNumber(event)">
                        </div>
                        <div class="text-right">
                            <button type="submit" name="add-accessid" class="btn btn-primary"><i class='bx bx-plus'></i> Add</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function isNumber(evt) {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) {
                return false;
            }
            return true;
        }
    </script>

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
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->

</body>

</html>