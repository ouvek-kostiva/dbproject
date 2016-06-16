<?php

require "./db.php";

$email = trim($_POST['Email']);
$pass = trim($_POST['Password']);

$select = $conn->prepare("SELECT Passhash FROM Users WHERE Email = :Email;");
$select->execute(array(':Email' => $email));
$row = $select->fetch(PDO::FETCH_ASSOC);
$hash = $row['Passhash'];
$result = password_verify($pass, $hash);

if(!$row){
    echo "
    <meta charset='UTF-8'>
    帳號或密碼錯誤
    即將在3秒內回到首頁, 您也可以點選<a href='http://db4-ouvek-kostiva.c9users.io'>http:db4-ouvek-kostiva.c9users.io</a>
    <script language=javascript>
        window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io'; },3000);
    </script>";
}else{
    if ($result) {
        try{
            echo "<meta charset='UTF-8'>登入中, 請稍候...";
            $cookie = bin2hex(openssl_random_pseudo_bytes(20));
            setcookie("dbproject", $cookie, time()+2592000, "/", "db4-ouvek-kostiva.c9users.io");
            $conn = "";
            $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname,$dbuser,$dbpass);
            $update = $conn->prepare("UPDATE Users SET userCookie = :cookie WHERE Email LIKE :Email;");
            $resp = $update->execute(array(':cookie'=> $cookie, ':Email' => $email));
            echo "
                登入成功!</br>
                請至 新增銷貨訂單 頁面, 或者你可以點
                <a href='http://db4-ouvek-kostiva.c9users.io/Sales/Sales_Order_Add.php'>http://db4-ouvek-kostiva.c9users.io/Sales/Sales_Order_Add.php</a>
                <script language=javascript>
                window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/Sales/Sales_Order_Add.php'; },3000);
                </script>
                ";
        }catch(PDOException $e){
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }
    }else{
            echo "
        <meta charset='UTF-8'>
        登入失敗, 帳號或密碼錯誤
        即將在3秒內回到首頁, 您也可以點選<a href='http://db4-ouvek-kostiva.c9users.io'>http://db4-ouvek-kostiva.c9users.io</a>
        <script language=javascript>
            window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io'; },3000);
        </script>";
    }
}


























?>