<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    $_SESSION['error'] = "Please login to access admin panel";
    header('Location: login.php');
    exit();
}

// Uncomment these lines when you have proper admin authentication
/*
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: admin_login.php');
    exit;
}
*/

include_once 'php/db.php'; // Include your database connection file

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer classes
require 'C:\xampp\htdocs\internship_portal\vendor\phpmailer\phpmailer\src\Exception.php';
require 'C:\xampp\htdocs\internship_portal\vendor\phpmailer\phpmailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\internship_portal\vendor\phpmailer\phpmailer\src\SMTP.php';

// Handle deletion of an application
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $sql = "DELETE FROM job_applications WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        echo "Application deleted successfully.";
    } else {
        echo "Error deleting application: " . $conn->error;
    }
}

// Handle selection or rejection of an application
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    $action = $_GET['action'];

    // Check if this action was already performed
    $action_key = $action . '_' . $id;
    if (!isset($_SESSION['completed_actions']) || !in_array($action_key, $_SESSION['completed_actions'])) {
        if ($action === 'select') {
            // Update the status of the application to "Selected"
            $sql = "UPDATE job_applications SET status='Selected' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                // Fetch the applicant's email
                $emailQuery = "SELECT email, full_name FROM job_applications WHERE id=$id";
                $emailResult = $conn->query($emailQuery);
                if ($emailResult->num_rows > 0) {
                    $applicant = $emailResult->fetch_assoc();
                    $to = $applicant['email'];
                    $fullName = $applicant['full_name'];

                    // Create a new PHPMailer instance
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->isSMTP();                                            // Send using SMTP
                        $mail->Host       = 'smtp.gmail.com';                     // Set the SMTP server to send through
                        $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
                        $mail->Username   = 'sandunisathyangani3@gmail.com';      // Your Gmail address
                        $mail->Password   = 'akcg givl dmmn uasd';                   // Your App Password (if 2FA is enabled)
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;      // Enable TLS encryption
                        $mail->Port       = 587;                                   // TCP port to connect to

                        // Recipients
                        $mail->setFrom('sandunisathyangani3@gmail.com', 'SLTMobitel');
                        $mail->addAddress($to, $fullName);                        // Add a recipient

                        // Content
                        $mail->isHTML(true); // Set email format to HTML
                        $mail->Subject = 'Software Internship - SLT Digital Platform';
                        $mail->Body    = "
                            <p>Dear $fullName,</p>
                            <p>Congratulations on being selected as a software intern at SLT!</p>
                            <p>Kindly visit SLT at your earliest convenience and ensure you bring the following documents with you:</p>
                            <ul>
                                <li>CV</li>
                                <li>University Letter</li>
                                <li>Police report</li>
                                <li>Signed trainee Guideline document</li>
                                <li>Photocopy of NIC</li>
                            </ul>
                            <p>Please upload your police report using the following link:</p>
                            <p><a href='http://localhost/project/php/policereport.php?id=$id'>Upload Police Report</a></p>
                            <p>Please read the trainee guidelines carefully. If you agree with the terms, proceed with applying for the internship.</p>
                            <p>Best regards,<br>The Team</p>
                        ";
                        $mail->AltBody = "Dear $fullName,\n\nCongratulations on being selected as a software intern at SLT!\n\n
                        Kindly visit SLT at your earliest convenience and ensure you bring the following documents with you:\n\n
                        (1) CV\n(2) University Letter\n(3) Police report\n(4) Signed trainee Guideline document\n
                        (5) Photocopy of NIC\n\n
                        Please upload your police report using the following link: http://localhost/project/php/policereport.php?id=$id\n\n
                        Please read the trainee guidelines carefully. If you agree with the terms, proceed with applying for the internship.\n\n
                        Best regards,\nThe Team";

                        $mail->send();

                        // After successful email send
                        if (!isset($_SESSION['completed_actions'])) {
                            $_SESSION['completed_actions'] = array();
                        }
                        $_SESSION['completed_actions'][] = $action_key;
                        
                        // Set success message
                        $_SESSION['message'] = "Application selected and email sent successfully.";
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Email could not be sent. Error: {$mail->ErrorInfo}";
                    }
                }
            } else {
                $_SESSION['error'] = "Error selecting application: " . $conn->error;
            }
        } elseif ($action === 'reject') {
            // Update the status of the application to "Rejected"
            $sql = "UPDATE job_applications SET status='Rejected' WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                // Fetch the applicant's email
                $emailQuery = "SELECT email, full_name FROM job_applications WHERE id=$id";
                $emailResult = $conn->query($emailQuery);
                if ($emailResult->num_rows > 0) {
                    $applicant = $emailResult->fetch_assoc();
                    $to = $applicant['email'];
                    $fullName = $applicant['full_name'];

                    // Create a new PHPMailer instance
                    $mail = new PHPMailer(true);

                    try {
                        // Server settings
                        $mail->isSMTP();
                        $mail->Host       = 'smtp.gmail.com';
                        $mail->SMTPAuth   = true;
                        $mail->Username   = 'sandunisathyangani3@gmail.com';
                        $mail->Password   = 'akcg givl dmmn uasd';
                        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                        $mail->Port       = 587;

                        // Recipients
                        $mail->setFrom('sandunisathyangani3@gmail.com', 'SLTMobitel');
                        $mail->addAddress($to, $fullName);

                        // Content
                        $mail->isHTML(true);
                        $mail->Subject = 'Application Status Update - SLT Digital Platform';
                        $mail->Body    = "
                            <p>Dear $fullName,</p>
                            <p>Thank you for your interest in the internship position at SLT Digital Platform.</p>
                            <p>After careful consideration of your application, we regret to inform you that we will not be moving forward with your application at this time.</p>
                            <p>We appreciate the time you took to apply and wish you the best in your future endeavors.</p>
                            <p>Best regards,<br>The Team</p>
                        ";
                        $mail->AltBody = "Dear $fullName,\n\nThank you for your interest in the internship position at SLT Digital Platform.\n\n
                        After careful consideration of your application, we regret to inform you that we will not be moving forward with your application at this time.\n\n
                        We appreciate the time you took to apply and wish you the best in your future endeavors.\n\n
                        Best regards,\nThe Team";

                        $mail->send();

                        // After successful email send
                        if (!isset($_SESSION['completed_actions'])) {
                            $_SESSION['completed_actions'] = array();
                        }
                        $_SESSION['completed_actions'][] = $action_key;
                        
                        // Set success message
                        $_SESSION['message'] = "Application rejected and email sent successfully.";
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Email could not be sent. Error: {$mail->ErrorInfo}";
                    }
                }
            } else {
                $_SESSION['error'] = "Error rejecting application: " . $conn->error;
            }
        }
    }
    
    // Redirect after processing
    header('Location: admin.php');
    exit;
}

