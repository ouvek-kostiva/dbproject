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

try {
    $db = new PDO($dsn, $db_user, $db_password);
    $add1 = $db->query("INSERT INTO Issue (Issuecode,Issue_Date,Issue_Remarks) VALUES ('$Issuecode','$Issue_Date','$Issue_Remarks')");
    $Issue_id=$db->query("SELECT Issue_id FROM Issue WHERE Issuecode='$Issuecode'");

    foreach ($Issue_id as $row) {
        $id=$row['Issue_id'];
    }

    $n=0;
    for($i=0;$i<7;$i++){
        if($Product_id[$i]>0){
            $n++;
            $add2 = $db->query("INSERT INTO Issue_List (Issue_List_Issue_id,Issue_List_Quantity,Issue_List_Remarks,Issue_List_Product_id) VALUES ('$id','$Qty[$i]','$Remarks[$i]','$Product_id[$i]')");
        }
    }
    echo $n;
} catch (PDOException $e) {
    echo $e->getMessage();
}
header("Location: ./Issue_Search.php");
?>