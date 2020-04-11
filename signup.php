<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.">
  <title>Starter Template - Materialize</title>

  <!-- CSS  -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <link href="css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <link href="css/style.css" type="text/css" rel="stylesheet" media="screen,projection"/>
  <style type="text/css">
  html, body {
    height: 100%;
    margin: 0;
    padding: 0;
  }
  #container1 { /* div you want to stretch */
   
    height: 100; /** IE 6 */
    min-height: 100%;
  }
  div
  {
  overflow: auto;
  }
  nav{
    height: 105px;
    font-family: Circular;
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
        input[type=text] {
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
         -webkit-box-shadow: none;
         -moz-box-shadow: none;
          box-shadow: none;
          font-size: 1rem;
          font-weight: 700;
          font-family: Circular;
          color: white;
        }
        .btn:hover {
        background-color: #21D88B;
        color: black;
         }
         .btn:focus {
         background-color: #21D88B;
         color: black;
          }
          
          ::placeholder {
           color: #212121 ;
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
           .successmessage
           {
             display: none;
           }
           
           .line
           {
            display:none;
            margin: 10px;
            margin-top:20px;
            margin-left: 15px;
            padding: 2px 4px 2px 4px;
            animation: pulse 1s infinite ease-in-out;
            -webkit-animation: pulse 1s infinite ease-in-out;
           }
           @keyframes pulse
           {
          0%{
                background-color: rgba(74, 20, 140,.4);
            }
            
            50%{
                background-color: rgba(74, 20,140,.8);
            }
            
            100%{
                background-color: rgba(74, 20, 140,.4);
            }
        
          }
          @-webkit-keyframes pulse
          {
            0%{
                background-color: rgba(165, 165, 165,.1);
            }
            
            50%{
                background-color: rgba(165, 165, 165,.3);
            }
            
            100%{
                background-color: rgba(165, 165, 165,.1);
            }
          }
            .material-tooltip 
            {
              padding: 10px 8px;
              font-size: 1rem;
              font-family: Product;
              font-size: 0.8em;
              font-weight: 700;
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
          


  </style>
</head>
<body>
    <div  role="navigation" class="nav3">
        <div class="nav2">
            <a href="#">MovieBase</a>    
        </div>
    </div>    
  <div class="section no-pad-bot white" id="container1">
    <div class="container container2" style="font-family: Product;">
      <div class="row">
        <div class="parent col s12">
          <form method="post">
          <div class="col s12">
              <input type="text" id="name" class="browser-default tooltipped" name="username" data-position="right" data-tooltip="no symbols allowed" placeholder="Name" style="font-family: Product;color: black;">
          </div>
          <div class="col s12">
             <input type="email" id="emailid" class="validate browser-default" name="email" placeholder="Email" style="font-family: Product;color: black;">
          </div>
          <div class="col s12">
              <input type="password" id="password" class="browser-default tooltipped" data-position="right" data-tooltip="Lenght should be between 6 and 60" name="password" placeholder="Password" style="font-family: Product;color: black;">
          </div>
          <div class="col s10 error">
              <p class="errormessage" style="color: #EE2942"></p>
          </div>
          <div class="col s12 but" style="padding-top:10px">
              <button type="button" id="signup" class="btn btn-blue button1 flat">SIGN UP</button>
          </div>
          
          <div class="line" style="color:white;background:#4a148c;">PROCESSING</div>
          <br>
          
          
          
          <div class="col s12" style="padding-top:12px;">
              <p class="signup" style="color: black;font-family:Product;">Already have an account?<a href="login.php" style="color:blue">&nbsp Login</a></p>
          </div>
        </form>
        </div>
      </div>

    </div>
    
  </div>

  <script src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
  <script src="js/materialize.js"></script>
  <script type='text/javascript'>
      $('.tooltipped').tooltip();

     $('#signup').click(function() {
  
                  $.ajax({
  
                          type: "POST",
                          url: "api/users",
                          processData: false,
                          contentType: "application/json",
                          data: '{ "username": "'+ $("#name").val() +'", "password": "'+ $("#password").val() +'" ,"email": "'+ $("#emailid").val() +'" }',
                          beforeSend: function()
                          {
                            $('.line').css("display","inline-block"); 
                            $('.successmessage').css("display","none");
                          },
                          success: function(r) {
                            console.log(r)
                            $('.errormessage').css("display","none");
                            $('.successmessage').css("display","inline-block");
                            window.location.replace("home.php")
                          },
                          error: function(r) {
                            //r = JSON.parse(r)
                            var n = r.responseText
                            n = JSON.parse(n)
                            console.log(n.Error);
                            $('.errormessage').html('<b>'+n.Error+'</b>');
                            $('.error').css("display","inline");
                                
                          },
                          complete: function(){
                            $('.line').css("display","none");
                          }
  
                  });
  
          });
  
  </script>
</body>
</html>
