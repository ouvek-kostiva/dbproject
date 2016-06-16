<?php
    $dbhost = '127.0.0.1';  //資料庫位址 127.0.0.1 = localhost
    $dbuser = 'Signupuser'; //資料庫帳號
    $dbpass = '';           //資料庫密碼
    $dbname = 'c9';         //資料庫名稱
    try{
        $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname.";charset=utf8mb4;",$dbuser,$dbpass); //建立資料庫連線物件

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);              //設定當資料庫連線出錯回訊息
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);       //設定用fetch時用PDO::FETCH_ASSOC
        $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');        //採萬國碼
    }catch (PDOException $e) {                                                     //接收錯誤訊息
        throw new PDOException("Error  : " .$e->getMessage());
    }
    $select = $conn->prepare("SELECT Username, User_id FROM Users WHERE userCookie = :ucook ;");    //Prepared Statement 避免出現 SQL Injection
    $select->execute(array(':ucook' => $_COOKIE['dbproject']));                                     //確定已登入所分配的Cookie['dbproject']是否存在於資料庫
    $row = $select->fetch(PDO::FETCH_ASSOC);
    if($row){   //如果有回傳資料代表Cookie存在(已登入)
                $username = $row['Username']; //將使用者名稱放入$username變數(登出旁邊)
                $User_id = $row['User_id'];   //將使用者id放入$User_id變數
    }else{
        header('Location: http://db4-ouvek-kostiva.c9users.io'); //如沒有回傳資料代表未登入, 回到登入頁面
    }

$listTotalRows = 10; //顯示10行格子用來填入
$listrows = 0; //資料庫已有行數

