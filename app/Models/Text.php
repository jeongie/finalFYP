<!-- Handle Text submission -->

<?php
        $text= $_POST["text"];
        $files= "D:/XAMPP/htdocs/laravel9/fyp/public/file/text/textreport.txt";
        file_put_contents($files ,$text);

        ?>
        
