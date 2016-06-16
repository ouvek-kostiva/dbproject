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
    }catch (PDOException $e) {
        throw new PDOException("Error  : " .$e->getMessage());
    }
    $select = $conn->prepare("SELECT User_id FROM Users WHERE userCookie = :ucook ;");
    $select->execute(array(':ucook' => $_COOKIE['dbproject']));
    $row = $select->fetch(PDO::FETCH_ASSOC);
    if($row){
                $userid = $row['User_id'];
                $select = $conn->prepare("UPDATE Users SET userCookie = NULL WHERE User_id = :userid ;");
                $select->execute(array(':userid' => $userid));
    }else{
        header('Location: http://db4-ouvek-kostiva.c9users.io');
    }

    echo "<meta charset='UTF-8'>";
    if (isset($_COOKIE['dbproject'])) {
        unset($_COOKIE['dbproject']);
        setcookie('dbproject', null, 1, '/', 'dbproject-ouvek-kostiva.c9users.io');
        echo "
            回到首頁, 您也可以點選 <a href='http://db4-ouvek-kostiva.c9users.io'>http:db4-ouvek-kostiva.c9users.io</a>
            <script language=javascript>
                window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io'; },2000);
            </script>
        ";
    }else{
        echo "
            回到首頁, 您也可以點選 <a href='http://db4-ouvek-kostiva.c9users.io'>http:db4-ouvek-kostiva.c9users.io</a>
            <script language=javascript>
                window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io'; },2000);
            </script>
        ";
    }

    echo "
            回到首頁, 您也可以點選 <a href='http://db4-ouvek-kostiva.c9users.io'>http:db4-ouvek-kostiva.c9users.io</a>
            <script language=javascript>
                window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io'; },2000);
            </script>
        ";

