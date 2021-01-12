<?php
    /*
    ******************************************************************************
    設定ファイル
    2020/12/09
    杉澤
    2020/12/23
    杉澤
    ******************************************************************************
    */

    $time_cron = '12:30';//クーロン時間の設定
    
    $max_adress = 255;//送信元の文字数
    $max_adress_send = 255;//送信先の文字数
    $max_subject =255;//件名の文字数
    $max_body = 1000;//本文の文字数

    $functionFlag_edit = false;
    $functionFlag_repeat = true;

    $dsn = 'mysql:dbname=LAA1192052-sugisawa01;host=mysql145.phy.lolipop.lan;charset=utf8'; //MySQLのデータソース名
    $user = 'LAA1192052'; //ユーザー名
    $password = 'AcroLoliPass2020'; //パスワード

    date_default_timezone_set('Asia/Tokyo');
    $today = date('Y-m-d');//今日の日付

    /*バージョン番号の更新目安は下記とします。
    例) 1.00
    メジャー番号(1の部分) ：機能追加時にインクリメント
    マイナー番号(00の部分)：機能修正時にインクリメント
    　　　　　　　　　　　　 機能追加時に「00」初期化
    */
    $major = 2;
    $minor = 0.02;
    $version = $major + $minor;
 ?>