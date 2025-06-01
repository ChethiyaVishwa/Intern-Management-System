<?php
session_start();

if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== true) {
    header('Location: login.php');
    exit();
}

include_once 'php/db.php';

// Handle form submission for adding new intern
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id = trim($_POST['student_id']);
    $full_name = trim($_POST['full_name']);
    $group_name = trim($_POST['group_name']);
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    
    // Check if student ID already exists
    $stmt = $conn->prepare("SELECT id FROM interns WHERE student_id = ?");
    $stmt->bind_param("s", $student_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error'] = "Student ID already exists";
    } else {
        $stmt = $conn->prepare("INSERT INTO interns (student_id, full_name, group_name, start_date, end_date) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $student_id, $full_name, $group_name, $start_date, $end_date);
        
        if ($stmt->execute()) {
            $_SESSION['success'] = "Intern added successfully";
        } else {
            $_SESSION['error'] = "Error adding intern: " . $conn->error;
        }
    }
    
    // Redirect after form submission
    header("Location: manage_interns.php");
    exit();
}

// Fetch all interns
$interns = $conn->query("SELECT * FROM interns ORDER BY group_name, full_name");

// Get unique group names for filtering
$groups = $conn->query("SELECT DISTINCT group_name FROM interns WHERE group_name IS NOT NULL ORDER BY group_name");
$group_list = [];
while ($group = $groups->fetch_assoc()) {
    if (!empty($group['group_name'])) {
        $group_list[] = $group['group_name'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Interns</title>
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="./css/admin.css">
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
            <li class="active">
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
            <a href="#" class="profile">
                <img src="img/people.png">
            </a>
        </nav>

        <!-- MAIN -->
        <main>
            <div class="head-title">
                <div class="left">
                    <h1>Manage Interns</h1>
                </div>
            </div>

            <div class="container">
                <!-- Add Intern Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h4>Add New Intern</h4>
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

                        <?php if (isset($_SESSION['error'])): ?>
                            <div class="alert alert-danger">
                                <?php 
                                echo $_SESSION['error'];
                                unset($_SESSION['error']);
                                ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Student ID</label>
                                    <input type="text" class="form-control" name="student_id" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Full Name</label>
                                    <input type="text" class="form-control" name="full_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Group Name</label>
                                    <input type="text" class="form-control" name="group_name" 
                                           list="group-list" placeholder="Enter or select group">
                                    <datalist id="group-list">
                                        <?php foreach ($group_list as $group): ?>
                                            <option value="<?php echo htmlspecialchars($group); ?>">
                                        <?php endforeach; ?>
                                    </datalist>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date" class="form-control" name="start_date" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date" class="form-control" name="end_date" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Intern</button>
                        </form>
                    </div>
                </div>

                <!-- Interns List -->
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>Current Interns</h4>
                        <div class="filter-group">
                            <select class="form-select" id="group-filter">
                                <option value="">All Groups</option>
                                <?php foreach ($group_list as $group): ?>
                                    <option value="<?php echo htmlspecialchars($group); ?>">
                                        <?php echo htmlspecialchars($group); ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Student ID</th>
                                        <th>Name</th>
                                        <th>Group</th>
                                        <th>Start Date</th>
                                        <th>End Date</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php while ($intern = $interns->fetch_assoc()): ?>
                                        <tr class="intern-row" data-group="<?php echo htmlspecialchars($intern['group_name'] ?? ''); ?>">
                                            <td><?php echo htmlspecialchars($intern['student_id']); ?></td>
                                            <td><?php echo htmlspecialchars($intern['full_name']); ?></td>
                                            <td><?php echo htmlspecialchars($intern['group_name'] ?? 'No Group'); ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($intern['start_date'])); ?></td>
                                            <td><?php echo date('Y-m-d', strtotime($intern['end_date'])); ?></td>
                                            <td>
                                                <span class="badge bg-<?php echo $intern['status'] === 'Active' ? 'success' : 'secondary'; ?>">
                                                    <?php echo htmlspecialchars($intern['status']); ?>
                                                </span>
                                            </td>
                                            <td>
                                                <button class="btn btn-primary btn-sm me-2" onclick="editIntern(<?php 
                                                    echo htmlspecialchars(json_encode([
                                                        'id' => $intern['id'],
                                                        'student_id' => $intern['student_id'],
                                                        'full_name' => $intern['full_name'],
                                                        'group_name' => $intern['group_name'],
                                                        'start_date' => $intern['start_date'],
                                                        'end_date' => $intern['end_date'],
                                                        'status' => $intern['status']
                                                    ])); 
                                                ?>)">
                                                    <i class='bx bx-edit'></i> Edit
                                                </button>
                                                <button class="btn btn-danger btn-sm" onclick="deleteIntern(<?php echo $intern['id']; ?>)">
                                                    <i class='bx bx-trash'></i> Delete
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>

    <!-- Edit Intern Modal -->
    <div class="modal fade" id="editInternModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Intern</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="editInternForm">
                        <input type="hidden" id="edit_intern_id" name="id">
                        <div class="mb-3">
                            <label class="form-label">Student ID</label>
                            <input type="text" class="form-control" id="edit_student_id" name="student_id" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="edit_full_name" name="full_name" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Group Name</label>
                            <input type="text" class="form-control" id="edit_group_name" name="group_name" 
                                   list="group-list">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="edit_start_date" name="start_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">End Date</label>
                            <input type="date" class="form-control" id="edit_end_date" name="end_date" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status</label>
                            <select class="form-select" id="edit_status" name="status" required>
                                <option value="Active">Active</option>
                                <option value="Completed">Completed</option>
                                <option value="Terminated">Terminated</option>
                            </select>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" onclick="updateIntern()">Save Changes</button>
                </div>
            </div>
        </div>
    </div>

    <script src="admin.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    let editModal;

    document.addEventListener('DOMContentLoaded', function() {
        editModal = new bootstrap.Modal(document.getElementById('editInternModal'));
    });

    function editIntern(intern) {
        document.getElementById('edit_intern_id').value = intern.id;
        document.getElementById('edit_student_id').value = intern.student_id;
        document.getElementById('edit_full_name').value = intern.full_name;
        document.getElementById('edit_group_name').value = intern.group_name || '';
        document.getElementById('edit_start_date').value = intern.start_date;
        document.getElementById('edit_end_date').value = intern.end_date;
        document.getElementById('edit_status').value = intern.status;
        
        editModal.show();
    }

    function updateIntern() {
        const form = document.getElementById('editInternForm');
        const formData = new FormData(form);
        
        fetch('update_intern.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(result => {
            if (result.trim() === 'success') {
                // Show success message
                alert('Intern updated successfully');
                // Close modal and refresh page
                editModal.hide();
                window.location.reload();
            } else {
                alert('Error: ' + result);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error updating intern');
        });
    }

    function deleteIntern(id) {
        if (confirm('Are you sure you want to delete this intern?')) {
            fetch('delete_intern.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: 'id=' + id
            })
            .then(response => response.text())
            .then(result => {
                if (result.trim() === 'success') {
                    alert('Intern deleted successfully');
                    window.location.reload();
                } else {
                    alert(result);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error deleting intern');
            });
        }
    }

    // Add group filtering functionality
    document.getElementById('group-filter').addEventListener('change', function() {
        const selectedGroup = this.value;
        const rows = document.querySelectorAll('.intern-row');
        
        rows.forEach(row => {
            const groupName = row.getAttribute('data-group');
            if (!selectedGroup || groupName === selectedGroup) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
    </script>
</body>
</html> 