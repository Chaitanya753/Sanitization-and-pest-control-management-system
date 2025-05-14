<?php
session_start();
include('db_connection.php');

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    echo "Unauthorized access!";
    exit;
}

// Fetch all reviews from the database
$query = "SELECT r.review_id, r.rating, r.review_text, r.status, r.created_at, u.name 
          FROM reviews r 
          JOIN users u ON r.user_id = u.user_id
          ORDER BY r.created_at DESC";

$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - View User Reviews</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 900px;
            margin: 0 auto;
            background: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        h1 {
            text-align: center;
            color: #343a40;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #007bff;
            color: white;
        }
        .status-approved {
            color: green;
            font-weight: bold;
        }
        .status-pending {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>All User Reviews</h1>
    <table>
        <tr>
            <th>User Name</th>
            <th>Rating</th>
            <th>Review</th>
            <th>Date</th>
            <th>Status</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo $row['rating']; ?> ⭐</td>
            <td><?php echo htmlspecialchars($row['review_text']); ?></td>
            <td><?php echo date("d-m-Y", strtotime($row['created_at'])); ?></td>
            <td class="<?php echo ($row['status'] == 'approved') ? 'status-approved' : 'status-pending'; ?>">
                <?php echo ucfirst($row['status']); ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
</div>

</body>
</html>

<?php
$conn->close();
?>
