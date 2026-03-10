<?php
include "config.php";

$no_siri = $_GET['no_siri'];
$status = $_GET['status'];

// Update book status
$conn->query("UPDATE books SET status='$status' WHERE no_siri='$no_siri'");

// If admin click RETURN → update borrow record
if($status == 'Available'){
    $conn->query("UPDATE borrow_records 
                  SET status='Returned'
                  WHERE no_siri='$no_siri' AND status='Borrowed'");
}

header("Location: book-list.php");
exit();
?>