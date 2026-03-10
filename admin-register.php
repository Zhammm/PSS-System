<?php
session_start();
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $check = $conn->query("SELECT * FROM admin WHERE username='$username'");

    if ($check->num_rows > 0) {
        $error = "Username already exists!";
    } else {

        $sql = "INSERT INTO admin (username, password) 
                VALUES ('$username', '$password')";

        if ($conn->query($sql) === TRUE) {

            $_SESSION['admin_id'] = $conn->insert_id;
            $_SESSION['admin_name'] = $username;

            header("Location: admin-dashboard.php");
            exit();
        } else {
            $error = "Error: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
<title>Admin Register | Library System</title>

<style>

body{
    margin:0;
    font-family:Arial, sans-serif;
    background: linear-gradient(135deg,#2c3e50,#4ca1af);
    height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
}

/* Register Box */
.register-box{
    background:white;
    padding:40px;
    width:320px;
    border-radius:10px;
    box-shadow:0 4px 15px rgba(0,0,0,0.2);
    text-align:center;
}

.register-box h2{
    margin-bottom:20px;
    color:#2c3e50;
}

/* Inputs */
input{
    width:100%;
    padding:10px;
    margin-bottom:15px;
    border:1px solid #ccc;
    border-radius:5px;
    font-size:14px;
}

/* Button */
button{
    width:100%;
    padding:10px;
    background:#2c3e50;
    color:white;
    border:none;
    border-radius:5px;
    font-size:15px;
    cursor:pointer;
    transition:0.3s;
}

button:hover{
    background:#34495e;
}

/* Error Message */
.error{
    background:#ffdddd;
    color:#c0392b;
    padding:8px;
    margin-bottom:10px;
    border-radius:5px;
    font-size:13px;
}

</style>
</head>

<body>

<div class="register-box">

<h2>📚 Admin Register</h2>

<?php if(isset($error)){ ?>
<div class="error"><?= $error ?></div>
<?php } ?>

<form method="POST">

<input type="text" name="username" placeholder="Username" required>

<input type="password" name="password" placeholder="Password" required>

<button type="submit">Register</button>

</form>

</div>

</body>
</html>