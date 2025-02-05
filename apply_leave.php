<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Apply Leave</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="form-container">
        <h2>Apply for Leave</h2>
        <form action="process_leave.php" method="POST">
            <label for="start_date">Start Date:</label>
            <input type="date" name="start_date" required>
            <label for="end_date">End Date:</label>
            <input type="date" name="end_date" required>
            <label for="reason">Reason:</label>
            <textarea name="reason" required></textarea>
            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>
