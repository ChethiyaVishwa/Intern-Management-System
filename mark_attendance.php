<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once 'php/db.php';

// Handle attendance submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['date'];
    $attendances = $_POST['attendance'];
    $remarks = $_POST['remarks'];
    
    foreach ($attendances as $intern_id => $status) {
        $stmt = $conn->prepare("INSERT INTO attendance (intern_id, date, status, remarks, marked_by) 
                               VALUES (?, ?, ?, ?, ?) 
                               ON DUPLICATE KEY UPDATE status = ?, remarks = ?");
        
        $admin_id = $_SESSION['admin_id'];
        $remark = $remarks[$intern_id] ?? '';
        
        $stmt->bind_param("issssss", $intern_id, $date, $status, $remark, $admin_id, $status, $remark);
        $stmt->execute();
    }
    
    $_SESSION['success'] = "Attendance marked successfully";
    header("Location: mark_attendance.php");
    exit();
}

// Get selected date (default to today)
$selected_date = $_GET['date'] ?? date('Y-m-d');
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Modify the query to include search by student ID, name, and group name
$query = "SELECT * FROM interns WHERE status = 'Active'";
if (!empty($search)) {
    $query .= " AND (student_id LIKE ? OR full_name LIKE ? OR group_name LIKE ?)";
}
$query .= " ORDER BY group_name, full_name";

if (!empty($search)) {
    $stmt = $conn->prepare($query);
    $search_param = "%$search%";
    $stmt->bind_param("sss", $search_param, $search_param, $search_param);
    $stmt->execute();
    $interns = $stmt->get_result();
} else {
    $interns = $conn->query($query);
}

// Fetch existing attendance for selected date
$attendance_query = $conn->prepare("SELECT * FROM attendance WHERE date = ?");
$attendance_query->bind_param("s", $selected_date);
$attendance_query->execute();
$attendance_result = $attendance_query->get_result();

$existing_attendance = [];
while ($row = $attendance_result->fetch_assoc()) {
    $existing_attendance[$row['intern_id']] = $row;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mark Attendance</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/admin.css">
    <style>
        .search-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .search-box .form-control:focus {
            box-shadow: none;
            border-color: #0d6efd;
        }
        .no-results {
            text-align: center;
            padding: 20px;
            font-size: 1.1em;
            color: #666;
        }
        .bx-check-circle {
            font-size: 18px; /* Adjust size */
            margin-right: 5px; /* Space between checkmark and name */
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
            <li class="active">
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
    </section>

    <!-- CONTENT -->
    <section id="content">
        <!-- NAVBAR -->
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="profile">
                <img src="img/people.png">
            </a>
        </nav>

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Mark Attendance</h1>
                </div>
            </div>

            <div class="container">
                <!-- Search Box -->
                <div class="search-box">
                    <form method="GET" class="row g-3 align-items-center">
                        <input type="hidden" name="date" value="<?php echo $selected_date; ?>">
                        <div class="col-md-8">
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i class='bx bx-search'></i>
                                </span>
                                <input type="text" 
                                       class="form-control" 
                                       name="search" 
                                       value="<?php echo htmlspecialchars($search); ?>" 
                                       placeholder="Search by ID, Name or Group...">
                            </div>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary">Search</button>
                            <?php if (!empty($search)): ?>
                                <a href="?date=<?php echo $selected_date; ?>" class="btn btn-secondary">Clear</a>
                            <?php endif; ?>
                        </div>
                    </form>
                </div>

                <!-- Attendance Card -->
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h4>Daily Attendance</h4>
                            <input type="date" class="form-control" style="width: 200px;" 
                                   value="<?php echo $selected_date; ?>" 
                                   onchange="window.location.href='?date='+this.value+'&search=<?php echo urlencode($search); ?>'">
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if (isset($_SESSION['success'])): ?>
                            <div class="alert alert-success">
                                <?php 
                                echo $_SESSION['success'];
                                unset($_SESSION['success']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <?php if ($interns->num_rows > 0): ?>
                            <form method="POST">
                                <input type="hidden" name="date" value="<?php echo $selected_date; ?>">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Student ID</th>
                                                <th>Name</th>
                                                <th>Group</th>
                                                <th>Status</th>
                                                <th>Remarks</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($intern = $interns->fetch_assoc()): ?>
                                                <tr>
                                                    <td><?php echo htmlspecialchars($intern['student_id']); ?></td>
                                                    <td><?php echo htmlspecialchars($intern['full_name']); ?>
                                                        <?php 
                                                        // Check if attendance has been marked for this intern
                                                        $attendance_marked = isset($existing_attendance[$intern['id']]); 

                                                        // If attendance is marked, display a checkmark
                                                        if ($attendance_marked): 
                                                        ?>
                                                            <i class="bx bx-check-circle" style="color: green;"></i> <!-- Checkmark icon -->
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?php echo htmlspecialchars($intern['group_name'] ?? 'No Group'); ?></td>
                                                    <td>
                                                        <select name="attendance[<?php echo $intern['id']; ?>]" class="form-select">
                                                            <?php
                                                            $statuses = ['Present', 'Absent', 'Half-day', 'Leave'];
                                                            $current_status = $existing_attendance[$intern['id']]['status'] ?? 'Present';
                                                            foreach ($statuses as $status):
                                                                $selected = ($status === $current_status) ? 'selected' : '';
                                                            ?>
                                                                <option value="<?php echo $status; ?>" <?php echo $selected; ?>>
                                                                    <?php echo $status; ?>
                                                                </option>
                                                            <?php endforeach; ?>
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control" 
                                                               name="remarks[<?php echo $intern['id']; ?>]"
                                                               value="<?php echo htmlspecialchars($existing_attendance[$intern['id']]['remarks'] ?? ''); ?>">
                                                    </td>
                                                </tr>
                                            <?php endwhile; ?>
                                        </tbody>
                                    </table>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Attendance</button>
                            </form>
                        <?php else: ?>
                            <div class="no-results">
                                <?php if (!empty($search)): ?>
                                    No interns found matching "<?php echo htmlspecialchars($search); ?>"
                                <?php else: ?>
                                    No active interns found
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <script src="admin.js"></script>
</body>
</html> 