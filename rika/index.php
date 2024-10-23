<?php

    
$true_password = "alice1023";
$dataFile = 'datafile.dat';
$post_list = file($dataFile,FILE_IGNORE_NEW_LINES);
//$post_list = array_reverse($post_list);
function h($s)
{
    return htmlspecialchars($s,ENT_QUOTES,'UTF-8');
}

if(isset($_POST["send_message"]))
{
    $message = trim($_POST['message']);
    $user = trim($_POST['user_name']);

    if(!empty($message))
    {
        if(empty($user))
        {
            $user = '名無し';
        }

        $postDate = date('Y-m-d H:i:s');
        $newData = $message."/".$user."/".$postDate."\n";
        $fp = fopen($dataFile,"a");
        fwrite($fp, $newData);
        fclose($fp);
        
    }


   


    if($_SERVER["REQUEST_METHOD"]==="POST")
        {
            header('Location: toukoukanryo.php');
            exit;
        }


}

if(isset($_POST['deleteLOG'])){
    if($true_password == trim($_POST['user_password'])){
        file_put_contents($dataFile,'');
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>sled1</title>
</head>
<body>
    <h1>Horiちゃんねる</h1>
    <a href="http://localhost/2ch_modoki/index.html">スレッド一覧に戻る</a>
    <section>
        <h2>投稿一覧</h2>
        <ul>
        <!--post_listがある場合-->
        <?php if (!empty($post_list)){ ?>
            <!--post_listの中身をひとつづつ取り出し表示する-->
            <?php foreach ($post_list as $post){ ?>
            <li><?php echo h($post); ?></li>
            <?php } ?>
        <?php }else { ?>
            <li>まだ投稿はありません。</li>
        <?php } ?>
        </ul>
    </section>
    <section>
        <h2>新規投稿</h2>
        <form action="" method="post">
            名前: <input type="text" name="user_name"><br>
            本文: <textarea name="message" rows="3"></textarea><br>
            <button type="submit" name="send_message" value="投稿">投稿する</button>
        </form>
    </section>
    <section>
        <form action="" method="post">
            password: <input type="text" name="user_password"><br>
            <button type="submit" name="deleteLOG">ログ削除</button>
        </form>
    </section>
    


</body>
</html>