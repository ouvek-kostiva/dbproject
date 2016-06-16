<?php
$db_host = '127.0.0.1';
$db_user = 'wei0604';
$db_password = '';
$db_name = 'c9';
$dsn = "mysql:host=$db_host;dbname=$db_name;charset=utf8";

$Issuecode=$_POST['Issuecode'];
$Issue_Date=$_POST['Issue_Date'];
$Issue_Remarks=$_POST['Issue_Remarks'];
$Product_id=$_POST['Product_id'];
$Qty=$_POST['Qty'];
$Remarks=$_POST['Remarks'];

echo $Qty[0];

try {
    $db = new PDO($dsn, $db_user, $db_password);
    $updata = $db->exec("UPDATE Issue SET Issuecode='$Issuecode',Issue_Date='$Issue_Date',Issue_Remarks='$Issue_Remarks'");
    $Issue_id=$db->query("SELECT Issue_id FROM Issue WHERE Issuecode='$Issuecode'");

    foreach ($Issue_id as $row) {
        $id=$row['Issue_id'];
    }
    for($i=0;$i<7;$i++){
        if($Product_id[$i]>0){
            $updata2 = $db->exec("UPDATE Issue_List SET Issue_List_Issue_id='$id',Issue_List_Quantity='$Qty[$i]',Issue_List_Remarks='$Remarks[$i]',Issue_List_Product_id='$Product_id[$i]'");
        }
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
header("Location: ./Issue_Search.php");
?>