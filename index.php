<?php
include 'lib.php';

$books = getBooks(); //books array

?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Welcome! to virtual book stall</title>
        <link rel="stylesheet" href="css/styles.css" type="text/css"/>
        <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_GB/all.js#xfbml=1";
        fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));</script>
        <script src="js/jquery-1.7.1.min.js"></script>
        <script src="js/core.js"></script>
    </head>
    <body>        
        <div id="fb-root"></div>

        <div id="container" style="display:none">
            <div id="login_status"></div>
        <h1>My virtual book stall</h1>
        <a href=".">Home</a>        
        <?php
        if(!isset($_GET['book'])){
         echo '<h1>Popular Books in Facebook</h1>
                <ul id="popular">

                </ul>
                <div style="clear:both" />';
        }
        ?>

        <h1>Available Books</h1>
        <ul>
        <?php
        if(isset($_GET['book'])){ //single book
            
            $book = $books[$_GET['book']]; 
            
            echo '<li>';
            echo '<a href="?book='.$book['id'].'" >';
            echo '<img src="images/'.$book['image'].'" />';
            echo '</a>';
            echo '<br />';
            echo '<strong>'.$book['name'].'</strong>';
            echo '<br />';
            echo '<span class="author">'.$book['author'].'</span>';
            echo '<br />';
            echo (string)$book['description'];
            echo '<br />';
                //like button
                echo '<div class="fb-like" 
                    data-href="http://www.imeddic.com/bookstall/?book='.$book['id'].'" 
                    data-send="false" 
                    data-layout="button_count" 
                    data-width="250" 
                    data-show-faces="false"></div>';
                
                echo '<br />';
                //comment box
                echo '<div class="fb-comments" 
                    data-href="http://www.imeddic.com/bookstall/?book='.$book['id'].'" 
                    data-num-posts="2" 
                    data-width="470"></div>';
                 echo '<div class="share" onclick="shareToMyFeed(\''.$book['id'].'\')">Share</div>';
            echo '</li>';
                
        } else{ //all books
            
            foreach ($books as $book) {
                echo '<li>';
                echo '<a href="?book='.$book['id'].'" >';
                echo '<img src="images/'.$book['image'].'" />';
                echo '</a>';
                echo '<br />';
                echo '<strong>'.$book['name'].'</strong>';
                echo '<br />';
                echo '<span class="author">'.$book['author'].'</span>';
                echo '<br />';
                echo (string)$book['description'];
                echo '<br />';
                //like button
                echo '<div class="fb-like" 
                    data-href="http://www.imeddic.com/bookstall/?book='.$book['id'].'" 
                    data-send="false" 
                    data-layout="button_count" 
                    data-width="250" 
                    data-show-faces="false"></div>';
                 echo '<div class="share" onclick="shareToMyFeed(\''.$book['id'].'\')">Share</div>';
                echo '<br />';
                echo '</li>';
            }
            
        }
        ?>
        </ul>
        </div>
    </body>
</html>
<script>
books = $.parseJSON('<?= json_encode($books)?>');
viewPopularBooks();
</script>