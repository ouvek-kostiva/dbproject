<?php
    function customError($errno, $errstr) {
        if($errno == 2){
            echo "<div class='alert alert-danger' role='alert'> 資料庫不存在 <a href='./init/index.php'>請按此建立資料表</a> </div>";
    
        }        
    }
    
    set_error_handler("customError");

    $dbhost = '127.0.0.1';
    $dbuser = 'Signupuser';
    $dbpass = '';
    $dbname = 'c9';
        $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname,$dbuser,$dbpass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'SET NAMES UTF8');
        
        $select = $conn->prepare("SELECT Username FROM Users WHERE userCookie = :ucook ;");
        $select->execute(array(':ucook' => $_COOKIE['dbproject']));
        $row = $select->fetch(PDO::FETCH_ASSOC);
        $username = "";
        if($row){
            $username = $row['Username'];
            header('Location: http://db4-ouvek-kostiva.c9users.io/Sales/Sales_Order_Add.php');
        }
?>

<!DOCTYPE html>
<!-- saved from url=(0038)https://kkbruce.tw/bs3/Examples/signin -->
<html lang="en">

<head>
    <title>使用者登入</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">
    <link href="./css/bootstrap.css" rel="stylesheet">
    <link href="./css/ie10-viewport-bug-workaround.css" rel="stylesheet">
    <link href="./css/starter-template.css" rel="stylesheet">
</head>

<body background="./pic2.jpg">

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
                    <li class="active"><a class="btn btn-secondary btn-sm" disabled><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 使用者登入</a></li>
                    <!--<li><a href="./map.php"><span class="glyphicon glyphicon-move" aria-hidden="true"></span> 使用者地圖導覽</a></li>
                    <li><a href="./Introduction.php"><span class="glyphicon glyphicon-home" aria-hidden="true"></span> 系統介紹</a></li>-->
                    <li><a href="./registered.php"><span class="glyphicon glyphicon-registration-mark" aria-hidden="true"></span> 註冊帳號</a></li>
                </ul>
                <ul class="nav navbar-nav pull-right">

                    <p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php if($username != ""){echo $username;}else{echo "Username";} ?></p>
                </ul>
            </div>
            <!--/.nav-collapse -->
            <div id="navbar" class=""></div>
        </div>
    </nav>

    <!--上選列-->
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <div class="container">

        <form action="login.php" method="POST" class="form-signin" role="form">
            <table align=center style="background-color=#FAFAFA">
                <tbody>
                    <tr>
                        <td>
                            <span style="color:orange;">
                            <h2 class="form-signin-heading">會員登入</h2>
                        </span>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <label for="inputEmail" class="sr-only">請輸入E-mail</label>
                            <input type="email" id="inputEmail" class="form-control" placeholder="Email address" size="60%" required="" autofocus="" name="Email"> <!-- name="Email" 代表php 的 $_POST['Email']取值 -->
                            <br/>
                            <label for="inputPassword" class="sr-only">Password</label>
                            <input type="password" id="inputPassword" class="form-control" placeholder="Password" size="60%" required="" autofocus="" name="Password">
                            </br>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <input class="btn btn-success" type="submit" value="送出">
                            <input class="btn btn-danger" type="reset" value="清除">
                        </td>
                    </tr>

                </tbody>
            </table>
        </form>
    </div>

    <script src="./js/ie10-viewport-bug-workaround.js"></script>
</body>

</html>
<!--pixiv 註記id=51696492 作者:Hattori184著-->