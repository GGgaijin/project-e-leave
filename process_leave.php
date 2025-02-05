<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

$user_id = $_SESSION['user_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$reason = $_POST['reason'];

// Check leave balance
$stmt = $pdo->prepare("SELECT leave_balance FROM users WHERE id = :id");
$stmt->execute(['id' => $user_id]);
$user = $stmt->fetch();

$days_requested = (strtotime($end_date) - strtotime($start_date)) / (60 * 60 * 24) + 1;

if ($user['leave_balance'] >= $days_requested) {
    $stmt = $pdo->prepare("INSERT INTO leave_requests (user_id, start_date, end_date, reason) VALUES (:user_id, :start_date, :end_date, :reason)");
    $stmt->execute([
        'user_id' => $user_id,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'reason' => $reason
    ]);

    // Deduct leave balance temporarily
    $new_balance = $user['leave_balance'] - $days_requested;
    $stmt = $pdo->prepare("UPDATE users SET leave_balance = :balance WHERE id = :id");
    $stmt->execute(['balance' => $new_balance, 'id' => $user_id]);

    echo "Leave request submitted successfully!";
} else {
    echo "Insufficient leave balance!";
}
?>
