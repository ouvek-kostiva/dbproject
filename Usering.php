<?php
    //連結資料庫
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

    //登入辨識
    $select = $conn->prepare("SELECT * FROM Users WHERE userCookie = :ucook ;");
    $select->execute(array(':ucook' => $_COOKIE['dbproject']));
    $row = $select->fetch(PDO::FETCH_ASSOC);
    if($row){
                $username = $row['Username'];
                $User_id = $row['User_id'];

    }else{
        header('Location: http://db4-ouvek-kostiva.c9users.io');
    }

echo "<meta charset='UTF-8'>";





if(isset($_POST['save']))
{ //如果按儲存的Button
    //傳入form的值,如果不是空的就傳到這裡的變數

    //空白null掉
    if(!"" == trim($_POST['Realname'])){
        $realname = $_POST['Realname'];
    }else{$realname = NULL;}

    if(!"" == trim($_POST['Sex'])){
        $sex = $_POST['Sex'];
    }else{$sex = NULL;}

    if(!"" == trim($_POST['Telephone'])){
        $telephone = $_POST['Telephone'];
    }else{$telephone = NULL;}

    if(!"" == trim($_POST['Remarks'])){
        $remarks = $_POST['Remarks'];
    }else{$remarks = NULL;}


    if(!"" == trim($row['Salt'])){
        $salt = $row['Salt'];
    }else{$salt = NULL;}

    if(!"" == trim($row['Passhash'])){
        $passhash = $row['Passhash'];
    }else{$rpasshash = NULL;}

    if(!"" == trim($_POST['newpassword'])){
        $newpassword = $_POST['newpassword'];
    }else{$newpassword = NULL;}

        //圖片
    if (isset($_FILES['UserPhoto']) && $_FILES['UserPhoto']['size'] > 0){
        $tmpName  = $_FILES['UserPhoto']['tmp_name'];
        $imageName = $_FILES['UserPhoto']['name'];
        $content = file_get_contents($tmpName);
    }



        if($newpassword != NULL){
            $Salt = mcrypt_create_iv(22, MCRYPT_DEV_URANDOM); //產生隨機數字
            $options = [
                'cost' => 8,
                'salt' => $Salt,
            ];
            $Passhash = password_hash($newpassword, PASSWORD_BCRYPT, $options);

            $select = $conn->prepare("UPDATE Users SET Passhash = :Passhash, Salt = :Salt WHERE User_id = :User_id"); //UPDATE 資料進入資料庫
            $select->execute(array(
                ':User_id' => $User_id,
                ':Passhash' => $Passhash,
                ':Salt' => $Salt
            ));
            if($select->rowCount() > 0){
                echo "<div class='alert alert-success' role='alert'> 更改密碼成功 </div>";
            }else{
                echo "<div class='alert alert-danger' role='alert'> 更改密碼出錯 </div>";
            }
        }


        $array = array(
                ':Realname' => $realname,
                ':Sex' => $sex,
                ':Telephone' => $telephone,
                ':Remarks' => $remarks,
                ':UserPhoto' => $content,
                ':UserPhotoName' => $imageName);
        $array = array_filter($array,function ($value) {return null !== $value;});
        $values = array();
        $query = "UPDATE Users SET ";
        foreach ($array as $name => $value) {
            $query .= ' '.substr($name,1).' = '.$name.' ,';
            $values[''.$name] = $value;
        }
        $query = substr($query, 0, -1).'WHERE User_id = :User_id;';
        $values[''.':User_id'] = $User_id;

        $select = $conn->prepare($query);
        $select->execute($values);

         //修改舊資料
            if($select->rowCount() > 0){
                echo "修改成功";
                echo "
                    <script language=javascript>
                    window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/User.php'; },1000);
                    </script>
                    <a href='http://db4-ouvek-kostiva.c9users.io/User.php'>http://db4-ouvek-kostiva.c9users.io/User.php</a>
                ";
            }else{
                echo "未修改資料";
                echo "
                    <script language=javascript>
                    window.setTimeout(function(){ window.location = 'http://db4-ouvek-kostiva.c9users.io/User.php'; },1000);
                    </script>
                    <a href='http://db4-ouvek-kostiva.c9users.io/User.php'>http://db4-ouvek-kostiva.c9users.io/User.php</a>
                ";
            }


    //確定有填入足夠資訊 has_required_value用true false if判定
//////////////以上為按下Save的部分

}
