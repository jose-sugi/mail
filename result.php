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
    <div class="container">
      <p class="title send"><span>送信完了</span></p>
      <a href="index.php" class="btn left">メールを送信</a>
      <a href="list.php" class="btn right">送信予定</a>
    </div>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $adra = $_POST['adra'];
    $adrb = $_POST['adrb'];
    $subj = $_POST['subject'];
    $tx = $_POST['tx'];
    $spe = $_POST['specify']; //日時指定あり→yes ,日時指定なし→no
    $dat = $_POST['dat'];

    if ($spe == "yes") { //日時指定ありならDBに保存
      $dsn = 'mysql:host=localhost;dbname=mailtest';
      $user = 'root';
      $password = 'root';

      try {
        $db = new PDO($dsn, $user, $password);
        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
        $sql = "INSERT INTO mail (adressA,adressB,subject,text,date) VALUES (:adressA,:adressB,:sbj,:tx,:dat)";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':adressA', $adra, PDO::PARAM_STR);
        $stmt->bindParam(':adressB', $adrb, PDO::PARAM_STR);
        $stmt->bindParam(':sbj', $subj, PDO::PARAM_STR);
        $stmt->bindParam(':tx', $tx, PDO::PARAM_STR);
        $stmt->bindParam(':dat', $dat, PDO::PARAM_STR);
        $stmt->execute();
      } catch (PDOException $error) {
        echo "error" . $error->getMessage();
      }
    } else { //日時指定なしなら直接送信
      $to = $adra;
      $subject = $subj;
      $message = $tx;
      $headers = "From:" . $adrb;

      mb_send_mail($to, $subject, $message, $headers);
    }
    ?>

  </main>
</body>

</html>