<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

$adra = $_POST['adra'];
$adrb = $_POST['adrb'];
$tx = $_POST['tx'];
$dat = $_POST['dat'];

$dsn='mysql:host=localhost;dbname=mailtest';
$user='root';
$password='root';

    try{
      $db=new PDO($dsn,$user,$password);
      $db ->setAttribute(PDO::ATTR_EMULATE_PREPARES,false);
      $sql= "INSERT INTO mail (adressA,adressB,text,date) VALUES (:adressA,:adressB,:tx,:dat)";
      $stmt = $db->prepare($sql);
      $stmt->bindParam(':adressA', $adra, PDO::PARAM_STR);
      $stmt->bindParam(':adressB', $adrb, PDO::PARAM_STR);
      $stmt->bindParam(':tx', $tx, PDO::PARAM_STR);
      $stmt->bindParam(':dat', $dat, PDO::PARAM_STR);
      $stmt->execute();
    }catch(PDOException $error){
      echo "error".$error->getMessage();
    }
?>
