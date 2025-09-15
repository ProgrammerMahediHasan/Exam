<?php
  session_start();

  if(!isset($_SESSION['name'])){
    header("location:login.php");
  }

  echo "Login successful ";
  echo "Hello {$_SESSION['name']} <br>";
  echo "Here is a {$_SESSION['role']} panel <br>";

  if(isset($_POST['btn_logout'])) {
     session_unset();
     session_destroy();
     header("location:login.php");
  }

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style> 
        body{
            display: flex;
            place-content: center;
            height: 100vh;
        }
    </style>
</head>
<body>
       <div>
        
            <form action="" method="POST"><br><br><br>
            <input type="submit" name="btn_logout" value="logout">
            </form>
       </div>

</body>
</html>