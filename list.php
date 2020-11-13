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
    error_reporting(E_ALL);
    ini_set('display_errors', '1');

    $dsn = 'mysql:host=localhost;dbname=mailtest';
    $user = 'root';
    $password = 'root';

    try {
      $db = new PDO($dsn, $user, $password);
      $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false); // それぞれの単一文で自動コミットするかどうか。
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
    $today = date("Y/m/d");


    ?>

    <!--取り出したデータをaタグで一覧表示させ、それぞれにidの値を持たせる-->
    <?php $n = 0; ?>
    <ul>
      <?php for ($i = 0; $i < count($id); $i++) : ?>
        <?php if ($subj[$i] == "") {
          global $subj;
          $subj[$i] = "件名なし";
        } ?>

        <form name="<?php echo 'form' . $n; ?>" method="POST" action="check.php">
          <li><a href="javascript:document.<?php echo 'form' . $n; ?>.submit()"><?php echo $adressb[$i] . "　" . $subj[$i] . "　" . $date[$i]; ?></a></li>
          <input type="hidden" name="id" value="<?php echo $id[$i]; ?>">
          <?php $n++; ?>
        </form>
      <?php endfor; ?>
    </ul>
    <a href="start.php">前の画面</a>
    <a href="list.php">メール送信</a>
  </main>
</body>

</html>