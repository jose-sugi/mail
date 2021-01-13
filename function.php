<?php 
    /*
    ******************************************************************************
    JS・PHP関数ファイル
    2020/12/09
    杉澤
    2020/12/18
    杉澤
    2020/12/22
    杉澤
    2020/12/23
    杉澤
    2021/01/05
    杉澤
    ******************************************************************************
    */
    
    include(dirname(__FILE__).'/variable.php');//変数ファイルの読み込み

 ?>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.js"></script>
 <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/locale/ja.js"></script>
 <script type="text/javascript">
        function myCheck(){//「送信」ボタンを押下したときポップアップ表示で確認するための関数（繰り返し機能offのとき）
            if(document.form1.specify[0].checked){ //ラジオボタン「日付指定なし」が選択されているとき表示
                var select = confirm("本日送信しますか？");
                return select;
            } else {
                select = confirm("日付を指定して送信しますか？");//ラジオボタン「日付指定あり」が選択されているとき表示
                return select;
            }
    }
        function myCheck_rep() {//「送信」ボタンを押下したときポップアップ表示で確認するための関数（繰り返し機能onのとき）

            if (document.form1["rep"][0].checked) {
                var select = confirm("送信予約しますか？");//ラジオボタン「日時指定」で送信予約したとき
                return select;
            } else {
                select = confirm("繰り返しで送信予約しますか？");//ラジオボタン「繰り返し送信」で送信予約したとき
                return select;
            }
        }
        function check_count() {
            letter_1 = <?php echo $max_address_send; ?>;//関数ファイルで設定した「送信先メールアドレス」の最大文字数
            letter_2 = count;//フォームに入力した送信先メールアドレスに含まれる、カンマ「,」の数
            letter_3 = address_send_letter;//フォームに入力したメールアドレスの文字数


            if ((letter_1 + letter_2) < letter_3) {
                alert("【送信不可】送信先メールアドレスは" + letter_1 + "文字以内で入力してください");
                return false;
            } else {
                return true;
            }
        }
        function changeDisabled0() {//ラジオボタン「日付指定」が選択されると、送信予定日の入力を必須化するための関数
            if (document.form1["rep"][0].checked) {
                document.form1["rep_no_date"].required = true;
            } else {
                document.form1["rep_no_date"].required = false; 
            }
        }
        function changeDisabled1() {//ラジオボタン「繰り返し予約」が選択されると、送信開始日の入力を必須化するための関数
            if (document.form1["rep"][1].checked) {
                document.form1["rep_yes_date"].required = true;
                document.form1["rep_no_date"].required = false;
            } else {
                document.form1["rep_yes_date"].required = false;
            }
        }

        function check(obj) {//変数ファイルで管理している文字数制限を超えたとき、アラートを表示するための関数
            str = ",";//コンマは文字数に含まない
            max_letter = 0;
            text = null;
            switch (obj) {
                case 'adra':
                    text = '送信元メールアドレス';
                    max_letter = <?php echo $max_address; ?>;//メールアドレスの最大文字数を代入
                    break;
                case 'adrb':
                    text = '送信先メールアドレス';
                    max_letter = <?php echo $max_address_send; ?>;
                    break;
                case 'subject':
                    text = '件名';
                    max_letter = <?php echo $max_subject; ?>;
                    break;
                case 'tx':
                    text = '本文';
                    max_letter = <?php echo $max_body; ?>;
                    break;
            }

            txt = document.form1[obj].value;//入力したメールアドレス、件名、本文を取得
            n = txt.length;//文字数に変換
            address_send_letter = document.form1.adrb.value.length;
            let modStr = '' //カット後の文字列

            count = ( txt.match( new RegExp( str, "g" ) ) || [] ).length ;//入力した内容からコンマの数を取得
            
        
            if (n - count >= max_letter) {
                alert(text + "は「" + max_letter + "」文字以下でお願いいたします");
            }
        }


        function check_empty() {//件名と本文に空文字が入っていたときに、アラート表示させるための関数
            check_suj = document.form1.subject.value;
            check_tx = document.form1.tx.value;

            if (!check_suj.match(/\S/g) || !check_tx.match(/\S/g)) {
                alert("【送信不可】文字を入力してください");
                return false;
            } else {
                return true;
            }
        }
        function del() {//メール内容確認画面から「削除」ボタンを押下したときに表示
                var select = confirm("このメールを削除してもよろしいですか？");
                return select;
        }
        function edi() {//メール内容確認画面から「変更」ボタンを押下したときに表示
                var select = confirm("メール内容を変更しますか？");
                return select;
        }


        window.onload = function() {//index.phpを開いたときに表示する要素（HTML）、表示しない要素(HTML)を指定
            document.getElementById("address_bcc").style.display = "none";
            document.getElementById("date_no").style.display="block";
            document.getElementById("date_yes").style.display="none";
            document.getElementById("check_container").style.display="none";
            document.getElementById("date_rep").style.display="none";
            document.form1["rep_no_date"].required = true;
            document.getElementById("message_container").style.display="none";
        }
        
        function hyoji(num){
          if (num == 0) {//「日時指定」をラジオボタンでボタン選択したとき、表示する要素（HTML）表示しない要素(HTML)を指定
            document.getElementById("date_no").style.display="block";
            document.getElementById("date_no").style.display="block";
            document.getElementById("date_yes").style.display="none";
            document.getElementById("date_rep").style.display="none";
            document.getElementById("check_container").style.display="none";
            document.getElementById("message_container").style.display="none";
            document.form1["rep_yes_period_list"].required = false;
          } else if (num == 1) {//「繰り返し予約」をラジオボタンでボタン選択したときに、表示する要素（HTML）表示しない要素(HTML)を指定
            document.getElementById("date_no").style.display="block";
            document.getElementById("date_no").style.display="none";
            document.getElementById("date_yes").style.display="block";
            document.getElementById("date_rep").style.display="block";
            document.getElementById("message_container").style.display="block";
            document.form1["rep_yes_period_list"].required = true;

          }
        }

        function select() {
            var element = document.getElementById("list_w") ;//繰り返し予約の周期のチェックリストに応じて月曜日〜金曜日のチェックボタンを表示・非表示させるための関数
                if ( element.selected ) {//「毎週」が選択されていると、チェックボタンを表示
                document.getElementById("check_container").style.display="block";
            } else {//「毎年・毎月・毎日」のときにチェックボタンを非表示
                 document.getElementById("check_container").style.display="none";
            }
        }
        var period = null;
        function status1(obj) {
                var idx = obj.selectedIndex;
                period  = obj.options[idx].text;
                switch(period) {
                    case '毎年':
                        document.getElementById("output_message2").style.display="inline-block";
                        document.getElementById("output_message3").style.display="none";
                        break;
                    case '毎月':
                        document.getElementById("output_message2").style.display="inline-block";
                        document.getElementById("output_message3").style.display="none";
                        break;
                    case '毎週':
                        document.getElementById("output_message2").style.display="none";
                        document.getElementById("output_message3").style.display="inline-block";
                        break;
                    case '毎日':
                        document.getElementById("output_message2").style.display="none";
                        document.getElementById("output_message3").style.display="none";
                        break;
                }
                if (period == '毎日') {
                    input_message = period + "送信します";
                } else {
                    input_message = period + " ・";
                }
                
                document.getElementById("output_message").innerHTML = input_message;
            }

        function status2(e) {
                var date = e.target.value;
                var y = date.substr(0, 4);
                var m = date.substr(5, 2) * 1;
                var d = date.substr(8, 2) * 1;
                var per = null;
                var message = y + "年" + m + "月" + d + "日";


                switch (period) {
                    case '毎年':
                        per = m + "月" + d + "日";
                        break;
                    case '毎月':
                        per = d + "日";
                        break;
                    case '毎週':
                        input_message = "";
                        break;
                    case '毎日':
                        input_message = "毎日";
                        break;
                } 

                if (period == null) {
                    input_message = per;
                    document.getElementById("output_message2").style.color="black";
                } else if(per == null){
                    input_message = "";
                    document.getElementById("output_message2").style.color="black";
                } else if (m == 0){
                    input_message = "日付を選択してください";
                    document.getElementById("output_message2").style.color="red";
                } else {
                    input_message = per +"に送信します";
                    document.getElementById("output_message2").style.color="black";
                }
                
                document.getElementById("output_message2").innerHTML = input_message;
                if (d == 0) {
                    message = "日付を選択してください"
                    document.getElementById("output_message4").style.color="#004fe4";
                } else {
                    document.getElementById("output_message4").style.color="#004fe4";
                    document.getElementById("output_message4").style.display="inline-block";
                    document.getElementById("output_message4").innerHTML = message;
                }
                
        }
        var week_day = null;
        function status3() {
                var week = document.form1["rep_yes_period_list_w"].value;
                
                switch (week) {
                    case "1":
                        week_day = "日";
                        break;
                    case "2":
                        week_day = "月";
                        break;
                    case "3":
                        week_day = "火";
                        break;
                    case "4":
                        week_day = "水";
                        break;
                    case "5":
                        week_day = "木";
                        break;
                    case "6":
                        week_day = "金";
                        break;
                    case "7":
                        week_day = "土";
                        break;
                }
                input_message = week_day +"曜日に送信します";
                document.getElementById("output_message3").innerHTML = input_message;
        }
        function open_bcc() {
            document.getElementById("bcc").style.display = "none";
            document.getElementById("address_bcc").style.display = "block";
            
        }
        function close_bcc() {
            document.getElementById("bcc").style.display = "block";
            document.getElementById("address_bcc").style.display = "none";
        }
    </script>
    <?php 
        function dbin($adra, $adrb, $subj, $tx, $date, $rep_yes_period_list = null, $rep_yes_period_list_w = null, $add_bcc) {
            try {
                global $dsn, $user, $password;//グローバル変数を宣言

                $db = new PDO($dsn, $user, $password);
                $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                $sql = "INSERT INTO mail (address_receive,address_send,subject,text,date,period,week,address_bcc) VALUES (:address_receive, :address_send, :sbj, :tx, :date, :period, :week, :address_bcc)";
                $stmt = $db->prepare($sql);
                $stmt->bindParam(':address_receive', $adra, PDO::PARAM_STR);
                $stmt->bindParam(':address_send', $adrb, PDO::PARAM_STR);
                $stmt->bindParam(':sbj', $subj, PDO::PARAM_STR);
                $stmt->bindParam(':tx', $tx, PDO::PARAM_STR);
                $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                $stmt->bindParam(':period', $rep_yes_period_list, PDO::PARAM_STR);
                $stmt->bindParam(':week', $rep_yes_period_list_w, PDO::PARAM_STR);
                $stmt->bindParam(':address_bcc', $add_bcc, PDO::PARAM_STR);
                $stmt->execute();
            } catch (PDOException $error) {
                echo "error" . $error->getMessage();
            }
        }
        function dbinUpd($adra, $adrb, $subj, $tx, $date, $id = null, $rep_yes_period_list = null, $rep_yes_period_list_w = null, $add_bcc) {
                    try {
                        global $dsn, $user, $password;//グローバル変数を宣言
                        
                        $db = new PDO($dsn, $user, $password);
                        $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
                        $sql = "UPDATE mail 
                                 SET address_receive = :address_receive, address_send = :address_send, subject = :sbj, text = :tx, date = :date, period = :period, week = :week, address_bcc = :address_bcc
                                 WHERE id = :id ";
                        $stmt = $db->prepare($sql);
                        $stmt->bindParam(':address_receive', $adra, PDO::PARAM_STR);
                        $stmt->bindParam(':address_send', $adrb, PDO::PARAM_STR);
                        $stmt->bindParam(':sbj', $subj, PDO::PARAM_STR);
                        $stmt->bindParam(':tx', $tx, PDO::PARAM_STR);
                        $stmt->bindParam(':date', $date, PDO::PARAM_STR);
                        $stmt->bindParam(':period', $rep_yes_period_list, PDO::PARAM_STR);
                        $stmt->bindParam(':week', $rep_yes_period_list_w, PDO::PARAM_STR);
                        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
                        $stmt->bindParam(':address_bcc', $add_bcc, PDO::PARAM_STR);
                        $stmt->execute();
                      } catch (PDOException $error) {
                        echo "error" . $error->getMessage();
                      }
                }

     ?>