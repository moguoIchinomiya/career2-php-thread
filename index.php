<html>
    <head>
        <title>掲示板App.verもぐお</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
        <link rel="stylesheet" href="thread.css">
    </head>
    <body>
        <h1>掲示板App.verもぐお</h1>
        <div id="input_form">
            <h2>投稿フォーム</h2>
            
            <form method="POST" action="index.php">
                <!---<input type="hidden" name="noMultiple" value="<?php echo $rnd; ?>">--->
                <div>
                    <input class="input_name" type="text" name="name" placeholder="ユーザー名" required>
                </div>
                <div>
                    <textarea class="input_contents" name="contents" rows="8" placeholder="投稿内容" required></textarea>
                </div>
                <div class="div_button">
                    <input class="submit_btn" type="submit" name="submitBtn" value="投稿">
                </div>
            </form>
            <form method="POST" action="index.php">
                <div class="div_button">
                    <input class="delete_btn" type="submit" name="deleteBtn" value="全削除">
                </div>
            </form>
        </div>
        <div id="thread">
            <h2>スレッド</h2>
            <?php
                //thread.phpの読み込み
                require 'thread.php';

                //Threadクラスの格納
                $thread = new Thread();

                //textデータの定数宣言
                const THREAD_DATA = 'thread.txt';

                //textデータがなかった場合、空のデータを作成。
                $thread -> initThread(THREAD_DATA);
                
                //削除ボタンを押したら、test.txtの中身を空にする。
                //削除ボタンでなければ、投稿する。
                if( isset($_POST['deleteBtn'])){
                    $thread -> deleteThread(THREAD_DATA);

                } else if ( isset($_POST['submitBtn'])) {
                    $thread -> inputValue(THREAD_DATA); 

                } else {
                    //リロードの重複投稿防止の奴のせいで、投稿の時にこっちも通っちゃうよ
                    $thread -> outputValue(THREAD_DATA);
                }
            ?>
        </div>
    </body>
</html>
