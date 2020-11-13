
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
        $id = $_POST['id'];
       ?>
       <?php
        error_reporting(E_ALL);
        ini_set('display_errors', '1');

        $dsn='mysql:host=localhost;dbname=mailtest';
        $user='root';
        $password='root';

        try{
          $db=new PDO($dsn,$user,$password);
          $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);// それぞれの単一文で自動コミットするかどうか。
          $sql= "SELECT * from mail WHERE id = ".$id." ";
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
        echo $adressa[0];
     ?>
    </main>	  
</body>
</html>


