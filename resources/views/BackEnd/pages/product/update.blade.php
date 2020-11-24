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
                        <strong>{{ $type['message'] }}
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
        <form action="{{Route('admin.productUpdate',$product->id)}}" method="POST" enctype="multipart/form-data">
            <div class="row">
                <div class="col-md-8">
                        @csrf
                        <div class="form-group">
                            <label for="title" class="size">Tên Sản Phẩm</label>
                            <input type="text" class="form-control" value="{{ $product->name }}" name="name" minlength="5">
                        </div>
                        <div class="form-group">
                            <label  class="size">Mô Tả Về Sản Phẩm</label>
                            <br>
                            <textarea class="form-control" name="mota" id="exampleFormControlTextarea1" rows="4">{{ $product->mota }} </textarea>
                          </div>
                        <div class="form-group">
                            <label  class="size">Loại Danh Mục</label>
                            <select class="form-control" data-style="btn btn-link" name="id_madm">
                                <option value="{{ $product->id_madm }}">---{{ $product->getNameCategory->name }}---</option>
                                @foreach ($category as $item)
                                   <option value="{{ $item->id }}" checked>{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="size">Giá Gốc Sản Phẩm</label>

                            <input type="number" value="{{ $product->gia }}" class="form-control" name="gia" >
                        </div>
                        <div class="form-group">
                            <label class="size">Giá Khuyến Mãi <small>Nếu Không Có Giá Khuyến Mãi Thì Nhập 0</small> </label>
                            <input type="number" value="{{ $product->gia_km }}" class="form-control" name="gia_km" >
                        </div>
                </div>
                <div class="col-md-4 image-detail">

                    <div class="width-file">
                        <img src="{{ $product->hinhanh }}" style="display: block">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                            <span class="btn btn-raised btn-round btn-default btn-file">
                                <span class="fileinput-new">Ảnh Miêu Tả </span>
                                <span class="fileinput-exists">Sản Phẩm</span>
                                <input type="file" name="hinhanh"  />
                            </span>
                                {{-- <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a> --}}
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="size">Trạng thái sản phẩm</label>
                        <div class="radio-list">
                                <label>
                                <input type="radio" name="trangthai" value="0" {{ $product->trangthai==0 ? 'checked':'' }}/>Không hoạt động</label>
                                <br>
                                <label>
                                <input type="radio" name="trangthai" value="1" {{ $product->trangthai==1 ? 'checked':'' }} />Hoạt động</label>
                        </div>
                    </div>
                    {{-- <div class="row">
                        <div class="col-md-12 d-flex justify-content-center">
                                <a href="#"  class="btn btn-sm btn-append-input">Thêm Input Thêm Sản Phẩm </a>
                        </div>
                    </div> --}}
                </div>
            </div>

        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Sửa Sản Phẩm
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
        CKEDITOR.replace( 'mota',options);
        // CKEDITOR.replace( 'specifications',options);

    </script>
@endsection
