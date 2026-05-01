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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <script src="sweetalert2.min.js"></script>
    <link rel="stylesheet" href="sweetalert2.min.css">
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

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Evaluation Dashboard</h1>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold fs-2 text-primary">Rating Legend </h5>
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
                                                    3. UNCERNTAIN
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

                        <div class="col-md-5">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title text-primary">Question Form</h5>
                                    <form action="../code/insert-question.php" method="POST">
                                        <div class="mb-3">
                                            <label for="commentTextArea" class="form-label"></label>
                                            <textarea class="form-control" id="commentTextArea" name="question" rows="3" placeholder="Insert question here." required></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" class="btn btn-success" name="insert_question" required>Insert Question</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-7">
                            <div class="card mb-4">
                                <div class="card-body">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th style="max-width: 300px;">Question</th>
                                                <th>Operation</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            include '../assets/connection/connection.php';

                                            // Pagination parameters
                                            $records_per_page = 5; // Number of records per page
                                            $current_page = isset($_GET['page']) ? $_GET['page'] : 1; // Current page number

                                            // Calculate the starting record index for the current page
                                            $start_from = ($current_page - 1) * $records_per_page;

                                            // Query to retrieve records for the current page
                                            $query = "SELECT * FROM questions_tbl LIMIT $start_from, $records_per_page";
                                            $query_run = mysqli_query($conn, $query);

                                            if (mysqli_num_rows($query_run) > 0) {
                                                foreach ($query_run as $row) {
                                            ?>
                                                    <tr>
                                                        <td class="text-break me-0" style="max-width: 300px;">
                                                            <?php echo $row['question']; ?>
                                                        </td>
                                                        <td width="150" style="max-width: 150px;">
                                                            <div class="row justify-content-center text-center mt-2 mb-2">
                                                                <div class="col-11 col-md-5">
                                                                    <button type="button" class="btn btn-success m-0 edit-question-btn" name="edit-question-btn" data-question-id="<?php echo $row['question_id']; ?>">
                                                                        <i class="fa fa-pencil-square" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                                <div class="col-11 col-md-5">
                                                                    <button type="button" class="btn btn-danger m-0 delete-question-btn" name="delete-question" value="<?= $row['question_id']; ?>" onclick="deletequestion(<?= $row['question_id']; ?>)">
                                                                        <i class="fa fa-trash" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>
                                            <?php
                                                }
                                            } else {
                                                echo "<tr><td colspan='3' class='text-center'>No questions found</td></tr>";
                                            }
                                            ?>
                                        </tbody>
                                    </table>
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
                                                    var response = JSON.parse(xhr.responseText);
                                                    if (response.status === 'success') {
                                                        // Show success message
                                                        Swal.fire({
                                                            title: 'Deleted!',
                                                            text: response.message,
                                                            icon: 'success'
                                                        }).then(() => {
                                                            // Reload the page after successful deletion
                                                            window.location.reload();
                                                        });
                                                    } else {
                                                        // Show error message
                                                        Swal.fire({
                                                            title: 'Error!',
                                                            text: response.message,
                                                            icon: 'error'
                                                        });
                                                    }
                                                } else {
                                                    // Show error message for AJAX request failure
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
                                        xhr.send('deletequestion=' + questionId); // Send the question ID as deletequestion parameter
                                    }
                                });
                            }
                        </script>


                        <!-- Include jQuery Library -->
                        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

                        <!-- JavaScript code for handling modal -->
                        <script>
                            jQuery(document).ready(function() {
                                jQuery('.edit-question-btn').click(function() {
                                    var questionId = jQuery(this).data('question-id');

                                    // Fetch question text using AJAX
                                    jQuery.ajax({
                                        type: "POST",
                                        url: "../code/get_question.php",
                                        data: {
                                            question_id: questionId
                                        },
                                        success: function(response) {
                                            // Populate textarea with fetched question text
                                            jQuery('#editedQuestion').val(response);
                                            // Pass question ID to the hidden input field
                                            jQuery('#question_id').val(questionId);
                                            // Show the modal
                                            jQuery('#editquestion').modal('show');
                                        },
                                        error: function() {
                                            alert('Error fetching question text');
                                        }
                                    });
                                });
                            });
                        </script>


                        <!-- Modal for editing question -->
                        <div class="modal fade" id="editquestion" tabindex="-1" role="dialog" aria-labelledby="editQuestionModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-header text-white" style="background-color: #00008B;">
                                        <h5 class="modal-title" id="editQuestionModalLabel">Edit Question</h5>
                                        <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                        <form id="editQuestionForm" action="./adminevaluation.php" method="post">
                                            <div class="form-group">
                                                <label for="editedQuestion">Question:</label>
                                                <textarea class="form-control" id="editedQuestion" name="editedQuestion" rows="5" required></textarea>
                                            </div>
                                            <input type="hidden" name="question_id" id="question_id" value="">
                                            <div class="text-right">
                                                <button type="submit" name="updatequestion" class="btn btn-primary">Update</button>
                                                <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php
                        // Include your database connection file
                        include '../assets/connection/connection.php';

                        if (isset($_POST['updatequestion'])) {
                            // Check if both question ID and updated question text are provided
                            if (isset($_POST['question_id'], $_POST['editedQuestion'])) {
                                $question_id = $_POST['question_id'];
                                $updated_question = $_POST['editedQuestion'];

                                // Prepare and execute the update query
                                $query = "UPDATE questions_tbl SET question = ? WHERE question_id = ?";
                                $stmt = mysqli_prepare($conn, $query);
                                mysqli_stmt_bind_param($stmt, "si", $updated_question, $question_id);
                                $success = mysqli_stmt_execute($stmt);

                                if ($success) {
                                    // If update is successful, display success message using SweetAlert2
                                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                                    echo '<script>
                    Swal.fire({
                        title: "Success!",
                        text: "Question updated successfully",
                        icon: "success",
                        confirmButtonText: "OK"
                    }).then(function() {
                        window.location = "./adminevaluation.php"; // Redirect to admin evaluation page
                    });
                  </script>';
                                } else {
                                    // If update fails, display error message using SweetAlert2
                                    echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                                    echo '<script>
                    Swal.fire({
                        title: "Error!",
                        text: "Failed to update question",
                        icon: "error",
                        confirmButtonText: "OK"
                    });
                  </script>';
                                }
                            } else {
                                // If question ID or updated question text is not provided, display an error message using SweetAlert2
                                echo "<script src='https://cdn.jsdelivr.net/npm/sweetalert2@10'></script>";
                                echo '<script>
                Swal.fire({
                    title: "Error!",
                    text: "Question ID or updated question text not provided",
                    icon: "error",
                    confirmButtonText: "OK"
                });
              </script>';
                            }
                        }
                        ?>



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
                        <!-- Scroll to Top Button-->
                        <a class="scroll-to-top rounded" href="#page-top">
                            <i class="fas fa-angle-up"></i>
                        </a>

                        <!-- Logout Modal-->

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
                        <script src="js/demo/chart-area-demo.js"></script>
                        <script src="js/demo/chart-pie-demo.js"></script>

</body>

</html>