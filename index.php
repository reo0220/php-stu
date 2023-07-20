<?php 

    $comment_array = array();
    $pdo = null;
    $stmt = null;

    //DB接続
    try{
        $dbh = new PDO('mysql:host=localhost;dbname=php-bb', "root", "root");
    }catch(PDOException $e){
        echo $e->getMessage();
    }

    if(!empty($_POST["submitButton"])){
        $postDate = date("Y-m-d H:i:s");
        
        try{
            $stmt = $dbh->prepare("INSERT INTO `bb-table`('username','comment','postDate') VALUE(:username,:comment,:postDate)");
        
            $stmt->bindParam(':username',$_POST['username'],PDO::PARAM_STR);
            $stmt->bindParam(':comment',$_POST['comment'],PDO::PARAM_STR);
            $stmt->bindParam(':postDate',$postDate,PDO::PARAM_STR);
            $stmt->execute();
        }catch(PDOException $e){
            echo $e->getMessage();
        }
    }


    //DBから取得する
    $sql = "SELECT * FROM `bb-table`";
    $comment_array = $dbh->query($sql);

    //DBを閉じる
    $dbh = null;
    
    
?>

<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>PHP掲示板</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <h1 class="title">PHPで掲示板アプリ</h1>
        <hr>
        <div class="boardWrapper">
            <section>
                <?php foreach($comment_array as $comment):?>
                <article>
                    <div class="wrapper">
                        <div class="nameArea">
                            <span>名前：</span>
                            <p class="username"><?php echo $comment['username'];?></p>
                            <time>：<?php echo $comment['postDate'];?></time>
                        </div>
                        <p class="comment"><?php echo $comment['comment'];?></p>
                    </div>
                </article>
                <?php endforeach;?> 
            </section>
            <form class="formWrapper" method="POST">
                <div>
                    <input type="submit" value="書き込む" name="submitButton">
                    <labal for="">名前：</label>
                    <input type="text" name="username">
                </div>
                <div>
                    <textarea class="commentTextArea" name="comment"></textarea>
                </div>
            </form>
        </div>
    </body>
</html>