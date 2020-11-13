<!DOCTYPE>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>メール配信システム</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    $id = $_POST['id'];
    ?>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $dsn = 'mysql:host=localhost;dbname=mailtest';
    $user = 'root';
    $password = 'root';

    try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // それぞれの単一文で自動コミットするかどうか。
        $sql = "SELECT * from mail WHERE id = " . $id . " ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    } catch (PDOException $error) {
        echo "error" . $error->getMessage();
    }

    // SQLより取り出したデータを配列に格納
    $data = $stmt->fetchAll();
    $id = array_column($data, 'id');
    $adressa = array_column($data, 'adressa');
    $adressb = array_column($data, 'adressb');
    $subj = array_column($data, 'subject');
    $text = array_column($data, 'text');
    $date = array_column($data, 'date');

    $today = date("Y/m/d");

    ?>
    <div class="mail_main">
        <p class="top">送信予定メール確認</p>
        <button onclick="history.back()" class="batsu">✕</button>
        <!-- 入力データをanswer.phpに送信 -->

        <div class="mail recieve_adress">
            <p>宛先：<?php echo $adressb[0]; ?></p>
        </div>
        <div class="mail send_adress">
            <p>件名：<?php echo $subj[0]; ?></p>
        </div>
        <div class="mail mailbody">
            <p>本文：<?php echo $text[0]; ?></p>
        </div>
        <div class="mail_date">
            <p>送信予定時間：<?php echo $date[0]; ?></p>
            <div class="mail_bottom3">
                <input type="submit" value="削除">
            </div>
        </div>
    </div>


    </main>
</body>

</html>