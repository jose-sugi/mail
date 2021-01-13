  <?php 
    /*
    ******************************************************************************
    メール予約内容確認画面
    2020/12/09
    ******************************************************************************
    */
   ?>
    
<!DOCTYPE html>
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
    include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
    include(dirname(__FILE__) . '/function.php');//関数ファイルの読み込み
    $id = $_POST['id'];
    ?>
    <?php
    try {//メール一覧で選んだメールのidを基に、メール内容を取得
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
        $sql = "SELECT * from mail WHERE id = " . $id . " ";
        $stmt = $db->prepare($sql);
        $stmt->execute();
    } catch (PDOException $error) {
        echo "error" . $error->getMessage();
    }

    // SQLより取り出したデータを配列に格納
          $data = $stmt->fetchAll();
          $id = array_column($data, 'id');
          $address_receive = array_column($data, 'address_receive');
          $address_send = array_column($data, 'address_send');
          $address_bcc = array_column($data, 'address_bcc');
          $subj = array_column($data, 'subject');
          $text = array_column($data, 'text');
          $date = array_column($data, 'date');
          $period = array_column($data, 'period');
          $week = array_column($data, 'week');

    ?>
    <?php 
                $week_array = [//数字で曜日を表示させるための配列
                      '日', //1
                      '月', //2
                      '火', //3
                      '水', //4
                      '木', //5
                      '金', //6
                      '土', //7
                    ];
                

            
                    //送信時間を表示するために場合分け
                if ($period[0] == null) {//「繰り返し送信」をしていないとき、「◯年◯月◯日」
                    $list_date = date('Y年n月j日',  strtotime($date[0]));
                } else if ($period[0] == "Y") {//「毎年」で繰り返し予約しているとき、「毎年　◯月◯日」
                    $list_date = "毎年".date('n月j日',  strtotime($date[0]));
                } else if ($period[0] == "M") {//「毎月」で繰り返し予約しているとき、「毎月　◯日」
                    $list_date = "毎月".substr($date[0],8,2)."日";
                } else if ($period[0] == "W") {//「毎週」で繰り返し予約しているとき、「毎週　◯曜日」
                    $list_date = "毎週".$week_array[$week[0] - 1]."曜日";//1〜７で日曜日〜土曜日
                } else if ($period[0] == "D") {//「毎日」で繰り返し予約しているとき、「毎日」
                    $list_date = "毎日";
                }
                
         ?>
    <div class="mail_main maincolor">
        <p class="top">送信予定メール確認</p>
        <button onclick="history.back()" class="batsu">✕</button>
        <div class="mail recieve_address">
            <p>宛先：<?php echo $address_send[0];?></p>
            <?php if ($address_bcc !== null) :?>
              <p>BCC：<?php echo $address_bcc[0]; ?></p>
            <?php endif; ?>
        </div>
        <div class="mail send_address">
            <p>件名：<?php echo $subj[0]; ?></p>
        </div>
        <div class="mail mailbody">
            <p>本文：<?php echo $text[0]; ?></p>
        </div>
        <div class="mail_date bottom">
            <p>送信予定時間：<?php echo $list_date."　".$time_cron; ?></p>
            <?php if($functionFlag_edit): //「変更・削除」機能のフラグがfalseのとき「変更」ボタンと「削除」ボタンを表示しない?>
                <div class="mail_bottom3 button">
                    <form action="result.php" name="form1" method="POST">
                        <input type="hidden" name="delete" value="yes">
                        <input type="hidden" name="id" value="<?php echo $id[0]; ?>">
                        <input type="submit" class="delete" value="削除" onclick="return del();">
                    </form>
                    <form action="edit.php" name="form1" method="POST">
                        <input type="hidden" name="id" value="<?php echo $id[0]; ?>">
                        <input type="submit" class="edit" value="編集" onclick="return edi();">
                    </form>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>
