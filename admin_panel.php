<?php
session_start();
include 'db.php';

// Ensure only admins can access this page
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

// Fetch all leave requests
$stmt = $pdo->query("SELECT lr.*, u.username FROM leave_requests lr JOIN users u ON lr.user_id = u.id");
$requests = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Leave Requests</h2>
    <table border="1">
        <tr>
            <th>User</th>
            <th>Start Date</th>
            <th>End Date</th>
            <th>Reason</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php foreach ($requests as $request): ?>
        <tr>
            <td><?= htmlspecialchars($request['username']) ?></td>
            <td><?= htmlspecialchars($request['start_date']) ?></td>
            <td><?= htmlspecialchars($request['end_date']) ?></td>
            <td><?= htmlspecialchars($request['reason']) ?></td>
            <td><?= htmlspecialchars($request['status']) ?></td>
            <td>
                <a href="approve_leave.php?id=<?= $request['id'] ?>&action=approve">Approve</a>
                <a href="approve_leave.php?id=<?= $request['id'] ?>&action=reject">Reject</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
