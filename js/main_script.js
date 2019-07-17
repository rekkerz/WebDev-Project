$(document).ready(function(){

  var username = $("#usersID").text();
  $.ajax({
    type:"POST",
    url:"php/check_admin.php",
    data:{
      check_admin:"true",
      username:username
    },
    success:function(response){
      if(response=="admin"){
        display_admin();}}
  });

  $("#selection").on("change",function(){
    var selected = $("#selection").val();

    $("#selected_quantity").attr("value",selected);
  });
});

function update(){
  var id = $("option:selected").attr("id");
  var quantity = $("#selected_quantity").val();

  $.ajax
  ({
    type:"POST",
    url:'php/update.php',
    data:{
      update:"true",
      id:id,
      quantity:quantity
    },
    success:function(response){
      if(response=="updated"){
        alert("Updated successfully.");
      }
      else if(response=="fail"){
        alert("Something went wrong, try again.");
      }
    }
  });
}

function add_user(){
  var new_username = $('#add_new_user').find('input[name="new_username"]').val();
  var new_password = $('#add_new_user').find('input[name="new_password"]').val();
  var new_password2 = $('#add_new_user').find('input[name="new_password2"]').val();
  var new_role = $("#new_role").val();
  if(new_password!=new_password2){ // case for when the passwords don't match.
    alert("Passwords didn't match. Try again.");
    exit();
  }
  if(new_username!="" && new_password!="" && new_role!=""){
    $.ajax({
      type:"POST",
      url:"php/update.php",
      data:{
        new_user:"true",
        username:new_username,
        password:new_password,
        role:new_role
      },
      success:function(response){
        if(response=="success"){
          alert("User added successfully.");
        }
        else if(response=="exists"){
          alert("User already exists.");
        }
        else{
          alert("An error occurred");
        }
      }
    });
  }else{
    alert("You've left some fields empty.");}}

function add_new_game(){
  var title = $('#add_new_game').find('input[name="title"]').val();
  var price = $('#add_new_game').find('input[name="price"]').val();
  var age = $('#add_new_game').find('input[name="age"]').val();
  var quantity = $('#add_new_game').find('input[name="quantity"]').val();

  if(title!="" && price!="" && age!="" && quantity!=""){
    $.ajax({
      type:"POST",
      url:"php/update.php",
      data:{
        add_new:"true",
        title:title,
        price:price,
        age:age,
        quantity:quantity
      },
      success:function(response){
        if(response=="success"){
          alert("Game added successfully.");
        }
        else if(response=="fail"){
          alert("Game already exists, just add more quantity in the field below.");
        }}});}
  else{
    alert("You left some of the fields empty.");}}

function display_admin(){ // used for displaying admins functions
  document.getElementById("title").innerHTML = "Admin logged in"; // Changing the title of the page to Admin logged in
  document.getElementById("admin").innerHTML = // adding add new user for admin users
  "<form onsubmit='add_user()' method='post' id='add_new_user'>"+
  "<h3>Create new user:</h3>"+
  "<input type='text' name='new_username' placeholder='Enter Username'>"+
  "<input type='password' name='new_password' placeholder='Enter Password'>"+
  "<input type='password' name='new_password2' placeholder='Enter Password Again'>"+
  "<select id='new_role'>"+
  "<option value='' selected='selected'>Select Role</option>"+
  "<option value='admin'>Admin</option>"+
  "<option value='employee'>Employee</option>"+
  "</select>"+
  "<input type='submit' value='Add User'>"+
  "</form>";
  $(".content").css("margin-top","350px");
}
