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

echo $Price[0];

try {
    $db = new PDO($dsn, $db_user, $db_password);
    $updata = $db->exec("UPDATE Receive SET Receivecode='$Receivecode',Receive_Date='$Receive_Date',Receive_Remarks='$Receive_Remarks'");
    $Receive_id=$db->query("SELECT Receive_id FROM Receive WHERE Receivecode='$Receivecode'");

    foreach ($Receive_id as $row) {
        $id=$row['Receive_id'];
    }

    for($i=0;$i<7;$i++){
        if($Product_id[$i]>0){
            $updata2 = $db->exec("UPDATE Receive_List SET Receive_List_Receive_id='$id',Receive_List_Quantity='$Qty[$i]',Receive_List_UnitPrice='$Price[$i]',Receive_List_Remarks='$Remarks[$i]',Receive_List_Product_id='$Product_id[$i]'");
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
header("Location: ./Receive_Search.php");
?>