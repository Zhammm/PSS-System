<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Get all deleted books
$sql = "SELECT * FROM books WHERE status = 'Deleted' ORDER BY tarikh DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Deleted Books | Library</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; }
        .container { width: 95%; margin: 30px auto; }
        h2 { margin-bottom: 15px; }

        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; font-size: 14px; }
        th { background: #2c3e50; color: white; }
        tr:hover { background: #f1f1f1; }

        .restore { padding:5px 10px; background:green; color:white; border-radius:5px; text-decoration:none; }
    </style>
</head>
<body>

<div class="container">
    <h2>🗑️ Deleted Books</h2>

    <!-- Top Buttons -->
    <div class="top-buttons" style="margin-bottom:15px;">
        <a href="book-list.php" style="
            padding:8px 15px; 
            background:#3498db; 
            color:white; 
            text-decoration:none; 
            border-radius:5px;
            margin-right: 5px;
        ">⬅️ Back to Book List</a>
    </div>

    <table>
        <tr>
            <th>No Siri</th>
            <th>Tarikh</th>
            <th>No Perolehan</th>
            <th>Pengarang</th>
            <th>Judul / Edisi</th>
            <th>Penerbit</th>
            <th>Tahun</th>
            <th>Harga (RM)</th>
            <th>Catatan</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['no_siri'] ?></td>
                <td><?= $row['tarikh'] ?></td>
                <td><?= $row['no_perolehan'] ?></td>
                <td><?= $row['pengarang'] ?></td>
                <td><?= $row['judul_edisi'] ?></td>
                <td><?= $row['penerbit'] ?></td>
                <td><?= $row['tahun'] ?></td>
                <td><?= number_format($row['harga'],2) ?></td>
                <td><?= $row['catatan'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <a href="update-status.php?no_siri=<?= $row['no_siri'] ?>&status=Available" class="restore">Restore</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="11">No deleted books</td>
            </tr>
        <?php endif; ?>
    </table>
</div>