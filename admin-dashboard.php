<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

// Dashboard statistics
$totalBooks = $conn->query("SELECT COUNT(*) FROM books")->fetch_row()[0];
$availableBooks = $conn->query("SELECT COUNT(*) FROM books WHERE status='Available'")->fetch_row()[0];
$borrowedBooks = $conn->query("SELECT COUNT(*) FROM books WHERE status='Borrowed'")->fetch_row()[0];
$deletedBooks = $conn->query("SELECT COUNT(*) FROM books WHERE status='Deleted'")->fetch_row()[0];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Sistem Pusat Sumber</title>

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
        }

        .sidebar {
            width: 250px;
            height: 100vh;
            background: #2c3e50;
            color: white;
            position: fixed;
            padding-top: 20px;
        }

        .sidebar h2 {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar a {
            display: block;
            color: white;
            padding: 15px 25px;
            text-decoration: none;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        .main {
            margin-left: 250px;
            padding: 30px;
        }

        .card-container {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 220px;
        }

        .card h3 {
            margin: 0;
            font-size: 18px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            margin-top: 10px;
        }

        .topbar {
            background: white;
            padding: 15px 30px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            margin-bottom: 20px;
            border-radius: 8px;
        }

        .logout {
            color: red;
        }
    </style>
</head>
<body>

<div class="sidebar">
    <h2>📚 Library Admin</h2>

    <a href="admin-dashboard.php">🏠 Dashboard</a>
    <a href="add-book.php">➕ Add Book</a>
    <a href="book-list.php">📖 Book List</a>
    <a href="borrow-list.php">🔄 Borrow Record</a>
    <a href="deleted-books.php">🗑 Delete Book</a>
    <a href="index.php" class="logout">🚪 Logout</a>
</div>

<div class="main">

    <div class="topbar">
        Welcome, <strong><?= $_SESSION['admin_name']; ?></strong> 👋
    </div>

    <h2>Dashboard Overview</h2>

    <div class="card-container">

        <div class="card">
            <h3>Total Books</h3>
            <p><?= $totalBooks ?></p>
        </div>

        <div class="card">
            <h3>Available</h3>
            <p><?= $availableBooks ?></p>
        </div>

        <div class="card">
            <h3>Borrowed</h3>
            <p><?= $borrowedBooks ?></p>
        </div>

        <div class="card">
            <h3>Deleted</h3>
            <p><?= $deletedBooks ?></p>
        </div>

    </div>

</div>

</body>
</html>