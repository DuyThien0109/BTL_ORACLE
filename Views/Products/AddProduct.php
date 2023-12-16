<?php
    require("../Connect_DB/Connect_DB.php");


    

    


    $stmt = $conn->prepare("SELECT MAX(MA_SAN_PHAM) AS MA_MAX FROM san_pham");
    $stmt->execute();
    $stmt->setFetchMode(PDO::FETCH_ASSOC);

    // $stmt = $conn->prepare("SELECT MAX(MA_SAN_PHAM) AS MA_MAX FROM san_pham");
    // $stmt->execute();

    // $ma_max = $stmt->fetchColumn();
    // echo $ma_max;


    $kt = -1;
    $ma_moi = 'SP01';
    while ($row = $stmt->fetch()) 
    {
       $kt = str_replace('SP', '', $row['MA_MAX']);
    }
    if($kt != -1)
    {
        if($kt<9)
 
            $ma_moi = 'SP0'.$kt+1;

        else
            $ma_moi = 'SP'.$kt+1;
    }


    $stmt = $conn->prepare("SELECT MA_THE_LOAI, TEN_THE_LOAI FROM the_loai");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<form class="row g-3 needs-validation" novalidate style="padding: 50px" method="POST" action="" enctype="multipart/form-data">


    <div class="mb-3">
        <label for="exampleFormControlInput1" class="form-label">Mã sản phẩm</label>
        <input type="text" class="form-control" name='ma_san_pham' readonly id="exampleFormControlInput1" value="<?php echo $ma_moi?>">
    </div>


    <div class="mb-3">
        <label for="exampleFormControlInput2" class="form-label">Tên sản phẩm</label>
        <input type="text" class="form-control" name='ten_san_pham' id="exampleFormControlInput2" value="" required>
        <div class="invalid-feedback">
            Bạn cần nhập tên.
        </div>
    </div>

    <div class="mb-3">
        <label for="exampleFormControlInput3" class="form-label">Thể loại</label>
        <select id="exampleFormControlInput3" name="ma_the_loai" class="form-select " aria-label="Default select example" required>
            <option value="" selected>---</option>

            <?php
            // Lặp qua kết quả truy vấn để tạo các tùy chọn
            foreach ($result as $row) {
                echo '<option value="' . $row['MA_THE_LOAI'] . '">' . $row['TEN_THE_LOAI'] . '</option>';
            }
            ?>
        </select>
        <div class="invalid-feedback">
            Bạn cần chọn thể loại.
        </div>
    </div>

    <div class="mb-3">
        <label for="exampleFormControlInput4" class="form-label">Đơn giá nhập</label>
        <input type="number" class="form-control" min="1000" name='don_gia_nhap' id="exampleFormControlInput4" value="" required>
        <div class="invalid-feedback">
            Bạn cần nhập đơn giá nhập.
        </div>
    </div>

    <div class="mb-3">
        <label for="exampleFormControlInput5" class="form-label">Đơn giá bán</label>
        <input type="number" class="form-control" min="1000" name='don_gia_ban' id="exampleFormControlInput5" value="" required>
        <div class="invalid-feedback">
            Bạn cần nhập đơn giá bán.
        </div>
    </div>

    <div class="mb-3">
        <label for="exampleFormControlInput6" class="form-label">Giảm giá</label>
        <input type="number" min="0" max="100" class="form-control" name='giam_gia' id="exampleFormControlInput6" value="">
    </div>

    <div class="mb-3">
        <label for="exampleFormControlInput7" class="form-label">Ảnh đại diện</label>
        <input type="file" class="form-control" name='anh_dai_dien' id="image" required>
        <div style="padding-top:20px"><img id="previewImage" src="" alt="Preview Image" style="margin: auto; display: none; width: 500px; height:400px"></div>
        <div class="invalid-feedback">
            Bạn cần chọn ảnh đại diện.
        </div>
    </div>


    

    <div class="mb-3">
        <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
        <textarea class="form-control" name='mo_ta' id="Create_SanPham_ckeditor" rows="3" required></textarea>
        <div class="invalid-feedback">
            Bạn cần nhập mô tả.
        </div>
    </div>
    <div class="col-12">
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        <a href="../Layout/Index.php?Renderbody=ListProduct" class="btn btn-dark">Quay lại</a>
    </div>
</form>

<?php
// Xử lý khi người dùng nhấp vào nút "Update"
if ($_SERVER["REQUEST_METHOD"] == "POST") 
{
    
    

    

    $ma_san_pham = $_POST['ma_san_pham'];
    $ten_san_pham = $_POST['ten_san_pham'];
    $ma_the_loai= $_POST['ma_the_loai'];
    $don_gia_nhap= $_POST['don_gia_nhap'];
    $don_gia_ban= $_POST['don_gia_ban'];
    $giam_gia= $_POST['giam_gia'];
    $anh_dai_dien= basename($_FILES["anh_dai_dien"]["name"]);
    $image_list= $_POST['image_list'];
    $mo_ta= $_POST['mo_ta'];
    // echo $ma_san_pham 
    // . ' - '. $ten_san_pham
    // . ' - '. $ma_the_loai
    // . ' - '. $don_gia_nhap
    // . ' - '. $don_gia_ban
    // . ' - '. $giam_gia
    // . ' - '. $anh_dai_dien
    // . ' - '. $image_list
    // . ' - '. $mo_ta;
    // Truy vấn để lấy sinh viên có ID lớn nhất

    $sql = "INSERT INTO san_pham (MA_SAN_PHAM, TEN_SAN_PHAM, DON_GIA_NHAP, DON_GIA_BAN, GIAM_GIA, ANH_DAI_DIEN, MO_TA, MA_THE_LOAI)
        VALUES ('$ma_san_pham', '$ten_san_pham', $don_gia_nhap, $don_gia_ban, $giam_gia, '$anh_dai_dien', '$mo_ta', '$ma_the_loai')";
    // use exec() because no results are returned
    $conn->exec($sql);
    
    // them anh san pham
    

    

    // upload file
    $target_file = "../IMG_SanPham/" . $anh_dai_dien;
    if (move_uploaded_file($_FILES["anh_dai_dien"]["tmp_name"], $target_file))// di chuyển file ảnh từ $_FILES["image"]["tmp_name"] sang thư mục $target_file
    {
        header("Location: Index.php?Renderbody=ListProduct&themthanhcong=1&page=".$_GET['page']);
    }
    
    

}
else {
   
}
?>