// Display messages if they exist
if (isset($_SESSION['message'])) {
    echo '<div class="alert alert-success">' . $_SESSION['message'] . '</div>';
    unset($_SESSION['message']);
}
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">' . $_SESSION['error'] . '</div>';
    unset($_SESSION['error']);
}

// Fetch counts for total applicants, shortlisted, and rejected
$totalApplicantsQuery = "SELECT COUNT(*) as total FROM job_applications";
$totalApplicantsResult = $conn->query($totalApplicantsQuery);
$totalApplicants = $totalApplicantsResult->fetch_assoc()['total'];

$shortlistedQuery = "SELECT COUNT(*) as shortlisted FROM job_applications WHERE status='Selected'";
$shortlistedResult = $conn->query($shortlistedQuery);
$shortlisted = $shortlistedResult->fetch_assoc()['shortlisted'];

$rejectedQuery = "SELECT COUNT(*) as rejected FROM job_applications WHERE status='Rejected'";
$rejectedResult = $conn->query($rejectedQuery);
$rejected = $rejectedResult->fetch_assoc()['rejected'];

// Fetch all applications
$sql = "SELECT * FROM job_applications";
$result = $conn->query($sql);

// Check if the query was successful
if ($result === FALSE) {
    die("Error fetching applications: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- My CSS -->
    <link rel="stylesheet" href="./css/admin.css">

    <title>AdminHub</title>
</head>
<body>

    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-user-account'></i>
            <span class="text">AdminHub</span>
        </a>
        <ul class="side-menu top">
            <li class="active">
                <a href="admin.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="selected_interns.php">
                    <i class='bx bxs-doughnut-chart'></i>
                    <span class="text">Selected Interns</span>
                </a>
            </li>
            <li>
                <a href="manage_interns.php">
                    <i class='bx bxs-user-detail'></i>
                    <span class="text">Manage Interns</span>
                </a>
            </li>
            <li>
                <a href="mark_attendance.php">
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">Mark Attendance</span>
                </a>
            </li>
            <li>
                <a href="attendance_summary.php">
                    <i class='bx bxs-report'></i>
                    <span class="text">Attendance Summary</span>
                </a>
            </li>
        </ul>

        <ul class="side-menu">
        <li>
                <a href="manage_admins.php">
                    <i class='bx bxs-user-plus'></i>
                    <span class="text">Admin</span>
                </a>
            </li>
            <li>
                <a href="#" class="logout">
                    <i class='bx bxs-log-out-circle' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>
    <!-- SIDEBAR -->

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu' ></i>
            <a href="#" class="nav-link">Categories</a>
            <form action="#" id="searchForm">
                <div class="form-input">
                    <input type="search" id="navSearch" placeholder="Search by role...">
                    <button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
                </div>
            </form>
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell' ></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="https://cdn6.aptoide.com/imgs/e/8/a/e8a9704f0c7e07d005f6ca4d3474cf8e_icon.png">
            </a>
        </nav>
        <!-- NAVBAR -->

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Dashboard</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Dashboard</a>
                        </li>
                        <li><i class='bx bx-chevron-right' ></i></li>
                        <li>
                            <a class="active" href="#">Home</a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <!-- Statistics Row (Top) -->
                <div class="stats-row">
                    <h2>Statistics</h2>
                    <ul class="box-info">
                        <li>
                            <i class='bx bxs-calendar-week'></i>
                            <span class="text">
                                <h3><?php echo $totalApplicants; ?></h3>
                                <p>Total Applicants</p>
                            </span>
                        </li>
                        <li>
                            <i class='bx bxs-group'></i>
                            <span class="text">
                                <h3><?php echo $shortlisted; ?></h3>
                                <p>Shortlisted</p>
                            </span>
                        </li>
                        <li>
                            <i class='bx bxs-group'></i>
                            <span class="text">
                                <h3><?php echo $rejected; ?></h3>
                                <p>Rejected</p>
                            </span>
                        </li>
                    </ul>
                </div>

                <!-- Table Section -->
                <div class="table-section">
                    <h2>Existing Applications</h2>
                    <div class="table-container">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Full Name</th>
                                    <th>Email</th>
                                    <th>Educational Institute</th>
                                    <th>Degree/Course</th>
                                    <th>Working Mode</th>
                                    <th>Role</th>
                                    <th>Selected Programming Languages</th>
                                    <th>Resume</th>
                                    <th>Status</th>
                                    <th colspan="3">Actions</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if ($result->num_rows > 0): ?>
                                    <?php while($row = $result->fetch_assoc()): ?>
                                        <tr>
                                            <td>
                                                <a href="applicant_details.php?id=<?php echo $row['id']; ?>" 
                                                   class="text-decoration-none text-primary">
                                                    <?php echo htmlspecialchars($row['full_name']); ?>
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                                            <td><?php echo htmlspecialchars($row['institute']); ?></td>
                                            <td><?php echo htmlspecialchars($row['course']); ?></td>
                                            <td>
                                                <?php 
                                                $work_mode = htmlspecialchars($row['work_mode']);
                                                switch($work_mode) {
                                                    case 'Remote':
                                                        echo '<span class="badge bg-primary">Remote</span>';
                                                        break;
                                                    case 'On-Site':
                                                        echo '<span class="badge bg-success">On-Site</span>';
                                                        break;
                                                    case 'Hybrid':
                                                        echo '<span class="badge bg-info">Hybrid</span>';
                                                        break;
                                                    default:
                                                        echo '<span class="badge bg-secondary">Not Specified</span>';
                                                }
                                                ?>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                                            <td><?php echo htmlspecialchars($row['skills']); ?></td>
                                            <td>
                                                <?php 
                                                $resumePath = $row['resume_path'];
                                                // Make sure we're using just the filename
                                                $resumePath = basename($resumePath);
                                                ?>
                                                <a href="download.php?file=<?php echo urlencode($resumePath); ?>" 
                                                   class="btn btn-primary btn-sm"
                                                   download>
                                                    Download Resume
                                                </a>
                                            </td>
                                            <td><?php echo htmlspecialchars($row['status']) ?: 'Pending'; ?></td>
                                            <td>
                                                <?php if ($row['status'] === 'Selected'): ?>
                                                    <button class="btn btn-success btn-sm" disabled>Selected</button>
                                                <?php elseif ($row['status'] === 'Rejected'): ?>
                                                    <button class="btn btn-success btn-sm" disabled>Select</button>
                                                <?php else: ?>
                                                    <a href="?action=select&id=<?php echo $row['id']; ?>" 
                                                       class="btn btn-success btn-sm"
                                                       onclick="return confirm('Are you sure you want to select this applicant?');">
                                                        Select
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <?php if ($row['status'] === 'Rejected'): ?>
                                                    <button class="btn btn-danger btn-sm" disabled>Rejected</button>
                                                <?php elseif ($row['status'] === 'Selected'): ?>
                                                    <button class="btn btn-danger btn-sm" disabled>Reject</button>
                                                <?php else: ?>
                                                    <a href="?action=reject&id=<?php echo $row['id']; ?>" 
                                                       class="btn btn-danger btn-sm"
                                                       onclick="return confirm('Are you sure you want to reject this applicant?');">
                                                        Reject
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <a href="?delete=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm">Delete</a>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9">No applications found</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <?php $conn->close(); ?>

        </main>
        <!-- CONTENT END-->

        <script src="admin.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script>
        function checkFileExists(url) {
            var xhr = new XMLHttpRequest();
            xhr.open('HEAD', url, false);
            try {
                xhr.send();
                if (xhr.status === 404) {
                    alert('Resume file not found. The file may have been moved or deleted.');
                    return false;
                }
                return true;
            } catch (error) {
                alert('Error accessing the file. Please try again later.');
                return false;
            }
        }

        // Add search functionality
        document.getElementById('searchForm').addEventListener('submit', function(e) {
            e.preventDefault();
            searchTable();
        });

        document.getElementById('navSearch').addEventListener('input', function() {
            searchTable();
        });

        function searchTable() {
            const searchTerm = document.getElementById('navSearch').value.toLowerCase();
            const tableRows = document.querySelectorAll('table tbody tr');
            
            tableRows.forEach(row => {
                const roleCell = row.querySelector('td:nth-child(6)'); // Adjust this index to match your role column
                if (roleCell) {
                    const roleText = roleCell.textContent.toLowerCase();
                    if (roleText.includes(searchTerm)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                }
            });
            
            // Update statistics after search
            updateStatistics();
        }

        function updateStatistics() {
            const visibleRows = Array.from(document.querySelectorAll('table tbody tr')).filter(row => 
                row.style.display !== 'none'
            );
            
            const totalVisible = visibleRows.length;
            const selectedVisible = visibleRows.filter(row => 
                row.querySelector('td:nth-child(9)').textContent.includes('Selected')).length;
            const rejectedVisible = visibleRows.filter(row => 
                row.querySelector('td:nth-child(9)').textContent.includes('Rejected')).length;
            
            // Update statistics display
            document.querySelector('.box-info li:nth-child(1) h3').textContent = totalVisible;
            document.querySelector('.box-info li:nth-child(2) h3').textContent = selectedVisible;
            document.querySelector('.box-info li:nth-child(3) h3').textContent = rejectedVisible;
        }
        </script>
    </body>
</html>

<style>
/* Layout Styles */
.container {
    max-width: 1400px;
    padding: 20px;
}

/* Statistics Row */
.stats-row {
    margin-bottom: 30px;
}

.box-info {
    display: flex;
    gap: 20px;
    padding: 0;
    margin: 0;
}

.box-info li {
    flex: 1;
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    min-width: 200px;
}

/* Table Section */
.table-container {
    background: white;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    overflow-x: auto;
}

/* Responsive Design */
@media (max-width: 992px) {
    .box-info {
        flex-wrap: wrap;
    }
    
    .box-info li {
        min-width: calc(33.333% - 14px);
    }
}

@media (max-width: 768px) {
    .box-info li {
        min-width: calc(50% - 10px);
    }
}

@media (max-width: 576px) {
    .box-info {
        flex-direction: column;
    }
    
    .box-info li {
        width: 100%;
    }
}

.badge {
    padding: 5px 10px;
    border-radius: 15px;
    font-size: 0.9em;
}
.bg-primary {
    background-color: #007bff;
}
.bg-success {
    background-color: #28a745;
}
.bg-info {
    background-color: #17a2b8;
}
.bg-secondary {
    background-color: #6c757d;
}

.form-input {
    display: flex;
    align-items: center;
    background: #F9F9F9;
    border-radius: 36px;
    overflow: hidden;
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}

.form-input input {
    flex: 1;
    padding: 10px 16px;
    border: none;
    outline: none;
    background: transparent;
    color: var(--dark);
    font-size: 14px;
}

.form-input input::placeholder {
    color: #888;
}

.search-btn {
    width: 36px;
    height: 36px;
    display: flex;
    justify-content: center;
    align-items: center;
    background: var(--blue);
    color: var(--light);
    font-size: 18px;
    border: none;
    cursor: pointer;
    transition: background 0.3s ease;
}

.search-btn:hover {
    background: var(--dark-blue);
}

@media screen and (max-width: 768px) {
    .form-input {
        max-width: 300px;
    }
    
    .form-input input {
        font-size: 13px;
    }
    
    .search-btn {
        width: 32px;
        height: 32px;
        font-size: 16px;
    }
}
</style>