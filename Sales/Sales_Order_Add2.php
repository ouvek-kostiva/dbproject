<?php

$SOid=$_POST['SOid'];
$Cid=$_POST['Cid'];
$Uid=$_POST['Uid'];
$Date=$_POST['SOdate'];
$RDate=$_POST['SORdate'];
$Address=$_POST['Address'];


$DMethod=$_POST['DeliveryMethod'];

if ($DMethod=="貨到付款") {
    $DMethod=1;
}elseif($DMethod=="自行提款"){
    $DMethod=2;
}elseif($DMethod=="付款後取貨"){
    $DMethod=3;
}elseif ($DMethod=="現金購買") {
   $DMethod=4;
}


    $id=$_POST['Productid'];
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





 $insert=$db->exec("INSERT INTO `SalesOrder`
(`SalesOrder_id`,
`SO_Date`,
`SO_ReqDate`,
`SO_Address`,
`SO_Customer_id`,
`SO_User_id`,
`SO_DeliveryMethod_id`,
`SO_Code`,
`SO_Amount`)
VALUES
('$SOid',
'$Date',
'$RDate',
'$Address',
'$Cid',
'$Uid',
'$DMethod',
'$SOid',
NULL);");

$id = array_filter($id);
var_dump($id);
for ( $i=0; $i < count($id);$i++) {


$insert1=$db->exec("INSERT INTO `SalesOrder_List`
(`SO_List_SalesOrder_id`,
`SO_List_Quantity`,
`SO_List_Discount`,
`SO_List_UnitPrice`,
`SO_List_Tax`,
`SO_List_Remarks`,
`SOList_id`,
`SO_Product_id`)
VALUES
('$SOid',
'$Qty[$i]',
'$Dt[$i]',
'$UPrice[$i]',
'$Tax[$i]',
'$Re[$i]',
null,
'$id[$i]');");


}

header("Location: ./Sales_Order_Search2.php");
?>

