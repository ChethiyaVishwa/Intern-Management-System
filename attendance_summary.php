<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once 'php/db.php';

// Get filter parameters
$month = isset($_GET['month']) ? $_GET['month'] : date('Y-m');
$intern_id = isset($_GET['intern_id']) ? (int)$_GET['intern_id'] : 0;

// Fetch all interns for filter dropdown
$interns = $conn->query("SELECT id, student_id, full_name FROM interns ORDER BY full_name");

// Prepare attendance query
$query = "SELECT a.*, i.student_id, i.full_name 
          FROM attendance a 
          JOIN interns i ON a.intern_id = i.id 
          WHERE DATE_FORMAT(a.date, '%Y-%m') = ?";
$params = [$month];
$types = "s";

if ($intern_id > 0) {
    $query .= " AND a.intern_id = ?";
    $params[] = $intern_id;
    $types .= "i";
}

$query .= " ORDER BY a.date DESC, i.full_name";

$stmt = $conn->prepare($query);
$stmt->bind_param($types, ...$params);
$stmt->execute();
$attendance_result = $stmt->get_result();

// Calculate summary statistics
$summary = [];
while ($row = $attendance_result->fetch_assoc()) {
    $intern_id = $row['intern_id'];
    if (!isset($summary[$intern_id])) {
        $summary[$intern_id] = [
            'name' => $row['full_name'],
            'student_id' => $row['student_id'],
            'present' => 0,
            'absent' => 0,
            'half_day' => 0,
            'leave' => 0,
            'total_days' => 0
        ];
    }
    
    $summary[$intern_id][$row['status']] = ($summary[$intern_id][$row['status']] ?? 0) + 1;
    $summary[$intern_id]['total_days']++;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Summary</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/admin.css">
    <style>
        .summary-card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .stat-box {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            text-align: center;
            margin-bottom: 10px;
        }
        .stat-box h4 {
            margin: 0;
            color: #0056a6;
        }
        .stat-box p {
            margin: 5px 0 0;
            color: #666;
        }
        .attendance-filters {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
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
            <li>
                <a href="mark_attendance.php">
                    <i class='bx bxs-calendar-check'></i>
                    <span class="text">Mark Attendance</span>
                </a>
            </li>
            <li class="active">
                <a href="attendance_summary.php">
                    <i class='bx bxs-report'></i>
                    <span class="text">Attendance Summary</span>
                </a>
            </li>
        </ul>
    </section>

    <!-- CONTENT -->
    <section id="content">
        <nav>
            <i class='bx bx-menu'></i>
            <a href="#" class="profile">
                <img src="img/people.png">
            </a>
        </nav>

        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Attendance Summary</h1>
                    <ul class="breadcrumb">
                        <li><a href="admin.php">Dashboard</a></li>
                        <li><i class='bx bx-chevron-right'></i></li>
                        <li><a class="active" href="#">Attendance Summary</a></li>
                    </ul>
                </div>
            </div>

            <div class="container">
                <!-- Filters -->
                <div class="attendance-filters">
                    <form method="GET" class="row align-items-end">
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Select Month</label>
                            <input type="month" class="form-control" name="month" 
                                   value="<?php echo $month; ?>" onchange="this.form.submit()">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Select Intern</label>
                            <select class="form-select" name="intern_id" onchange="this.form.submit()">
                                <option value="">All Interns</option>
                                <?php while ($intern = $interns->fetch_assoc()): ?>
                                    <option value="<?php echo $intern['id']; ?>" 
                                            <?php echo $intern_id == $intern['id'] ? 'selected' : ''; ?>>
                                        <?php echo htmlspecialchars($intern['full_name']); ?> 
                                        (<?php echo htmlspecialchars($intern['student_id']); ?>)
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    </form>
                </div>

                <!-- Summary Cards -->
                <div class="row">
                    <?php foreach ($summary as $id => $data): ?>
                        <div class="col-md-6 mb-4">
                            <div class="summary-card">
                                <h3><?php echo htmlspecialchars($data['name']); ?></h3>
                                <p class="text-muted">ID: <?php echo htmlspecialchars($data['student_id']); ?></p>
                                
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="stat-box">
                                            <h4><?php echo $data['Present'] ?? 0; ?></h4>
                                            <p>Present</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-box">
                                            <h4><?php echo $data['Absent'] ?? 0; ?></h4>
                                            <p>Absent</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-box">
                                            <h4><?php echo $data['Half-day'] ?? 0; ?></h4>
                                            <p>Half Day</p>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="stat-box">
                                            <h4><?php echo $data['Leave'] ?? 0; ?></h4>
                                            <p>Leave</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <h5>Attendance Rate: 
                                        <?php 
                                        $present_days = ($data['Present'] ?? 0) + (($data['Half-day'] ?? 0) * 0.5);
                                        $rate = ($data['total_days'] > 0) ? 
                                               round(($present_days / $data['total_days']) * 100, 1) : 0;
                                        echo $rate . '%';
                                        ?>
                                    </h5>
                                    <div class="progress">
                                        <div class="progress-bar" role="progressbar" 
                                             style="width: <?php echo $rate; ?>%"
                                             aria-valuenow="<?php echo $rate; ?>" 
                                             aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </main>
    </section>

    <script src="admin.js"></script>
</body>
</html> 