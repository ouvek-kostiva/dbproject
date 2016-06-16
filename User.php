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
    $select = $conn->prepare("SELECT Username,Realname,Email,Sex,Telephone,Remarks FROM Users WHERE userCookie = :ucook ;");
    $select->execute(array(':ucook' => $_COOKIE['dbproject']));
    $row = $select->fetch(PDO::FETCH_ASSOC);
    if($row){
                $username = $row['Username'];
                $realname = $row['Realname'];
                $email = $row['Email'];
                $sex = $row['Sex'];
                $telephone = $row['Telephone'];
                $remarks = $row['Remarks'];

    }else{
        header('Location: http://db4-ouvek-kostiva.c9users.io');
    }

?>

<!DOCTYPE html >
<!---->
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="./favicon.ico">

    <title>個人設定</title>
    <!-- Bootstrap core CSS -->
    <link href="./css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="./css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="./css/starter-template.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]-->
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <!--[endif]-->
  </head>

  <body onload="ShowTime()">

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
          <li><a href="./Sales/Sales_Order_Add.php" ><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 銷貨</a></li>
          <li><a href="./Purchase/Purchase_Order_Add.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 進貨</a></li>
          <li><a href="./Inventory/Receive_Add.php"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 庫存</a></li>
          <li><a href="./Items/Item_Add.php"><span class="glyphicon glyphicon-indent-left" aria-hidden="true"></span> 品項</a></li>
            <li><a href="./Partners/Customer_Add.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> 商業夥伴</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <li class="navbar-left active" ><a class="btn btn-secondary btn-sm" disabled><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 個人設定</a></li>
            <p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $username ?></p>
            <li><a href="./signout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 登出</a></li>
          </ul>
        </div><!--/.nav-collapse -->
        <div id="navbar" class=""></div>
      </div>
    </nav>



&nbsp;&nbsp;&nbsp;&nbsp;
<h2>
<span style="font-family:DFKai-sb;">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <span class="glyphicon glyphicon-home" aria-hidden="true"></span> 個人資料檢視
</span>



<ul class="nav navbar-nav pull-right">
<div id="showbox"></div>
</ul>

<ul class="nav navbar-nav pull-right">
<span class="glyphicon glyphicon-time" aria-hidden="true"></span> &nbsp;
</ul>
</h2>




    <hr class="hr1" align="center" width="75%" noshade="noshade" />

    <div class="container">

      <div class="row">
        <div class="col-lg-3">
          <div class="thumbnail">
            <div class="caption">
              <img class='demoimg' src="./getImage.php?cook=<?php echo $username?>" width="235" height="250">
            </div>
          </div>
        </div>

        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">使用者名稱</span>
            <input type="text" class="form-control" placeholder="未設定" value="<?php echo $username ?>" disabled>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">真實名稱</span>
            <input type="text" class="form-control" placeholder="未設定" value="<?php echo $realname ?>" disabled>
          </div>
        </div>
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">E-mail帳號</span>
            <input type="text" class="form-control" placeholder="未設定" value="<?php echo $email ?>" disabled>
          </div>
        </div>

        <div class="col-lg-3">
          <br/><br/>
          <div class="input-group">
            <span class="input-group-addon">真實性別</span>
            <input type="text" class="form-control" placeholder="未設定" value="<?php echo $sex?>" disabled>
          </div>
        </div>

        <div class="col-lg-3">
          <br/><br/>
          <div class="input-group">
            <span class="input-group-addon">聯絡電話</span>
            <input type="text" class="form-control" placeholder="未設定" value="<?php echo $telephone ?>" disabled>
          </div>
        </div>

        <div class="col-lg-3">
          <br/><br/>
          <div class="input-group">
            <span class="input-group-addon">個人帳戶</span>
            <input type="text" class="form-control" placeholder="未設定" disabled>
          </div>
        </div>

        <div class="col-lg-3">
          <br/><br/>
          <div class="input-group">
            <span class="input-group-addon">公司名稱</span>
            <input type="text" class="form-control" placeholder="未設定" disabled>
          </div>
        </div>

        <div class="col-lg-3">
          <br/><br/>
          <div class="input-group">
            <span class="input-group-addon">公司電話</span>
            <input type="text" class="form-control" placeholder="未設定" disabled>
          </div>
        </div>

        <div class="col-lg-3">
          <br/><br/>
          <div class="input-group">
            <span class="input-group-addon">公司帳戶</span>
            <input type="text" class="form-control" placeholder="未設定" disabled>
          </div>
        </div>

        <div class="col-lg-9">
          <br/><br/>
          <div class="input-group">
            <span class="input-group-addon">公司地址</span>
            <input type="text" class="form-control" placeholder="未設定" disabled>
          </div>
        </div>


      </div>

      <div class="row">
        <div class="col-lg-6">
            <span class="input-group-addon">個人簡介</span>
            <textarea class="form-control" rows="9" disabled>
<?php echo $remarks ?>
            </textarea>
        </div>
        <div class="col-lg-6">
            <span class="input-group-addon">公司介紹</span>
            <textarea class="form-control" rows="9" disabled>
<?php echo 未設定 ?>
            </textarea>
        </div>
      </div>


</div>

      <div class="row" align=center>
        <br/>
        <a href="./transform.php">
          <button type="button" class="btn btn-primary">
            <span class="glyphicon glyphicon-pencil" aria-hidden="true">
              更改個人資料
            </span>
          </button>
        </a>
      </div>



<!--第二時間顯示
<nav class="navbar navbar-default navbar-fixed-bottom" role="navigation">
<span style="font-family:fantasy;">
      <div class="row">
        <div class="col-lg-2">
&nbsp;&nbsp;&nbsp;&nbsp;
      <span class="glyphicon glyphicon-time" aria-hidden="true"></span>

      <script language="javascript">
　      var Today=new Date();
　      document.write("現在時間:  " + Today.getFullYear()+ "年" + (Today.getMonth()+1) + "月" + Today.getDate() + "日 星期 " + Today.getDay() );
      </script>


      </div>
      <div class="col-lg-1">
        <div id="showbox"></div>
      </div>
      </div>
</span>

</nav>
-->

    <!--全標準時間
    <script language="JavaScript">
      function ShowTime(){
　      document.getElementById('showbox').innerHTML = new Date();
　      setTimeout('ShowTime()',1000);}
    </script>
    -->
  <script language="JavaScript">
    function ShowTime(){
　    var NowDate=new Date();
　    var y=NowDate.getFullYear();
　    var mo=NowDate.getMonth()+1;
　    var d=NowDate.getDate();
　    var da=NowDate.getDay();
　    var h=NowDate.getHours();
　    var m=NowDate.getMinutes();
　    var s=NowDate.getSeconds();
　    document.getElementById('showbox').innerHTML = y+'年'+mo+'月'+d+'日'+ ' '+h+'時'+m+'分'+s+'秒';
　    setTimeout('ShowTime()',1000);  }
  </script>


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="./js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="./js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="./js/count.js"></script>
  </body>
</html>