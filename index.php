<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title>メール自動配信フォーム</title>
  </head>
  <body>
    <div class="top">
      <h1>メール自動配信フォーム</h1>
    </div>
    <!-- 入力データをanswer.phpに送信 -->
    <form  method="POST" action="result.php">
      <label><h3>宛先アドレス：</h3>
        <textarea name="adra" rows="4" cols="40"></textarea><br>
      <label><h3>送信元アドレス：</h3>
        <input type="text" id="adrb" name="adrb"  size="40" value="" required></label><br>
      <label><h3>本文：</h3>
        <textarea name="tx" rows="4" cols="40"></textarea><br>
      <label><h3>配信指定日：</h3>
        <input type="text" id="dat" name="dat"  size="30" value="" required></label><br>
        <br>
        <input type="submit" value="登録">
      </form>
    </body>
</html>
