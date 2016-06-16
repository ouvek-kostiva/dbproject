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
        header('Location: http://db4-ouvek-kostiva.c9users.io/ver0.1');
    }
?>

<?php
if(isset($_POST['search'])){

  require '../db.php';
  $if_has_input = false;

  $array = "";

  if(isset($_POST['Customercode']) && !(trim($_POST['Customercode']) == '')){$Customercode = $_POST['Customercode'];$if_has_input = true;}
  if(isset($_POST['Customername']) && !(trim($_POST['Customername']) == '')){$Customername = $_POST['Customername'];$if_has_input = true;}
  if(isset($_POST['CustomerTel_1']) && !(trim($_POST['CustomerTel_1']) == '')){$CustomerTel_1 = $_POST['CustomerTel_1'];$if_has_input = true;}
  if(isset($_POST['CustomerID']) && !(trim($_POST['CustomerID']) == '')){$CustomerID = $_POST['CustomerID'];$if_has_input = true;}
  if(isset($_POST['CustomerEmail']) && !(trim($_POST['CustomerEmail']) == '')){$CustomerEmail = $_POST['CustomerEmail'];$if_has_input = true;}

  if(isset($_POST['CustomerCompany']) && !(trim($_POST['CustomerCompany']) == '')){$CustomerCompany = $_POST['CustomerCompany'];$if_has_input = true;}
  if(isset($_POST['CustomerTel_2']) && !(trim($_POST['CustomerTel_2']) == '')){$CustomerTel_2 = $_POST['CustomerTel_2'];$if_has_input = true;}
  if(isset($_POST['CustomerWebsite']) && !(trim($_POST['CustomerWebsite']) == '')){$CustomerWebsite = $_POST['CustomerWebsite'];$if_has_input = true;}
  if(isset($_POST['CustomerType']) && !(trim($_POST['CustomerType']) == '')){$CustomerType = $_POST['CustomerType'];$if_has_input = true;}
  if(isset($_POST['CustomerPayMethod_id']) && !(trim($_POST['CustomerPayMethod_id']) == '')){
    $CustomerPayMethod_id = $_POST['CustomerPayMethod_id'];
        $select = $conn->prepare("SELECT PaymentMethod_id FROM PaymentMethod WHERE PaymentName = :CustomerPayMethod_id ");
        $select->execute(array(':CustomerPayMethod_id' => $CustomerPayMethod_id));//取得Username對應的User_id
        $CustomerPayMethod_id = $select->fetchColumn();
    $if_has_input = true;
  }

  if(isset($_POST['CustomerBank']) && !(trim($_POST['CustomerBank']) == '')){$CustomerBank = $_POST['CustomerBank'];$if_has_input = true;}
  if(isset($_POST['CustomerBankNo']) && !(trim($_POST['CustomerBankNo']) == '')){$CustomerBankNo = $_POST['CustomerBankNo']; $if_has_input = true;}
  if(isset($_POST['CustomerUser_id']) && !(trim($_POST['CustomerUser_id']) == '')){$CustomerUser_id = $_POST['CustomerUser_id'];$if_has_input = true;}
  if(isset($_POST['CustomerAddress']) && !(trim($_POST['CustomerAddress']) == '')){$CustomerAddress = $_POST['CustomerAddress'];$if_has_input = true;}
  if(isset($_POST['CustomerRemarks']) && !(trim($_POST['CustomerRemarks']) == '')){$CustomerRemarks = $_POST['CustomerRemarks'];$if_has_input = true;}

  $array = array(
      ':Customercode' => $Customercode,
      ':Customername' => $Customername,
      ':CustomerTel_1' => $CustomerTel_1,
      ':CustomerID' => $CustomerID,
      ':CustomerEmail' => $CustomerEmail,
      ':CustomerCompany' => $CustomerCompany,
      ':CustomerTel_2' => $CustomerTel_2,
      ':CustomerWebsite' => $CustomerWebsite,
      ':CustomerType' => $CustomerType,
      ':CustomerPayMethod_id' => $CustomerPayMethod_id,
      ':CustomerBank' => $CustomerBank,
      ':CustomerBankNo' => $CustomerBankNo,
      ':CustomerUser_id' => $Username,
      ':CustomerAddress' => $CustomerAddress,
      ':CustomerRemarks' => $CustomerRemarks
      );

  $array = array_filter($array,function ($value) {return null !== $value;});
  $query = 'SELECT * FROM Customer WHERE';
  $values = array();

  foreach ($array as $name => $value) {
    $query .= ' '.substr($name,1).' = '.$name.' AND'; // the :$name part is the placeholder, e.g. :zip
    $values[''.$name] = $value; // save the placeholder
  }

  $query = substr($query, 0, -3).';';
  $select = $conn->prepare($query);
  $select->execute($values);
  $row = $select->fetchAll(PDO::FETCH_OBJ);
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

    <title>客戶-查詢</title>
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
          <a class="btn btn-secondary btn-sm" disabled>
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            查詢
          </a>
          <a href="./Customer_Add.php" class="btn btn-primary btn-sm">
            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
            新增
          </a>
        </div>
      </ul>
    </nav>

    <div class="container">
<form class="form-horizontal" role="form" method="post">
      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">客戶編號</span>
            <input type="text" class="form-control" placeholder="935824428">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">名稱</span>
            <input type="text" class="form-control" placeholder="17237938429">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">電話1</span>
            <input type="text" class="form-control" placeholder="薰衣草">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">統一編號</span>
            <input type="text" class="form-control" placeholder="Lavandula">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">Email</span>
            <input type="text" class="form-control" placeholder="574289">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">手機</span>
            <input type="text" class="form-control" placeholder="KG">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">電話2</span>
            <input type="text" class="form-control" placeholder="資訊">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">網站</span>
            <input type="text" class="form-control" placeholder="資訊">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <select class=" form-control btn btn-default dropdown-toggle" name="CustomerType">
            <option value="Personal">個人</option>
            <option value="Company">公司</option>
          </select>
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <select class=" form-control btn btn-default dropdown-toggle" name="CustomerPayMethod_id">
            <option value="Credit">刷卡</option>
            <option value="Transfer">轉帳</option>
            <option value="Cash">現金</option>
          </select>
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">銀行</span>
            <input type="text" class="form-control" placeholder="574289">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">戶號</span>
            <input type="text" class="form-control" placeholder="574289">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">Username</span>
            <input type="text" class="form-control" placeholder="574289">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">地址</span>
            <input type="text" class="form-control" placeholder="574289">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-5">
          <div class="input-group">
            <span class="input-group-addon">備註</span>
            <input type="text" class="form-control" placeholder="574289">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-1">
          <button type="submit" class="btn btn-primary btn-sm" name="search">
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            搜尋
          </button>
        </div>
      </div>
</form>
      <table class="table">
        <thead>
          <tr>
            <th class="col-lg-1">列</th>
            <th class="col-lg-2">客戶編號</th>
            <th class="col-lg-1">名稱</th>
            <th class="col-lg-2">Username</th>
            <th class="col-lg-2">Email</th>
            <th class="col-lg-1">客戶類別</th>
            <th class="col-lg-2">備註</th>
            <th class="col-lg-1">查看</th>
          </tr>
        </thead>
        <tbody>
          <?php
if(isset($_POST['search'])){

            $i = 1;
            foreach($row as $ro){
                echo "<tr><th>"."$i</th>"."<th>".$ro->Customercode."</th>"."<th>".$ro->Customername."</th>"."<th>".$ro->CustomerUser_id."</th>"."<th>".$ro->CustomerEmail."</th>"."<th>".$ro->CustomerType."</th>"."<th>".$ro->CustomerRemarks."</th>"."<th><a href='./Customer_Add.php?view=".$ro->Customercode."'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></th>";
                $i++;
            }




}
?>

<!-- Haven't changed below for javascript end  -->

        </tbody>
      </table>

            <h3> </h3>

    </div><!-- /.container -->


    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script>window.jQuery || document.write('<script src="../../assets/js/Customer/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="../js/count.js"></script>
  </body>
</html>
