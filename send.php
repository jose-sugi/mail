<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$dsn='mysql:host=localhost;dbname=mailtest';
$user='root';
$password='root';

    try{
      $db=new PDO($dsn,$user,$password);
      $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
      $sql= "SELECT * from mail WHERE date = DATE(NOW())";
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
    // メールの送信の際、文字化けを防ぐため下記２行を記述
    mb_language("Japanese");
    mb_internal_encoding("UTF-8");

    for ($i=0; $i < count($data); $i++) {
        $to = $adressa[$i];
        $subject = "自動送信";
        $message = $text[$i];
        $headers = "From:".$adressb[$i];

        mb_send_mail($to, $subject, $message, $headers);
    }

 ?>
