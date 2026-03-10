<?php
session_start();
include "config.php";

if (!isset($_SESSION['admin_id'])) {
    header("Location: admin-login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $no_siri = $_POST['no_siri'];
    $tarikh = $_POST['tarikh'];
    $no_perolehan = $_POST['no_perolehan'];
    $pengarang = $_POST['pengarang'];
    $judul_edisi = $_POST['judul_edisi'];
    $penerbit = $_POST['penerbit'];
    $tahun = $_POST['tahun'];
    $harga = $_POST['harga'];
    $catatan = $_POST['catatan'];

    $sql = "INSERT INTO books 
            (no_siri, tarikh, no_perolehan, pengarang, judul_edisi, penerbit, tahun, harga, catatan)
            VALUES 
            ('$no_siri','$tarikh','$no_perolehan','$pengarang','$judul_edisi','$penerbit','$tahun','$harga','$catatan')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Book Added Successfully!'); window.location='book-list.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Add Book | Library</title>
<style>
    body {
        font-family: Arial;
        background: #f4f6f9;
    }
    .form-container {
        width: 600px;
        margin: 40px auto;
        background: white;
        padding: 30px;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }
    input, textarea {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
    }
    button {
        padding: 10px 20px;
        background: #2c3e50;
        color: white;
        border: none;
        cursor: pointer;
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

<div class="form-container">
    <h2>➕ Add New Book</h2>

    <form method="POST">

        <label>No Siri (Primary Key)</label>
        <input type="text" name="no_siri" required>

        <label>Tarikh</label>
        <input type="date" name="tarikh" required>

        <label>No Perolehan</label>
        <input type="text" name="no_perolehan" required>

        <label>Pengarang</label>
        <input type="text" name="pengarang" required>

        <label>Judul / Edisi</label>
        <input type="text" name="judul_edisi" required>

        <label>Penerbit</label>
        <input type="text" name="penerbit" required>

        <label>Tahun</label>
        <input type="number" name="tahun" required>

        <label>Harga (RM)</label>
        <input type="number" step="0.01" name="harga" required>

        <label>Catatan</label>
        <textarea name="catatan"></textarea>

        <button type="submit">Add Book</button>

    </form>
</div>

</body>
</html>