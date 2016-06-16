<?php

echo "<meta charset='UTF-8'>";

if(isset($_POST['save']))
{ //如果按儲存的Button
    //傳入form的值,如果不是空的就傳到這裡的變數
    $has_reqired_values = true;

    if(!"" == trim($_POST['Customercode'])){
        $Customercode = $_POST['Customercode'];
    }else{echo "客戶編號 不可為空白 </br>"; $has_reqired_values = false;}

    if(!"" == trim($_POST['Customername'])){
        $Customername = $_POST['Customername'];
    }else{echo "名稱 不可為空白 </br>"; $has_reqired_values = false;}

    if(!"" == trim($_POST['CustomerTel_1'])){
        $CustomerTel_1 = $_POST['CustomerTel_1'];
    }else{$CustomerTel_1 = NULL;}

    if(!"" == trim($_POST['CustomerID'])){
        $CustomerID = $_POST['CustomerID'];
    }else{$CustomerID = NULL;}

    if(!"" == trim($_POST['CustomerEmail'])){
        $CustomerEmail = $_POST['CustomerEmail'];
    }else{echo "Email不可為空白</br>"; $has_reqired_values = false;}

    if(!"" == trim($_POST['CustomerCompany'])){
        $CustomerCompany = $_POST['CustomerCompany'];
    }else{$CustomerCompany = NULL;}

    if(!"" == trim($_POST['CustomerTel_2'])){
        $CustomerTel_2 = $_POST['CustomerTel_2'];
    }else{$CustomerTel_2 = NULL;}

    if(!"" == trim($_POST['CustomerWebsite'])){
        $CustomerWebsite = $_POST['CustomerWebsite'];
    }else{$CustomerWebsite = NULL;}

    if(!"" == trim($_POST['CustomerType'])){
        $CustomerType = $_POST['CustomerType'];
    }else{$CustomerType = NULL;}

    if(!"" == trim($_POST['CustomerPayMethod_id'])){
        $CustomerPayMethod_id = $_POST['CustomerPayMethod_id'];
    }else{$CustomerPayMethod_id = NULL;}

    if(!"" == trim($_POST['CustomerBank'])){
        $CustomerBank = $_POST['CustomerBank'];
    }else{$CustomerBank  = NULL;}

    if(!"" == trim($_POST['CustomerBankNo'])){
        $CustomerBankNo = $_POST['CustomerBankNo'];
    }else{$CustomerBankNo = NULL;}

    if(!"" == trim($_POST['Username'])){
        $Username = $_POST['Username'];
    }else{
        echo "Username不可為空白</br>
        如果並未為客戶新增帳號, 請點 <a href='https://db4-ouvek-kostiva.c9users.io/registered.php'>https://db4-ouvek-kostiva.c9users.io/registered.php</a> 幫客戶新增帳號 </br>
        或回客戶頁面 <a href='https://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php</a>
        ";
        $has_reqired_values = false;
    }

    if(!"" == trim($_POST['CustomerAddress'])){
        $CustomerAddress = $_POST['CustomerAddress'];
    }else{$CustomerAddress = NULL;}

    if(!"" == trim($_POST['CustomerRemarks'])){
        $CustomerRemarks = $_POST['CustomerRemarks'];
    }else{$CustomerRemarks = NULL;}

    if($has_reqired_values){

        require '../db.php';
        $select = $conn->prepare("SELECT COUNT(Customercode) FROM Customer WHERE Customercode = :Customercode; ");//檢查是否已有Customercode在資料庫中
        $select->execute(array(':Customercode' => $Customercode));//執行SQL
        $result = $select->fetchColumn();//取得數量

        $select = $conn->prepare("SELECT User_id FROM Users WHERE Username = :Username ");
        $select->execute(array(':Username' => $Username));//取得Username對應的User_id
        $Username = $select->fetchColumn();

        $select = $conn->prepare("SELECT PaymentMethod_id FROM PaymentMethod WHERE PaymentName = :CustomerPayMethod_id ");
        $select->execute(array(':CustomerPayMethod_id' => $CustomerPayMethod_id));//取得Username對應的User_id
        $CustomerPayMethod_id = $select->fetchColumn();

        if($result > 0)
        {//修改舊資料
            $select = $conn->prepare("UPDATE Customer SET
                Customername = :Customername,
                CustomerTel_1 = :CustomerTel_1,
                CustomerID = :CustomerID,
                CustomerEmail = :CustomerEmail,
                CustomerCompany = :CustomerCompany,
                CustomerTel_2 = :CustomerTel_2,
                CustomerWebsite = :CustomerWebsite,
                CustomerType = :CustomerType,
                CustomerPayMethod_id = :CustomerPayMethod_id,
                CustomerBank = :CustomerBank,
                CustomerBankNo = :CustomerBankNo,
                CustomerUser_id = :CustomerUser_id,
                CustomerAddress = :CustomerAddress,
                CustomerRemarks = :CustomerRemarks WHERE Customercode = :Customercode");
            $select->execute(array(
                    ':Customercode' => $Customercode,
                    ':Customername' => $Customername,
                    ':CustomerTel_1' => $CustomerTel_1,
                    ':CustomerID' => $CustomerID,
                    ':CustomerEmail' => $CustomerEmail,
                    ':CustomerCompany' => $CustomerCompany,
                    ':CustomerTel_2' => $CustomerTel_2,
                    ':CustomerWebsite' => $CustomerWebsite,
                    ':CustomerType' => $CustomerType,
                    ':CustomerPayMethod_id' => $CustomerPayMethod_id,
                    ':CustomerBank' => $CustomerBank,
                    ':CustomerBankNo' => $CustomerBankNo,
                    ':CustomerUser_id' => $Username,
                    ':CustomerAddress' => $CustomerAddress,
                    ':CustomerRemarks' => $CustomerRemarks
                    ));
            echo "新增成功! </br>
                  即將跳轉回客戶頁面 <a href='http://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php</a>
                  <script language=javascript>
                    window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'; },1000);
                  </script>
            ";
        }
        else
        {//新增新資料
            $select = $conn->prepare("INSERT INTO Customer (
                Customer_id,
                Customercode,
                Customername,
                CustomerTel_1,
                CustomerID,
                CustomerEmail,
                CustomerCompany,
                CustomerTel_2,
                CustomerWebsite,
                CustomerType,
                CustomerPayMethod_id,
                CustomerBank,
                CustomerBankNo,
                CustomerUser_id,
                CustomerAddress,
                CustomerRemarks) VALUES (
                    :Customer_id,
                    :Customercode,
                    :Customername,
                    :CustomerTel_1,
                    :CustomerID,
                    :CustomerEmail,
                    :CustomerCompany,
                    :CustomerTel_2,
                    :CustomerWebsite,
                    :CustomerType,
                    :CustomerPayMethod_id,
                    :CustomerBank,
                    :CustomerBankNo,
                    :CustomerUser_id,
                    :CustomerAddress,
                    :CustomerRemarks)");
            $select->execute(array(
                    ':Customer_id' => NULL,
                    ':Customercode' => $Customercode,
                    ':Customername' => $Customername,
                    ':CustomerTel_1' => $CustomerTel_1,
                    ':CustomerID' => $CustomerID,
                    ':CustomerEmail' => $CustomerEmail,
                    ':CustomerCompany' => $CustomerCompany,
                    ':CustomerTel_2' => $CustomerTel_2,
                    ':CustomerWebsite' => $CustomerWebsite,
                    ':CustomerType' => $CustomerType,
                    ':CustomerPayMethod_id' => $CustomerPayMethod_id,
                    ':CustomerBank' => $CustomerBank,
                    ':CustomerBankNo' => $CustomerBankNo,
                    ':CustomerUser_id' => $Username,
                    ':CustomerAddress' => $CustomerAddress,
                    ':CustomerRemarks' => $CustomerRemarks
                    ));

            echo "更新成功! </br>
                  即將跳轉回客戶頁面 <a href='http://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php</a>
                  <script language=javascript>
                    window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'; },1000);
                  </script>
            ";
            }
    }//確定有填入足夠資訊 has_required_value用true false if判定
//////////////以上為按下Save的部分
}
if(isset($_POST['delete']))
{
    require '../db.php';
    if(!"" == trim($_POST['Customercode'])){
        $Customercode = $_POST['Customercode'];
    }else{echo "客戶編號 不可為空白 </br>";}
    $select = $conn->prepare("SELECT COUNT(Customercode) FROM Customer WHERE Customercode = :Customercode; ");//檢查是否已有Customercode在資料庫中
    $select->execute(array(':Customercode' => $Customercode));//執行SQL
    $result = $select->fetchColumn();//取得數量
    if($result > 0){
        $filler = "DataRemoved";//填充資料, 代表已刪除
        $select = $conn->prepare("UPDATE Customer SET
            Customername = :Customername,
            CustomerTel_1 = :CustomerTel_1,
            CustomerID = :CustomerID,
            CustomerEmail = :CustomerEmail,
            CustomerCompany = :CustomerCompany,
            CustomerTel_2 = :CustomerTel_2,
            CustomerWebsite = :CustomerWebsite,
            CustomerType = :CustomerType,
            CustomerBank = :CustomerBank,
            CustomerBankNo = :CustomerBankNo,
            CustomerAddress = :CustomerAddress,
            CustomerRemarks = :CustomerRemarks WHERE Customercode = :Customercode");
        $select->execute(array(
                ':Customercode' => $Customercode,
                ':Customername' => $filler,
                ':CustomerTel_1' => $filler,
                ':CustomerID' => $filler,
                ':CustomerEmail' => $filler,
                ':CustomerCompany' => $filler,
                ':CustomerTel_2' => $filler,
                ':CustomerWebsite' => $filler,
                ':CustomerType' => $filler,
                ':CustomerBank' => $filler,
                ':CustomerBankNo' => $filler,
                ':CustomerAddress' => $filler,
                ':CustomerRemarks' => $filler
                ));
        echo "客戶編號:$Customercode 資料已刪除! </br>
              即將跳轉回客戶頁面 <a href='http://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php</a>
              <script language=javascript>
                window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/Partners/Customer_Add.php'; },1000);
              </script>
        ";
    }//確定有資料
}//刪除按鈕