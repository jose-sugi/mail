<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>メール配信システム</title>
    <link rel="stylesheet" href="style.css">
  </head>
  <body>
    <div class="mail_main">
            <p class="top">新規メール作成</p>
            <!-- 入力データをanswer.phpに送信 -->
            <div>
                <form  method="POST" action="result.php">
                    <div class="mail recieve_adress">
                        <input type="text" name="adra" rows="4" cols="40" placeholder="宛先"></textarea>
                    </div>
                    <div class="mail send_adress">
                        <input type="text" id="adrb" name="adrb"  size="40" value=""  placeholder="送信元" required></label> 
                    </div>
                    <div class="mail mailbody">
                        <input type="textarea" name="tx" rows="4" cols="40" placeholder="本文"></textarea>
                    </div>
                    <p>配信指定日：</p>
                    <input type="text" id="dat" name="dat"  size="30" value="" required></label><br>
                    <br>
                    <input type="submit" value="登録">
                  </form>
            </div>
                
    </div>
  </body>
</html>
