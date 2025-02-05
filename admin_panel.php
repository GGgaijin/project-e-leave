<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

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
    <table>
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
            <td><?= $request['username'] ?></td>
            <td><?= $request['start_date'] ?></td>
            <td><?= $request['end_date'] ?></td>
            <td><?= $request['reason'] ?></td>
            <td><?= $request['status'] ?></td>
            <td>
                <a href="approve_leave.php?id=<?= $request['id'] ?>&action=approve">Approve</a>
                <a href="approve_leave.php?id=<?= $request['id'] ?>&action=reject">Reject</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
