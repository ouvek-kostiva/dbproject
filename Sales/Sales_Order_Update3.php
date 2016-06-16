<?php


    $id=$_POST['Productid'];
    $SOid=$_POST['SOid'];
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

$id = array_filter($id);
var_dump($id);

   for($i=0; $i < count($id) ; $i++){

  $stmt=$db->prepare("Update SalesOrder_List SET

  SO_List_SalesOrder_id=:SO_List_SalesOrder_id,
  SO_List_Quantity=:SO_List_Quantity,
  SO_List_Discount=:SO_List_Discount,
  SO_List_UnitPrice=:SO_List_UnitPrice,
  SO_List_Tax=:SO_List_Tax,
  SO_List_Remarks=:SO_List_Remarks,
  SOList_id=:SOList_id,
  SO_Product_id=:SO_Product_id WHERE SO_List_SalesOrder_id=:SO_List_SalesOrder_id ");
  $stmt->execute(array(
    ":SO_List_SalesOrder_id"=>$SOid,
    ":SO_List_Quantity"=>$Qty[$i],
    ":SO_List_Discount"=>$Dt[$i],
    ":SO_List_UnitPrice"=>$UPrice[$i],
    ":SO_List_Tax"=>$Tax[$i],
    ":SO_List_Remarks"=>$Re[$i],
    ":SOList_id"=>null,
    ":SO_Product_id"=>$id[$i]

    ));

   }

   header("Location: ./Sales_Order_Search2.php");
?>
