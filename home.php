<?php
include("class/DB.php");
include("class/login.php");
$userid = null;
if(Login::isLoggedIn())
{
  $userid =  Login::isLoggedIn(); 
  $username1 = DB::query('SELECT name FROM users WHERE id=:id',array(':id'=>$userid))[0]['name'];
  $email1 = DB::query('SELECT email FROM users WHERE id=:id',array(':id'=>$userid))[0]['email']; 
}
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.">
  <title>Starter Template - Materialize</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/css?family=Material+Icons|Material+Icons+Outlined|Material+Icons+Two+Tone|Material+Icons+Round|Material+Icons+Sharp" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
      
  <style>
    html, body {
      height: 100%;
      margin: 0;
      padding: 0;
    }
    

    @font-face {
          font-family: Circular;
         src: url("font/Circular/CircularStd-Bold.otf");
          }
    @font-face{
          font-family: Product;
          src: url("font/Product/ProductBold.ttf");
    }
    .nav3
    {
      height: 110px;
      padding:15px;
      padding-left:20px;
      font-family: Circular;
    }
    .nav2
    {
      
      display: inline-block;
      padding-top:4px;
      padding-left: 4px;
      width:180px;
      height:40px;
      border:3px solid blue;
      float:left;
      position:relative;
      top:16px;
      
    }
    .nav2 a
    {
     color:blue;
     font-size: 20px;
     
    }
    
    .nav4
    {
     color:white;
     display:inline-block;
     float: right; 
     position:relative;
     top:16px;
     right:130px;
     text-align:center;
    }
    #logout
    {
      position:relative;
      top:22px;
      right:-20px;
      background: blue;
      padding:5px 10px 5px 10px;
    }
    #signin
    {
      position:relative;
      top:22px;
      right:-20px;
      background: blue;
      padding:5px 10px 5px 10px;
    }
    .navimg
    {
     border-radius:50%;
     width:45px;
     height:45px;
     object-fit:cover;
    }
    .nav4 i
    {
     font-size: 45px;
    }
    .sidebar
    {
     display: block;
     font-family: Circular;
     font-size: 18px;
     width: 18%;
     float: left;
     height: 100%; /** IE 6 */
     min-height: 100%;
    }
        
    .sidebar li
    {
     padding-top: 8px;    
    }
    a:hover
    {
      color: blue;
    }
    a{
      color:#616161;
    }
    .dropdown-content{
      min-width:220px;
    }
    .dropli:hover
    { 
      background: #f5f5f5 !important;
    }
   
  </style> 
</head>
<body>
<div  role="navigation" class=" nav3 white">
        <div class="nav2">
            <a href="#">MovieBase</a>    
        </div>
        <div class="nav4 dropdown-trigger" data-target="dropdown1">
        <?php
        if(Login::isLoggedIn())
        {
        
          echo '<a><img class="navimg"  src="images/img.jpg"/></a>';
           
          
        }
        else
        {
          echo '<i class="material-icons-outlined">account_circle</i>';
        }
        
        ?>     
        </div>
        <?php 
          if(Login::isLoggedIn())
          {
             echo '<div id="logout" style="color:black;float:right;">LOGOUT</div>';
          }
          else
          {
            echo '<a href="login.php"><div id="signin" style="color:black;float:right;">SIGN IN</div></a>';
          }
          
        ?>
        
</div>
<div class="sidebar">
    <!-- Grey navigation panel -->
    <div>
     <ul style="padding:24px;">
       <li style="color: black;">SURF</li>
       <li><a  href="home.php">Home</a></li>
     </ul>
    </div>
</div>

<ul id='dropdown1' class='dropdown-content grey lighten-2' style="font-family:Product;">
          <?php
          if(Login::isLoggedIn())
          {
            echo '
            <li class="dropli"><a style="color:black;font-size:16px;" ><i class="material-icons-outlined" style="color:#212121">face</i>'.$username1.'<br><br><i class="material-icons-outlined" style="color:#212121">mail</i>'.$email1.'</a></li>
            ';
          }
          else
          {
            echo'
            <li class="dropli"><a style="color:black;font-size:16px;" href="login.html"><i class="material-icons-outlined" style="color:#212121">account_circle</i>login</a></li>
            <li class="dropli"><a style="color:black;font-size:16px" href="signup.html"><i class="material-icons-outlined" style="color:#212121;">person_add</i><span>signup</span></a></li>
            ';
          }
          ?>
</ul> 
<div id="movies" style="display:inline-block;width:80%;">

