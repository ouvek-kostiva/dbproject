<?php
$db_host = '127.0.0.1';
$db_user = 'wei0604';
$db_password = '';
$db_name = 'c9';
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

$Issue_id=$_POST['Issue_id'];

try {
    $db = new PDO($dsn, $db_user, $db_password);
    $search1 = $db->query("SELECT * FROM Issue WHERE Issue_id='$Issue_id'");
    $search2 = $db->query("SELECT * FROM Issue_List WHERE Issue_List_Issue_id='$Issue_id'");
} catch (PDOException $e) {
    echo $e->getMessage();
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

    <title>出庫-修改</title>
    <!-- Bootstrap core CSS -->
    <link href="../css/bootstrap.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="../css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="../css/starter-template.css" rel="stylesheet">

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
            <li><a href="../Sales/Sales_Order_Add.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 銷貨</a></li>
            <li><a href="../Purchase/Purchase_Order_Add.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 進貨</a></li>
            <li class="active"><a href=./Receive_Add.php><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 庫存</a></li>
            <li><a href="../Items/Item_Add.php"><span class="glyphicon glyphicon-indent-left" aria-hidden="true"></span> 品項</a></li>
            <li><a href="../Partners/Customer_Add.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> 商業夥伴</a></li>
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
        <li role="presentation"><a href="./Receive_Add.php">入庫</a></li>
        <li role="presentation" class="active"><a>出庫</a></li>
        <div class="col-lg-3">
          <a href="./Issue_Search.php" class="btn btn-primary btn-sm">
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
  <form method="POST" action="Issue_Updata2.php">
    <div class="container">
      <?php foreach ($search1 as $row) { ?>
      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">出庫編號</span>
            <input type="text" class="form-control" placeholder="Receive ID" name="Issuecode" value="<?php echo $row['Issuecode'] ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">出庫日期</span>
            <input type="text" class="form-control" placeholder="2016/01/01" name="Issue_Date" value="<?php echo $row['Issue_Date'] ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-4">
          <div class="input-group">
            <span class="input-group-addon">備註</span>
            <input type="text" class="form-control" placeholder="資訊" name="Issue_Remarks" value="<?php echo $row['Issue_Remarks'] ?>">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->
      <?php } ?>
      <div class="input-group input-group-sm"></div>

      <table class="table">
        <thead>
          <tr>
            <th>列</th>
            <th>商品編號</th>
            <th>商品名稱</th>
            <th>數量</th>
            <th>單位</th>
            <th>備註</th>
          </tr>
        </thead>
        <tbody>
        <?php
          $n=0;
          foreach ($search2 as $row2) {
            $n++;
        ?>
          <tr>
            <td><?php $n ?></td>
            <td><input type="text" class="form-control" placeholder="00001" name="Product_id[]" value="<?php echo $row2['Issue_List_Product_id'] ?>"></td>
            <td><input type="text" class="form-control" placeholder="胡椒鹽" ></td>
            <td><input type="text" class="form-control" placeholder="2" name="Qty[]" value="<?php echo $row2['Issue_List_Quantity'] ?>"></td>
            <td><input type="text" class="form-control" placeholder="KG"></td>
            <td><input type="text" class="form-control" placeholder="" name="Remarks[]" value="<?php echo $row2['Issue_List_Remarks'] ?>"></td>
          </tr>
        <?php } ?>
        </tbody>
      </table>

      <div class="col-lg-5">
      </div><!-- /.col-lg-6 -->
      <div class="col-lg-5"></div>
      <div class="col-lg-2">
        <button type="submit" class="btn btn-default">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          儲存出庫單
        </button>
      </div><!-- /.col-lg-6 -->

      <h3>.</h3>

    </div><!-- /.container -->

  </form>
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
