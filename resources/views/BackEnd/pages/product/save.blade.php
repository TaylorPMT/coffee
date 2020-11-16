@extends('BackEnd.layout.layoutsite')
@section('title', $controllerName)
@section('head')
    @include('BackEnd.scripts.css')
    <style>
        img{
            max-height: 100px;
            max-width: 100px;
        }
        .form-group{
            margin: 40px 0;
            line-height: 1.5;
        }
        .size{
            display: block;
            font-size: 1.3rem !important;
            color: #9C27B0 !important;
            font-weight: 500;


        }
        .width-file{
            width: 100px;
        }
    </style>
@endsection
@section('content')

    <div class="container-fluid my-5">
        <div class="row">
            <div class="col-md-12">
                @if (session('message'))
                    @php
                        $type=session('message');
                    @endphp
                    <div class="alert alert-{{ $type['type'] }} alert-dismissible fade show" role="alert">
                        <strong>{{ $type['msg'] }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                          <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                @endif
                @if ($errors->any())

                @foreach ($errors->all() as $item)
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <strong>{{ $item }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>



                @endforeach

             @endif
              </div>
        </div>
        <form action="{{Route('admin.productSave')}}" method="POST" enctype="multipart/form-data">
        <div class="row">
            <div class="col-md-8">

                    @csrf
                    <div class="form-group">
                        <label for="title" class="size">Tên Sản Phẩm</label>
                        <input type="text" class="form-control" name="name" minlength="5" maxlength="20" required>
                    </div>
                    <div class="form-group">
                        <label  class="size">Loại Sản Phẩm</label>
                        <select class="form-control" data-style="btn btn-link" name="category_detail_id">
                            @foreach ($categoryDetal as $item)
                               <option value="{{ $item->id }}" checked>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label  class="size">Nơi Xuất Xứ</label>
                        <select class="form-control " data-style="btn btn-link" name="origin_id">
                            @foreach ($origin as $item)
                               <option value="{{ $item->id }}" checked>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label  class="size">Thương Hiệu</label>
                        <select class="form-control " data-style="btn btn-link" name="brands_id">
                            @foreach ($brands as $item)
                               <option value="{{ $item->id }}" checked>{{ $item->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="size">Thời Gian Bảo Hành </label>
                        <select class="form-control " data-style="btn btn-link" name="guarantee_id">
                            @foreach ($guarantee as $item)
                               <option value="{{ $item->id }}" checked>{{ $item->time }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label  class="size">Thẻ Từ Khóa Seo <small> Không Quá 100 kí tự </small></label>

                        <input type="meta_key" class="form-control" name="meta_key" required>
                    </div>
                    <div class="form-group">
                        <label  class="size">Mô Tả Chi Tiết Seo <small> Không Quá 100 kí tự </small></label>

                        <input type="meta_desc" class="form-control" name="meta_desc" required>
                    </div>
                    <div class="form-group">
                        <label class="size">Giá Gốc Sản Phẩm</label>

                        <input type="number" class="form-control" name="price" required>
                    </div>
                    <div class="form-group">
                        <label class="size">Giá Gốc Khuyến Mãi <small>Nếu Không Có Giá Khuyến Mãi Thì Nhập 0</small> </label>
                        <input type="number" class="form-control" name="price_sale" >
                    </div>
            </div>
            <div class="col-md-4 image-detail">
                <div class="width-file">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <div>
                        <span class="btn btn-raised btn-round btn-default btn-file">
                            <span class="fileinput-new"> Đại Diện</span>
                            <span class="fileinput-exists">Sản Phẩm</span>
                            <input type="file" name="image" required />
                        </span>
                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>
                </div>
                <div class="width-file">
                    <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                        <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                        <div>
                        <span class="btn btn-raised btn-round btn-default btn-file">
                            <span class="fileinput-new">Ảnh Miêu Tả </span>
                            <span class="fileinput-exists">Sản Phẩm</span>
                            <input type="file" name="detail_image[]"  />
                        </span>
                            <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12 d-flex justify-content-center">
                            <a href="#"  class="btn btn-sm btn-append-input">Thêm Input Thêm Sản Phẩm </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label  class="size">Mô Tả Về Sản Phẩm</label>
                    <textarea class="form-control" name="detail" id="exampleFormControlTextarea1" rows="4"></textarea>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="form-group">
                    <label  class="size">Mô Tả Về Thông Số Kỹ Thuật</label>
                    <textarea class="form-control" name="specifications" id="exampleFormControlTextarea1" rows="4"></textarea>
                  </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Thêm Sản Phẩm
                </button>
                </form>
            </div>
        </div>

    </div>
    {{-- /**include modal confirm **/--}}
@endsection
@section('script')
    @include('BackEnd.scripts.js')
    <script src="http://cdn.ckeditor.com/4.15.0/full/ckeditor.js"></script>
    <script src="/vendor/unisharp/laravel-ckeditor/adapters/jquery.js"></script>

    <script>

        $(document).on('click','.btn-append-input',function(event){
            event.preventDefault();

            $(".image-detail").append("<div class='width-file'><div class='fileinput fileinput-new text-center' data-provides='fileinput'><div class='fileinput-preview fileinput-exists thumbnail img-raised'></div><div><span class='btn btn-raised btn-round btn-default btn-file'><span class='fileinput-new'>Ảnh Miêu Tả</span><span class='fileinput-exists'>Sản Phẩm</span><input type='file' name='detail_image[]'  /></span><a href='#pablo' class='btn btn-danger btn-round fileinput-exists' data-dismiss='fileinput'><i class='fa fa-times'></i>Remove</a></div></div></div>");

        });



    </script>
    <script>
        var options = {
            filebrowserImageBrowseUrl: '/laravel-filemanager?type=Images',
            filebrowserImageUploadUrl: '/laravel-filemanager/upload?type=Images&_token=',
            filebrowserBrowseUrl: '/laravel-filemanager?type=Files',
            filebrowserUploadUrl: '/laravel-filemanager/upload?type=Files&_token='
          };
        CKEDITOR.replace( 'detail',options);
        CKEDITOR.replace( 'specifications',options);


    </script>
@endsection
