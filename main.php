<?php

session_start();
if(!isset($_SESSION['user'])){
  header("Location:index.html");
  session_destroy();
}
//session_destroy();

require("php/connection.php");

if(isset($_POST['logout'])){ // code to log out
  unset($_SESSION['user']);
  session_destroy();
  header("Location:index.html");
}

$games = array();

$sql = "SELECT * FROM games;";

$result = $conn->query($sql);
if ($result->num_rows > 0){
    // output data of each row
    while($row = $result->fetch_assoc()){
    $output = "<option id=".$row['id']." value =".$row['quantity'].">".$row['title']."</option>";
    array_push($games,$output);
  }
}

?>
<html lang="en">
  <head>
    <link rel="stylesheet" href="css/main.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="js/main_script.js"></script>
    <title id = "title">Employee logged in</title>
    <meta name="viewport" content="width=device-width, initial-scale=1" />
  </head>
  <body>
    <div class='nav'>
      <div class="logout">
      <p> Welcome, <?php echo $_SESSION['user']; ?></p>
      <p id="usersID"><?php echo $_SESSION['user']; ?></p><!--Hidden element thats used for changing page to admin page.-->
      <form method="post"><input id = 'logout' type='submit' name='logout' value='Logout'></form>
      </div>
      <div id="add_new_game" class='add_game' onsubmit="add_new_game()">
        <h3>Add new game:</h3>
        <form method="post">
          <input type="text" name="title" placeholder="Title of the game">
          <input type="number" name="price" placeholder="Price" step="0.01" min="0" max="1000">
          <input type="number" name="age" placeholder="Age Rating" min="0" max="18">
          <input type="number" name="quantity" placeholder="Quantity" min="0" max="10000">
          <input id="submit" type="submit" value="Add Game">
        </form>
      </div>
      <div class = "update">
        <h3>Update quantity:</h3>
        <form method="post" onsubmit="update()">
          <select id='selection' name="game">
            <option value="" selected = "selected"><== Select a game ==></option>
            <?php // PHP script for selecting a game to change quantity of
            foreach($games as $game){echo $game;}
            ?>
          </select>
          <input id="selected_quantity" type='number' name='quantity' min='0' max='1000' value=''>
          <input id="submit" type="submit" value="Update">
        </form>
      <div id="admin">
      </div>
      </div>
    </div>
    <div id ="main_content" class='content'>
      <?php // PHP script for displaying all games
      require("php/connection.php");
      $sql = "SELECT * FROM games;";
      $result = $conn->query($sql);
      if ($result->num_rows > 0){
          $output = '<ul class="list">';
          // output data of each row
          while($row = $result->fetch_assoc()){
            $output.='<li class="game"> <ul> <li class="title"> id:'.$row['id'].' - '.$row["title"]."</li>"
            ."<li class ='price'>Price = £".$row["price"]."</li>"
            ."<li class='age'>".$row["age_rating"]."+</li>"
            ."<li class ='quantity'>Quantity = ".$row["quantity"]."</li></ul></li>";}
          $output.="</ul>";echo $output;}
      ?>
    </div>
  </body>
</html>