</div>
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>    
<script type='text/javascript'> 
    $('.dropdown-trigger').dropdown({
        inDuration: 225,
        constrainWidth: false,
        coverTrigger: false
    });
    $.ajax({
        type: 'GET',
        url: 'api/movies',
        processData: false,
        contentType: 'application/json',
        async: false,
        data: '',
        success: function(r){
        r = JSON.parse(r)
        for (var i = 0; i < r.length; i++)
        {
           $('#movies').html($('#movies').html()+'<div data-value="'+r[i].id+'" data-user="'+r[i].user_rate+'" style="width:70%;padding:20px;display:flex;height:250px;overflow:hidden;border-radius:0px;" class="rater card grey lighten-2 white-text"><div class="rater1" style="display:flex;font-family:Circular;color:black;"><img src="'+r[i].images+'" style="width:120px;height:220px;"><div style="display:block;padding-left:8px;font-family:Product;"><h4>'+r[i].movie_name+'</h4><div>Director: '+r[i].director+'</div><div>Writer: '+r[i].writer+'</div><div>Stars: '+r[i].stars+' </div><div class="aratdiv"  style="text-align:initial;width:170px;height:27px;color:black;background:#58D68D;font-family: Product;position:relative;padding-left:10px;">'+r[i].rates+'<i class="material-icons" style="font-size: 19px;color:blue;position: relative;top:3px;">star</i></div><div class="ratingdiv" style="color:white;text-align:initial;background:blue;width:156px;position: relative;top:4px;font-family: Product;"><div  value = "1" class="s" style="background-color: #2196f3;border-radius:50%;position: relative;top:-4px;left:8px;display:inline-block;font-size: 14px;width:21px;text-align: center;cursor: pointer;" value=1><span style="position: relative;top:1px;right: 1px;">1</span></div><div  value = "2" class="s" style="background-color: #2196f3;border-radius:50%;position: relative;top:-4px;left:10px;display:inline-block;font-size: 14px;width:21px;text-align: center;cursor: pointer;"><span style="position: relative;top:1px;">2</span></div><div  value = "3" class="s" style="background-color: #2196f3;border-radius:50%;position: relative;top:-4px;left:12px;display:inline-block;font-size: 14px;width:21px;text-align: center;cursor: pointer;"><span style="position: relative;top:1px;">3</span></div><div  value = "4" class="s" style="background-color: #2196f3;border-radius:50%;position: relative;top:-4px;left:14px;display:inline-block;font-size: 14px;width:21px;text-align: center;cursor: pointer;"><span style="position: relative;top:1px;">4</span></div><div  value = "5" class="s" style="background-color: #2196f3;border-radius:50%;position: relative;top:-4px;left:16px;display:inline-block;font-size: 14px;width:21px;text-align: center;cursor: pointer;"><span style="position: relative;top:1px;">5</span></div><div class="remsongrat" style="color:#D32F2F;display:inline;position: relative;left:18px;"><i class="material-icons" style="cursor:pointer;position: relative;top:4px;">remove_circle</i></div></div><div class="count" style="padding-top:4px;">Reviews: '+r[i].count+'</div></div></div></div>')
        }
        $('.rater').each(function(){
           user =  $(this).closest('.rater').attr('data-user');
           //alert(user)
           if(user.charAt(0)!= 'r' )
            {
              $(this).children('.rater1').find('.ratingdiv .s[value='+user.charAt(0)+']').css("background-color","orangered");
            }        
        });
        }
        ,
        error: function(r){
        console.log(r)
        }
    });
    <?php
     if(Login::isLoggedIn())
     {
       echo "$('.s').unbind().click(function(){
        var s = $(this).attr('value')
        var s1 = $(this).closest('.rater').attr('data-value');
        var s2 = $(this).closest('.rater1').find('.count');
        var s3 = $(this).closest('.ratingdiv').find('.s');
        var s4 = $(this)
        var s5 = $(this).closest('.rater1').find('.aratdiv');
        
        $.ajax({
          type: 'POST',
          url:  'api/rates?value='+$(this).attr('value')+'&id='+s1,
          processData: false,
          contentType: 'application/json',
          async: false,
          data: '',
          success: function(r){
            r = JSON.parse(r)
            
            s3.css('background-color','#2196f3');
            s4.css('background-color','orangered');
            s5.html(r.movievalue+'<i class=".'material-icons'." style=".'"font-size: 19px;color:blue;position: relative;top:3px;right:0px;"'.">star</i>')
            s2.html('Reviews: '+r.count)
              console.log(r) 
            },
            error: function(r){}

        });  
        }); 
    ";  
     }
     else
     {
      echo "$('.s').unbind().click(function(){
         alert('Sign in')
      });
      
      ";

     }
    ?>
    
    $('.remsongrat i').unbind().click(function(){
          var l2 = $(this).closest('.ratingdiv').find('.s')
          var k1 = $(this).closest('.rater').attr('data-value');
          var k3 = $(this).closest('.rater');
          var k5 = $(this).closest('.rater1').find('.aratdiv');
          $.ajax({
            type: 'POST',
            url:  'api/remove?id='+k1,
            processData: false,
            contentType: 'application/json',
            async: false,
            data: '',
            success: function(r){
              r = JSON.parse(r)
              l2.css("background-color","#2196f3");
              k3.find('.s').css("background-color","#2196f3");
              k5.html(r.movievalue+'<i class="material-icons" style="font-size: 19px;color:blue;position: relative;top:3px;right:2px;">star</i>')
              console.log(r)
              },
              error: function(r){
          
              }
              });
    });          
                              
        
        
        $('#logout').click(function(){
          
              $.ajax({
              type: 'DELETE',
              url: 'api/logout',
              proccessData: false,
              contentType: 'application/json',
              async: false,
              data: '',
              success: function(r){
                
                    window.location.reload();
                
              },
              error: function(r){}
            });
        });                        
</script>
</html>