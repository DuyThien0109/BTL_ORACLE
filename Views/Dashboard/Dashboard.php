<!-- Xử lý lấy dữ liệu -->
<?php
require("../Connect_DB/Connect_DB.php");
// Doanh thu hôm nay 
$doanhthuhomnay = 0;
$sql = "SELECT SUM(tong_tien_hdb) AS total
        FROM hoa_don_ban 
        WHERE TRUNC(ngay_tao_hoa_don) = TRUNC(SYSDATE)
        and tinh_trang_hoa_don = 'Đã giao hàng'
        ";
$stmt = $conn->prepare($sql);
$stmt->execute();
// Kiểm tra xem có bản ghi nào được trả về hay không
if ($stmt->rowCount() > 0) {
    // Nếu có bản ghi, lấy giá trị từ cột 'total'
    $doanhthuhomnay = $stmt->fetchColumn();
}

//Số hóa đơn hôm nay
$sohoadonhomnay = 0;
$sql = "SELECT count(*) as sohoadonhomnay
        FROM hoa_don_ban 
        WHERE TRUNC(ngay_tao_hoa_don) = TRUNC(SYSDATE)
        and tinh_trang_hoa_don = 'Đã giao hàng'
        ";
$stmt = $conn->prepare($sql);
$stmt->execute();
// Kiểm tra xem có bản ghi nào được trả về hay không
if ($stmt->rowCount() > 0) {
    // Nếu có bản ghi, lấy giá trị từ cột 'total'
    $sohoadonhomnay = $stmt->fetchColumn();
}

//Doanh thu tháng này
$doanhthuthangnay = 0;
$sql = "SELECT SUM(tong_tien_hdb) AS total
        FROM hoa_don_ban 
        WHERE EXTRACT(MONTH FROM ngay_tao_hoa_don) = EXTRACT(MONTH FROM SYSDATE)
        AND EXTRACT(YEAR FROM ngay_tao_hoa_don) = EXTRACT(YEAR FROM SYSDATE)
        AND tinh_trang_hoa_don = 'Đã giao hàng'";
$stmt = $conn->prepare($sql);
$stmt->execute();
// Kiểm tra xem có bản ghi nào được trả về hay không
if ($stmt->rowCount() > 0) {
    // Nếu có bản ghi, lấy giá trị từ cột 'total'
    $doanhthuthangnay = $stmt->fetchColumn();
}

//Số hóa đơn tháng này
$sohoadonthangnay = 0;
$sql = "SELECT count(*) AS sohoadonthangnay
        FROM hoa_don_ban 
        WHERE EXTRACT(MONTH FROM ngay_tao_hoa_don) = EXTRACT(MONTH FROM SYSDATE)
        AND EXTRACT(YEAR FROM ngay_tao_hoa_don) = EXTRACT(YEAR FROM SYSDATE)
        AND tinh_trang_hoa_don = 'Đã giao hàng'";
$stmt = $conn->prepare($sql);
$stmt->execute();
// Kiểm tra xem có bản ghi nào được trả về hay không
if ($stmt->rowCount() > 0) {
    // Nếu có bản ghi, lấy giá trị từ cột 'total'
    $sohoadonthangnay = $stmt->fetchColumn();
}

//Biểu đồ
$totalchart = [];
for ($month = 1; $month <= 12; $month++) {
    $sql = "SELECT NVL(sum(tong_tien_hdb),0) as doanh_thu
    from hoa_don_ban
    where EXTRACT(month FROM hoa_don_ban.ngay_tao_hoa_don)=$month
    and tinh_trang_hoa_don='Đã giao hàng'
    and EXTRACT(YEAR FROM hoa_don_ban.ngay_tao_hoa_don)=EXTRACT(YEAR FROM SYSDATE)";

    $stmt = $conn->prepare($sql);
    $stmt->execute();

    $totalchart[$month] = $stmt->fetchColumn();

}
?>

<!-- 4 cái bên trên -->
<div class="row">

    <!-- Doanh thu hôm nay -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Doanh thu hôm nay</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $doanhthuhomnay; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Số hóa đơn hôm nay -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Số hóa đơn hôm nay</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $sohoadonhomnay; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Doanh thu tháng này -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Doanh thu tháng này
                        </div>
                        <div class="row no-gutters align-items-center">
                            <div class="col-auto">
                                <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">
                                    <?php echo $doanhthuthangnay; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Số hóa đơn tháng này -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Số hóa đơn tháng này</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800">
                            <?php echo $sohoadonthangnay; ?>
                        </div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Biểu đồ -->
<div class="row">
    <!-- Area Chart -->
    <div class="col-xl-12 col-lg-12">
        <div class="card shadow mb-4">
            <!-- Card Header - Dropdown -->
            <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Doanh thu</h6>
                <div class="dropdown no-arrow">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Dropdown Header:</div>
                        <a class="dropdown-item" href="#">Action</a>
                        <a class="dropdown-item" href="#">Another action</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#">Something else here</a>
                    </div>
                </div>
            </div>
            <!-- Card Body -->
            <div class="card-body">
                <div class="chart-area">
                    <canvas id="myAreaChart"></canvas>
                </div>
            </div>
        </div>
    </div>

</div>

<div id="totalchart" data-totals="<?php echo htmlspecialchars(json_encode($totalchart), ENT_QUOTES, 'UTF-8'); ?>"></div>
