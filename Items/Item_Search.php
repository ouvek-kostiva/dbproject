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
    $select = $conn->prepare("SELECT Username FROM Users WHERE userCookie = :ucook ;");
    $select->execute(array(':ucook' => $_COOKIE['dbproject']));
    $row = $select->fetch(PDO::FETCH_ASSOC);
    if($row){
                $username = $row['Username'];
    }else{
        header('Location: http://db4-ouvek-kostiva.c9users.io');
    }


if(isset($_POST['search'])){
    $has_where = false;

    if(!"" == trim($_POST['Productcode'])){
        $Productcode = $_POST['Productcode'];
        $has_where = true;
    }else{$Productcode = NULL;}

    if(!"" == trim($_POST['Product_Barcode'])){
        $Product_Barcode = $_POST['Product_Barcode'];
        $has_where = true;
    }else{$Product_Barcode = NULL;}

    if(!"" == trim($_POST['Productname'])){
        $Productname = $_POST['Productname'];
        $has_where = true;
    }else{$Productname = NULL;}

    if(!"" == trim($_POST['Productname2'])){
        $Productname2 = $_POST['Productname2'];
        $has_where = true;
    }else{$Productname2 = NULL;}

    if(!"" == trim($_POST['Unit'])){
        $Unit = $_POST['Unit'];
        $has_where = true;
    }else{$Unit = NULL;}

    if(!"" == trim($_POST['Product_Remarks'])){
        $Product_Remarks = $_POST['Product_Remarks'];
        $has_where = true;
    }else{$Product_Remarks = NULL;}

    $array = array(
        ':Productcode' => $Productcode,
        ':Product_Barcode' => $Product_Barcode,
        ':Productname' => $Productname,
        ':Productname2' => $Productname2,
        ':Unit' => $Unit,
        ':Product_Remarks' => $Product_Remarks);

    $array = array_filter($array,function ($value) {return null !== $value;});
    $values = array();
    $query = "SELECT * FROM Products";
    if($has_where){
        $query = $query." WHERE ";
        foreach ($array as $name => $value) {
            $query .= ' '.substr($name,1).' = '.$name.' ,';
            $values[''.$name] = $value;
        }
    }
    $select = $conn->prepare($query);
    $select->execute($values);
    $searchRow = $select->rowCount();
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

    <title>物品-查詢</title>
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
        </div><!--/.nav-collapse -->
        <div id="navbar" class=""></div>
      </div>
    </nav>
    <nav class="navbar">
      <ul class="nav nav-tabs">
        <li role="presentation" class="active"><a>物品</a></li>
        <li role="presentation"><a href="./BOM_Add.php">組合</a></li>
        <li role="presentation"><a href="./Production_Add.php">製作</a></li>
        <div class="col-lg-3">
          <a class="btn btn-secondary btn-sm" disabled>
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            查詢
          </a>
          <a href="./Item_Add.php" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            新增
          </a>
        </div>
      </ul>
    </nav>

    <div class="container">
<form method="post">
      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">物品編號</span>
            <input type="text" class="form-control" placeholder="935824428" name="Productcode">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">物品條碼</span>
            <input type="text" class="form-control" placeholder="17237938429" name="Product_Barcode">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">物品名稱</span>
            <input type="text" class="form-control" placeholder="薰衣草" name="Productname">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">物品異名</span>
            <input type="text" class="form-control" placeholder="Lavandula" name="Productname2">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-2">
          <div class="input-group">
            <span class="input-group-addon">單位</span>
            <input type="text" class="form-control" placeholder="KG" name="Unit">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-6">
          <div class="input-group">
            <span class="input-group-addon">備註</span>
            <input type="text" class="form-control" placeholder="資訊" name="Product_Remarks">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-1">
          <button type="submit" class="btn btn-primary btn-sm" name="search">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            搜尋
          </button>
        </div>
      </div><!-- /.row -->

            <h3> </h3>

      <div class="col-lg-5"></div>
      <table class="table">
        <thead>
          <tr>
            <th>列</th>
            <th>物品編號</th>
            <th>條碼</th>
            <th>名稱</th>
            <th>異名</th>
            <th>存量</th>
            <th>單位</th>
            <th>備註</th>
            <th>查看</th>
          </tr>
        </thead>
        <tbody>
          <?php

            for($i = 1; $i <= $searchRow; $i++){
                $row = $select->fetch(PDO::FETCH_ASSOC);
                echo "
                    <tr>
                        <th>$i</th> <th>".$row['Productcode']."</th> <th>".$row['Product_Barcode']."</th> <th>".$row['Productname']."</th> <th>".$row['Productname2']."</th> <th>".$row['Product_Qty']."</th> <th>".$row['Unit']."</th> <th>".$row['Product_Remarks']."</th> <th><a href='./Item_Add.php?view=".$row['Productcode']."'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></th>
                    </tr>
                ";
            }
          ?>
<!-- Haven't changed below for javascript end  -->

        </tbody>
      </table>
</form>
    </div><!-- /.container -->


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
