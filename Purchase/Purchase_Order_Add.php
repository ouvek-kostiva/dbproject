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

    /*------------------------檢查Vendor資訊 開始------------------------*/
    $has_vendor = false; //是否有輸入供應商
    if(!"" == trim($_POST['PO_Vendor_id'])){ //確定PO_Vendor_id是否有輸入
        $has_vendor = true;
        $Vendorcode = $_POST['PO_Vendor_id'];
    }else{
        $vendor_check = $vendor_check."供應商編號 \t"; //檢查是否有輸入的Vendor訊息
        $Vendorcode = NULL;
    }

    if(!"" == trim($_POST['Vendorname'])){
        $Vendorname = $_POST['Vendorname'];
        $has_vendor = true;
    }else{
        $vendor_check = $vendor_check."供應商名稱 \t";
        $Vendorname = NULL;
    }

    if(!"" == trim($_POST['VendorEmail'])){
        $VendorEmail = $_POST['VendorEmail'];
        $has_vendor = true;
    }else{
        $vendor_check = $vendor_check."供應商Email \t";
        $VendorTel = NULL;
    }

    if(!$has_vendor){ //echo 中為未輸入任何Vendor格 的 警告訊息
        echo "</br></br><div class='alert alert-danger' role='alert'> 請至少在 $vendor_check 其中一格中輸入一項供應商資料 </div>";
    }else{ //有輸入Vendor資料

        $vendor_exist = false;

        $query = "SELECT Vendor_id FROM Vendor WHERE"; //查詢Vendor_id
        $array = array( //Vendor資料組成陣列
          ':Vendorcode' => $Vendorcode,
          ':Vendorname' => $Vendorname,
          ':VendorEmail' => $VendorEmail);
        $values = array(); //執行SQL指令輸入Prepared Statement的資料
        $array = array_filter($array,function ($value) {return null !== $value;}); //如果其中有Null會直接刪掉
        foreach ($array as $name => $value) {
          $query .= ' '.substr($name,1).' = '.$name.' AND'; //產生SQL Statement中的WHERE部分
          $values[''.$name] = $value; //形成Execute中要輸入的資料
        }
        $query = substr($query, 0, -3).';';//刪掉WHERE部分多餘的AND及加上;
        $select = $conn->prepare($query);  //產生Prepared Statement
        $select->execute($values);         //執行(Execute)SQL指令
        $PO_Vendor = $select->fetch(PDO::FETCH_ASSOC); //取得Vendor_id
        $PO_Vendor_id = $PO_Vendor['Vendor_id'];
        if($select->rowCount() > 0){ //如果Vendor_id不存在,顯示錯誤及提示訊息
            $vendor_exist = true;
        }else{  //如果Vendor_id存在
            echo "</br></br><div class='alert alert-danger' role='alert'> 供應商資料不存在, 請檢查 供應商編號 名稱 及 Email 是否吻合, 請<a href='http://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'>新增供應商</a></div>";
        }
    }

    /*------------------------檢查Vendor資訊 結束------------------------*/
    /*------------------------檢查其他表頭資訊 開始------------------------*/

    if($vendor_exist){ //當Vendor_id存在才繼續執行

        if(!"" == trim($_POST['PO_Date'])){ //是否有輸入日期
            $PO_Date = date("Y-m-d H:i:s", strtotime($_POST['PO_Date'])); //將日期從字串->變整數->變MySQL日期格式
        }else{
            $PO_Date = date("Y-m-d H:i:s"); //未輸入日期自動填入現在伺服器時間
        }

        if(!"" == trim($_POST['PO_ValidDate'])){ //送貨截止日
            $PO_ValidDate = date("Y-m-d H:i:s", strtotime($_POST['PO_ValidDate']));
        }else{
            $PO_ValidDate = NULL; //空值
        }

        if(!"" == trim($_POST['PO_Address'])){ //送貨地址
            $PO_Address = $_POST['PO_Address'];
        }else{
            $PO_Address = NULL;
        }

        if(!"" == trim($_POST['PO_Amount'])){ //總金額
            $PO_Amount = $_POST['PO_Amount'];
        }else{
            $PO_Amount = NULL;
        }

        if(!"" == trim($_POST['PO_Code'])){ //是否有輸入 PO_Code
            $PO_exists = false; //PO 進貨訂單 是否存在
            $PO_Code = $_POST['PO_Code'];
            $PO_checked = true; //確定有輸入PO_code
            $select = $conn->prepare("SELECT * FROM PurchaseOrder WHERE PO_Code = :PO_Code AND PO_Date = :PO_Date "); //檢查Purchase_Order是否已存在
            $select->execute(array(':PO_Code' => $PO_Code, ':PO_Date' => $PO_Date));//執行SQL
            if($select->rowCount() > 0){ //有進貨訂單
                $result = $select->fetch();
                $PO_exists = true;
                $PurchaseOrder_id = $result['PurchaseOrder_id']; //取得PO 進貨訂單的 PK
            }
            //確認POcode不重複
            $POcode_Dup = false;//避免POcode重複
            $select = $conn->prepare("SELECT COUNT(*) FROM PurchaseOrder WHERE PO_Code = :PO_Code "); //檢查Purchase_Order是否已存在
            $select->execute(array(':PO_Code' => $PO_Code));//執行SQL
            $count_result = $select->fetchColumn();
            if($count_result > 0){ //有進貨訂單
                $POcode_Dup = true;
            }
        }else{
            echo "</br></br><div class='alert alert-danger' role='alert'> 請輸入訂單編號 </div>"; //沒有輸入訂單編號的錯誤訊息
        }

    }
    /*------------------------檢查其他表頭資訊 開始------------------------*/

    if($PO_checked){ //PO 進貨訂單是否存在完成檢查
      $PO_header = false; //確定表頭完成新增修改
      $PO_header_update = false;
      if($PO_exists){ //PO 進貨訂單存在, 修改訂單
          /*------------------------修改訂單表頭 開始------------------------*/
          $update = $conn->prepare("UPDATE PurchaseOrder SET
              PO_Date = :PO_Date,
              PO_ValidDate = :PO_ValidDate,
              PO_Address = :PO_Address,
              PO_Amount = :PO_Amount,
              PO_Vendor_id = :PO_Vendor_id,
              PO_User_id = :PO_User_id WHERE PurchaseOrder_id = :PurchaseOrder_id");
          $update->execute(array(
              ':PurchaseOrder_id' => $PurchaseOrder_id,
              ':PO_Date' => $PO_Date,
              ':PO_ValidDate' => $PO_ValidDate,
              ':PO_Address' => $PO_Address,
              ':PO_Amount' => $PO_Amount,
              ':PO_Vendor_id' => $PO_Vendor_id,
              ':PO_User_id' => $User_id)); //紀錄新增表單的使用者
          if($update){
              echo "</br></br><div class='alert alert-success' role='alert'> 修改表頭成功 </div>";
              $PO_header_update = true;//表頭完成新增修改
          }else{
              echo "</br></br><div class='alert alert-warning' role='alert'> 修改表頭失敗 </div>";
          }
          /*------------------------更新訂單表頭 結束------------------------*/
      }elseif($PO_exists == false && $POcode_Dup == false){ //PO 進貨訂單不存在, 新增訂單, 沒有重複
          /*------------------------新增訂單表頭 開始------------------------*/
          $insert = $conn->prepare("INSERT INTO PurchaseOrder (
              PurchaseOrder_id,
              PO_Date,
              PO_ValidDate,
              PO_Address,
              PO_Amount,
              PO_Vendor_id,
              PO_User_id,
              PO_Code) VALUES (
                  :PurchaseOrder_id,
                  :PO_Date,
                  :PO_ValidDate,
                  :PO_Address,
                  :PO_Amount,
                  :PO_Vendor_id,
                  :PO_User_id,
                  :PO_Code)");
          $insert->execute(array( //執行新增
              ':PurchaseOrder_id' => NULL,
              ':PO_Date' => $PO_Date,
              ':PO_ValidDate' => $PO_ValidDate,
              ':PO_Address' => $PO_Address,
              ':PO_Amount' => $PO_Amount,
              ':PO_Vendor_id' => $PO_Vendor_id,
              ':PO_User_id' => $User_id, //紀錄新增表單的使用者
              ':PO_Code' => $PO_Code));
          $PurchaseOrder_id = $conn->lastInsertId(); //回傳剛才Insert的Table PK

          if($insert){ //確定是否新增成功
              echo "</br></br><div class='alert alert-success' role='alert'> 新增訂單表頭成功 </div>";
              $PO_header = true;//表頭完成新增修改
          }else{
              echo "</br></br><div class='alert alert-warning' role='alert'> 新增訂單表頭失敗 </div>";
          }
          /*------------------------新增訂單表頭 結束------------------------*/
      }if($PO_exists == false && $POcode_Dup == true){
          echo "</br></br><div class='alert alert-warning' role='alert'> 訂單編號重複 </div>";
      }
    }

    if($PO_header){ //表頭完成新增修改後再執行
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
                  }else{  //如果Vendor_id存在
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
                        $stmt = $conn->prepare("INSERT INTO PurchaseOrder_List (
                            PO_List_PurchaseOrder_id,
                            PO_List_Quantity,
                            PO_List_Discount,
                            PO_List_UnitPrice,
                            PO_List_Tax,
                            PO_List_Remarks,
                            POList_id,
                            PO_List_Product_id,
                            PO_Amount
                            ) VALUES (
                                :PO_List_PurchaseOrder_id,
                                :PO_List_Quantity,
                                :PO_List_Discount,
                                :PO_List_UnitPrice,
                                :PO_List_Tax,
                                :PO_List_Remarks,
                                :POList_id,
                                :PO_List_Product_id,
                                :PO_Amount
                                )");
                        $stmt->execute(array(
                            ':PO_List_PurchaseOrder_id' => $PurchaseOrder_id,
                            ':PO_List_Quantity' => $Qty[$key],
                            ':PO_List_Discount' => $Discount[$key],
                            ':PO_List_UnitPrice' =>$UnitPrice[$key],
                            ':PO_List_Tax' => $Tax[$key],
                            ':PO_List_Remarks' => $Remarks[$key],
                            ':POList_id' => NULL,
                            ':PO_List_Product_id' => $Product_arr[$key],
                            ':PO_Amount' => NULL
                            ));//執行SQL
                    }catch(PDOException $e){
                        echo "</br></br><div class='alert alert-danger' role='alert'> ".$e->getMessage()." </div>";
                    }
                }
                echo "</br></br><div class='alert alert-success' role='alert'> 新增進貨訂單成功 </div>";
            }else{
                echo "</br></br><div class='alert alert-danger' role='alert'> 某些商品資料缺少, 請確認數量及單價為必填欄位 </div>";
            }
        }


        /*------------------------檢查清單資訊存在 結束------------------------*/
    }/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~新增訂單完成~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/

    if($PO_header_update){ //表頭完成修改後再執行
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
                  }else{  //如果Vendor_id存在
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

            $select = $conn->prepare("SELECT PurchaseOrder_id FROM PurchaseOrder WHERE PO_Code = :PO_Code "); //檢查Purchase_Order是否已存在
            $select->execute(array(':PO_Code' => $PO_Code));//執行SQL
            $PO_id_fetch = $select->fetch(PDO::FETCH_ASSOC);
            $PO_id = $PO_id_fetch['PurchaseOrder_id'];

            $select = $conn->prepare("SELECT * FROM PurchaseOrder_List WHERE PO_List_PurchaseOrder_id = :PO_List_PurchaseOrder_id "); //檢查Purchase_Order是否已存在
            $select->execute(array(':PO_List_PurchaseOrder_id' => $PO_id));//執行SQL
            $listrowcount = $select->rowCount();

            //var_dump($Product_Array);
            //var_dump($Qty);
            //var_dump($UnitPrice);

            if(count($Product_Array) == count($Qty) && count($Product_Array) == count($UnitPrice)){//檢查資料數量可對齊
                $Product_arr = $Product_Array;
                for($key = 0; $key < $listrowcount; $key++) { //將清單用回圈匯入

                    $POList = $select->fetch(PDO::FETCH_ASSOC);
                    try{
                        $stmt = $conn->prepare("UPDATE PurchaseOrder_List SET
                            PO_List_PurchaseOrder_id = :PO_List_PurchaseOrder_id,
                            PO_List_Quantity = :PO_List_Quantity,
                            PO_List_Discount = :PO_List_Discount,
                            PO_List_UnitPrice = :PO_List_UnitPrice,
                            PO_List_Tax = :PO_List_Tax,
                            PO_List_Remarks = :PO_List_Remarks,
                            PO_List_Product_id = :PO_List_Product_id,
                            PO_Amount = :PO_Amount
                            WHERE POList_id = :POList_id
                            ");
                        $stmt->execute(array(
                            ':PO_List_PurchaseOrder_id' => $PO_id,
                            ':PO_List_Quantity' => $Qty[$key],
                            ':PO_List_Discount' => $Discount[$key],
                            ':PO_List_UnitPrice' =>$UnitPrice[$key],
                            ':PO_List_Tax' => $Tax[$key],
                            ':PO_List_Remarks' => $Remarks[$key],
                            ':POList_id' => $POList['POList_id'],
                            ':PO_List_Product_id' => $Product_arr[$key][0],
                            ':PO_Amount' => NULL
                            ));//執行SQL

                    }catch(PDOException $e){
                        echo "</br></br><div class='alert alert-danger' role='alert'> ".$e->getMessage()." </div>";
                    }
                }
                echo "</br></br><div class='alert alert-success' role='alert'> 修改進貨訂單成功 離開修改回到<a href='./Purchase_Order_Add.php'>新增訂單</a> </div>";
            }else{
                echo "</br></br><div class='alert alert-danger' role='alert'> 某些商品資料缺少, 請確認數量及單價為必填欄位 </div>";
            }
        }


        /*------------------------檢查清單資訊存在 結束------------------------*/
    }



}elseif(isset($_POST['delete'])){ //如果按下刪除按鈕

    $ok_delete = true;//確認所有資料是否可以

    if(!"" == trim($_POST['PO_Date'])){ //是否有輸入日期
        $PO_Date = date("Y-m-d H:i:s", strtotime($_POST['PO_Date'])); //將日期從字串->變整數->變MySQL日期格式
    }else{
        $ok_delete = false;
        echo "</br></br><div class='alert alert-danger' role='alert'> 日期不可空白 </div>";
    }

    if(!"" == trim($_POST['PO_Code'])){ //是否有輸入 PO_Code
        $PO_Code = $_POST['PO_Code'];
        $PO_checked = true; //確定有輸入PO_code
        $select = $conn->prepare("SELECT * FROM PurchaseOrder WHERE PO_Code = :PO_Code AND PO_Date = :PO_Date "); //檢查Purchase_Order是否已存在
        $select->execute(array(':PO_Code' => $PO_Code, ':PO_Date' => $PO_Date));//執行SQL
        if($select->rowCount() > 0){ //有進貨訂單
            $result = $select->fetch();
            $PurchaseOrder_id = $result['PurchaseOrder_id']; //取得PO 進貨訂單的 PK
        }else {
            echo "</br></br><div class='alert alert-danger' role='alert'> 訂單不存在 </div>";
        }
    }else{
        $ok_delete = false;
        echo "</br></br><div class='alert alert-danger' role='alert'> 請輸入訂單編號 </div>"; //沒有輸入訂單編號的錯誤訊息
    }

    if($ok_delete){
        $select = $conn->prepare("SELECT * FROM PurchaseOrder WHERE PO_Code = :PO_Code AND PO_Date = :PO_Date "); //檢查Purchase_Order是否已存在
        $select->execute(array(':PO_Code' => $PO_Code, ':PO_Date' => $PO_Date));//執行SQL
        if($select->rowCount() > 0){ //有進貨訂單
            $result = $select->fetch();
            $PO_exists = true;
            $PurchaseOrder_id = $result['PurchaseOrder_id']; //取得PO 進貨訂單的 PK

            $select = $conn->prepare("DELETE FROM PurchaseOrder_List WHERE PO_List_PurchaseOrder_id = :PurchaseOrder_id"); //檢查Purchase_Order是否已存在
            $select->execute(array(':PurchaseOrder_id' => $PurchaseOrder_id));//執行SQL
            if($select->rowCount() > 0){
                echo "</br></br><div class='alert alert-danger' role='alert'> 刪除出現錯誤 </div>";
            }else{
                $select = $conn->prepare("DELETE FROM PurchaseOrder WHERE PurchaseOrder_id = :PurchaseOrder_id AND PO_Date = :PO_Date"); //檢查Purchase_Order是否已存在
                $select->execute(array(':PurchaseOrder_id' => $PurchaseOrder_id, ':PO_Date' => $PO_Date));//執行SQL
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

    if(!"" == trim($_GET['view'])){ //確定真的有PO_Code傳入
        $PO_Code = $_GET['view'];

        $select = $conn->prepare("SELECT * FROM PurchaseOrder WHERE PO_Code = :PO_Code");
        $select->execute(array(':PO_Code' => $PO_Code));
        $updaterow = $select->fetch(PDO::FETCH_ASSOC);

        $vesel = $conn->prepare("SELECT Vendorcode,Vendorname,VendorEmail FROM Vendor WHERE Vendor_id = :PO_Vendor_id");
        $vesel->execute(array(':PO_Vendor_id' => $updaterow['PO_Vendor_id']));
        $updatevendor = $vesel->fetch(PDO::FETCH_ASSOC);

        $PO_List_PurchaseOrder_id = $updaterow['PurchaseOrder_id'];

        $getlist = $conn->prepare("SELECT * FROM PurchaseOrder_List WHERE PO_List_PurchaseOrder_id = :PO_List_PurchaseOrder_id");
        $getlist->execute(array(':PO_List_PurchaseOrder_id' => $PO_List_PurchaseOrder_id));
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

    <title>進貨訂單-新增</title>
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
            <li><a href="../Sales/Sales_Order_Add.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 銷貨</a></li>
            <li class="active"><a href="./Purchase_Order_Add.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 進貨</a></li>
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
        <li role="presentation"><a href="./Purchase_Quotation_Add.php">報價</a></li>
        <li role="presentation" class="active"><a>訂單</a></li>
        <li role="presentation"><a href="./Goods_Received_Add.php">收貨</a></li>
        <li role="presentation"><a href="./Receipt_Add.php">發票</a></li>
        <li role="presentation"><a href="./Payment_Add.php">付款</a></li>
        <li role="presentation"><a href="./Reject_Add.php">退貨</a></li>
        <div class="col-lg-3">
          <a href="./Purchase_Order_Search.php" class="btn btn-primary btn-sm">
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
            <span class="input-group-addon">供應商編號*</span>
            <input type="text" class="form-control" placeholder="PO_Vendor_id" name="PO_Vendor_id" value="<?php echo $updatevendor['Vendorcode']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">供應商名稱*</span>
            <input type="text" class="form-control" placeholder="Vendorname" name="Vendorname" value="<?php echo $updatevendor['Vendorname']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">供應商Email</span>
            <input type="text" class="form-control" placeholder="VendorTel" name="VendorEmail" value="<?php echo $updatevendor['VendorEmail']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">訂單編號*</span>
            <input type="text" class="form-control" placeholder="PO_Code" name="PO_Code" <?php if(!"" == trim($_GET['view'])){echo "value='".$updaterow['PO_Code']."' ";} ?>>
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">下訂日期*</span>
            <input type="text" class="form-control" placeholder="PO_Date" name="PO_Date" value="<?php if(!"" == trim($_GET['view'])){ echo $updaterow['PO_Date']; }else{ echo date("Y-m-d H:i:s");} ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">送貨截止日</span>
            <input type="text" class="form-control" placeholder="PO_ValidDate" name="PO_ValidDate" value="<?php echo $updaterow['PO_ValidDate']; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">送貨地址</span>
            <input type="text" class="form-control" placeholder="PO_Address" name="PO_Address" value="<?php $updaterow['PO_Address']; ?>">
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
                $getProduct->execute(array(':Product_id' => $updatelist['PO_List_Product_id']));
                $updateProduct = $getProduct->fetch(PDO::FETCH_ASSOC);

                echo "
                    <tr>
                      <td>$i</td>
                      <td><input type='text' class='form-control' placeholder='Productcode[]' name='Productcode[]' value='".$updateProduct['Productcode']."'></td>
                      <td><input type='text' class='form-control' placeholder='Productname[]' name='Productname[]' value='".$updateProduct['Productname']."'></td>
                      <td><input type='text' class='form-control' placeholder='Qty[]' name='Qty[]' value='".$updatelist['PO_List_Quantity']."'></td>
                      <td><input type='text' class='form-control' placeholder='UnitPrice[]' name='UnitPrice[]' value='".$updatelist['PO_List_UnitPrice']."'></td>
                      <td><input type='text' class='form-control' placeholder='Discount[]' name='Discount[]' value='".$updatelist['PO_List_Discount']."'></td>
                      <td><input type='text' class='form-control' placeholder='Tax[]' name='Tax[]' value='".$updatelist['PO_List_Tax']."'></td>
                      <td><input type='text' class='form-control' placeholder='Remarks[]' name='Remarks[]' value='".$updatelist['PO_List_Remarks']."'></td>
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
          <input type="text" class="form-control" placeholder="PO_Amount" name="PO_Amount">
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
