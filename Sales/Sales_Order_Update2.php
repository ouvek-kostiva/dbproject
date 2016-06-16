<?php
    require "../head.php";


    $id=$_POST['Productid'];
    $SOid=$_POST['SalesOrderid'];
    $Qty=$_POST['Qty'];
    $UPrice=$_POST['UnitPrice'];
    $Dt=$_POST['Discount'];
    $Tax=$_POST['Tax'];
    $Re=$_POST['Remarks'];

 $dbhost = '127.0.0.1';
 $dbuser = 'theleaves';
 $dbpass = '3ajilojl';
 $dbname = 'c9';
 $dsn = "mysql:host=$dbhost;dbname=$dbname;charset=utf8";

  $db = new PDO($dsn, $dbuser, $dbpass);

   $result0=$db->query("SELECT * FROM SalesOrder_List" );

  for($i=0;$i < $result0;$i++){
     $result1=$db->query("SELECT * FROM SalesOrder_List WHERE SO_List_SalesOrder_id ='$SOid[i]'");

     $result1->execute();
     $result1->fetchAll();
       foreach ($result1 as $row) {
     $id=$row['SO_Product_id'];
     $Qty=$row['SO_List_Quantity'];
     $UPrice=$row['SO_List_UnitPrice'];
     $Dt=$row['SO_List_Discount'];
     $Tax=$row['SO_List_Tax'];
     $Re=$row['SO_List_Remarks'];
     $SOid=$row['SOList_id'];
  }
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
    <link rel="icon" href="favicon.ico">

    <title>銷貨訂單-新增</title>
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
            <li class="active"><a href="./Sales_Order_Add.php"><span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> 銷貨</a></li>
           <li><a href="../Purchase/Purchase_Order_Add.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 進貨</a></li>
            <li><a href="../Inventory/Receive_Add.php"><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 庫存</a></li>
            <li><a href="../Items/Item_Add.php"><span class="glyphicon glyphicon-indent-left" aria-hidden="true"></span> 品項</a></li>
             <li><a href="../Partners/Customer_Add.php"><span class="glyphicon glyphicon-briefcase" aria-hidden="true"></span> 商業夥伴</a></li>
          </ul>
          <ul class="nav navbar-nav pull-right">
            <li class="navbar-left"><a href="../User.php"><span class="glyphicon glyphicon-cog" aria-hidden="true"></span> 個人設定</a></li>
            <p class="navbar-text"><span class="glyphicon glyphicon-user" aria-hidden="true"></span>  <?php echo $username ?></p>
            <li><a href="../signout.php">登出</a></li>
          </ul>
        </div><!--/.nav-collapse -->
        <div id="navbar" class=""></div>
      </div>
    </nav>
    <nav class="navbar">
      <ul class="nav nav-tabs">
        <li role="presentation"><a href="./Sales_Quotation_Add.php">詢價</a></li>
        <li role="presentation" class="active"><a>訂單</a></li>
        <li role="presentation"><a href="./Delivery_Add.php">出貨</a></li>
        <li role="presentation"><a href="./Invoice_Add.php">發票</a></li>
        <li role="presentation"><a href="./Collections_Add.php">收款</a></li>
        <li role="presentation"><a href="./Return_Add.php">退貨</a></li>
        <div class="col-lg-3">
          <a href="./Sales_Order_Search.php" class="btn btn-primary btn-sm">
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


<form class="form-horizontal" role="form" method="post" action="./Sales_Order_Update3.php">
    <div class="container">

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">訂單編號</span>
            <input type="text" class="form-control" name="SOid">
          </div><!-- /input-group -->
               </div>
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶編號</span>
            <input type="text" class="form-control" name="Cid">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->

        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">使用者編號</span>
            <input type="text" class="form-control" name="Uid">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="btn-group">
            <select class="btn btn-default dropdown-toggle" name="DeliveryMethod"> 選擇送貨方式
             <option value='1'>貨到後付款</option>
            <option value='2'>客戶自行提貨</option>
            <option value='3'>先付款後取貨</option>
            <option value='4'>現場購買 / 一次性客戶</option>
            </select>
          </ul>
          </div>
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->


      <div class="input-group input-group-sm"></div>
  <div class="input-group input-group-sm"></div>
           <?php
 $dbhost = '127.0.0.1';
 $dbuser = 'theleaves';
 $dbpass = '3ajilojl';
 $dbname = 'c9';
 $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die('Error with MySQL connection');

  mysql_query("SET NAMES 'utf8'");
  mysql_select_db($dbname);
  $sql = "select * from SalesOrder_List";
    $result = mysql_query($sql) or die('MySQL query error');

    echo '<table class="table">';
    echo '<thead>';
    echo '          <tr>
              <th>產品編號</th>
            <th>數量</th>
            <th>價格</th>
            <th>折扣</th>
            <th>稅率</th>
            <th>備註</th>
          </tr>';
  while($row = mysql_fetch_array($result))
  {

 echo "<tr><td><input type='text' class='form-control'  name='Productid[]'  value=".$row['SO_Product_id']."></td>";
  echo "<td><input type='text' class='form-control'  name='Qty[]' value=".$row['SO_List_Quantity']."></td>";
  echo "<td><input type='text' class='form-control'  name='UnitPrice[]'  value=".$row['SO_List_UnitPrice']."></td>";
  echo "<td><input type='text' class='form-control'  name='Discount[]' value=".$row['SO_List_Discount']."></td>";
  echo "<td><input type='text' class='form-control'  name='Tax[]' value=".$row['SO_List_Tax']."></td>";
  echo "<td><input type='text' class='form-control'  name='Remarks[]' value=".$row['SO_List_Remarks']."></td>";



  }
  ?>
          </tr>

<!-- Haven't changed below for javascript end  -->

        </tbody>
      </table>


        </button>
      </div><!-- /.col-lg-6 -->
      <div class="col-lg-2">
        <button type="submit" class="btn btn-default">
          <span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
          修改完成
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
