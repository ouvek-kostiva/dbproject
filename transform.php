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
    $select = $conn->prepare("SELECT Username,Realname,Email,Sex,Telephone,Remarks,Salt,UserPhoto FROM Users WHERE userCookie = :ucook ;");
    $select->execute(array(':ucook' => $_COOKIE['dbproject']));
    $row = $select->fetch(PDO::FETCH_ASSOC);
    if($row){
                $username = $row['Username'];
                $realname = $row['Realname'];
                $email = $row['Email'];
                $sex = $row['Sex'];
                $telephone = $row['Telephone'];
                $remarks = $row['Remarks'];
                $salt = $row['Salt'];
                $userphoto = $row['UserPhoto'];

    }else{
        header('Location: http://db4.ouvek.com/ver0.1');
    }

    $tol=0;


    if($email != NULL){
      $tol++;}
    if($username != NULL){
      $tol++;}
    if($realname != NULL){
      $tol++;}
    if($sex != NULL){
      $tol++;}
    if($telephone != NULL){
      $tol++;}
    if($remarks != NULL){
      $tol++;}
    if($salt != NULL){
      $tol++;}
    if($userphoto != NULL){
      $tol++;}


    $pre=100/14*$tol;


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
          <li><a href="./Sales/Sales_Order_Add.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 銷貨</a></li>
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

    <div class="alert alert-warning alert-dismissible" role="alert">
  <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
  <strong>注意!</strong> 切勿給予他人帳號資訊以免個人資料外洩。
</div>



<form action="Usering.php" method="POST" class="form-signin" role="form"  enctype="multipart/form-data">

<div class="row">

  <br/>
  <div class="col-lg-3"  align=center>
        <!--sm:高範圍 md:寬範圍-->
    <div class="thumbnail">

      <h4>
      <p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $realname." 先生"; ?></p>
      </h4>
        <!--男生 女生判定?-->
      <br/><br/><br/>
      <div class="caption">
        <img class='demoimg' src="./getImage.php?cook=<?php echo $username?>" width="250" height="250">
      </div>

      <div class="form-group">
        <label for="exampleInputFile">大頭貼上傳</label>
        <input type="file" id="exampleInputFile" name="UserPhoto" accept="image/jpeg,image/gif,image/png,image/tif">
        <p class="help-block">請上傳250*250正方照片。</p>
      </div>

    </div>
  </div>
  <div class="col-lg-4">
    <div class="input-group">
      <span class="input-group-addon">E-mail 帳號</span>
      <input type="text" class="form-control" placeholder="<?php echo $email ;?>" disabled>
    </div>
  </div>



  <div class="col-lg-2">
    <div class="input-group">
      <span class="input-group-addon">密碼</span>
      <input type="password" class="form-control" placeholder="密碼" name="newpassword">
    </div>
  </div>

  <div class="col-lg-2">
    <div class="input-group">
      <span class="input-group-addon">聯絡電話</span>
      <input type="text" class="form-control" placeholder="<?php echo $telephone ;?>" name="Telephone" >
    </div>
  </div>

  <br/><br/><br/>

    <div class="col-lg-4">
      <div class="input-group">
        <span class="input-group-addon">公司地址</span>
        <input type="text" class="form-control" placeholder="未設定">
      </div>
    </div>

    <div class="col-lg-2">
      <div class="input-group">
        <span class="input-group-addon">公司名稱</span>
        <input type="text" class="form-control" placeholder="未設定">
      </div>
    </div>

    <div class="col-lg-2">
      <div class="input-group">
        <span class="input-group-addon">公司電話</span>
        <input type="text" class="form-control" placeholder="未設定">
      </div>
    </div>

    <br/><br/><br/>

      <div class="col-lg-2">
        <div class="input-group">
          <span class="input-group-addon">個人銀行帳戶</span>
          <input type="text" class="form-control" placeholder="未設定">
        </div>
      </div>

      <div class="col-lg-2">
        <div class="input-group">
          <span class="input-group-addon">公司銀行帳戶</span>
          <input type="text" class="form-control" placeholder="未設定">
        </div>
      </div>

      <div class="col-lg-2">
        <div class="input-group">
          <span class="input-group-addon">真實姓名</span>
          <input type="text" class="form-control" placeholder="<?php echo $realname ;?>" name="Realname">
        </div>
      </div>

      <div class="col-lg-2">
          <span style="color:black" class="glyphicon glyphicon-heart" aria-hidden="true"></span>
              使用者性別:
              &nbsp; &nbsp;
              <input type="radio" name="Sex" value="男" checked>
              男性
              &nbsp; &nbsp;
              <input type="radio" name="Sex" value="女">
              女性
      </div>

      <!--字數限定-->

        <br/><br/><br/>
        <div class="col-lg-4">
          <span class="input-group-addon">個人簡介</span>
          <textarea class="form-control" rows="11" value="<?php echo $remarks ;?>" name="Remarks"></textarea>
        </div>

        <div class="col-lg-4">
          <span class="input-group-addon">公司介紹</span>
          <textarea class="form-control" rows="11" placeholder="未設定"></textarea>
        </div>

