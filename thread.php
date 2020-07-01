<?php 
class Thread {
    public function initThread($threadData) {
        if (! file_exists($threadData)){
            $fp = fopen($threadData, "a");
            fclose($fp);
        }
    }


    //リロード時の重複防止
    private function notReload() {
        $redirect_url = $_SERVER['HTTP_REFERER'];
        header("Location: $redirect_url");
        exit;
    }
    //受け取ったポインタに入力情報、投稿日時をテキストファイルに書き込み後、fclose
    //(fopenしたファイルポインタ, 投稿者名, 投稿内容, 投稿時間)
    public function inputValue($threadData) {
        //各情報をPOSTで変数に格納
        $inputName = $_POST['name'];
        $inputContents = $_POST['contents'];

        //改行コードを<br>に変換
        $inputContents = nl2br($inputContents);

        //投稿日時を取得
        $inputTime = date("Y/m/d H:i:s");
        
        $fp = fopen($threadData, "a");

        $inputValue = 
        "<div><p>投稿日時:${inputTime}</p><p>投稿者：${inputName}</p><p>${inputContents}<p></div>\n";
        fwrite($fp, "${inputValue}");
        fclose($fp);
        $this -> notReload();
    }
    //受け取ったポインタのファイルを1行読み込み、画面に表示をファイルの終端までループ、その後、fclose
    //(fopenしたファイルポインタ)
    public function outputValue($threadData) {
        //$threadNumber = 1;
        echo "<div id='thread_div'>";
        $fp = fopen($threadData, "r");
        while(!feof($fp)){
            //echo "<span>${threadNumber}</span><br />";
            $str = fgets($fp);
            echo "${str}";
            //$threadNumber ++;
        }
        fclose($fp);
        echo "</div>";
    }
    //投稿記事全削除(ファイル名)
    public function deleteThread($threadData) {
        $fpD = fopen($threadData,"w");
        fclose($fpD);
        $this -> notReload();
    }

}

?>