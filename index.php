<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title></title>
    </head>
    <body>
        <?php
        
        $currTime = time();
        
        echo $currTime . "<br>";
        
        $time = strtotime('- 1 minutes');
        
        echo $time . "<br>";
        
        ?>
    </body>
</html>
