<?php

$dbhost = '127.0.0.1';
    $dbuser = 'Signupuser';
    $dbpass = '';
    $dbname = 'c9';
    try{
    $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname,$dbuser,$dbpass);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
    $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
    } catch (PDOException $e) {
        throw new PDOException("Error  : " .$e->getMessage());
    }

echo "<meta charset='UTF-8'>";

if(isset($_POST['save']))
{ //如果按儲存的Button
    //傳入form的值,如果不是空的就傳到這裡的變數
    $has_reqired_values = true;

    if(!"" == trim($_POST['Vendorcode'])){
        $Vendorcode = $_POST['Vendorcode'];
    }else{echo "供應商編號 不可為空白 </br>"; $has_reqired_values = false;}

    if(!"" == trim($_POST['Vendorname'])){
        $Vendorname = $_POST['Vendorname'];
    }else{echo "名稱 不可為空白 </br>"; $has_reqired_values = false;}

    if(!"" == trim($_POST['VendorTel_1'])){
        $VendorTel_1 = $_POST['VendorTel_1'];
    }else{$VendorTel_1 = NULL;}

    if(!"" == trim($_POST['VendorID'])){
        $VendorID = $_POST['VendorID'];
    }else{$VendorID = NULL;}

    if(!"" == trim($_POST['VendorEmail'])){
        $VendorEmail = $_POST['VendorEmail'];
    }else{echo "Email不可為空白</br>"; $has_reqired_values = false;}

    if(!"" == trim($_POST['VendorCompany'])){
        $VendorCompany = $_POST['VendorCompany'];
    }else{$VendorCompany = NULL;}

    if(!"" == trim($_POST['VendorTel_2'])){
        $VendorTel_2 = $_POST['VendorTel_2'];
    }else{$VendorTel_2 = NULL;}

    if(!"" == trim($_POST['VendorWebsite'])){
        $VendorWebsite = $_POST['VendorWebsite'];
    }else{$VendorWebsite = NULL;}

    if(!"" == trim($_POST['VendorType'])){
        $VendorType = $_POST['VendorType'];
    }else{$VendorType = NULL;}

    if(!"" == trim($_POST['VendorPayMethod_id'])){
        $VendorPayMethod_id = $_POST['VendorPayMethod_id'];
    }else{$VendorPayMethod_id = NULL;}

    if(!"" == trim($_POST['VendorBank'])){
        $VendorBank = $_POST['VendorBank'];
    }else{$VendorBank  = NULL;}

    if(!"" == trim($_POST['VendorBankNo'])){
        $VendorBankNo = $_POST['VendorBankNo'];
    }else{$VendorBankNo = NULL;}

    if(!"" == trim($_POST['Username'])){
        $Username = $_POST['Username'];
    }else{
        echo "Username不可為空白</br>
        如果並未為供應商新增帳號, 請點 <a href='https://db4-ouvek-kostiva.c9users.io/registered.php'>https://db4-ouvek-kostiva.c9users.io/registered.php</a> 幫供應商新增帳號 </br>
        或回供應商頁面 <a href='https://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php</a>
        ";
        $has_reqired_values = false;
    }

    if(!"" == trim($_POST['VendorAddress'])){
        $VendorAddress = $_POST['VendorAddress'];
    }else{$VendorAddress = NULL;}

    if(!"" == trim($_POST['VendorRemarks'])){
        $VendorRemarks = $_POST['VendorRemarks'];
    }else{$VendorRemarks = NULL;}

    if($has_reqired_values){

        require '../db.php';
        $select = $conn->prepare("SELECT COUNT(Vendorcode) FROM Vendor WHERE Vendorcode = :Vendorcode; ");//檢查是否已有Vendorcode在資料庫中
        $select->execute(array(':Vendorcode' => $Vendorcode));//執行SQL
        $result = $select->fetchColumn();//取得數量

        $select = $conn->prepare("SELECT User_id FROM Users WHERE Username = :Username ");
        $select->execute(array(':Username' => $Username));//取得Username對應的User_id
        $Username = $select->fetchColumn();

        $select = $conn->prepare("SELECT PaymentMethod_id FROM PaymentMethod WHERE PaymentName = :VendorPayMethod_id ");
        $select->execute(array(':VendorPayMethod_id' => $VendorPayMethod_id));//取得Username對應的User_id
        $VendorPayMethod_id = $select->fetchColumn();

        if($result > 0)
        {//修改舊資料
            $select = $conn->prepare("UPDATE Vendor SET
                Vendorname = :Vendorname,
                VendorTel_1 = :VendorTel_1,
                VendorID = :VendorID,
                VendorEmail = :VendorEmail,
                VendorCompany = :VendorCompany,
                VendorTel_2 = :VendorTel_2,
                VendorWebsite = :VendorWebsite,
                VendorType = :VendorType,
                VendorPayMethod_id = :VendorPayMethod_id,
                VendorBank = :VendorBank,
                VendorBankNo = :VendorBankNo,
                VendorUser_id = :VendorUser_id,
                VendorAddress = :VendorAddress,
                VendorRemarks = :VendorRemarks WHERE Vendorcode = :Vendorcode");
            $select->execute(array(
                    ':Vendorcode' => $Vendorcode,
                    ':Vendorname' => $Vendorname,
                    ':VendorTel_1' => $VendorTel_1,
                    ':VendorID' => $VendorID,
                    ':VendorEmail' => $VendorEmail,
                    ':VendorCompany' => $VendorCompany,
                    ':VendorTel_2' => $VendorTel_2,
                    ':VendorWebsite' => $VendorWebsite,
                    ':VendorType' => $VendorType,
                    ':VendorPayMethod_id' => $VendorPayMethod_id,
                    ':VendorBank' => $VendorBank,
                    ':VendorBankNo' => $VendorBankNo,
                    ':VendorUser_id' => $Username,
                    ':VendorAddress' => $VendorAddress,
                    ':VendorRemarks' => $VendorRemarks
                    ));
            echo "新增成功! </br>
                  即將跳轉回供應商頁面 <a href='http://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php</a>
                  <script language=javascript>
                    window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'; },1000);
                  </script>
            ";
        }
        else
        {//新增新資料
            $select = $conn->prepare("INSERT INTO Vendor (
                Vendor_id,
                Vendorcode,
                Vendorname,
                VendorTel_1,
                VendorID,
                VendorEmail,
                VendorCompany,
                VendorTel_2,
                VendorWebsite,
                VendorType,
                VendorPayMethod_id,
                VendorBank,
                VendorBankNo,
                VendorUser_id,
                VendorAddress,
                VendorRemarks) VALUES (
                    :Vendor_id,
                    :Vendorcode,
                    :Vendorname,
                    :VendorTel_1,
                    :VendorID,
                    :VendorEmail,
                    :VendorCompany,
                    :VendorTel_2,
                    :VendorWebsite,
                    :VendorType,
                    :VendorPayMethod_id,
                    :VendorBank,
                    :VendorBankNo,
                    :VendorUser_id,
                    :VendorAddress,
                    :VendorRemarks)");
            $select->execute(array(
                    ':Vendor_id' => NULL,
                    ':Vendorcode' => $Vendorcode,
                    ':Vendorname' => $Vendorname,
                    ':VendorTel_1' => $VendorTel_1,
                    ':VendorID' => $VendorID,
                    ':VendorEmail' => $VendorEmail,
                    ':VendorCompany' => $VendorCompany,
                    ':VendorTel_2' => $VendorTel_2,
                    ':VendorWebsite' => $VendorWebsite,
                    ':VendorType' => $VendorType,
                    ':VendorPayMethod_id' => $VendorPayMethod_id,
                    ':VendorBank' => $VendorBank,
                    ':VendorBankNo' => $VendorBankNo,
                    ':VendorUser_id' => $Username,
                    ':VendorAddress' => $VendorAddress,
                    ':VendorRemarks' => $VendorRemarks
                    ));

            echo "更新成功! </br>
                  即將跳轉回供應商頁面 <a href='http://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php</a>
                  <script language=javascript>
                    window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'; },1000);
                  </script>
            ";
            }
    }//確定有填入足夠資訊 has_required_value用true false if判定
//////////////以上為按下Save的部分
}
if(isset($_POST['delete']))
{
    require '../db.php';
    if(!"" == trim($_POST['Vendorcode'])){
        $Vendorcode = $_POST['Vendorcode'];
    }else{echo "供應商編號 不可為空白 </br>";}
    $select = $conn->prepare("SELECT COUNT(Vendorcode) FROM Vendor WHERE Vendorcode = :Vendorcode; ");//檢查是否已有Vendorcode在資料庫中
    $select->execute(array(':Vendorcode' => $Vendorcode));//執行SQL
    $result = $select->fetchColumn();//取得數量
    if($result > 0){
        $filler = "DataRemoved";//填充資料, 代表已刪除
        $select = $conn->prepare("UPDATE Vendor SET
            Vendorname = :Vendorname,
            VendorTel_1 = :VendorTel_1,
            VendorID = :VendorID,
            VendorEmail = :VendorEmail,
            VendorCompany = :VendorCompany,
            VendorTel_2 = :VendorTel_2,
            VendorWebsite = :VendorWebsite,
            VendorType = :VendorType,
            VendorBank = :VendorBank,
            VendorBankNo = :VendorBankNo,
            VendorAddress = :VendorAddress,
            VendorRemarks = :VendorRemarks WHERE Vendorcode = :Vendorcode");
        $select->execute(array(
                ':Vendorcode' => $Vendorcode,
                ':Vendorname' => $filler,
                ':VendorTel_1' => $filler,
                ':VendorID' => $filler,
                ':VendorEmail' => $filler,
                ':VendorCompany' => $filler,
                ':VendorTel_2' => $filler,
                ':VendorWebsite' => $filler,
                ':VendorType' => $filler,
                ':VendorBank' => $filler,
                ':VendorBankNo' => $filler,
                ':VendorAddress' => $filler,
                ':VendorRemarks' => $filler
                ));
        echo "供應商編號:$Vendorcode 資料已刪除! </br>
              即將跳轉回供應商頁面 <a href='http://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'>https://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php</a>
              <script language=javascript>
                window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/Partners/Vendor_Add.php'; },1000);
              </script>
        ";
    }//確定有資料
}//刪除按鈕