<?php
if (isset($_GET['ma_san_pham'])) {
    // Kết nối đến cơ sở dữ liệu
    require("../../Connect_DB/Connect_DB.php");
    $ma_san_pham = trim($_GET['ma_san_pham']);

    
    try {
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Sử dụng tham số để tránh SQL injection
        
       
        // sql to delete a record
        $sql = "DELETE FROM san_pham WHERE MA_SAN_PHAM = :ma_san_pham";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ma_san_pham', $ma_san_pham);
        $stmt->execute();

       

        header("Location: ../../Layout/Index.php?Renderbody=ListProduct&xoathanhcong=1&page=".$_GET['page']);
    } catch (PDOException $e) {
        // Log hoặc xử lý lỗi theo cách bạn muốn
        //echo $sql . "<br>" . $e->getMessage();
        header("Location: ../../Layout/Index.php?Renderbody=ListProduct&xoathanhcong=2&page=".$_GET['page']);
    }
} else {
    echo "Không có ID sản phẩm để xóa.";
}
?>



