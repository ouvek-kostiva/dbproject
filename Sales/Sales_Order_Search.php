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
    //----------------匯入有輸入的欄位----------------
    $has_customer = false;
    $all_null = true;

    if(isset($_POST['Customercode']) && !(trim($_POST['Customercode']) == '')){
        $Customercode = $_POST['Customercode'];
        $has_customer = true;
        $all_null = false;
    }

    if(isset($_POST['Customername']) && !(trim($_POST['Customername']) == '')){
        $Customername = $_POST['Customername'];
        $has_customer = true;
        $all_null = false;
    }

    if(isset($_POST['CustomerEmail']) && !(trim($_POST['CustomerEmail']) == '')){
        $CustomerEmail = $_POST['CustomerEmail'];
        $has_customer = true;
        $all_null = false;
    }

    if(isset($_POST['SO_Code']) && !(trim($_POST['SO_Code']) == '')){
        $SO_Code = $_POST['SO_Code'];
        $all_null = false;
    }

    if(isset($_POST['SO_Date']) && !(trim($_POST['SO_Date']) == '')){
        $SO_Date = $_POST['SO_Date'];
        $all_null = false;
    }

    if(isset($_POST['SO_ReqDate']) && !(trim($_POST['SO_ReqDate']) == '')){
        $SO_ValiDate = $_POST['SO_ReqDate'];
        $all_null = false;
    }

    if(isset($_POST['SO_Address']) && !(trim($_POST['SO_Address']) == '')){
        $SO_Address = $_POST['SO_Address'];
        $all_null = false;
    }

    //----------------匯入有輸入的欄位 結束----------------
    if($has_customer){
        //----------------尋找SO_Customer_id----------------

        $array = array(
          ':Customercode' => $Customercode,
          ':Customername' => $Customername,
          ':CustomerEmail' => $CustomerEmail,
          );

        $array = array_filter($array,function ($value) {return null !== $value;});
        $query = 'SELECT * FROM Customer WHERE';
        $values = array();

        foreach ($array as $name => $value) {
        $query .= ' '.substr($name,1).' = '.$name.' AND'; // the :$name part is the placeholder, e.g. :zip
        $values[''.$name] = $value; // save the placeholder
        }
        $query = substr($query, 0, -3).';';

        $vensel = $conn->prepare($query);
        $vensel->execute($values);

        if($vensel->rowCount() > 1){
            echo "</br></br><div class='alert alert-danger' role='alert'> 找到超過一個客戶 </div>";
        }else{
            $Venrs = $vensel->fetch();
            $SO_Customer_id = $Venrs->Customer_id;
        }
        //----------------尋找SO_Customer_id 結束----------------
    }else {
        $SO_Customer_id = NULL;
    }
    //----------------尋找訂單----------------

    $array = array(
      ':SO_Customer_id' => $SO_Customer_id,
      ':SO_Code' => $SO_Code,
      ':SO_Date' => $SO_Date,
      ':SO_ReqDate' => $SO_ReqDate,
      ':SO_Address' => $SO_Address);

    $array = array_filter($array,function ($value) {return null !== $value;});
    $query = 'SELECT * FROM SalesOrder';

    if($all_null == false){
        $where = " WHERE";
        $values = array();
        foreach ($array as $name => $value) {
          $where .= ' '.substr($name,1).' = '.$name.' AND'; // the :$name part is the placeholder, e.g. :zip
          $values[''.$name] = $value; // save the placeholder
        }
        $query = $query.$where;
        $query = substr($query, 0, -3).';';
    }

    $select = $conn->prepare($query);
    if($all_null == false){
        $select->execute($values);
    }else {
        $select->execute();
    }
    $rowcount = $select->rowCount();
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

    <title>進貨訂單-搜尋</title>
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
            <li class="active"><a href="../Purchase/Purchase_Order_Add.php"><span class="glyphicon glyphicon-log-in" aria-hidden="true"></span> 進貨</a></li>
            <li><a href=../Inventory/Receive_Add.php><span class="glyphicon glyphicon-th-large" aria-hidden="true"></span> 庫存</a></li>
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
      <ul class="nav nav-tabs"></br></br>
        <li role="presentation"><a href="./Sales_Quotation_Add.php">報價</a></li>
        <li role="presentation" class="active"><a>訂單</a></li>
        <li role="presentation"><a href="./Delivery_Add.php">出貨</a></li>
        <li role="presentation"><a href="./Invoice_Add.php">發票</a></li>
        <li role="presentation"><a href="./Collections_Add.php">付款</a></li>
        <li role="presentation"><a href="./Return_Add.php">退貨</a></li>
        <div class="col-lg-3">
          <a class="btn btn-secondary btn-sm" disabled>
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            查詢
          </a>
          <a href="./Sales_Order_Add.php" class="btn btn-primary btn-sm">
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
            <span class="input-group-addon">客戶編號</span>
            <input type="text" class="form-control" placeholder="Cust ID" name="Customercode">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶名稱</span>
            <input type="text" class="form-control" placeholder="張三" name="Customername">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶Email</span>
            <input type="text" class="form-control" placeholder="023456789" name="CustomerEmail">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-1">
          <button type="submit" class="btn btn-primary btn-sm" name="search">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            搜尋
          </button>
        </div>
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">訂單編號</span>
            <input type="text" class="form-control" placeholder="Order ID" name="SO_Code">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">下訂日期</span>
            <input type="text" class="form-control" placeholder="2016-06-04 20:25:48" name="SO_Date">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">送貨截止日</span>
            <input type="text" class="form-control" placeholder="2016-06-04 20:25:48" name="SO_ReqDate">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">送貨地址</span>
            <input type="text" class="form-control" placeholder="10048 臺北市中正區重慶南路1段122號" name="SO_Address">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->
</form>
      <div class="input-group input-group-sm"></div>
      <table class="table">
        <thead>
          <tr>
            <th>列</th>
            <th>客戶編號</th>
            <th>名稱</th>
            <th>訂單編號</th>
            <th>下訂日期</th>
            <th>送貨截止日</th>
            <th>送貨地址</th>
            <th>查詢</th>
          </tr>
        </thead>
        <tbody>
<?php
if(isset($_POST['search'])){

    for($i = 1; $i <= $rowcount; $i++){
        $row = $select->fetch(PDO::FETCH_OBJ);
        $findcustomer = $conn->prepare("SELECT Customername,Customercode FROM Customer WHERE Customer_id = :Customer_id");
        $findcustomer->execute(array(':Customer_id' => $row->SO_Customer_id));
        $customerrs = $findcustomer->fetch();

        echo "
            <tr><th>".$i."</th> <th>".$customerrs->Customercode."</th> <th>".$customerrs->Customername."</th> <th>".$row->SO_Code."</th> <th>".$row->SO_Date."</th> <th>".$row->SO_ReqDate."</th> <th>".$row->SO_Address."</th> <th><a href='./Sales_Order_Add.php?view=".$row->SO_Code."'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></th></tr>
        ";
    }
}
?>

<!-- Haven't changed below for javascript end  -->

        </tbody>
      </table>

      <div class="col-lg-5"></div>

      <h3>.</h3>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/customer/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="../js/count.js"></script>
  </body>
</html>