<?php
$db_host = '127.0.0.1';
$db_user = 'wei0604';
$db_password = '';
$db_name = 'c9';
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

$Receivecode=$_POST['Receivecode'];
$Receive_Date=$_POST['Receive_Date'];
$Receive_Remarks=$_POST['Receive_Remarks'];
$Product_id=$_POST['Product_id'];
$Qty=$_POST['Qty'];
$Price=$_POST['Price'];
$Remarks=$_POST['Remarks'];

try {
    $db = new PDO($dsn, $db_user, $db_password);
    $add1 = $db->query("INSERT INTO Receive (Receivecode,Receive_Date,Receive_Remarks) VALUES ('$Receivecode','$Receive_Date','$Receive_Remarks')");
    $Receive_id=$db->query("SELECT Receive_id FROM Receive WHERE Receivecode='$Receivecode'");

    foreach ($Receive_id as $row) {
        $id=$row['Receive_id'];
    }

    $n=0;
    for($i=0;$i<7;$i++){
        if($Product_id[$i]>0){
            $n++;
            $add2 = $db->query("INSERT INTO Receive_List (Receive_List_Receive_id,Receive_List_Quantity,Receive_List_Remarks,Receive_List_Product_id,Receive_List_UnitPrice) VALUES ('$id','$Qty[$i]','$Remarks[$i]','$Product_id[$i]','$Price[$i]')");
        }
    }
    echo $n;
} catch (PDOException $e) {
    echo $e->getMessage();
}
header("Location: ./Receive_Search.php");
?>