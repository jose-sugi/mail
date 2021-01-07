<?php 
    /*
    ******************************************************************************
    メール予約　一覧画面
    2020/12/09
    杉澤
    2020/12/18
    杉澤
    2020/12/21
    杉澤
    ******************************************************************************
    */
 ?>
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
    <div class="main_list">
        <?php
        include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
        
        try {
            $db = new PDO($dsn, $user, $password);
            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
            $sql = "SELECT * from mail;";
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
          $period = array_column($data, 'period');
          $week = array_column($data, 'week');
        ?>
        <?php 
                $week_array = [//数字で曜日を表示させるための配列
                      '日', //0
                      '月', //1
                      '火', //2
                      '水', //3
                      '木', //4
                      '金', //5
                      '土', //6
                    ];
                

            $list_date = array();

            for ($i = 0; $i < count($data); $i++) {//データベースで取得した一つずつを場合分け
                if ($period[$i] == null) {// ラジオボタン「日付指定なし（繰り返し送信なし）」で送信予約した場合
                    $list_date[$i] = date('Y年n月j日',  strtotime($date[$i]));
                } else if ($period[$i] == "Y") {//ラジオボタン「繰り返し送信」で「毎年」を選択した場合
                    $list_date[$i] = "毎年".date('n月j日',  strtotime($date[$i]));
                } else if ($period[$i] == "M") {//ラジオボタン「繰り返し送信」で「毎月」を選択した場合
                    $list_date[$i] = "毎月".substr($date[$i],8,2)."日";
                } else if ($period[$i] == "W") {//ラジオボタン「繰り返し送信」で「毎週」を選択した場合
                    $list_date[$i] = "毎週".$week_array[$week[$i] - 1]."曜日";//0〜6で日曜日〜土曜日（$weekは1〜7で日曜日から土曜日なので、マイナス１）
                } else if ($period[$i] == "D") {//ラジオボタン「繰り返し送信」で「毎日」を選択した場合
                    $list_date[$i] = "毎日";
                }
            }

            if ($functionFlag_repeat) {//繰り返し送信機能フラグをfalseにしたとき、配列から繰り返し予約メールを削除
                $flag = $list_date;//フラグがtrueのときすべての配列データを$flagに代入
            } else {
                    for ($i = 0; $i < count($id); $i++) {
                        if ($period[$i] == "Y" || $period[$i] == "M" || $period[$i] == "W" || $period[$i] == "D") {//periodカラムに"Y","M","W","D"のいずれかが含まれていたら、「繰り返し送信」メールのため$dateを削除
                            unset($date[$i]);
                        }
                    }
                $flag = $date;//フラグがfalseのときunset()で削除したデータを$flagに代入
            }
         ?>
        <p class="list_top">送信予定メール　一覧</p>
        <p class="li">送信予定日　　　　宛先　　　　　　　　　　　　　　　　　　　　件名</p>

        
        <?php $n = 0; ?>
        <ul>
            <?php for ($i = 0; $i < count($id); $i++) : ?>
                <?php $adrcou = substr_count($adressb[$i], ",") + 1;//複数名に送信するとき「A,B,・・・」とコンマで区切るので、コンマの数を数えて送信人数を判断 ?>
                <?php if ($date[$i] !== null) ://「繰り返し送信機能」のフラグをfalseにしたときに繰り返し予約メールを表示しない（unset()では削除したが配列として前に詰められていないので必要）?>
                    <form name="<?php echo 'form' . $n; ?>" method="POST" action="check.php"><!--取り出したデータをaタグで一覧表示させ、それぞれにidの値を持たせる-->
                        <?php if (strpos($adressb[$i], ',') === false) { ?>
                            <li><a href="javascript:document.<?php echo 'form' . $n; ?>.submit()"><span class="list_data"><?php echo $flag[$i]; ?></span><span class="list_ad"><?php echo $adressb[$i];?></span><span class="list_subj"><?php echo $subj[$i]; ?></span></a></li>
                        <?php } else { ?>
                            <li><a href="javascript:document.<?php echo 'form' . $n; ?>.submit()"><span class="list_data"><?php echo $flag[$i]; ?></span><span class="list_ad"><?php echo $adrcou ."名同時送信";?></span><span class="list_subj"><?php echo $subj[$i]; ?></span></a></li>
                        <?php } ?>
                        <input type="hidden" name="id" value="<?php echo $id[$i]; ?>">
                        <?php $n++; ?>
                    </form>
                <?php endif; ?>
            <?php endfor; ?>
        </ul>
        <div class="mail_bottom">
            <a href="start.php" class="btn list back">← 前の画面</a>
            <a href="index.php" class="btn list left">新規メール作成</a>
        </div>

    </div>
</body>

</html>