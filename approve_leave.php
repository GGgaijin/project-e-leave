<?php
session_start();
include 'db.php';

if ($_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

$id = $_GET['id'];
$action = $_GET['action'];

$stmt = $pdo->prepare("SELECT * FROM leave_requests WHERE id = :id");
$stmt->execute(['id' => $id]);
$request = $stmt->fetch();

if ($action === 'approve') {
    $stmt = $pdo->prepare("UPDATE leave_requests SET status = 'approved' WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Notify user via email
    sendEmail($request['email'], "Leave Approved", "Your leave request has been approved.");
} elseif ($action === 'reject') {
    $stmt = $pdo->prepare("UPDATE leave_requests SET status = 'rejected' WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Restore leave balance
    $stmt = $pdo->prepare("SELECT leave_balance FROM users WHERE id = :user_id");
    $stmt->execute(['user_id' => $request['user_id']]);
    $user = $stmt->fetch();

    $days_requested = (strtotime($request['end_date']) - strtotime($request['start_date'])) / (60 * 60 * 24) + 1;
    $new_balance = $user['leave_balance'] + $days_requested;

    $stmt = $pdo->prepare("UPDATE users SET leave_balance = :balance WHERE id = :id");
    $stmt->execute(['balance' => $new_balance, 'id' => $request['user_id']]);

    // Notify user via email
    sendEmail($request['email'], "Leave Rejected", "Your leave request has been rejected.");
}

header('Location: admin_panel.php');
?>
