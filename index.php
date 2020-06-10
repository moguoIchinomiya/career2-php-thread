
<style>
    #thread_div > div {
        border-bottom:1px solid #000;
        margin:30px 0;
    }
    body {
        margin:0 10%;
        font-weight:600;
    }
    form > div {
        margin-bottom: 1rem;
    }
    p {
        margin-bottom: 1rem;
    }
    .input_name, .input_contents, .submit_btn, .delete_btn {
        width:100%;
    }
    .submit_btn, .delete_btn {
        height:40px;
    }
    .input_name {
        height:50px;
    }
    .input_contents{
    }
    .submit_btn {

    }

</style>

<html>
    <head>
        <title>掲示板App.verもぐお</title>
        <meta name="viewport" content="width=768px">
        <meta name="viewport" content="width=568px">
        <meta name="viewport" content="width=376px">

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
                <div>
                    <input class="submit_btn" type="submit" name="submitBtn" value="投稿する">
                </div>
            </form>
            <form method="POST" action="index.php">
                <div>
                    <input class="delete_btn" type="submit" name="deleteBtn" value="削除する">
                </div>
            </form>
        </div>
        <div id="thread">
            <h2>スレッド</h2>
            <?php
                //textデータの定数宣言
                const THREAD_DATA = 'test.txt';
                //textデータがなかった場合、空のデータを作成。
                if (! file_exists(THREAD_DATA)){
                    $fp = fopen(THREAD_DATA, "a");
                    fclose($fp);
                }
                
                //受け取ったポインタに入力情報、投稿日時をテキストファイルに書き込み後、fclose
                function inputValue($fp, $name, $contents, $time) {
                    $inputValue = 
                    "<div><p>投稿日時:${time}</p><p>投稿者：${name}</p><p>内容:<br />${contents}<p></div>\n";
                    fwrite($fp, "${inputValue}");
                    fclose($fp);
                    $redirect_url = $_SERVER['HTTP_REFERER'];
                    header("Location: $redirect_url");
                    exit;
                }
                //受け取ったポインタのファイルを1行読み込み、画面に表示をファイルの終端までループ、その後、fclose
                function outputValue($fp) {
                    echo "<div id='thread_div'>";
                    while(!feof($fp)){
                        $str = fgets($fp);
                        echo "${str}";
                    }
                    fclose($fp);
                    echo "</div>";
                }
                //削除ボタンを押したら、test.txtの中身を空にする。
                //削除ボタンでなければ、投稿する。
                if( isset($_POST['deleteBtn'])){
                    $fpD = fopen(THREAD_DATA,"w");
                    fclose($fpD);
                    $redirect_url = $_SERVER['HTTP_REFERER'];
                    header("Location: $redirect_url");
                    exit;
                } else if ( isset($_POST['submitBtn'])) {
                    //各情報をPOSTで変数に格納
                    $inputName = $_POST['name'];
                    $inputContents = $_POST['contents'];

                    //投稿日時を取得
                    $inputTime = date("Y/m/d H:i:s");
                    
                    $fp = fopen(THREAD_DATA, "a");
                    inputValue($fp, $inputName, $inputContents, $inputTime);                       
                } else {
                    $fpR = fopen(THREAD_DATA, "r");
                    outputValue($fpR); 
                }

            ?>
        </div>
    </body>
</html>
