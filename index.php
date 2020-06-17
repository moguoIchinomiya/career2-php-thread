
<style>
    h1 {
        margin-top:50px;
        font-size:1.8em;
    }
    body {
        margin:0 10%;
        font-weight:600;
    }
    p {
        margin-bottom: 1rem;
    }
    form > div {
        margin-bottom: 1rem;
    }
    #thread {
        margin-top:70px;
    }
    #thread_div > div {
        border-bottom:1px solid #000;
        margin:30px 0;
    }
    .input_name, .input_contents, .submit_btn, .delete_btn {
        width:100%;
    }
    .div_button {
        padding:0 25%;
    }
    .submit_btn, .delete_btn {
        height:60px;
        color:#fff;
        font-weight:600;
        font-size:1.2em;
    }
    .submit_btn {
        background-color:#832;
    }
    .delete_btn {
        background-color:#111;
    }
    .input_name {
        height:50px;
    }
    .input_contents{
    }
    
    .submit_btn {
        font-weight:600;
        color:#fff;
        background-color:#3AB;
    }
    @media(max-width){

    }
</style>

<html>
    <head>
        <title>掲示板App.verもぐお</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0">
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
                    "<div><p>投稿日時:${time}</p><p>投稿者：${name}</p><p>${contents}<p></div>\n";
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

                    //改行コードを<br>に変換
                    $inputContents = nl2br($inputContents);

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
