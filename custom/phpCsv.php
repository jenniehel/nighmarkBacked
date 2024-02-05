  <?php

    require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/db_connect.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/html-head.php';
    require $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/html/header.php';
    ?>
  <style>
      .bg-title {
          background-color: rgb(40, 40, 197);
          color: white;
      }

      p {
          color: red;
      }
  </style>
  </head>

  <div  style="margin-left: 270px" >
      <div class="card text-center">
          <div class="card-body pt-1">
          <div class="card-title  text-start " > <button type="submit" class="btn btn-primary mb-3" onclick="window.location.href='read.php'">回上一頁</button></div>

              <h1 class="card-title text-center bg-title py-3">請匯入您的csv</h1>
              <h5 class="card-title">請對照下方欄位名稱!!!</h5>
              <p>
              <h2 style="color:red;">提醒!!!</h2>
              黑名單欄位(custom_authorId) :&nbsp;&nbsp;黑名單=>0 &nbsp;&nbsp; 不是黑名單=>1 <br>
              圖片(custom_image) :請手動，這邊無法放入喔!!

              </p>
              <img class="my-5" src="../assets/images/example.png" alt="" style="border: 10px solid red;">
              <!-- co -->

              <form action='#' method='post' enctype='multipart/form-data'>
                  <!-- <INPUT type='file' > -->
                  <input type="file" name='userfile' accept=".csv" />
                  <INPUT type='hidden' name='op' value='import'>
                  <INPUT type='submit' value='匯入'>
              </form>
          </div>

      </div>
  </div>

  <?php
    include $_SERVER['DOCUMENT_ROOT'] . '/midMonth2024-1-31/com-parts/script.php';

    //開啟上傳檔 
    // header("Content-type: text/x-csv");
    // header("Content-type: text/html;charset=utf-8");
    $m = [];

    if (isset($_FILES['userfile'])) {
        //開啟 CSV 檔案
        if (!is_file($_FILES['userfile']['tmp_name'])) {
            exit('沒有檔案請重新匯入');
        }
        $handle = fopen($_FILES['userfile']['tmp_name'], "r");
        if (!$handle) {
            exit('讀取檔案失敗');
        }
        // 紀錄資料筆數
        $i = 0;
        while (($data = __fgetcsv($handle)) !== false) {
            // 下面這行程式碼可以解決中文字元亂碼問題 

            // 跳過第一行標題
            if (
                $data[0] == 'custom_name' || $data[1] == "custom_email" || $data[2] == "custom_authorId"
                || $data[3] == "custom_password" || $data[4] == "custom_account"
            ) {
                continue;
            }

            // data 為每行的資料，這裡轉換為一維陣列
            // print_r($data);// Array ( [0] => tom [1] => 12 )
            // echo mb_convert_encoding($data[$i][], "UTF-8");
            printf("<div style='margin-left:270px'>姓名：%s <br>", $data[0]);
            printf("郵件 : %s  <br>", $data[1]);
            printf("黑名單 %s  <br>", $data[2]);
            printf("密碼 %s  <br>", $data[3]);
            printf("帳號 %s  <br>", $data[4]);
            printf(" <br>
            </div>
            ");
            $i++;
            $sql = "INSERT INTO `custom`( `custom_name`, `custom_email`,`custom_authorId`, `custom_password`,`custom_date`,`custom_account`) VALUES (?, ?, ?, ?, NOW(),?)";
            $stmt = $pdo->prepare($sql);
            try {
                $stmt->execute([
                    $data[0],
                    $data[1],
                    $data[2],
                    $data[3],
                    $data[4]
                ]);
            } catch (PDOException $e) {
                echo 'SQL有東西出錯了' . $e->getMessage();
            }

            // $output['success'] = boolval($stmt->rowCount()); 
            if (boolval($stmt->rowCount())) {
                echo '<br><br>第' . $i . '筆新增成功<br><br>';
            };
        }

        fclose($handle);

        //關閉檔案
    }


    // fetcsv黨
    function __fgetcsv(&$handle, $length = null, $d = ",", $e = '"')
    {
        $d = preg_quote($d);
        $e = preg_quote($e);
        $_line = "";
        $eof = false;
        while ($eof != true) {
            $_line .= (empty($length) ? fgets($handle) : fgets($handle, $length));
            $itemcnt = preg_match_all('/' . $e . '/', $_line, $dummy);
            if ($itemcnt % 2 == 0) {
                $eof = true;
            }
        }

        $_csv_line = preg_replace('/(?: |[ ])?$/', $d, trim($_line));

        $_csv_pattern = '/(' . $e . '[^' . $e . ']*(?:' . $e . $e . '[^' . $e . ']*)*' . $e . '|[^' . $d . ']*)' . $d . '/';
        preg_match_all($_csv_pattern, $_csv_line, $_csv_matches);
        $_csv_data = $_csv_matches[1];

        for ($_csv_i = 0; $_csv_i < count($_csv_data); $_csv_i++) {
            $_csv_data[$_csv_i] = preg_replace("/^" . $e . "(.*)" . $e . "$/s", "$1", $_csv_data[$_csv_i]);
            $_csv_data[$_csv_i] = str_replace($e . $e, $e, $_csv_data[$_csv_i]);
        }

        return empty($_line) ? false : $_csv_data;
    }
    ?>