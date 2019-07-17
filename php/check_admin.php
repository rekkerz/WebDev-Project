<?php
  if(isset($_POST["check_admin"])){
    require('connection.php');
    $username = $_POST["username"];
    $sql = "SELECT role FROM users WHERE username='$username';";
    $response = $conn->query($sql);
    if ($response->num_rows > 0) //if the username has been found.
    {while($row = $response->fetch_assoc())
      {echo $row["role"];}}}
?>
