<?php 
    /*
    ******************************************************************************
    スタート画面
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
    include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み
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
        <div class="container">
                <p class="title"><span>メール配信システム</span></p>
                <a href="index.php" class="btn left">新規メール作成</a>
                <a href="list.php" class="btn right">送信予定</a>
        </div>
        <p class="version">v<?php printf('%.2f',$version); ?></p>
    </main>	  
</body>
</html>
