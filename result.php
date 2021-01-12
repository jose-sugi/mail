<?php 
    /*
    ******************************************************************************
    メール送信後　結果表示画面
    2020/12/09
    杉澤
    2020/12/18
    杉澤
    2020/12/21
    杉澤
    2020/12/23
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
    <main>
        <?php
        include(dirname(__FILE__) . '/variable.php');//変数ファイルの読み込み
        include(dirname(__FILE__) . '/function.php');//関数ファイルの読み込み
        error_reporting(E_ALL);//エラー発生時に原因を表示
        ini_set('display_errors', '1');//エラー発生時に原因を表示

        $time_today = date('H:i'); //現在時刻（分：秒）


        //POSTされないときにエラー表示されるのを防ぐ
                if (!empty($_POST['adra'])) {//メールアドレス：送信元　
                    $adra = $_POST['adra'];
                } else {
                    $adra = null;
                }
                if (!empty($_POST['adrb'])) {//メールアドレス：宛先
                    $adrb = $_POST['adrb'];
                } else {
                    $adrb = null;
                }
                if (!empty($_POST['adress_bcc'])) {
                    $add_bcc = $_POST['adress_bcc'];
                } else {
                    $add_bcc = null;
                }
                if (!empty($_POST['subject'])) {//件名
                    $subj = $_POST['subject'];
                } else {
                    $subj = null;
                }
                if (!empty($_POST['tx'])) {
                    $tx = $_POST['tx'];
                } else {
                    $tx = null;
                }
                if (!empty($_POST['id'])) {
                    $id = $_POST['id'];
                } else {
                    $id = null;
                }

                if (!empty($_POST['upd'])) {
                    $upd = $_POST['upd'];
                } else {
                    $upd = null;
                }

                if (!empty($_POST['rep'])) {
                    $rep = $_POST['rep'];
                } else {
                    $rep = null;
                }

                if(!empty($_POST['dat'])) {
                    $date = $_POST['dat'];
                } else {
                    $date = null;
                }

                if(!empty($_POST['specify'])) {
                    $spe = $_POST['specify'];            
                } else {
                    $spe = null;
                }

                if(!empty($_POST['rep_yes_period_list'])) {
                    $rep_yes_period_list = $_POST['rep_yes_period_list'];  
                    if ($rep_yes_period_list !== "W") {//「毎週」を選択しなかった場合nullを代入
                            $rep_yes_period_list_w = null;
                        }          
                } else {
                    $rep_yes_period_list = null;
                    $rep_yes_period_list_w = null;
                }
                
                if(!empty($_POST['rep_yes_period_list_w'])) {
                    $rep_yes_period_list_w = $_POST['rep_yes_period_list_w'];            
                    } else {
                    $rep_yes_period_list_w = null;
                    }

                if(!empty($_POST['rep_no_date'])) {
                    $rep_no_date = $_POST['rep_no_date']; 
                    $rep_yes_period_list = null;
                    $rep_yes_period_list_w = null;
                    }

                if(!empty($_POST['rep_yes_date'])) {
                    $rep_yes_date = $_POST['rep_yes_date'];            
                    } else {
                        $rep_yes_date = null;
                    }

                if(empty($rep_no_date)) {//ラジオボタンで「日付指定」が選択されていれば、「日付指定」で選択した日付が$dateになる
                    $date = $rep_yes_date;
                } else {//ラジオボタンで「繰り返し送信」が選択されていれば、「繰り返し送信」で指定した日付が$dateになる
                    $date = $rep_no_date;
                }//※ラジオボタンで選択していないがinput[type=date]で日付指定を入力してしまったときの対策

                if (!empty($_POST['delete'])) {
                    $delete = $_POST['delete'];
                    try {//送信予約メールの確認画面で「削除」ボタンを押下すると、古いメールを削除する
                            $db = new PDO($dsn, $user, $password);
                            $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); 
                            $sql = "DELETE FROM mail WHERE id = " . $id . " ";//変更したメールのidを指定して削除
                            $stmt = $db->prepare($sql);
                            $stmt->execute();
                        } catch (PDOException $error) {
                            echo "error" . $error->getMessage();
                        } 
                } else {
                    $delete = null;
                }
        ?>
        <?php if ($functionFlag_repeat) ://繰り返し送信機能のフラグがオンのとき?>
                <?php
                $case1 = $rep == 'no' && $date == $today && $time_cron < $time_today;//繰り返し設定無し + 本日送信予定 + クーロン設定時間より遅いとき（送信予約できない）
                $case2 = $rep == 'yes' && $date == $today && $time_cron < $time_today;//繰り返し機能あり + 本日送信予定 + クーロン設定時間よりも遅いとき（本日の送信はできないが、翌日以降の繰り返し予約は可能）

                if ($case1) {
                    //処理なし
                } else if ($delete == "yes") {
                    //処理なし
                } else if ($upd == "yes") {
                    dbinUpd($adra, $adrb, $subj, $tx, $date, $id, $rep_yes_period_list, $rep_yes_period_list_w, $add_bcc);
                } else {
                    dbin($adra, $adrb, $subj, $tx, $date, $rep_yes_period_list, $rep_yes_period_list_w, $add_bcc);
                }
                
                ?>

                <div class="container">
                    <?php if ($delete == "yes") :?>
                        <p class="title send"><span>メールを削除しました</span></p>
                    <?php elseif ($upd == "yes" && $date !== $today) : ?><!-- メール内容変更画面から遷移してくるとき表示 -->
                        <p class="title send"><span>メール内容を変更しました</span></p>
                    <?php elseif ($case1) : ?><!-- 繰り返し設定無し + 本日送信予定 + クーロン設定時間より遅いとき送信予約できない -->
                        <p class="title send"><span>送信予約できませんでした</span></p>
                    <?php elseif ($case2) : ?><!-- 繰り返し機能あり + 本日送信予定 + クーロン設定時間よりも遅いとき、本日の送信はできないが翌日以降の繰り返し予約は可能 -->
                        <p class="title send"><span>繰り返し予約完了<br>本日は送信できていません</span></p>
                    <?php elseif($rep == "no"): ?><!-- 「送信日付指定」で送信したとき表示 -->
                        <p class="title send"><span>送信予約完了</span></p>
                    <?php elseif($rep == "yes"): ?><!-- 「繰り返し予約」で送信したとき表示 -->
                        <p class="title send"><span>繰り返し予約完了</span></p>
                    <?php endif; ?>
                    <a href="index.php" class="btn left">メールを送信</a>
                    <a href="list.php" class="btn right">送信予定</a>
                </div>
        <?php elseif ($functionFlag_edit): //「変更・削除機能」のフラグがオフのとき?>
        <?php
            if($spe == "no") {//ラジオボタンで「日付指定なし」が選択されていれば、自動で本日送信（「日付指定あり」に誤って入力していた時の対策）
                $date = $today;
            }

            if ($spe == "no" && $time_cron < $time_today) { //「変更」ボタンからメール内容変更したら、そのメール内容を更新
                //処理なし
            } else if ($upd == "yes") {
                dbinUpd($adra, $adrb, $subj, $tx, $date, $id, $add_bcc, $add_bcc);
            } else {
                dbin($adra, $adrb, $subj, $tx, $date, $rep_yes_period_list, $rep_yes_period_list_w, $add_bcc, $add_bcc);
            }
        ?>
        <div class="container">
            <?php if ($delete == "yes") :?>
                <p class="title send"><span>メールを削除しました</span></p>
            <?php elseif ($spe == "no" && $date == $today && $time_cron < $time_today) : ?><!-- 日付指定なし（本日送信） + クーロン時間よりも遅い時間 の送信は予約できない -->
                <p class="title send"><span>送信予約できませんでした</span></p>
            <?php elseif ($upd == "yes") : ?><!-- メール内容変更画面から遷移してくるとき表示 -->
                <p class="title send"><span>メール内容を変更しました</span></p>
            <?php else : ?>
                <p class="title send"><span>送信予約完了</span></p>
            <?php endif; ?>
            <a href="index.php" class="btn left">メールを送信</a>
            <a href="list.php" class="btn right">送信予定</a>
        </div>
        <?php else: ?>
            <?php
            if($_POST["specify"] == "no") {//ラジオボタンで「日付指定なし」が選択されていれば、自動で本日送信
                $date = $today;
            } else if ($_POST["specify"] == "yes") {//ラジオボタンで「日付指定あり」が選択されていれば、指定した日付で本日送信
                $date = $_POST["dat"];
            }

            if (!($spe == "no" && $time_cron < $time_today)) {
                dbin($adra, $adrb, $subj, $tx, $date, $add_bcc, $add_bcc);
            } 
            ?>
            <div class="container">
              <?php if ($spe == "no" && $time_cron < $time_today) : ?>
                <p class="title send"><span>送信予約できませんでした</span></p>
              <?php else : ?>
                <p class="title send"><span>送信予約完了</span></p>
              <?php endif; ?>
              <a href="index.php" class="btn left">メールを送信</a>
              <a href="list.php" class="btn right">送信予定</a>
            </div>
        <?php endif ?>
    </main>
</body>

</html>