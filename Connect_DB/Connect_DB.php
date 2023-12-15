<?php 
    $tns = "(DESCRIPTION=(ADDRESS_LIST = (ADDRESS = (PROTOCOL = TCP)(HOST = localhost)(PORT = 1521)))(CONNECT_DATA=(SID=orcl)))";
    $db_username = 'Nhom12_BTL_ORACLE';
    $db_password = '123';
    try {
        $conn = new PDO("oci:dbname=".$GLOBALS['tns'].";charset=utf8", $GLOBALS['db_username'], $GLOBALS['db_password']);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        echo "Connected";
    } 
    catch(PDOException $e) 
    {
        echo "Error: " . $e->getMessage();
    }
    //    $conn = null;
?>