</div>

    <br/>
    <br/>
    <br/>
  <!--
    <div class="container">
      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶編號</span>
            <input type="text" class="form-control" placeholder="935824428">
          </div>
        </div>
      </div>
  -->
      <div class="col-lg-1">
        <span class="glyphicon glyphicon-pencil">
        完成度:
        </span>
      </div>

        <div class="col-lg-3">
          <div class="progress" style="width: 100%">
            <div  class="progress-bar progress-bar-striped active" align="center"
                  role="progressbar"
                  style="width: <?php echo $pre; ?>%">
            <span class="sr-only"></span>
            <!--aria-valuenow="7"
                aria-valuemin="5"
                aria-valuemax="14" -->

            </div>
          </div>
        </div>
        <div class="col-lg-2" style="font-weight:bold;">已完成: <?php echo $tol; ?> /14  ( <?php echo round($pre,0); ?> %) </div>
        <div class="col-lg-2"></div>



<div class="col-lg-1">

        <button type="button" class="btn btn-success" data-toggle="modal" data-target="#exampleModal" data-whatever="@mdo">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          儲存資料
        </button>

  <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="exampleModalLabel">確認訊息:</h4>
        </div>

      <div class="modal-body">
        <form role="form">
          <b>
            確定是否修改個人資料？
          </b>
        </form>
      </div>

      <div class="modal-footer">
        <button type="submit" class="btn btn-primary" name="save">確認修改</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">取消動作</button>
      </div>
      </div>
    </div>
  </div>
</div>


</form>

<form action="User.php" method="POST" class="form-signin" role="form"  enctype="multipart/form-data">
        <div class="col-lg-1">
          <button type="submit" class="btn btn-danger">
            <span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
              取消修改
          </button>
        </div>
</form>


<div class="col-lg-1">

        <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#deleteaccount" data-whatever="@mdo">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
          刪除帳號
        </button>

  <div class="modal fade" id="deleteaccount" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="exampleModalLabel">警告訊息:</h4>
        </div>

      <div class="modal-body">
        <form role="form">
          <font color=red>
          <b>
            確定是否刪除帳號？
          </b>
          </font>
        </form>
      </div>

      <div class="modal-footer">
        <button type="button" class="btn btn-primary">刪除帳號</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">取消動作</button>
      </div>
      </div>
    </div>
  </div>
</div>


<!--舊式java script 彈跳警示視窗
        <div class="col-lg-1">
          <button type="submit" class="btn btn-warning">
            <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
              <a href="javascript:Deleteaccount()">
                <font color="white">
                  刪除帳號
                </font>
              </a>
          </button>
        </div>


    <script>
      function Deleteaccount() {
	    answer = confirm("確定是否刪除帳號？");
	    if (answer)
		  location.href="http://www.kuas.edu.tw";
      }
    </script>
-->


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