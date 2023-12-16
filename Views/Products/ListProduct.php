



<div class="row">
    <div class="col-sm-12">
        <a id="linkAdd" class="btn btn-primary" href="Index.php?Renderbody=AddProduct" style="margin-bottom: 20px;">Thêm sản phẩm</a>
        <table class="table table-bordered  col-sm-12">
            <tr>
                <th>Mã sản phẩm</th>
                <th>Ảnh đại diện</th>
                <th>Tên sản phẩm</th>
                <th>Thể loại</th>
                <th>Tổng số lượng</th>
                <th>Đơn giá nhập</th>
                <th>Đơn giá bán</th>
                <th>Giảm giá</th>
                <th>Hành động</th>
            </tr>
            <?php 
                require("../Connect_DB/Connect_DB.php");
                // Define the number of records to display per page and get the current page from the query string
                $recordsPerPage = 5;// số ban ghi tren 1 trang
                if (isset($_GET['page'])) 
                {
                    $currentPage = $_GET['page'];

                } else {
                    $currentPage = 1;
                }
                
                // Calculate the LIMIT clause for SQL query
                $limit = ($currentPage - 1) * $recordsPerPage;
                
                $stmt = $conn->prepare("SELECT 
                                            san_pham.MA_SAN_PHAM, 
                                            san_pham.TEN_SAN_PHAM, 
                                            san_pham.DON_GIA_NHAP, 
                                            san_pham.DON_GIA_BAN, 
                                            san_pham.GIAM_GIA, 
                                            san_pham.ANH_DAI_DIEN, 
                                            san_pham.MO_TA, 
                                            san_pham.MA_THE_LOAI, 
                                            the_loai.TEN_THE_LOAI,
                                            COALESCE(SUM(chi_tiet_san_pham.SO_LUONG), 0) AS TONG_SO_LUONG
                                        FROM 
                                            san_pham
                                        JOIN 
                                            the_loai ON san_pham.MA_THE_LOAI = the_loai.MA_THE_LOAI
                                        LEFT JOIN 
                                            chi_tiet_san_pham ON san_pham.MA_SAN_PHAM = chi_tiet_san_pham.MA_SAN_PHAM
                                        GROUP BY 
                                            san_pham.MA_SAN_PHAM, 
                                            san_pham.TEN_SAN_PHAM, 
                                            san_pham.DON_GIA_NHAP, 
                                            san_pham.DON_GIA_BAN, 
                                            san_pham.GIAM_GIA, 
                                            san_pham.ANH_DAI_DIEN, 
                                            san_pham.MO_TA, 
                                            san_pham.MA_THE_LOAI, 
                                            the_loai.TEN_THE_LOAI
                                        ORDER BY san_pham.MA_SAN_PHAM
                                        OFFSET $limit ROWS FETCH NEXT $recordsPerPage ROWS ONLY");
                //$stmt = $conn->prepare("SELECT *  FROM sinhvien");
                $stmt->execute();
                $stmt->setFetchMode(PDO::FETCH_ASSOC);

                // Get the total number of records
                $totalRecords = $conn->query("SELECT COUNT(*) FROM san_pham")->fetchColumn();

                // Calculate the total number of pages
                $totalPages = ceil($totalRecords / $recordsPerPage);
                
                while($row = $stmt->fetch()){
            ?>
                   <tr>
                        <td><?php echo $row['MA_SAN_PHAM']; ?></td>
                        <td><img src="../IMG_SanPham/<?php echo $row['ANH_DAI_DIEN']; ?>"  alt="lỗi ảnh" style="width: 90px;height:90px;"></td>
                        <td><?php echo $row['TEN_SAN_PHAM']; ?></td>
                        <td><?php echo $row['TEN_THE_LOAI']; ?></td>
                        <td><?php echo $row['TONG_SO_LUONG']; ?></td>
                        <td><?php echo $row['DON_GIA_NHAP']; ?></td>
                        <td><?php echo $row['DON_GIA_BAN']; ?></td>
                        <td><?php echo $row['GIAM_GIA']; ?></td>
                        
                        <td>
                        
                       
                            <a class="btn btn-success" 
                            href="Index.php?Renderbody=EditProduct&page=<?php echo $currentPage; ?>
                            &ma_san_pham=<?php echo $row['MA_SAN_PHAM']; ?>
                            &ten_san_pham=<?php echo $row['TEN_SAN_PHAM']; ?>
                            &ma_the_loai=<?php echo $row['MA_THE_LOAI']; ?>
                            &don_gia_nhap=<?php echo $row['DON_GIA_NHAP']; ?>
                            &don_gia_ban=<?php echo $row['DON_GIA_BAN']; ?>
                            &giam_gia=<?php echo $row['GIAM_GIA']; ?>
                            &anh_dai_dien=<?php echo $row['ANH_DAI_DIEN']; ?>
                            &mo_ta=<?php echo $row['MO_TA']; ?>">
                                <i class="bi bi-pencil-square"></i>
                            </a>

                            <a href="../Views/Products/DeleteProduct.php?ma_san_pham=<?php echo $row['MA_SAN_PHAM']; ?>&page=<?php echo $currentPage ?>" 
                            onclick="return confirm('Bạn muốn xóa không')" class="btn btn-danger">
                                <i class="bi bi-x-square-fill"></i>
                            </a>
                          
                            
                        </td>
                    </tr> 
            <?php } $conn = null;?>
        </table>
        <?php if($totalPages > 1){ ?>
        <ul class="pagination">
            <?php
            if($currentPage!=1)
                echo '<li class="page-item "><a class="page-link" href="?Renderbody=ListProduct&page=' . $currentPage-1 . '"> Trước </a></li>'; 
            for ($i = 1; $i <= $totalPages; $i++) 
            {
                echo '<li class="page-item' . ($i == $currentPage ? ' active' : '') . '"><a class="page-link" href="?Renderbody=ListProduct&page=' . $i . '">' . $i . '</a></li>';
            }
            if($currentPage!=$totalPages)
                echo '<li class="page-item "><a class="page-link" href="?Renderbody=ListProduct&page=' . $currentPage+1 . '"> Sau </a></li>'; 
            ?>
        </ul>
        <?php } ?>
    </div>
</div>

