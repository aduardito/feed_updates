<?php

    include( 'includes/DisplayData.php' );
    
    $data = new DisplayData();
    
    $content = $data->fetchContent();
    

?>
<!DOCTYPE HTML>
<html>
    
    <head>
        
        <link rel="stylesheet" type="text/css" href="asset/css/feed.css" media="all" />
        <script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        
    </head>
    
    <body>
        
        <header>
            <a href="logout.php">log out</a>
        </header>
        <div id="updated_message">
        </div>
         
        <div id="wrapper">
            <?= $content; ?>
            <div class="clear:both;"></div>
        </div>
        
        
        <script>
            $(document).ready(function(){
                

                window.setInterval(function(){
                  refreshNews();
                }, 5000);



            });
            
            function refreshNews()
            {
                $.ajax({
                    type: "GET",
                    url: "update_feed.php?name=bbc_name",
                    dataType: 'json',
                    success: function(data){
                        console.log(data);
                        $('#updated_message').empty();
                        $('#updated_message').append('latest update:' + data.time);
                    },
                    error:function(){
                        alert('error');
                    }
                });
            }
        </script>
        
        
    </body>
</html>
