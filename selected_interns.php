<?php
session_start();

// Check if user is logged in as admin
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once 'php/db.php';

// Fetch only selected interns
$sql = "SELECT * FROM job_applications WHERE status = 'Selected' ORDER BY full_name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Selected Interns</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/admin.css">
    <style>
        .intern-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .intern-card h3 {
            color: #0056a6;
            margin-bottom: 15px;
        }

        .intern-info {
            margin-bottom: 10px;
        }

        .intern-info label {
            font-weight: 600;
            color: #555;
            min-width: 120px;
            display: inline-block;
        }

        .action-buttons {
            margin-top: 15px;
        }

        .action-buttons .btn {
            margin-right: 10px;
        }

        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            background-color: #28a745;
            color: white;
        }

        .police-report-status {
            margin-top: 10px;
            padding: 8px;
            border-radius: 5px;
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <!-- SIDEBAR -->
    <section id="sidebar">
        <a href="#" class="brand">
            <i class='bx bxs-user-account'></i>
            <span class="text">AdminHub</span>
        </a>
        <ul class="side-menu top">
            <li>
                <a href="admin.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
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
        </ul>
    </section>

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <form action="#">
                <div class="form-input">
                    <input type="search" placeholder="Search...">
                    <button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
                </div>
            </form>
            <a href="#" class="profile">
                <img src="img/people.png">
            </a>
        </nav>

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Selected Interns</h1>
                    <ul class="breadcrumb">
                        <li><a href="admin.php">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Selected Interns</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <?php if ($result->num_rows > 0): ?>
                    <?php while($row = $result->fetch_assoc()): ?>
                        <div class="intern-card">
                            <h3><?php echo htmlspecialchars($row['full_name']); ?></h3>
                            <div class="intern-info">
                                <label>Email:</label>
                                <span><?php echo htmlspecialchars($row['email']); ?></span>
                            </div>
                            <div class="intern-info">
                                <label>Institute:</label>
                                <span><?php echo htmlspecialchars($row['institute']); ?></span>
                            </div>
                            <div class="intern-info">
                                <label>Course:</label>
                                <span><?php echo htmlspecialchars($row['course']); ?></span>
                            </div>
                            <div class="intern-info">
                                <label>Work Mode:</label>
                                <span class="badge bg-primary"><?php echo htmlspecialchars($row['work_mode']); ?></span>
                            </div>
                            <div class="police-report-status">
                                <strong>Police Report Status:</strong>
                                <?php if (!empty($row['police_report_path'])): ?>
                                    <span class="text-success">✓ Uploaded</span>
                                    <a href="download.php?file=<?php echo urlencode(basename($row['police_report_path'])); ?>" 
                                       class="btn btn-sm btn-primary ms-2">
                                        <i class='bx bx-download'></i> Download Report
                                    </a>
                                <?php else: ?>
                                    <span class="text-warning">⚠ Pending Upload</span>
                                    <span class="text-muted">(Link sent via email)</span>
                                <?php endif; ?>
                            </div>
                            <div class="action-buttons">
                                <a href="mailto:<?php echo $row['email']; ?>" class="btn btn-primary btn-sm">
                                    <i class='bx bx-envelope'></i> Send Email
                                </a>
                                <a href="download.php?file=<?php echo urlencode($row['resume_path']); ?>" 
                                   class="btn btn-info btn-sm">
                                    <i class='bx bx-download'></i> Download Resume
                                </a>
                            </div>
                        </div>
                    <?php endwhile; ?>
                <?php else: ?>
                    <div class="alert alert-info">No selected interns found.</div>
                <?php endif; ?>
            </div>
        </main>
    </section>

    <script src="admin.js"></script>
</body>
</html> 