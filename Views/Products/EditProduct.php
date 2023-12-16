
<?php
    require("../Connect_DB/Connect_DB.php");

    $stmt = $conn->prepare("SELECT MA_THE_LOAI, TEN_THE_LOAI FROM the_loai");
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<form class="row g-3 needs-validation" novalidate style="padding: 50px" method="POST"  action="" enctype="multipart/form-data">
      
        
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" name ='ma_san_pham'readonly id="exampleFormControlInput1" value="<?php echo trim($_GET['ma_san_pham']); ?>" >
        </div>


        <div class="mb-3">
            <label for="exampleFormControlInput2" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" name ='ten_san_pham' id="exampleFormControlInput2" value="<?php echo trim($_GET['ten_san_pham']); ?>" required>
            <div class="invalid-feedback">
                Bạn cần nhập tên.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput3" class="form-label">Thể loại</label>
            <select id="exampleFormControlInput3"  name="ma_the_loai" class="form-select " aria-label="Default select example" required>
                <option value="" selected>---</option>
                <?php
                    // Lặp qua kết quả truy vấn để tạo các tùy chọn
                    foreach ($result as $row) {
                ?>
                    <option value="<?php echo $row['MA_THE_LOAI'] ?>" <?php echo $row['MA_THE_LOAI'] == trim($_GET['ma_the_loai'])? 'selected':''  ?> > <?php echo $row['TEN_THE_LOAI'] ?> </option>;
                    
                <?php }?>
                
            </select>
            <div class="invalid-feedback">
                Bạn cần chọn thể loại.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput4" class="form-label">Đơn giá nhập</label>
            <input type="number" class="form-control" min="1000" name ='don_gia_nhap' id="exampleFormControlInput4"  value="<?php echo trim($_GET['don_gia_nhap']); ?>" required>
            <div class="invalid-feedback">
                Bạn cần nhập đơn giá nhập.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput5" class="form-label">Đơn giá bán</label>
            <input type="number" class="form-control" min="1000" name ='don_gia_ban' id="exampleFormControlInput5"  value="<?php echo trim($_GET['don_gia_ban']); ?>" required>
            <div class="invalid-feedback">
                Bạn cần nhập đơn giá bán.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput6" class="form-label">Giảm giá</label>
            <input type="number" class="form-control" name ='giam_gia' id="exampleFormControlInput6" min="0" max="100"  value="<?php echo trim($_GET['giam_gia']); ?>" >
            <div class="invalid-feedback">
                Bạn cần nhập đơn giá bán và không được nhỏ hơn 0.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput7" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" name ='anh_dai_dien' id="imageEdit"  >
            <div class="row" style="margin: auto; padding-top:20px">
                <div class="col-6" style="display: flex; flex-direction: column; align-items: center; text-align: center;">
                    <label class="form-label">Ảnh cũ</label>
                    <img  id="previewImage"  src="../IMG_SanPham/<?php echo $_GET['anh_dai_dien']; ?>" alt="Preview Image" 
                    style="width: 250px; height:250px">
                </div>

                <div class="col-6" style="display: flex; flex-direction: column; align-items: center; text-align: center;" >
                    <label class="form-label">Ảnh mới(Mặc định là theo ảnh cũ)</label>
                    <img  id="previewImageNew"  src="../IMG_SanPham/<?php echo $_GET['anh_dai_dien']; ?>" alt="Preview Image" 
                    style="width: 250px; height:250px">
                </div>
                
            </div>
            <div class="invalid-feedback">
                Bạn cần chọn ảnh.
            </div>
        </div>

        


        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
            <textarea class="form-control" name ='mo_ta' id="Edit_SanPham_ckeditor" rows="3" required ><?php echo $_GET['mo_ta']; ?></textarea>
            <div class="invalid-feedback">
                Bạn cần nhập mô tả.
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">cập nhật</button>
            <a href="../Layout/Index.php?Renderbody=ListProduct" class="btn btn-dark">Quay lại</a>
        </div>
    </form>
    <script>
        document.getElementById('imageEdit').onchange = function(e) {
                const previewImageNew = document.getElementById('previewImageNew');
                const fileInput = e.target;
                if (fileInput.files && fileInput.files[0]) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        previewImageNew.src = e.target.result;
                        previewImageNew.style.display = 'block';
                    };
                    reader.readAsDataURL(fileInput.files[0]);
                } else
                {
                    previewImageNew.src = document.getElementById('previewImage').src;  
                }
                    
            };
    </script>

