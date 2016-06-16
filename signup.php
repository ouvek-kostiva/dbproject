<?php

require './db.php';

$Username = trim($_POST['username']);
$Email = trim($_POST['userEmail']);
$pass_1 = trim($_POST['Password']);
$pass_2 = trim($_POST['againPassword']);
$Permission = "General";

$select = $conn->prepare("SELECT COUNT(Username) FROM Users WHERE Username = :Username; "); //確認是否有重複帳號
$select->execute(array(':Username' => $Username));
$result = $select->fetchColumn();
$select = $conn->prepare("SELECT COUNT(Email) FROM Users WHERE Email = :Email; "); //確認是否有重複Email
$select->execute(array(':Email' => $Email));
$result = $result + $select->fetchColumn();
if($result > 0){
    echo "
        <meta charset='UTF-8'>
        <script language=javascript>
            alert('帳號或密碼已註冊');
            window.setTimeout(function(){ window.location = 'https://db4-ouvek-kostiva.c9users.io/registered.php'; },3000);
        </script>
        即將回到註冊頁面...
    ";

}else{
    if($pass_1 == $pass_2 ){ //兩次輸入的密碼相同
        echo "<head>
        <title>使用者登入</title>
        <meta charset='UTF-8'>
        </head>";
        echo "註冊成功!<br>";
        $Salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM); //產生隨機數字
        $options = [
            'cost' => 8,
            'salt' => $Salt,
        ];
        $Passhash = password_hash($pass_1, PASSWORD_BCRYPT, $options); //密碼+隨機數字 進行 雜湊函數 運算

        $select = $conn->prepare("INSERT INTO Users (User_id, Username, Email, Passhash, Salt, Permission) VALUES (:User_id, :Username, :Email, :Passhash, :Salt, :Permission)"); //INSERT 資料進入資料庫
        $select->execute(array(
            ':User_id' => NULL,
            ':Username' => $Username,
            ':Email' => $Email,
            ':Passhash' => $Passhash,
            ':Salt' => $Salt,
            ':Permission' => $Permission
            ));
        echo "
            即將在3秒內回到首頁, 您也可以點選<a href='http:db4-ouvek-kostiva.c9users.io'>http:db4-ouvek-kostiva.c9users.io</a>
            <script language=javascript>
            window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io'; },3000);
            </script>
        ";
    }else{
        echo "您所輸入的密碼不同";
    }

}

?>