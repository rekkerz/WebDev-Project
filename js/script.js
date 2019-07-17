function login(){

  var username=document.getElementById("usernameID").value;
  var pass=document.getElementById("passwordID").value;

  if(username != "" && pass != ""){
  showLoad(); // starting the loading animation
  setTimeout(function(){ // putting a short delay (1.5 seconds) for animation
      $.ajax
      ({
        type:'POST',
        url:'php/auth.php',
        data:{
          login:"login",
          username:username,
          password:pass
        },
        success:function(response){
          if(response=="user")
          {
            window.location.href="main.php";
          }
          else if(response=="admin")
          {
            window.location.href="main.php";
          }
          else if(response=="fail")
          {
            alert("Wrong Details");
            hideLoad();
          }
        }
      });
    },1500);}
   else
   {
     alert("You left some or all of the fields empty 👿 ");
   }
   return false;
 }

function showLoad(){ // function for showing the Loading animation.
  document.getElementById("loading").style.visibility = "visible";
  document.getElementById("loading").style.width = "40%";
}

function hideLoad(){ // function for hiding the Loading animation.
  document.getElementById("loading").style.visibility = "hidden";
  document.getElementById("loading").style.width = "0%";
}
