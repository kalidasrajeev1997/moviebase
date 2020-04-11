<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.">
  <title>Starter Template - Materialize</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  
  <style type="text/css">
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  
  div
  {
  overflow: auto;
  }
     @font-face {
          font-family: Circular;
         src: url("font/Circular/CircularStd-Bold.otf");
          }
      
      @font-face{
          font-family: Product;
          src: url("font/Product/ProductBold.ttf");
      }
      input[type=email] {
        width: 100%;
        padding: 12px 20px;
        margin: 8px 0;
        box-sizing: border-box;
        border: none;
        border-radius: 4px;
        background-color: #DED8D8;
       }
       input[type=password] {
         width: 100%;
         padding: 12px 20px;
         margin: 8px 0;
         box-sizing: border-box;
         border: none;
         border-radius: 4px;
         background-color: #DED8D8;
        }
        .button1
        {
         background-color: blue;
         -moz-border-radius: 1.875rem;
         -webkit-border-radius: 1.875rem;
         width: 50%;
         height: 40px;
         position: relative;
         
         font-family: Circular;
         -webkit-box-shadow: none;
         -moz-box-shadow: none;
          box-shadow: none;
          font-size: 1rem;
          font-weight: 700;
          font-family: Circular;
          color: white;
        }
        .btn:hover {
        background-color: #58D68D;
        color: black;
         }
         .btn:focus {
         background-color: #58D68D;
         color: black;
          }

           .container2
           {
             width:40%;
           }
           .footer
           {
             padding-top:80px;
           }
           .error
           {
             display: none;
           }
           .nav3
           {
             background:white;
             height: 110px;
             padding:15px;
             padding-left:20px;
             font-family: Circular;
             text-align:center;
           }
           .nav2
           {  
             display: inline-block;
             padding-top:4px;
             padding-left: 4px;
             width:180px;
             height:40px;
             border:3px solid blue;
             position:relative;
             top:16px;
             
            }
            .nav2 a
            {
             color:blue;
             font-size: 20px;
             
            }

            ::placeholder {
             color: #212121 ;
            }


  </style>
</head>
<body>
<div  role="navigation" class="nav3">
    <div class="nav2">
        <a href="home">MovieBase</a>    
    </div>
</div>     
  <div class="section no-pad-bot white"  id="container1">
    <div class="container container2" style="font-family: Circular;">
      <div class="row"> 
        <div class="parent col s12">
          <form method="post">
          <div class="col s12">
             <input type="email" id="emailid" class="validate browser-default" name="email" placeholder="Email" style="font-family: Product;color: black;">
          </div>
          <div class="col s12">
              <input type="password" id="password" class="browser-default"name="password" placeholder="Password" style="font-family: Product;color: black;">
          </div>
          <div class="col s10 error">
              <p class="errormessage" style="color: #EE2942;font-family: Product;"><b>wrong password or email</b></p>
          </div>
          <div class="col s12 but" style="padding-top:10px">
              <button type="button" id="login" class="btn btn-blue button1 flat">LOGIN</button>
          </div>
          <div class="col s12">
              <p class="signup" style="color: #black;font-family:Product;">Don't have an account?<a href="signup.php" style="color:blue;" id="signup">&nbsp Sign Up</a></p>
          </div>
          </form>
        </div>
      </div>

    </div>
   
  </div>
  
<script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
<script src="js/materialize.js"></script>
<script type='text/javascript'>
   $('#login').click(function() {

                $.ajax({

                        type: "POST",
                        url: "api/auth",
                        processData: false,
                        contentType: "application/json",
                        data: '{ "email": "'+ $("#emailid").val() +'", "password": "'+ $("#password").val() +'" }',
                        success: function(r) {
                          $('.error').css("display","none");
                          window.location.replace("home.php")
                          console.log(r)
                        },
                        error: function(r) {
                                $('.error').css("display","inline");
                                console.log(r)  
                        }

                });

        });

</script>
</body>
</html>
