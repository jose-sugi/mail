<?php
    /*
    ******************************************************************************
    クーロン実行ファイル
    2020/12/09
    杉澤
    2020/12/18
    杉澤
    2020/12/21
    杉澤
    2021/01/06
    杉澤
    ******************************************************************************
    */
  include(dirname(__FILE__).'/variable.php');
  $weekday = date("w") + 1;
  //global $adressb, $subj, $text, $adressa;

  try {
    $db = new PDO($dsn, $user, $password);
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $sql = "SELECT * FROM mail WHERE DATE_FORMAT(date, '%d') = DATE_FORMAT(NOW(), '%d') OR week = DAYOFWEEK(NOW()) OR period = 'D'";
    //今日の日付（日のみ）が同じもの、今日の曜日と「毎週」送信の設定曜日が同じもの、「繰り返し送信」で「毎日」送信を設定したメール、の３点どれかに該当するメールをDBから取得
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
  $address_bcc = array_column($data, 'address_bcc');
  $subj = array_column($data, 'subject');
  $text = array_column($data, 'text');
  $date = array_column($data, 'date');
  $period = array_column($data, 'period');
  $week = array_column($data, 'week');

  // メールの送信の際、文字化けを防ぐため下記２行を記述
  mb_language("Japanese");
  mb_internal_encoding("UTF-8");

  for ($i = 0; $i < count($data); $i++) {
    echo "No,".$i."<br>";
    if ($date[$i] == $today && $period[$i] == null) {//本日の日付指定で「繰り返し送信」出ないものは送信
      echo "日付が同じで繰り返しなし".$id[$i].$date[$i].$subj[$i].$period[$i].$text[$i].'<br>';
      send_mail($adressb[$i], $subj[$i], $text[$i], $adressa[$i], $address_bcc[$i]);
    } else if ($period[$i] == "Y" && substr($date[$i],5,5) == substr($today,5,5) && $date[$i] <= $today) {
    //「毎年」送信指定かつ、今日の月日と繰り返し指定日付が同じメールかつ、今日よりも送信開始日が前のメールは送信
      echo "毎年送信".$id[$i].$date[$i].$subj[$i].$period[$i].$text[$i].'<br>';
      send_mail($adressb[$i], $subj[$i], $text[$i], $adressa[$i], $address_bcc[$i]);
    } else if ($period[$i] == "M" && substr($date[$i],8,2) == substr($today,8,2) && $date[$i] <= $today) {
      //「毎月」送信指定かつ、今日の日と繰り返し指定日付が同じメールかつ、今日よりも送信開始日が前のメールは送信
      echo "毎月送信".$id[$i].$date[$i].$subj[$i].$period[$i].$text[$i].'<br>';
      send_mail($adressb[$i], $subj[$i], $text[$i], $adressa[$i], $address_bcc[$i]);
    } else if ($period[$i] == "W" && $week[$i] == $weekday && $date[$i] <= $today) {
      //「毎週」送信指定かつ、今日の曜日と繰り返し指定曜日が同じメールかつ、今日よりも送信開始日が前のメールは送信
      echo "毎週送信".$id[$i].$date[$i].$subj[$i].$period[$i].$text[$i].'<br>';
      send_mail($adressb[$i], $subj[$i], $text[$i], $adressa[$i], $address_bcc[$i]);
    } else if ($period[$i] == "D" && $date[$i] <= $today) {
      //「毎日」送信指定かつ、今日よりも送信開始日が前のメールは送信
      echo "毎日送信".$id[$i].$date[$i].$subj[$i].$period[$i].$text[$i].'<br>';
      send_mail($adressb[$i], $subj[$i], $text[$i], $adressa[$i], $address_bcc[$i]);
    } else {
      //上記5つに当てはまらない場合（繰り返し送信「毎週月曜日」で今日を送信開始日にしているが、今日は月曜日出ないメールや、繰り返し送信「毎年」で今日の日付ではあるが、送信開始日が来年の今日からの場合など）は送信しない
      echo "今日は送信しない".$id[$i].$date[$i].$subj[$i].$period[$i].$text[$i].'<br>';
      echo "No,".$i."は送信しません✕✕✕"."<br>";
    }
  }

function send_mail($adressb, $subj, $text, $adressa, $address_bcc) {
   //配列に格納したデータが全てメール送信されるよう設定
    $to = $adressb;
    $subject = $subj;
    $message = $text;
    $headers = "From:" .$adressa;
    $headers.="\n";
    $headers.="Bcc:" .$address_bcc;

    mb_send_mail($to, $subject, $message, $headers);
    echo "No,".$i."を送信しました"."<br>";
}



?>
