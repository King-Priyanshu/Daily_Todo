<?php
session_start(); // Start the session

include 'connection.php';

$msg = " ";

if (isset($_POST['submit'])){
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email' AND password = '$password'";
    $result = mysqli_query($conn, $sql);


if (isset($_SESSION['email'])){
    header('Location: todo.php');
    exit();
}


    if ($result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['email'] = $row['email']; // Set session variable
        header('Location: todo.php');
        exit();
    } else {
        $msg = "User not found!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="signup.css">
</head>
<body>

    <div class="main_div">
        <form action="login.php" method="post">
            <h2>Login</h2>
            <?php echo $msg ?>
            <input type="text" name="email" placeholder="Email"><br>
            <input type="password" name="password" placeholder="Password"><br>
            <button type="submit" name="submit">Login</button><br>
            <a href="signup.php">Don't have an account? SignUp here</a>
        </form>
    </div>

</body>
</html>
