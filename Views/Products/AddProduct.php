

    <form class="row g-3 needs-validation" novalidate style="padding: 50px" method="POST"  action="" enctype="multipart/form-data">

        
        <div class="mb-3">
            <label for="exampleFormControlInput1" class="form-label">Mã sản phẩm</label>
            <input type="text" class="form-control" name ='ma_san_pham'readonly id="exampleFormControlInput1" value="" >
        </div>


        <div class="mb-3">
            <label for="exampleFormControlInput2" class="form-label">Tên sản phẩm</label>
            <input type="text" class="form-control" name ='ten_san_pham' id="exampleFormControlInput2" value="" required>
            <div class="invalid-feedback">
                Bạn cần nhập tên.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput3" class="form-label">Thể loại</label>
            <select id="exampleFormControlInput3"  name="ma_the_loai" class="form-select " aria-label="Default select example" required>
                <option value="" selected>---</option>
        
                
            </select>
            <div class="invalid-feedback">
                Bạn cần chọn thể loại.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput4" class="form-label">Đơn giá nhập</label>
            <input type="number"  class="form-control" min="1000"  name ='don_gia_nhap' id="exampleFormControlInput4" value="" required>
            <div class="invalid-feedback">
                Bạn cần nhập đơn giá nhập.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput5" class="form-label">Đơn giá bán</label>
            <input type="number"  class="form-control" min="1000" name ='don_gia_ban' id="exampleFormControlInput5" value="" required>
            <div class="invalid-feedback">
                Bạn cần nhập đơn giá bán.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput6" class="form-label">Giảm giá</label>
            <input type="number"  min="0" max="100" class="form-control" name ='giam_gia' id="exampleFormControlInput6" value="" >
        </div>

        <div class="mb-3">
            <label for="exampleFormControlInput7" class="form-label">Ảnh đại diện</label>
            <input type="file" class="form-control" name ='anh_dai_dien' id="image"  required>
            <div style="padding-top:20px"><img id="previewImage"  src="" alt="Preview Image" style="margin: auto; display: none; width: 500px; height:400px"></div>
            <div class="invalid-feedback">
                Bạn cần chọn ảnh đại diện.
            </div>
        </div>


        <div class="mb-3">
            <label for="exampleFormControlInput8" class="form-label">Ảnh chi tiết</label>
            <button class="btn btn-outline-secondary" type="button" data-bs-toggle="modal" data-bs-target="#exampleModal">
                <i class="fa fa-folder-open"></i>
            </button>
            <input id="input-image" hidden type="text" name="image_list" class="form-control" placeholder="" required>
            <div class="row" id="show-imgeList">
                
            </div>
            <div class="invalid-feedback">
                Bạn cần chọn ảnh chi tiết sản phẩm.
            </div>
        </div>

        <div class="mb-3">
            <label for="exampleFormControlTextarea1" class="form-label">Mô tả</label>
            <textarea class="form-control" name ='mo_ta' id="Create_SanPham_ckeditor" rows="3" required ></textarea>
            <div class="invalid-feedback">
                Bạn cần nhập mô tả.
            </div>
        </div>
        <div class="col-12">
            <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
            <a href=""class="btn btn-dark">Quay lại</a>
        </div>
    </form>
<script>
  
    
        $('#exampleModal').on('hide.bs.modal', event=>
        {
            $('.modal-backdrop').hide();
            $('#show-imgeList').html('');
            var _link = $('#input-image').val();
            var _html = '';
            if(_link!='')
            {
                if(_link[0]==='[')
                {
                    var arrs =  $.parseJSON(_link);
                    for(var i=0;i<arrs.length;i++)
                    {
                        var _url = "{{ asset('IMG_SanPham') }}"+'/'+arrs[i];
                        _html += `<div class="col-md-3"><img id="img-show" src="` + _url + `" alt="" style="width:100%;height:220px;margin-top: 20px;"></div>`;
                    }
                    $('#input-image').val(arrs);
                } 
                else
                {
                    var _url = "{{ asset('IMG_SanPham') }}"+'/'+_link;
                    _html += `<div class="col-md-3"><img id="img-show" src="` + _url + `" alt="" style="width:100%;height:220px;margin-top: 20px;"></div>`;
                }
                $('#show-imgeList').html(_html);

            }
            
            
        });
</script>