<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") 
    {

        $ma_san_pham = $_POST['ma_san_pham'];
        $ten_san_pham = $_POST['ten_san_pham'];
        $ma_the_loai= $_POST['ma_the_loai'];
        $don_gia_nhap= $_POST['don_gia_nhap'];
        $don_gia_ban= $_POST['don_gia_ban'];
        $giam_gia= $_POST['giam_gia'];
        $anh_dai_dien = basename($_FILES['anh_dai_dien']['name']);
        if($anh_dai_dien=='')
            $anh_dai_dien= $_GET['anh_dai_dien'];
        //echo $anh_dai_dien;
        $mo_ta= $_POST['mo_ta'];

       
        //echo "Mã san phẩm: ".$ma_san_pham .'- tên san phảm: '.$ten_san_pham.'- ma the loai: '.$ma_the_loai.'- don gia nhap: '.$don_gia_nhap.'- don gia ban: '.$don_gia_ban.'- giam gia: '.$giam_gia.'- anh dai dien: '.$anh_dai_dien.'- mo ta: '.$mo_ta;


        
        
        $updateStmt = $conn->prepare("UPDATE san_pham SET
        TEN_SAN_PHAM = :ten_san_pham, 
        DON_GIA_NHAP = :don_gia_nhap, 
        DON_GIA_BAN = :don_gia_ban, 
        GIAM_GIA = :giam_gia, 
        ANH_DAI_DIEN = :anh_dai_dien, 
        MO_TA = :mo_ta, 
        MA_THE_LOAI = :ma_the_loai
        WHERE MA_SAN_PHAM = :ma_san_pham");

        // $updateStmt = $conn->prepare("UPDATE san_pham SET
        // TEN_SAN_PHAM = '$ten_san_pham', 
        // DON_GIA_NHAP = $don_gia_nhap, 
        // DON_GIA_BAN = $don_gia_ban, 
        // GIAM_GIA = $giam_gia, 
        // ANH_DAI_DIEN = '$anh_dai_dien', 
        // MO_TA = '$mo_ta', 
        // MA_THE_LOAI = '$ma_the_loai'
        // WHERE MA_SAN_PHAM = '$ma_san_pham'");

        $updateStmt->bindParam(':ten_san_pham', $ten_san_pham);
        $updateStmt->bindParam(':don_gia_nhap', $don_gia_nhap);
        $updateStmt->bindParam(':don_gia_ban', $don_gia_ban);
        $updateStmt->bindParam(':giam_gia', $giam_gia);
        $updateStmt->bindParam(':anh_dai_dien', $anh_dai_dien);
        $updateStmt->bindParam(':mo_ta', $mo_ta);
        $updateStmt->bindParam(':ma_the_loai', $ma_the_loai);
        $updateStmt->bindParam(':ma_san_pham', $ma_san_pham);

        $conn->beginTransaction();
        if ($updateStmt->execute()) 
        {
            $conn->commit();
            //echo $ma_san_pham .'-'.$ten_san_pham.'-'.$ma_the_loai.'-'.$don_gia_nhap.'-'.$don_gia_ban.'-'.$giam_gia.'-'.$anh_dai_dien.'-'.$mo_ta;
            // Upload tệp mới
     
            $target_dir = "../IMG_SanPham/";
            $target_file = $target_dir . $anh_dai_dien;
            if($anh_dai_dien != $_GET['anh_dai_dien'])
            {
                if (!move_uploaded_file($_FILES["anh_dai_dien"]["tmp_name"], $target_file)) 
                {
                    echo 'Upload file error: ' . $anh_dai_dien;
                    exit();
                } 
                else
                {
                    //echo 'Upload file success';
                }
            }
            
            
            
            
            header("Location: Index.php?Renderbody=ListProduct&suathanhcong=1&page=".$_GET['page']);
            
        } else {
            echo "Lỗi khi cập nhật dữ liệu.";
        }
        
        
    
    }
    else {
       
    }

?>