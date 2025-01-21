<?php
include 'connection.php';

$msg = "";
if(isset($_POST['submit'])){
    $email = $_POST['email'];
    $query = "SELECT email FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    if ($result->num_rows > 0) {
        $msg = "$email  already exist !";
    }
    else{
        $username=$_POST["name"];
        $email=$_POST["email"];
        $password=$_POST["password"];
        $sql= "insert into users (username,email,password) values ('$username','$email','$password')";
        mysqli_query($conn,$sql);
        header("Location: login.php");
}
} 

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- <meta http-equiv="refresh" content="1"> -->
    <link rel="stylesheet" href="signup.css">
</head>
<body>

    <div  class="main_div">

    <form action="signup.php" method="post">
        <h2>Signup</h2>
        <?php echo $msg ?>
        <input type="text" name="name" placeholder="Full name" ><br>
        <input type="text" name="email" placeholder="Email"><br>
        <input type="password" name="password" placeholder="Password"><br>
        <button type="submit" name="submit">Sign up</button><br>
        <a href="login.php">Already have an account? Login here</a>
    </div>

</body>
</html>