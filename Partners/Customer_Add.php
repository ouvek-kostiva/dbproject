<?php
    $dbhost = '127.0.0.1';
    $dbuser = 'Signupuser';
    $dbpass = '';
    $dbname = 'c9';
    try{
        $conn = new PDO("mysql:host=".$dbhost.";dbname=".$dbname.";charset=utf8;",$dbuser,$dbpass);

        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
        $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        $conn->setAttribute(PDO::MYSQL_ATTR_INIT_COMMAND,'set names utf8');
    }catch (PDOException $e) {
        throw new PDOException("Error  : " .$e->getMessage());
    }
    $select = $conn->prepare("SELECT Username FROM Users WHERE userCookie = :ucook ;");
    $select->execute(array(':ucook' => $_COOKIE['dbproject']));
    $row = $select->fetch(PDO::FETCH_ASSOC);
    if($row){
                $username = $row['Username'];
    }else{
        header('Location: http://db4-ouvek-kostiva.c9users.io/ver0.1');
    }
?>
<?php

if(isset($_GET['view'])){
  $select = $conn->prepare("SELECT * FROM Customer WHERE Customercode = :Customercode");
  $select->execute(array(':Customercode' => $_GET['view']));
  $row = $select->fetch();

  $VendorUser_id = $row->VendorUser_id;
  $select = $conn->prepare("SELECT Username FROM Users WHERE User_id = :CustomerUser_id");
  $select->execute(array(':CustomerUser_id' => $row->CustomerUser_id));
  $usr = $select->fetch();
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

    <title>客戶-新增</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/starter-template.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
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
          <li><a href="../Purchase/Purchase_Order_Add.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 進貨</a></li>
          <li><a href="../Inventory/Receive_Add.php"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 庫存</a></li>
          <li><a href="../Items/Item_Add.php"><span class="glyphicon glyphicon-indent-left" aria-hidden="true"></span> 品項</a></li>
            <li class="active"><a href="./Customer_Add.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> 商業夥伴</a></li>
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
        <li role="presentation" class="active"><a >客戶</a></li>
        <li role="presentation"><a href="./Vendor_Add.php">供應商</a></li>
        <div class="col-lg-3">
          <a href="./Customer_Search.php" class="btn btn-primary btn-sm">
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
<form class="form-horizontal" role="form" method="post" action="./Customer.php">
      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶編號*</span>
            <input type="text" class="form-control" placeholder="935824428" name="Customercode" value="<?php echo $row->Customercode; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">名稱*</span>
            <input type="text" class="form-control" placeholder="17237938429" name="Customername" value="<?php echo $row->Customername; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">電話1</span>
            <input type="text" class="form-control" placeholder="薰衣草" name="CustomerTel_1" value="<?php echo $row->CustomerTel_1; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">統一編號</span>
            <input type="text" class="form-control" placeholder="Lavandula" name="CustomerID" value="<?php echo $row->CustomerID; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">Email*</span>
            <input type="text" class="form-control" placeholder="574289" name="CustomerEmail" value="<?php echo $row->CustomerEmail; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">公司</span>
            <input type="text" class="form-control" placeholder="KG" name="CustomerCompany" value="<?php echo $row->CustomerCompany; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">電話2</span>
            <input type="text" class="form-control" placeholder="資訊" name="CustomerTel_2" value="<?php echo $row->CustomerTel_2; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">網站</span>
            <input type="text" class="form-control" placeholder="資訊" name="CustomerWebsite" value="<?php echo $row->CustomerWebsite; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <select class=" form-control btn btn-default dropdown-toggle" name="CustomerType" value="<?php echo $row->CustomerType; ?>">
            <option value="Personal">個人</option>
            <option value="Company">公司</option>
          </select>
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <select class=" form-control btn btn-default dropdown-toggle" name="CustomerPayMethod_id" value="<?php echo $row->CustomerPayMethod_id; ?>">
            <option value="Credit">刷卡</option>
            <option value="Transfer">轉帳</option>
            <option value="Cash">現金</option>
          </select>
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">銀行</span>
            <input type="text" class="form-control" placeholder="574289" name="CustomerBank" value="<?php echo $row->CustomerBank; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">戶號</span>
            <input type="text" class="form-control" placeholder="574289" name="CustomerBankNo" value="<?php echo $row->CustomerBankNo; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">Username*</span>
            <input type="text" class="form-control" placeholder="574289" name="Username" value="<?php echo $usr->Username; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">地址</span>
            <input type="text" class="form-control" placeholder="574289" name="CustomerAddress" value="<?php echo $row->CustomerAddress; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-6">
          <div class="input-group">
            <span class="input-group-addon">備註</span>
            <input type="text" class="form-control" placeholder="574289" name="CustomerRemarks" value="<?php echo $row->CustomerRemarks; ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div>

            <h3> </h3>

      <div class="col-lg-8"></div>
      <div class="col-lg-2">
        <button type="submit" class="btn btn-default" name="save">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          儲存客戶資料
        </button>
      </div><!-- /.col-lg-6 -->
      <div class="col-lg-2">
        <button type="submit" class="btn btn-danger" name="delete">
          <span class="glyphicon glyphicon-trash" aria-hidden="true"> </span>
          刪除
        </button>
      </div><!-- /.col-lg-6 -->
</form>
    </div><!-- /.container -->


    <script language="JavaScript">
    function ShowTime(){
　    var NowDate=new Date();
　    var y=NowDate.getFullYear();
　    var mo=NowDate.getMonth();
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
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="../js/count.js"></script>
  </body>
</html>
