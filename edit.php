<?php 
    /*
    ******************************************************************************
    送信予約メール　編集画面
    2020/12/09
    杉澤
    2020/12/18
    杉澤
    2020/12/21
    杉澤
    2020/12/25
    杉澤
    2021/01/05
    杉澤
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
    try {//一覧表で選択したメールのidを指定して、内容を取得
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
          $adressa = array_column($data, 'adressa');
          $adressb = array_column($data, 'adressb');
          $subj = array_column($data, 'subject');
          $text = array_column($data, 'text');
          $date = array_column($data, 'date');
          $period = array_column($data, 'period');
          $week = array_column($data, 'week');
    ?>
    <div class="mail_main">
        <p class="top">送信予定メール　編集</p>
        <button onclick="history.back()" class="batsu">✕</button>
        <!-- 入力データをanswer.phpに送信 -->
        <form method="POST" action="result.php" name="form1" onsubmit="return check_empty()">
            <div class="mail recieve_adress">
                <input type="email" id="adra" name="adra" size="40" value="<?php echo $adressa[0]; ?>" placeholder="メールアドレス" maxlength='<?php echo $max_adress; ?>' onChange="check(this.name)" required>
            </div>
            <div class="mail send_adress">
                <input type="email" name="adrb" rows="4" cols="40" value="<?php echo $adressb[0]; ?>" placeholder="宛先　　※複数の場合は「,」で区切る" maxlength='<?php echo $max_adress_send; ?>' onChange="check(this.name)" required multiple></input>
            </div>
            <div class="mail send_adress">
                <input type="textarea" name="subject" size="40" value="<?php echo $subj[0]; ?>" placeholder="件名" maxlength='<?php echo $max_subject; ?>' onChange="check(this.name)" required>
            </div>
            <div class="mail mailbody">
                <textarea name="tx" rows="4" cols="40" maxlength='<?php echo $max_body; ?>' onChange="check_mailbody()" required><?php echo $text[0]; ?></textarea>
            </div>
                <?php if($functionFlag_repeat)://「繰り返し機能」のフラグがtrueの場合、送信設定画面を表示 ?>
                    <div class="mail_date rep">
                        <div class="mail_submit">
                            <p>送信設定</p>
                            <div class="message_container" id="message_container">
                                <div>　繰り返し　：
                                    <span id="output_message" class="status_display"></span>
                                    <span id="output_message2" class="status_display2"></span>
                                    <span id="output_message3" class="status_display3"></span>
                                </div>
                                <div>送信開始予定：<span id="output_message4" class="status_display4"></span></div>
                            </div>
                            <div class="radio_rep">
                                <input type="radio" name="rep" onClick="hyoji(0);changeDisabled0();" value="no" checked><label>日付指定</label><!-- 日時指定と繰り返し予約をラジオボタンで選択 -->
                                <input type="radio" name="rep" onClick="hyoji(1);changeDisabled1();" value="yes"><label>繰り返し予約</label>
                            </div>
                            <div id="date_no" class="date_no">
                                <label>送信予定日 :</label><input type="date" name="rep_no_date" min="<?php echo $today; ?>"><!-- ラジオボタンで「日時指定」を選択したときに表示 -->
                            </div>
                            <div id="date_yes" class="date_yes"><!-- ラジオボタンで「繰り返し予約」を選択したときに表示 -->
                                <label>周期　:</label>
                                <select name="rep_yes_period_list" onChange="select();status1(this);status2(event)"><!-- データリストで毎年・毎月・毎週・毎日を選択 -->
                                        <option></option>
                                        <option id="list_y" value="Y">毎年</option>
                                        <option id="list_m" value="M">毎月</option>
                                        <option id="list_w" value="W">毎週</option>
                                        <option id="list_d" value="D">毎日</option>
                                </select>
                            </div>
                            <div id="check_container" class="check_container" onChange=status3();><!-- 毎週を選択したときに日〜月曜日のラジオボタンを表示 -->
                                <label>曜日　:</label>
                                <input type="radio" name="rep_yes_period_list_w" value="1" checked><label>日曜日</label>
                                <input type="radio" name="rep_yes_period_list_w" value="2"><label>月曜日</label>
                                <input type="radio" name="rep_yes_period_list_w" value="3"><label>火曜日</label>
                                <input type="radio" name="rep_yes_period_list_w" value="4"><label>水曜日</label>
                                <input type="radio" name="rep_yes_period_list_w" value="5"><label>木曜日</label>
                                <input type="radio" name="rep_yes_period_list_w" value="6"><label>金曜日</label>
                                <input type="radio" name="rep_yes_period_list_w" value="7"><label>土曜日</label>
                            </div>
                            <div id="date_rep" class="date_rep"><!-- ラジオボタンで「繰り返し予約」を選択したときに表示 -->
                                <label>送信開始日　:</label><input type="date" name="rep_yes_date" id="rep_yes_date" min="<?php echo $today; ?>" onChange="status2(event)">
                            </div>
                            <input type="hidden" name="upd" value="yes">
                            <input type="submit" value="変更" onclick="return myCheck_rep();">
                        </div>
                    </div>
                <?php else ://「繰り返し送信」機能のフラグがfalseになっていたときに、繰り返し送信ができないメール配信システムを表示  ?>
            <div class="mail_date">
                <div class="mail_bottom1">
                    <input type="radio" name="specify" value="no" onClick="changeDisabled()" checked><label>日付指定なし</label>
                </div>
                <div class="mail_bottom2">
                    <input type="radio" name="specify" value="yes" onClick="changeDisabled()"><label>日付指定あり</label>
                    <?php $date_tomorrow = date('Y-m-d',strtotime("today +1 day"));//翌日の日付を変数宣言?>
                    <input type="date" id="dat" name="dat" size="30" min="<?php echo $date_tomorrow; ?>">
                </div>
                <div class="mail_bottom3">
                    <input type="hidden" name="id" value="<?php echo $id[0];?>">
                    <input type="hidden" name="upd" value="yes">
                    <input type="submit" value="変更" onclick="return myCheck();">
                </div>
            </div>
        <?php endif; ?>
        </form>
    </div>
</body>

</html>
