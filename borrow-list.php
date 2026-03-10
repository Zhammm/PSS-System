<?php
include "config.php";

// Get search query
$search = "";
if(isset($_GET['search'])){
    $search = $conn->real_escape_string($_GET['search']);
}

// Query with search
$sql = "SELECT borrow_records.*, books.judul_edisi 
        FROM borrow_records
        JOIN books ON borrow_records.no_siri = books.no_siri
        WHERE borrow_records.nama_peminjam LIKE '%$search%'
        ORDER BY borrow_records.tarikh_pinjam DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Borrow Records | Library</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            padding: 30px;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            max-width: 1000px;
            margin: auto;
        }

        h2 {
            margin-top: 0;
            margin-bottom: 15px;
        }

        /* Search Bar */
        .search-form {
            margin-bottom: 15px;
        }

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

        .search-form button:hover {
            background: #2980b9;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th {
            background: #3498db;
            color: white;
            padding: 12px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: center;
        }

        table tr:hover {
            background: #f1f1f1;
        }

        .status-borrowed {
            color: red;
            font-weight: bold;
        }

        .status-returned {
            color: green;
            font-weight: bold;
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
<a href="admin-dashboard.php" class="back-btn">⬅ Back to Dashboard</a>
<div class="card">
    <h2>Borrow Records</h2>

    <form method="GET" class="search-form">
        <input type="text" name="search" placeholder="Search by Nama Peminjam" value="<?= htmlspecialchars($search) ?>">
        <button type="submit">Search</button>
        <a href="borrow-list.php" style="padding:8px 12px; background:#95a5a6; color:white; text-decoration:none; border-radius:5px;">Reset</a>
    </form>

    <table>
        <tr>
            <th>Nama Peminjam</th>
            <th>Judul Buku</th>
            <th>Tarikh Pinjam</th>
            <th>Tarikh Pulang</th>
            <th>Status</th>
        </tr>

        <?php if($result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['nama_peminjam'] ?></td>
                <td><?= $row['judul_edisi'] ?></td>
                <td><?= $row['tarikh_pinjam'] ?></td>
                <td><?= $row['tarikh_pulang'] ? $row['tarikh_pulang'] : '-' ?></td>
                <td>
                    <?php if($row['status'] == 'Borrowed'): ?>
                        <span class="status-borrowed">Borrowed</span>
                    <?php else: ?>
                        <span class="status-returned">Returned</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="5">No records found</td>
            </tr>
        <?php endif; ?>
    </table>
</div>

</body>
</html>