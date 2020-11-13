
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

        $dsn='mysql:host=localhost;dbname=mailtest';
        $user='root';
        $password='root';

        try{
          $db=new PDO($dsn,$user,$password);
          $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);// それぞれの単一文で自動コミットするかどうか。
          $sql= "SELECT * from mail;";
          $stmt = $db->prepare($sql);
          $stmt->execute();
        }catch(PDOException $error){
          echo "error".$error->getMessage();
        }
        // SQLより取り出したデータを配列に格納
        $data = $stmt->fetchAll();
        $id = array_column($data, 'id');
        $adressa = array_column($data, 'adressa');
        $adressb = array_column($data, 'adressb');
        $text = array_column($data, 'text');
        $date = array_column($data, 'date');

        $today = date("Y/m/d");
     ?>
     




     <!--取り出したデータをaタグで一覧表示させ、それぞれにidの値を持たせる-->
    <?php $n = 0; ?>
    <ul>
          <?php for($i = 0; $i < count($id); $i++): ?>
            <form name="<?php echo 'form'.$n; ?>" method="POST" action="check.php" >
              <a href="javascript:document.<?php echo 'form'.$n; ?>.submit()"><?php echo $adressa[$i]. $adressb[$i]. $text[$i]. $date[$i]; ?></a>
                <input type="hidden" name="id" value="<?php echo $id[$i]; ?>">
              <?php $n++; ?>
            </form>
          <?php endfor; ?>
    </ul>
    </main>	  
</body>
</html>
<!--
<?php for($i = 0; $i < count($id); $i++): ?>
              <form action="check.php" method="POST" name="form1">
                <li><a href="" onclick="document.form1.submit();return false;"><?php echo $adressa[$i]. $adressb[$i]. $text[$i]. $date[$i]; ?></a>
                <input type="hidden" name="id" value="<?php echo $id[$i]; ?>">
              </form></li>
         <?php endfor; ?>
<?php for($n = 0; $n < count($id); $n++): ?>
      <?php echo 'form'.$n; ?>

      <?php endfor; ?>