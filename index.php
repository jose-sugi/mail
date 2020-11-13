<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>メール配信システム</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <script>
        function confirm_test() {
            var select = confirm("送信しますか？");
            return select;
        }
    </script>
    <div class="mail_main">
        <p class="top">新規メール作成</p>
        <button onclick="history.back()" class="batsu">✕</button>
        <!-- 入力データをanswer.phpに送信 -->
        <form method="POST" action="result.php" onsubmit="return confirm_test()">
            <div class="mail send_adress">
                <input type="text" id="adrb" name="adrb" size="40" value="" placeholder="メールアドレス" required>
            </div>
            <div class="mail recieve_adress">
                <input type="text" name="adra" rows="4" cols="40" placeholder="宛先"></input>
            </div>
            <div class="mail send_adress">
                <input type="text" name="subject" size="40" value="" placeholder="件名" required>
            </div>
            <div class="mail mailbody">
                <textarea name="tx" rows="4" cols="40"></textarea>
            </div>
            <div class="mail_date">
                <div class="mail_bottom1">
                    <input type="radio" name="specify" value="no" checked><label>日時指定なし</label>
                </div>
                <div class="mail_bottom2">
                    <input type="radio" name="specify" value="yes"><label>日時指定あり</label>
                    <input type="date" id="dat" name="dat" size="30" value="">
                </div>
                <div class="mail_bottom3">
                    <input type="submit" value="送 信">
                </div>
            </div>

        </form>

    </div>
</body>

</html>