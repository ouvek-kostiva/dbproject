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
?>
<?php
if(isset($_POST['search'])){

  require '../db.php';
  $if_has_input = false;

  $array = "";

  if(isset($_POST['Vendorcode']) && !(trim($_POST['Vendorcode']) == '')){$Vendorcode = $_POST['Vendorcode'];$if_has_input = true;}
  if(isset($_POST['Vendorname']) && !(trim($_POST['Vendorname']) == '')){$Vendorname = $_POST['Vendorname'];$if_has_input = true;}
  if(isset($_POST['VendorTel_1']) && !(trim($_POST['VendorTel_1']) == '')){$VendorTel_1 = $_POST['VendorTel_1'];$if_has_input = true;}
  if(isset($_POST['VendorID']) && !(trim($_POST['VendorID']) == '')){$VendorID = $_POST['VendorID'];$if_has_input = true;}
  if(isset($_POST['VendorEmail']) && !(trim($_POST['VendorEmail']) == '')){$VendorEmail = $_POST['VendorEmail'];$if_has_input = true;}

  if(isset($_POST['VendorCompany']) && !(trim($_POST['VendorCompany']) == '')){$VendorCompany = $_POST['VendorCompany'];$if_has_input = true;}
  if(isset($_POST['VendorTel_2']) && !(trim($_POST['VendorTel_2']) == '')){$VendorTel_2 = $_POST['VendorTel_2'];$if_has_input = true;}
  if(isset($_POST['VendorWebsite']) && !(trim($_POST['VendorWebsite']) == '')){$VendorWebsite = $_POST['VendorWebsite'];$if_has_input = true;}
  if(isset($_POST['VendorType']) && !(trim($_POST['VendorType']) == '')){$VendorType = $_POST['VendorType'];$if_has_input = true;}
  if(isset($_POST['VendorPayMethod_id']) && !(trim($_POST['VendorPayMethod_id']) == '')){
    $VendorPayMethod_id = $_POST['VendorPayMethod_id'];
        $select = $conn->prepare("SELECT PaymentMethod_id FROM PaymentMethod WHERE PaymentName = :VendorPayMethod_id ");
        $select->execute(array(':VendorPayMethod_id' => $VendorPayMethod_id));//取得Username對應的User_id
        $VendorPayMethod_id = $select->fetchColumn();
    $if_has_input = true;
  }

  if(isset($_POST['VendorBank']) && !(trim($_POST['VendorBank']) == '')){$VendorBank = $_POST['VendorBank'];$if_has_input = true;}
  if(isset($_POST['VendorBankNo']) && !(trim($_POST['VendorBankNo']) == '')){$VendorBankNo = $_POST['VendorBankNo']; $if_has_input = true;}
  if(isset($_POST['VendorUser_id']) && !(trim($_POST['VendorUser_id']) == '')){$VendorUser_id = $_POST['VendorUser_id'];$if_has_input = true;}
  if(isset($_POST['VendorAddress']) && !(trim($_POST['VendorAddress']) == '')){$VendorAddress = $_POST['VendorAddress'];$if_has_input = true;}
  if(isset($_POST['VendorRemarks']) && !(trim($_POST['VendorRemarks']) == '')){$VendorRemarks = $_POST['VendorRemarks'];$if_has_input = true;}

  $array = array(
      ':Vendorcode' => $Vendorcode,
      ':Vendorname' => $Vendorname,
      ':VendorTel_1' => $VendorTel_1,
      ':VendorID' => $VendorID,
      ':VendorEmail' => $VendorEmail,
      ':VendorCompany' => $VendorCompany,
      ':VendorTel_2' => $VendorTel_2,
      ':VendorWebsite' => $VendorWebsite,
      ':VendorType' => $VendorType,
      ':VendorPayMethod_id' => $VendorPayMethod_id,
      ':VendorBank' => $VendorBank,
      ':VendorBankNo' => $VendorBankNo,
      ':VendorUser_id' => $Username,
      ':VendorAddress' => $VendorAddress,
      ':VendorRemarks' => $VendorRemarks
      );

  $array = array_filter($array,function ($value) {return null !== $value;});
  $query = 'SELECT * FROM Vendor WHERE';
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

    <title>供應商-查詢</title>
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
        <li role="presentation"><a href="./Customer_Add.php">客戶</a></li>
        <li role="presentation" class="active"><a>供應商</a></li>
        <div class="col-lg-3">
          <a class="btn btn-secondary btn-sm" disabled>
            <span class="glyphicon glyphicon-search" aria-hidden="true"></span>
            查詢
          </a>
          <a href="./Vendor_Add.php" class="btn btn-primary btn-sm">
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
            <span class="input-group-addon">供應商編號</span>
            <input type="text" class="form-control" placeholder="935824428" name="Vendorcode">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">名稱</span>
            <input type="text" class="form-control" placeholder="17237938429" name="Vendorname">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">電話1</span>
            <input type="text" class="form-control" placeholder="薰衣草" name="VendorTel_1">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">統一編號</span>
            <input type="text" class="form-control" placeholder="Lavandula" name="VendorID">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">Email</span>
            <input type="text" class="form-control" placeholder="574289" name="VendorEmail">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">公司</span>
            <input type="text" class="form-control" placeholder="KG" name="VendorCompany">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">電話2</span>
            <input type="text" class="form-control" placeholder="資訊" name="VendorTel_2">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">網站</span>
            <input type="text" class="form-control" placeholder="資訊" name="VendorWebsite">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div><!-- /.row -->

      <div class="row">
        <div class="col-lg-3">
          <select class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" name="VendorType">
            <option value="Personal">個人</option>
            <option value="Company">公司</option>
          </select>
          </div>
        <div class="col-lg-3">
          <select class=" form-control btn btn-default dropdown-toggle" name="VendorPayMethod_id">
            <option value="Credit">刷卡</option>
            <option value="Transfer">轉帳</option>
            <option value="Cash">現金</option>
          </select>
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">銀行</span>
            <input type="text" class="form-control" placeholder="574289" name="VendorBank">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">戶號</span>
            <input type="text" class="form-control" placeholder="574289" name="VendorBankNo">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
      </div>

      <div class="row">
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">Username</span>
            <input type="text" class="form-control" placeholder="574289" name="VendorUser_id">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-3">
          <div class="input-group">
            <span class="input-group-addon">地址</span>
            <input type="text" class="form-control" placeholder="574289" name="VendorAddress">
          </div><!-- /input-group -->
        </div><!-- /.col-lg-6 -->
        <div class="col-lg-5">
          <div class="input-group">
            <span class="input-group-addon">備註</span>
            <input type="text" class="form-control" placeholder="574289" name="VendorRemarks">
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
            <th class="col-lg-2">供應商編號</th>
            <th class="col-lg-1">名稱</th>
            <th class="col-lg-2">Username</th>
            <th class="col-lg-2">Email</th>
            <th class="col-lg-1">供應商類別</th>
            <th class="col-lg-2">備註</th>
            <th class="col-lg-1">查看</th>
          </tr>
        </thead>
        <tbody>
<?php
if(isset($_POST['search'])){

            $i = 1;
            foreach($row as $ro){

                $VendorUser_id = $ro->VendorUser_id;
                $find = $conn->prepare("SELECT Username FROM Users WHERE User_id = :VendorUser_id");
                $find->execute(array(':VendorUser_id' => $VendorUser_id));
                $usr = $find->fetch(PDO::FETCH_ASSOC);

                echo "<tr><th>"."$i</th>"."<th>".$ro->Vendorcode."</th>"."<th>".$ro->Vendorname."</th>"."<th>".$usr['Username']."</th>"."<th>".$ro->VendorEmail."</th>"."<th>".$ro->VendorType."</th>"."<th>".$ro->VendorRemarks."</th>"."<th><a href='./Vendor_Add.php?view=".$ro->Vendorcode."'><span class='glyphicon glyphicon-pencil' aria-hidden='true'></span></a></th>";
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
    <script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
    <script src="../js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <script src="../js/ie10-viewport-bug-workaround.js"></script>

    <script type="text/javascript" src="../js/count.js"></script>
  </body>
</html>
