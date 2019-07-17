<?php
session_start();

// function for adding a new user.
if(isset($_POST['new_user'])){

  require('connection.php');
  $username = $_POST['username'];
  $password = $_POST['password'];
  $role = $_POST['role'];

  $result = $conn->query("SELECT * FROM users WHERE username='$username';");

  if($result->num_rows > 0){
    echo 'exists';
  }
  else{
    $rand = openssl_random_pseudo_bytes(48); // Random bytes for encryption. (Pepper)
    $salt = '$2a$07$'.strtr(base64_encode($rand).'$', array('_' => '.', '~' => '/')); // Password + Salt + Pepper

    //This is the hashed password which would be stored in our db

    $hashed_password = crypt($password,$salt); //BlowFish password encryption

    if($hashed_password != "*0"){ //preventing empty password from being generated.
      $sql = "INSERT INTO users (id, role, username, password ,salt)
      VALUES (NULL ,'$role', '$username' , '$hashed_password','$salt')" ;
      if ($conn->query($sql) === TRUE)
      {echo "success";} // case if the user is added successfully
      else
      {echo "fail";} //rm

  }else{echo "fail";} // as sometimes password wont hash correctly
  }
}

// function for updating the quanitity of a game.
if(isset($_POST['update']))
{
  require("connection.php");
  $id = $_POST['id'];
  $quantity = $_POST['quantity'];
  if($quantity==0){ // a case for dropping the
    $sql = "DELETE FROM games WHERE id='$id';";
  }
  else{
    $sql = "UPDATE games SET quantity='$quantity' WHERE id='$id'";
  }
  $conn->query($sql);
  if(mysqli_affected_rows($conn)>0){
    echo "updated";
  }
  else{
    echo "fail";
  }
  $conn->close();
  exit();
}

// function for adding a new game.
if(isset($_POST['add_new']))
{
  require("connection.php");

  $title=$_POST['title']; //only field that can cause sql injection.
  $price=$_POST['price'];
  $age_rating=$_POST['age'];
  $quantity=$_POST['quantity'];

  $sql = "INSERT INTO games (id, title, price, age_rating ,quantity) VALUES (NULL,'$title','$price','$age_rating','$quantity');";
  $conn->query($sql);
  if (mysqli_affected_rows($conn)>0) //record created successfully
  {
    echo "success";
  }
  else
  {
    echo "fail";
  }// uncaught fail, will echo error message.

}

?>
