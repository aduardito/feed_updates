<!DOCTYPE HTML>
<html >  
    <head>
        
        <link rel="stylesheet" type="text/css" href="asset/css/styles.css" media="all" />
        
         <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
    </head>
    
    <body>
        <div class="form_login">
            <?php if ( isset($_GET['msg']) && $_GET['msg'] != null ) : ?> 
            <div class="form_message">
                <?= str_replace( '_', ' ', $_GET['msg']); ?>
            </div>
            <?php endif; ?>
            <form action="login.php" method="post">
                <input id="user_name" type="text" name="user_name" placeholder="User Name"/>
                <input id="user_pass" type="password" name="user_pass" placeholder="Password" />
                <input type="submit" value="Enviar" />
            </form>    
            
        </div>
        
        <script type = 'text/javascript'>
            $( document ).ready(function() {
                var screenHeight = screen.height / 2;
                
                var top = screenHeight - 110 - 100;
                console.log(top);
                
                $('div.form_login').css( 'margin-top', top);
            });
        </script>
        
    </body>
    
</html>
    


