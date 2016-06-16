<?php
require "../head.php";
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

  <title>組合-搜尋</title>
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
          <li><a href="../Inventory/Receive_Add.php"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 庫存</a></li>
          <li class="active"><a href="./Item_Add.php"><span class="glyphicon glyphicon-indent-left" aria-hidden="true"></span> 品項</a></li>
          <li><a href="../Partners/Customer_Add.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> 商業夥伴</a></li>
        </ul>
       <ul class="nav navbar-nav pull-right">
            <li class="navbar-left"><a href="../User.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 個人設定</a></li>
            <p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> <?php echo $username ?></p>
            <li><a href="../signout.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 登出</a></li>
          </ul>
      </div>
      <!--/.nav-collapse -->
      <div id="navbar" class=""></div>
    </div>
  </nav>
  <nav class="navbar">
    <ul class="nav nav-tabs">
      <li role="presentation"><a href="./Item_Add.php">物品</a></li>
      <li role="presentation" class="active"> <a>組合</a></li>
      <li role="presentation"><a href="./Production_Add.php">製作</a></li>
      <div class="col-lg-3">
        <a class="btn btn-secondary btn-sm" disabled>
          <span class="glyphicon glyphicon-search" aria-hidden="true"></span> 查詢
        </a>
        <a href="./BOM_Add.php" class="btn btn-primary btn-sm">
          <span class="glyphicon glyphicon-plus" aria-hidden="true"></span> 新增
        </a>
      </div>
    </ul>
  </nav>

  <div class="container">

    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          <span class="input-group-addon">物品編號</span>
          <input type="text" class="form-control" placeholder="Receive ID">
        </div>
        <!-- /input-group -->
      </div>
      <!-- /.col-lg-6 -->
      <div class="col-lg-3">
        <div class="input-group">
          <span class="input-group-addon">物品條碼</span>
          <input type="text" class="form-control" placeholder="2016/01/01">
        </div>
        <!-- /input-group -->
      </div>
      <!-- /.col-lg-6 -->
      <div class="col-lg-3">
        <div class="input-group">
          <span class="input-group-addon">物品名稱</span>
          <input type="text" class="form-control" placeholder="資訊">
        </div>
        <!-- /input-group -->
      </div>
      <!-- /.col-lg-6 -->
      <div class="col-lg-3">
        <div class="input-group">
          <span class="input-group-addon">物品異名</span>
          <input type="text" class="form-control" placeholder="資訊">
        </div>
        <!-- /input-group -->
      </div>
      <!-- /.col-lg-6 -->
    </div>
    <!-- /.row -->

    <div class="row">
      <div class="col-lg-3">
        <div class="input-group">
          <span class="input-group-addon">倉庫編號</span>
          <input type="text" class="form-control" placeholder="資訊">
        </div>
        <!-- /input-group -->
      </div>
      <!-- /.col-lg-6 -->
      <div class="col-lg-3">
        <div class="input-group">
          <span class="input-group-addon">單位</span>
          <input type="text" class="form-control" placeholder="資訊">
        </div>
        <!-- /input-group -->
      </div>
      <!-- /.col-lg-6 -->
      <div class="col-lg-5">
        <div class="input-group">
          <span class="input-group-addon">備註</span>
          <input type="text" class="form-control" placeholder="資訊">
        </div><!-- /input-group -->
      </div><!-- /.col-lg-6 -->
      <div class="col-lg-1">
          <button type="button" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            搜尋
          </button>
        </div>
    </div><!-- /.row -->

    <div class="input-group input-group-sm"></div>
    <table class="table">
      <thead>
        <tr>
          <th class="col-lg-1">列</th>
          <th class="col-lg-1">物品編號</th>
          <th class="col-lg-1">物品條碼</th>
          <th class="col-lg-2">物品名稱</th>
          <th class="col-lg-2">物品異名</th>
          <th class="col-lg-1">倉庫編號</th>
          <th class="col-lg-1">單位</th>
          <th class="col-lg-2">備註</th>
          <th class="col-lg-1">查看</th>
        </tr>
      </thead>
      <tbody>
        <tr>
            <!-- 第1列 -->
          </tr>
          <tr>
            <!-- 第2列 -->
          </tr>
          <tr>
            <!-- 第3列 -->
          </tr>
          <tr>
            <!-- 第5列 -->
          </tr>
          <tr>
            <!-- 第6列 -->
          </tr>
          <tr>
            <!-- 第7列 -->
          </tr>

        <!-- Haven't changed below for javascript end  -->

      </tbody>
    </table>

    <div class="col-lg-5">
    </div>
    <!-- /.col-lg-6 -->
    <div class="col-lg-5"></div>

  </div>
  <!-- /.container -->


  <!-- Bootstrap core JavaScript
    ================================================== -->
  <!-- Placed at the end of the document so the pages load faster -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <script>
    window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')
  </script>
  <script src="../js/bootstrap.min.js"></script>
  <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
  <script src="../js/ie10-viewport-bug-workaround.js"></script>

  <script type="text/javascript" src="../js/count.js"></script>
</body>

</html>
