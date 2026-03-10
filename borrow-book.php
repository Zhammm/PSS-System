<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

$no_siri = $_GET['no_siri'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nama = $_POST['nama_peminjam'];
    $tarikh_pinjam = $_POST['tarikh_pinjam'];
    $tarikh_pulang = $_POST['tarikh_pulang'];

    // Insert into borrow_records
    $conn->query("INSERT INTO borrow_records 
        (no_siri, nama_peminjam, tarikh_pinjam, tarikh_pulang) 
        VALUES ('$no_siri','$nama','$tarikh_pinjam','$tarikh_pulang')");

    // Update book status
    $conn->query("UPDATE books SET status='Borrowed' WHERE no_siri='$no_siri'");

    header("Location: book-list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Borrow Book</title>
<style>
    body { font-family: Arial; background:#f4f6f9; }
    .box {
        width: 400px;
        margin: 80px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
    }
    input { width:100%; padding:8px; margin-bottom:15px; }
    button { padding:8px 15px; background:#2c3e50; color:white; border:none; }
</style>
</head>
<body>

<div class="box">
    <h3>Borrow Book (<?= $no_siri ?>)</h3>

    <form method="POST">
        <label>Nama Peminjam</label>
        <input type="text" name="nama_peminjam" required>

        <label>Tarikh Pinjam</label>
        <input type="date" name="tarikh_pinjam" required>

        <label>Tarikh Pulang</label>
        <input type="date" name="tarikh_pulang" required>

        <button type="submit">Confirm Borrow</button>
    </form>
</div>

</body>
</html>