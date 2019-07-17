<?php

session_start();

if(isset($_POST['login']))
{
  require("connection.php");

  $username = $_POST['username'];
  $password = $_POST['password'];

  $username = $conn->real_escape_string($username); //preventing injection attack

  $sql = "SELECT * FROM users WHERE username='$username';";
  $result = $conn->query($sql);

  if ($result->num_rows > 0) //if the username has been found.
  {
    while($row = $result->fetch_assoc())
    {
      if($row["password"] == crypt($password,$row["salt"]))
        {
          $_SESSION['user'] = $username;

          if ($row["role"]=="admin"){

            $_SESSION['admin']="admin";
            echo 'admin';
          }
          else{
          echo 'user';
          }

        }//rm Correct password case

        else{echo "fail";} //rm Incorrect password case
    }
  }else{echo "fail";} //rm Incorrect username case
mysql_close($conn);
}

?>
