<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Get search query
$search = "";
if(isset($_GET['search'])){
    $search = $conn->real_escape_string($_GET['search']);
}

// Query books with search filter
$sql = "SELECT * FROM books 
        WHERE status != 'Deleted' 
        AND (
            judul_edisi LIKE '%$search%' OR
            pengarang LIKE '%$search%' OR
            no_siri LIKE '%$search%'
        )
        ORDER BY tarikh DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Book List | Library</title>
    <style>
        body { font-family: Arial; background: #f4f6f9; }

        .container { width: 95%; margin: 30px auto; }

        h2 { margin-bottom: 15px; }

        /* Search Form */
        .search-form { margin-bottom: 15px; }
        .search-form input[type="text"] {
            padding: 8px;
            width: 250px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }
        .search-form button {
            padding: 8px 12px;
            border: none;
            background: #3498db;
            color: white;
            border-radius: 5px;
            cursor: pointer;
        }
        .search-form button:hover { background: #2980b9; }
        .search-form a {
            padding: 8px 12px;
            background: #95a5a6;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            margin-left: 5px;
        }

        table { width: 100%; border-collapse: collapse; background: white; }
        th, td { padding: 10px; border: 1px solid #ddd; text-align: center; font-size: 14px; }
        th { background: #2c3e50; color: white; }
        tr:hover { background: #f1f1f1; }

        .btn { padding: 5px 10px; text-decoration: none; border-radius: 5px; font-size: 12px; }
        .borrow { background: orange; color: white; }
        .return { background: green; color: white; }
        .delete { background: red; color: white; }

        .top { margin-bottom: 15px; }
        .add-btn {
            background: #2c3e50;
            color: white;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 5px;
        }
        .back-btn{
    display:inline-block;
    margin-bottom:15px;
    padding:8px 14px;
    background:#2c3e50;
    color:white;
    text-decoration:none;
    border-radius:5px;
    font-size:14px;
}

.back-btn:hover{
    background:#34495e;
}
    </style>
</head>
<body>

<div class="container">
<a href="admin-dashboard.php" class="back-btn">⬅ Back to Dashboard</a>

    <div class="top">
        <h2>📚 Book List</h2>
        <a href="add-book.php" class="add-btn">➕ Add New Book</a>
        <a href="admin-dashboard.php" class="add-btn">🏠 Dashboard</a>
    </div>

    <!-- Search Form -->
    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search by Judul, Pengarang, or No Siri" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
        <a href="book-list.php">Reset</a>
    </form>

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
                    <?php if($row['status'] == 'Available'): ?>
                        <a href="borrow-book.php?no_siri=<?= $row['no_siri'] ?>" class="btn borrow">Borrow</a>
                    <?php elseif($row['status'] == 'Borrowed'): ?>
                        <a href="update-status.php?no_siri=<?= $row['no_siri'] ?>&status=Available" class="btn return">Return</a>
                    <?php endif; ?>
                    <a href="update-status.php?no_siri=<?= $row['no_siri'] ?>&status=Deleted" class="btn delete">Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="11">No books found</td>
            </tr>
        <?php endif; ?>
    </table>

</div>

</body>
</html>