if(isset($_POST['save'])){ //如果按下儲存按鈕

    /*------------------------檢查Customer資訊 開始------------------------*/
    $has_vendor = false; //是否有輸入客戶
    if(!"" == trim($_POST['SO_Customer_id'])){ //確定SO_Customer_id是否有輸入
        $has_vendor = true;
        $Customercode = $_POST['SO_Customer_id'];
    }else{
        $vendor_check = $vendor_check."客戶編號 \t"; //檢查是否有輸入的Customer訊息
        $Customercode = NULL;
    }

    if(!"" == trim($_POST['Customername'])){
        $Customername = $_POST['Customername'];
        $has_vendor = true;
    }else{
        $vendor_check = $vendor_check."客戶名稱 \t";
        $Customername = NULL;
    }

    if(!"" == trim($_POST['CustomerEmail'])){
        $CustomerEmail = $_POST['CustomerEmail'];
        $has_vendor = true;
    }else{
        $vendor_check = $vendor_check."客戶Email \t";
        $CustomerTel = NULL;
    }

    if(!$has_vendor){ //echo 中為未輸入任何Customer格 的 警告訊息
        echo "</br></br><div class='alert alert-danger' role='alert'> 請至少在 $vendor_check 其中一格中輸入一項客戶資料 </div>";
    }else{ //有輸入Customer資料

        $vendor_exist = false;

        $query = "SELECT Customer_id FROM Customer WHERE"; //查詢Customer_id
        $array = array( //Customer資料組成陣列
          ':Customercode' => $Customercode,
          ':Customername' => $Customername,
          ':CustomerEmail' => $CustomerEmail);
        $values = array(); //執行SQL指令輸入Prepared Statement的資料
        $array = array_filter($array,function ($value) {return null !== $value;}); //如果其中有Null會直接刪掉
        foreach ($array as $name => $value) {
          $query .= ' '.substr($name,1).' = '.$name.' AND'; //產生SQL Statement中的WHERE部分
          $values[''.$name] = $value; //形成Execute中要輸入的資料
        }
        $query = substr($query, 0, -3).';';//刪掉WHERE部分多餘的AND及加上;
        $select = $conn->prepare($query);  //產生Prepared Statement
        $select->execute($values);         //執行(Execute)SQL指令
        $SO_Customer = $select->fetch(PDO::FETCH_ASSOC); //取得Customer_id
        $SO_Customer_id = $SO_Customer['Customer_id'];
        if($select->rowCount() > 0){ //如果Customer_id不存在,顯示錯誤及提示訊息
            $vendor_exist = true;
        }else{  //如果Customer_id存在
            echo "</br></br><div class='alert alert-danger' role='alert'> 客戶資料不存在, 請檢查 客戶編號 名稱 及 Email 是否吻合, 請<a href='http://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'>新增客戶</a></div>";
        }
    }

    /*------------------------檢查Customer資訊 結束------------------------*/
    /*------------------------檢查其他表頭資訊 開始------------------------*/

    if($vendor_exist){ //當Customer_id存在才繼續執行

        if(!"" == trim($_POST['SO_Date'])){ //是否有輸入日期
            $SO_Date = date("Y-m-d H:i:s", strtotime($_POST['SO_Date'])); //將日期從字串->變整數->變MySQL日期格式
        }else{
            $SO_Date = date("Y-m-d H:i:s"); //未輸入日期自動填入現在伺服器時間
        }

        if(!"" == trim($_POST['SO_ReqDate'])){ //送貨截止日
            $SO_ReqDate = date("Y-m-d H:i:s", strtotime($_POST['SO_ReqDate']));
        }else{
            $SO_ReqDate = NULL; //空值
        }

        if(!"" == trim($_POST['SO_Address'])){ //送貨地址
            $SO_Address = $_POST['SO_Address'];
        }else{
            $SO_Address = NULL;
        }

        if(!"" == trim($_POST['SO_Amount'])){ //總金額
            $SO_Amount = $_POST['SO_Amount'];
        }else{
            $SO_Amount = NULL;
        }

        if(!"" == trim($_POST['SO_Code'])){ //是否有輸入 SO_Code
            $SO_exists = false; //SO 銷貨訂單 是否存在
            $SO_Code = $_POST['SO_Code'];
            $SO_checked = true; //確定有輸入SO_code
            $select = $conn->prepare("SELECT * FROM SalesOrder WHERE SO_Code = :SO_Code AND SO_Date = :SO_Date "); //檢查Sales_Order是否已存在
            $select->execute(array(':SO_Code' => $SO_Code, ':SO_Date' => $SO_Date));//執行SQL
            if($select->rowCount() > 0){ //有銷貨訂單
                $result = $select->fetch();
                $SO_exists = true;
                $SalesOrder_id = $result['SalesOrder_id']; //取得SO 銷貨訂單的 PK
            }
            //確認SOcode不重複
            $SOcode_Dup = false;//避免SOcode重複
            $select = $conn->prepare("SELECT COUNT(*) FROM SalesOrder WHERE SO_Code = :SO_Code "); //檢查Sales_Order是否已存在
            $select->execute(array(':SO_Code' => $SO_Code));//執行SQL
            $count_result = $select->fetchColumn();
            if($count_result > 0){ //有銷貨訂單
                $SOcode_Dup = true;
            }
        }else{
            echo "</br></br><div class='alert alert-danger' role='alert'> 請輸入訂單編號 </div>"; //沒有輸入訂單編號的錯誤訊息
        }

    }
    /*------------------------檢查其他表頭資訊 開始------------------------*/

    if($SO_checked){ //SO 銷貨訂單是否存在完成檢查
      $SO_header = false; //確定表頭完成新增修改
      $SO_header_update = false;
      if($SO_exists){ //SO 銷貨訂單存在, 修改訂單
          /*------------------------修改訂單表頭 開始------------------------*/
          $update = $conn->prepare("UPDATE SalesOrder SET
              SO_Date = :SO_Date,
              SO_ReqDate = :SO_ReqDate,
              SO_Address = :SO_Address,
              SO_Amount = :SO_Amount,
              SO_Customer_id = :SO_Customer_id,
              SO_User_id = :SO_User_id WHERE SalesOrder_id = :SalesOrder_id");
          $update->execute(array(
              ':SalesOrder_id' => $SalesOrder_id,
              ':SO_Date' => $SO_Date,
              ':SO_ReqDate' => $SO_ReqDate,
              ':SO_Address' => $SO_Address,
              ':SO_Amount' => $SO_Amount,
              ':SO_Customer_id' => $SO_Customer_id,
              ':SO_User_id' => $User_id)); //紀錄新增表單的使用者
          if($update){
              echo "</br></br><div class='alert alert-success' role='alert'> 修改表頭成功 </div>";
              $SO_header_update = true;//表頭完成新增修改
          }else{
              echo "</br></br><div class='alert alert-warning' role='alert'> 修改表頭失敗 </div>";
          }
          /*------------------------更新訂單表頭 結束------------------------*/
      }elseif($SO_exists == false && $SOcode_Dup == false){ //SO 銷貨訂單不存在, 新增訂單, 沒有重複
          /*------------------------新增訂單表頭 開始------------------------*/
          $insert = $conn->prepare("INSERT INTO SalesOrder (
              SalesOrder_id,
              SO_Date,
              SO_ReqDate,
              SO_Address,
              SO_Amount,
              SO_Customer_id,
              SO_User_id,
              SO_Code) VALUES (
                  :SalesOrder_id,
                  :SO_Date,
                  :SO_ReqDate,
                  :SO_Address,
                  :SO_Amount,
                  :SO_Customer_id,
                  :SO_User_id,
                  :SO_Code)");
          $insert->execute(array( //執行新增
              ':SalesOrder_id' => NULL,
              ':SO_Date' => $SO_Date,
              ':SO_ReqDate' => $SO_ReqDate,
              ':SO_Address' => $SO_Address,
              ':SO_Amount' => $SO_Amount,
              ':SO_Customer_id' => $SO_Customer_id,
              ':SO_User_id' => $User_id, //紀錄新增表單的使用者
              ':SO_Code' => $SO_Code));
          $SalesOrder_id = $conn->lastInsertId(); //回傳剛才Insert的Table PK

          if($insert){ //確定是否新增成功
              echo "</br></br><div class='alert alert-success' role='alert'> 新增訂單表頭成功 </div>";
              $SO_header = true;//表頭完成新增修改
          }else{
              echo "</br></br><div class='alert alert-warning' role='alert'> 新增訂單表頭失敗 </div>";
          }
          /*------------------------新增訂單表頭 結束------------------------*/
      }if($SO_exists == false && $SOcode_Dup == true){
          echo "</br></br><div class='alert alert-warning' role='alert'> 訂單編號重複 </div>";
      }
    }

    if($SO_header){ //表頭完成新增修改後再執行
        /*------------------------檢查清單資訊存在 開始------------------------*/
        $has_product = false;//檢查是否有輸入Product資料

        if(array_map('trim',$_POST["Productcode"])){ //確定刪除空格後的Productcode的輸入Array存在資料
              $Productcode = array_map('trim',$_POST["Productcode"]); //Productcode陣列
              $has_product = true;
        }else{
              $product_check = $product_check." 商品編號\t"; //部分警告訊息
        }

        if(array_map('trim',$_POST["Productname"])){ //確定刪除空格後的Productname的輸入Array存在資料
              $Productname = array_map('trim',$_POST["Productname"]); //Productname陣列
              $has_product = true;
        }else{
              $product_check = $product_check." 商品名稱\t"; //部分警告訊息
        }

        if(!$has_product){
              echo "</br></br><div class='alert alert-danger' role='alert'> 您未輸入 $product_check </div>";
        }else{ //完成輸入清單資訊, 找在資料庫中的 Productcode
              $product_exists = false; //檢查Productcode 存不存在
              /*------------------------檢查Product存在於資料庫中 開始------------------------*/
              $Productcode = array_filter($Productcode);//刪除空白
              $Productname = array_filter($Productname);//刪除空白
              foreach($Productcode as $key => $Product){ //$Productcode計算數量, $key數字, $Product是$Productcode資料(不用$key)
                  $query = "SELECT Product_id FROM Products WHERE"; //查詢Productcode
                  $array = array( //Product WHERE 條件
                      ':Productcode' => $Product,
                      ':Productname' => $Productname[$key]);
                  $values = array();
                  $array = array_filter($array,function ($value) {return null !== $value;}); //如果其中有Null會直接刪掉
                  foreach ($array as $nkey => $value) {
                      $query .= ' '.substr($nkey,1).' = '.$nkey.' AND'; //產生SQL Statement中的WHERE部分
                      $values[''.$nkey] = $value; //形成Execute中要輸入的資料
                  }
                  $query = substr($query, 0, -3).';';//刪掉WHERE部分多餘的AND及加上;
                  $select = $conn->prepare($query);  //產生Prepared Statement
                  $select->execute($values);         //執行(Execute)SQL指令

                  $product_exist = true;
                  if(!($select->rowCount() > 0)){ //如果回傳行數不大於0,顯示錯誤及提示訊息
                      echo "</br></br><div class='alert alert-danger' role='alert'> 商品 ".$Product." 資料不存在, 請<a href='http://db4-ouvek-kostiva.c9users.io/Items/Item_Add.php'>新增商品</a></div>";
                      $product_exist = false;
                  }else{  //如果Customer_id存在
                      $Product_Array = array();
                      $Product_Array = $select->fetchAll(PDO::FETCH_COLUMN, 0); //將Product_id 加到$Product_Array
                  }
              }
              /*------------------------檢查Product存在於資料庫中 結束------------------------*/
        }

        $has_list = false; //確定其他清單不可空值資訊

        if(array_map('trim',$_POST["Qty"])){ //確定刪除空格後的Qty的輸入Array存在資料
              $Qty = array_map('trim',$_POST["Qty"]); //Qty陣列
              $has_list = true;
        }else{
              $product_check = $product_check." 數量\t"; //部分警告訊息
              $has_list = false;
        }

        if(array_map('trim',$_POST["UnitPrice"])){ //確定刪除空格後的UnitPrice的輸入Array存在資料
              $UnitPrice = array_map('trim',$_POST["UnitPrice"]); //UnitPrice陣列
              $has_list = true;
        }else{
              $product_check = $product_check." 價格\t"; //部分警告訊息
              $has_list = false;
        }


        $Qty = array_filter($Qty);//刪除空白
        $UnitPrice = array_filter($UnitPrice);//刪除空白
        $Product_Array = array_filter($Product_Array);
        $Discount = array_map('trim',$_POST["Discount"]); //折價,可空值
        $Tax = array_map('trim',$_POST["Tax"]); //稅率,可空值
        $Remarks = array_map('trim',$_POST["Remarks"]); //備註,可空值

        //確定資料數量可對齊

        if($has_list){
            if(count($Product_Array) == count($Qty) && count($Product_Array) == count($UnitPrice)){//檢查資料數量可對齊
                $Product_arr = $Product_Array;
                foreach ($Product_Array as $key => $Product_id) { //將清單用回圈匯入
                    try{
                        $stmt = $conn->prepare("INSERT INTO SalesOrder_List (
                            SO_List_SalesOrder_id,
                            SO_List_Quantity,
                            SO_List_Discount,
                            SO_List_UnitPrice,
                            SO_List_Tax,
                            SO_List_Remarks,
                            SOList_id,
                            SO_Product_id
                            ) VALUES (
                                :SO_List_SalesOrder_id,
                                :SO_List_Quantity,
                                :SO_List_Discount,
                                :SO_List_UnitPrice,
                                :SO_List_Tax,
                                :SO_List_Remarks,
                                :SOList_id,
                                :SO_Product_id
                                )");
                        $stmt->execute(array(
                            ':SO_List_SalesOrder_id' => $SalesOrder_id,
                            ':SO_List_Quantity' => $Qty[$key],
                            ':SO_List_Discount' => $Discount[$key],
                            ':SO_List_UnitPrice' =>$UnitPrice[$key],
                            ':SO_List_Tax' => $Tax[$key],
                            ':SO_List_Remarks' => $Remarks[$key],
                            ':SOList_id' => NULL,
                            ':SO_Product_id' => $Product_arr[$key]
                            ));//執行SQL
                    }catch(PDOException $e){
                        echo "</br></br><div class='alert alert-danger' role='alert'> ".$e->getMessage()." </div>";
                    }
                }
                echo "</br></br><div class='alert alert-success' role='alert'> 新增銷貨訂單成功 </div>";
            }else{
                echo "</br></br><div class='alert alert-danger' role='alert'> 某些商品資料缺少, 請確認數量及單價為必填欄位 </div>";
            }
        }


        /*------------------------檢查清單資訊存在 結束------------------------*/
    }/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~新增訂單完成~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    if($SO_header_update){ //表頭完成修改後再執行
        /*------------------------檢查清單資訊存在 開始------------------------*/
        $has_product = false;//檢查是否有輸入Product資料

        if(array_map('trim',$_POST["Productcode"])){ //確定刪除空格後的Productcode的輸入Array存在資料
              $Productcode = array_map('trim',$_POST["Productcode"]); //Productcode陣列
              $has_product = true;
        }else{
              $product_check = $product_check." 商品編號\t"; //部分警告訊息
        }

        if(array_map('trim',$_POST["Productname"])){ //確定刪除空格後的Productname的輸入Array存在資料
              $Productname = array_map('trim',$_POST["Productname"]); //Productname陣列
              $has_product = true;
        }else{
              $product_check = $product_check." 商品名稱\t"; //部分警告訊息
        }

        if(!$has_product){
              echo "</br></br><div class='alert alert-danger' role='alert'> 您未輸入 $product_check </div>";
        }else{ //完成輸入清單資訊, 找在資料庫中的 Productcode
              $product_exists = false; //檢查Productcode 存不存在
              /*------------------------檢查Product存在於資料庫中 開始------------------------*/
              $Productcode = array_filter($Productcode);//刪除空白
              $Productname = array_filter($Productname);//刪除空白
              $Product_Array = array();
              foreach($Productcode as $key => $Product){ //$Productcode計算數量, $key數字, $Product是$Productcode資料(不用$key)
                  $query = "SELECT Product_id FROM Products WHERE"; //查詢Productcode
                  $array = array( //Product WHERE 條件
                      ':Productcode' => $Product,
                      ':Productname' => $Productname[$key]);
                  $values = array();
                  $array = array_filter($array,function ($value) {return null !== $value;}); //如果其中有Null會直接刪掉
                  foreach ($array as $nkey => $value) {
                      $query .= ' '.substr($nkey,1).' = '.$nkey.' AND'; //產生SQL Statement中的WHERE部分
                      $values[''.$nkey] = $value; //形成Execute中要輸入的資料
                  }
                  $query = substr($query, 0, -3).';';//刪掉WHERE部分多餘的AND及加上;
                  $select = $conn->prepare($query);  //產生Prepared Statement
                  $select->execute($values);         //執行(Execute)SQL指令

                  $product_exist = true;
                  if(!($select->rowCount() > 0)){ //如果回傳行數不大於0,顯示錯誤及提示訊息
                      echo "</br></br><div class='alert alert-danger' role='alert'> 商品 ".$Product." 資料不存在, 請<a href='http://db4-ouvek-kostiva.c9users.io/Items/Item_Add.php'>新增商品</a></div>";
                      $product_exist = false;
                  }else{  //如果Customer_id存在
                      $Product_Array[] = $select->fetchAll(PDO::FETCH_COLUMN, 0); //將Product_id 加到$Product_Array
                  }
              }
              /*------------------------檢查Product存在於資料庫中 結束------------------------*/
        }

        $has_list = false; //確定其他清單不可空值資訊

        if(array_map('trim',$_POST["Qty"])){ //確定刪除空格後的Qty的輸入Array存在資料
              $Qty = array_map('trim',$_POST["Qty"]); //Qty陣列
              $has_list = true;
        }else{
              $product_check = $product_check." 數量\t"; //部分警告訊息
              $has_list = false;
        }

        if(array_map('trim',$_POST["UnitPrice"])){ //確定刪除空格後的UnitPrice的輸入Array存在資料
              $UnitPrice = array_map('trim',$_POST["UnitPrice"]); //UnitPrice陣列
              $has_list = true;
        }else{
              $product_check = $product_check." 價格\t"; //部分警告訊息
              $has_list = false;
        }

        $Qty = array_filter($Qty);//刪除空白
        $UnitPrice = array_filter($UnitPrice);//刪除空白
        $Product_Array = array_filter($Product_Array);
        $Discount = array_map('trim',$_POST["Discount"]); //折價,可空值
        $Tax = array_map('trim',$_POST["Tax"]); //稅率,可空值
        $Remarks = array_map('trim',$_POST["Remarks"]); //備註,可空值

        //確定資料數量可對齊

        if($has_list){

            $select = $conn->prepare("SELECT SalesOrder_id FROM SalesOrder WHERE SO_Code = :SO_Code "); //檢查Sales_Order是否已存在
            $select->execute(array(':SO_Code' => $SO_Code));//執行SQL
            $SO_id_fetch = $select->fetch(PDO::FETCH_ASSOC);
            $SO_id = $SO_id_fetch['SalesOrder_id'];

            $select = $conn->prepare("SELECT * FROM SalesOrder_List WHERE SO_List_SalesOrder_id = :SO_List_SalesOrder_id "); //檢查Sales_Order是否已存在
            $select->execute(array(':SO_List_SalesOrder_id' => $SO_id));//執行SQL
            $listrowcount = $select->rowCount();

            //var_dump($Product_Array);
            //var_dump($Qty);
            //var_dump($UnitPrice);

            if(count($Product_Array) == count($Qty) && count($Product_Array) == count($UnitPrice)){//檢查資料數量可對齊
                $Product_arr = $Product_Array;
                for($key = 0; $key < $listrowcount; $key++) { //將清單用回圈匯入

                    $SOList = $select->fetch(PDO::FETCH_ASSOC);
                    try{
                        $stmt = $conn->prepare("UPDATE SalesOrder_List SET
                            SO_List_SalesOrder_id = :SO_List_SalesOrder_id,
                            SO_List_Quantity = :SO_List_Quantity,
                            SO_List_Discount = :SO_List_Discount,
                            SO_List_UnitPrice = :SO_List_UnitPrice,
                            SO_List_Tax = :SO_List_Tax,
                            SO_List_Remarks = :SO_List_Remarks,
                            SO_Product_id = :SO_Product_id
                            WHERE SOList_id = :SOList_id
                            ");
                        $stmt->execute(array(
                            ':SO_List_SalesOrder_id' => $SO_id,
                            ':SO_List_Quantity' => $Qty[$key],
                            ':SO_List_Discount' => $Discount[$key],
                            ':SO_List_UnitPrice' =>$UnitPrice[$key],
                            ':SO_List_Tax' => $Tax[$key],
                            ':SO_List_Remarks' => $Remarks[$key],
                            ':SOList_id' => $SOList['SOList_id'],
                            ':SO_Product_id' => $Product_arr[$key][0]
                            ));//執行SQL

                    }catch(PDOException $e){
                        echo "</br></br><div class='alert alert-danger' role='alert'> ".$e->getMessage()." </div>";
                    }
                }
                echo "</br></br><div class='alert alert-success' role='alert'> 修改銷貨訂單成功 離開修改回到<a href='./Sales_Order_Add.php'>新增訂單</a> </div>";
            }else{
                echo "</br></br><div class='alert alert-danger' role='alert'> 某些商品資料缺少, 請確認數量及單價為必填欄位 </div>";
            }
        }


        /*------------------------檢查清單資訊存在 結束------------------------*/
    }



}elseif(isset($_POST['delete'])){ //如果按下刪除按鈕

    $ok_delete = true;//確認所有資料是否可以

    if(!"" == trim($_POST['SO_Date'])){ //是否有輸入日期
        $SO_Date = date("Y-m-d H:i:s", strtotime($_POST['SO_Date'])); //將日期從字串->變整數->變MySQL日期格式
    }else{
        $ok_delete = false;
        echo "</br></br><div class='alert alert-danger' role='alert'> 日期不可空白 </div>";
    }

    if(!"" == trim($_POST['SO_Code'])){ //是否有輸入 SO_Code
        $SO_Code = $_POST['SO_Code'];
        $SO_checked = true; //確定有輸入SO_code
        $select = $conn->prepare("SELECT * FROM SalesOrder WHERE SO_Code = :SO_Code AND SO_Date = :SO_Date "); //檢查Sales_Order是否已存在
        $select->execute(array(':SO_Code' => $SO_Code, ':SO_Date' => $SO_Date));//執行SQL
        if($select->rowCount() > 0){ //有銷貨訂單
            $result = $select->fetch();
            $SalesOrder_id = $result['SalesOrder_id']; //取得SO 銷貨訂單的 PK
        }else {
            echo "</br></br><div class='alert alert-danger' role='alert'> 訂單不存在 </div>";
        }
    }else{
        $ok_delete = false;
        echo "</br></br><div class='alert alert-danger' role='alert'> 請輸入訂單編號 </div>"; //沒有輸入訂單編號的錯誤訊息
    }

    if($ok_delete){
        $select = $conn->prepare("SELECT * FROM SalesOrder WHERE SO_Code = :SO_Code AND SO_Date = :SO_Date "); //檢查Sales_Order是否已存在
        $select->execute(array(':SO_Code' => $SO_Code, ':SO_Date' => $SO_Date));//執行SQL
        if($select->rowCount() > 0){ //有銷貨訂單
            $result = $select->fetch();
            $SO_exists = true;
            $SalesOrder_id = $result['SalesOrder_id']; //取得SO 銷貨訂單的 PK

            $select = $conn->prepare("DELETE FROM SalesOrder_List WHERE SO_List_SalesOrder_id = :SalesOrder_id"); //檢查Sales_Order是否已存在
            $select->execute(array(':SalesOrder_id' => $SalesOrder_id));//執行SQL
            if($select->rowCount() == 0){
                echo "</br></br><div class='alert alert-danger' role='alert'> 刪除出現錯誤 </div>";
            }else{
                $select = $conn->prepare("DELETE FROM SalesOrder WHERE SalesOrder_id = :SalesOrder_id AND SO_Date = :SO_Date"); //檢查Sales_Order是否已存在
                $select->execute(array(':SalesOrder_id' => $SalesOrder_id, ':SO_Date' => $SO_Date));//執行SQL
                if($select->rowCount() > 0){
                    echo "</br></br><div class='alert alert-success' role='alert'> 刪除成功 </div>";
                }else{
                    echo "</br></br><div class='alert alert-danger' role='alert'> 刪除出現錯誤! </div>";
                }
            }

        }else{
            echo "</br></br><div class='alert alert-danger' role='alert'> 訂單不存在 </div>";
        }
    }
}elseif(isset($_POST['copyToGR'])){

/////////////////////複製到收貨單

} //如果按下複製至收貨單按鈕


/*修改傳入值*/
if(isset($_GET['view'])){

    if(!"" == trim($_GET['view'])){ //確定真的有SO_Code傳入
        $SO_Code = $_GET['view'];

        $select = $conn->prepare("SELECT * FROM SalesOrder WHERE SO_Code = :SO_Code");
        $select->execute(array(':SO_Code' => $SO_Code));
        $updaterow = $select->fetch(PDO::FETCH_ASSOC);

        $vesel = $conn->prepare("SELECT Customercode,Customername,CustomerEmail FROM Customer WHERE Customer_id = :SO_Customer_id");
        $vesel->execute(array(':SO_Customer_id' => $updaterow['SO_Customer_id']));
        $updatevendor = $vesel->fetch(PDO::FETCH_ASSOC);

        $SO_List_SalesOrder_id = $updaterow['SalesOrder_id'];

        $getlist = $conn->prepare("SELECT * FROM SalesOrder_List WHERE SO_List_SalesOrder_id = :SO_List_SalesOrder_id");
        $getlist->execute(array(':SO_List_SalesOrder_id' => $SO_List_SalesOrder_id));
        $listrows = $getlist->rowCount();

    }

}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../favicon.ico">

    <title>銷貨訂單-新增</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/starter-template.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]-->
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!--[endif]-->
  </head>

  <body>
    <nav class="navbar navbar-inverse navbar-fixed-top">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
        </div>
        <div id="navbar" class="collapse navbar-collapse navbar-inverse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../Sales/Sales_Order_Add.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 銷貨</a></li>
            <li><a href="../Purchase/Purchase_Order_Add.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 進貨</a></li>
            <li><a href=../Inventory/Receive_Add.php><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 庫存</a></li>
            <li><a href="../Items/Item_Add.php"><span class="glyphicon glyphicon-indent-left" aria-hidden="true"></span> 品項</a></li>
            <li><a href="../Partners/Customer_Add.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> 商業夥伴</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <li class="navbar-left"><a href="../User.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 個人設定</a></li>
            <p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $username ?></p>
            <li><a href="../signout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 登出</a></li>
          </ul>
        </div><!--/.nav-collapse -->
        <div id="navbar" class=""></div>
      </div>
    </nav>
    <nav class="navbar">
      <ul class="nav nav-tabs">
        <li role="presentation"><a href="./Sales_Quotation_Add.php">報價</a></li>
        <li role="presentation" class="active"><a>訂單</a></li>
        <li role="presentation"><a href="./Delivery_Add.php">出貨</a></li>
        <li role="presentation"><a href="./Invoice_Add.php">發票</a></li>
        <li role="presentation"><a href="./Collections_Add.php">付款</a></li>
        <li role="presentation"><a href="./Return_Add.php">退貨</a></li>
        <div class="col-lg-3">
          <a href="./Sales_Order_Search.php" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            查詢
          </a>
          <a class="btn btn-secondary btn-sm" disabled>
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            新增
          </a>
        </div>
      </ul>
    </nav>

    <div class="container">
<form class="form-horizontal" role="form" method="post">
      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶編號*</span>
            <input type="text" class="form-control" placeholder="SO_Customer_id" name="SO_Customer_id" value="<?php echo $updatevendor['Customercode']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶名稱*</span>
            <input type="text" class="form-control" placeholder="Customername" name="Customername" value="<?php echo $updatevendor['Customername']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶Email</span>
            <input type="text" class="form-control" placeholder="CustomerTel" name="CustomerEmail" value="<?php echo $updatevendor['CustomerEmail']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">訂單編號*</span>
            <input type="text" class="form-control" placeholder="SO_Code" name="SO_Code" <?php if(!"" == trim($_GET['view'])){echo "value='".$updaterow['SO_Code']."' ";} ?>>
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">下訂日期*</span>
            <input type="text" class="form-control" placeholder="SO_Date" name="SO_Date" value="<?php if(!"" == trim($_GET['view'])){ echo $updaterow['SO_Date']; }else{ echo date("Y-m-d H:i:s");} ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">送貨截止日</span>
            <input type="text" class="form-control" placeholder="SO_ReqDate" name="SO_ReqDate" value="<?php echo $updaterow['SO_ReqDate']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">送貨地址</span>
            <input type="text" class="form-control" placeholder="SO_Address" name="SO_Address" value="<?php $updaterow['SO_Address']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="input-group input-group-sm"></div>
      <table class="table">
        <thead>
          <tr>
            <th>列</th>
            <th>商品編號</th>
            <th>名稱</th>
            <th>數量</th>
            <th>單價</th>
            <th>折扣 %</th>
            <th>稅率 %</th>
            <th>備註</th>
          </tr>
        </thead>
        <tbody>
          <?php
          /*  ~~~~~~~~~~~~~~~~~~~~~~~~~~~顯示清單輸入框~~~~~~~~~~~~~~~~~~~~~~~~~~~  */

          if(isset($_GET['view'])){
            for($i = 1; $i <= $listrows; $i++){
                $updatelist = $getlist->fetch(PDO::FETCH_ASSOC);
                $getProduct = $conn->prepare("SELECT Productcode,Productname FROM Products WHERE Product_id = :Product_id");
                $getProduct->execute(array(':Product_id' => $updatelist['SO_Product_id']));
                $updateProduct = $getProduct->fetch(PDO::FETCH_ASSOC);

                echo "
                    <tr>
                      <td>$i</td>
                      <td><input type='text' class='form-control' placeholder='Productcode[]' name='Productcode[]' value='".$updateProduct['Productcode']."'></td>
                      <td><input type='text' class='form-control' placeholder='Productname[]' name='Productname[]' value='".$updateProduct['Productname']."'></td>
                      <td><input type='text' class='form-control' placeholder='Qty[]' name='Qty[]' value='".$updatelist['SO_List_Quantity']."'></td>
                      <td><input type='text' class='form-control' placeholder='UnitPrice[]' name='UnitPrice[]' value='".$updatelist['SO_List_UnitPrice']."'></td>
                      <td><input type='text' class='form-control' placeholder='Discount[]' name='Discount[]' value='".$updatelist['SO_List_Discount']."'></td>
                      <td><input type='text' class='form-control' placeholder='Tax[]' name='Tax[]' value='".$updatelist['SO_List_Tax']."'></td>
                      <td><input type='text' class='form-control' placeholder='Remarks[]' name='Remarks[]' value='".$updatelist['SO_List_Remarks']."'></td>
                    </tr>
                ";
            }
          }
            for($i = $listrows+1; $i <= $listTotalRows-$listrows; $i++){
                echo "
                    <tr>
                      <td>$i</td>
                      <td><input type='text' class='form-control' placeholder='Productcode[]' name='Productcode[]'></td>
                      <td><input type='text' class='form-control' placeholder='Productname[]' name='Productname[]'></td>
                      <td><input type='text' class='form-control' placeholder='Qty[]' name='Qty[]'></td>
                      <td><input type='text' class='form-control' placeholder='UnitPrice[]' name='UnitPrice[]'></td>
                      <td><input type='text' class='form-control' placeholder='Discount[]' name='Discount[]'></td>
                      <td><input type='text' class='form-control' placeholder='Tax[]' name='Tax[]'></td>
                      <td><input type='text' class='form-control' placeholder='Remarks[]' name='Remarks[]'></td>
                    </tr>
                ";
            }

          /*  ~~~~~~~~~~~~~~~~~~~~~~~~~~~顯示清單輸入框 輸入~~~~~~~~~~~~~~~~~~~~~~~~~~~  */
          ?>


<!-- Haven't changed below for javascript end  -->

        </tbody>
      </table>

    <!--  <div class="col-lg-3">
        <div class="input-group">
          <span class="input-group-addon">總金額 $</span>
          <input type="text" class="form-control" placeholder="SO_Amount" name="SO_Amount">
        </div>--><!-- /input-group -->
    <!--  </div>--><!-- /.col-lg-6 -->

      <div class="col-lg-6"> </div>
      <div class="col-lg-2">
        <button type="submit" class="btn btn-danger" name="delete">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          刪除本訂單
        </button>
      </div><!-- /.col-lg-6 -->
      <div class="col-lg-2">
        <button type="submit" class="btn btn-default" name="copyToGR">
          <span class="glyphicon glyphicon-forward" aria-hidden="true"></span>
          複製至收貨單
        </button>
      </div><!-- /.col-lg-6 -->
      <div class="col-lg-2">
        <button type="submit" class="btn btn-default" name="save">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          儲存訂單
        </button>
      </div><!-- /.col-lg-6 -->
</form>
      <h3>.</h3>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="../js/count.js"></script>
  </body>
</html>
