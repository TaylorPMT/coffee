@extends('BackEnd.layout.layoutsite')
@section('title', $controllerName)
@section('head')
    @include('BackEnd.scripts.css')
    <style>
        img{
            max-height: 100px;
            max-width: 100px;
        }
    </style>
     @include('BackEnd.scripts.js')
     <script>

           $(document).ready(function(){
             function showNotification(message,from, align){

                 $.notify({
                     icon: "add_alert",
                     message: message,

                 },{
                     type: 'danger',
                     timer: 2000,
                     placement: {
                         from: from,
                         align: align
                     }
                 });
              };
           });

     </script>
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
        <div class="row">
            <div class="col-md-8">
                <form action="{{Route('admin.categorydetailsSave',$id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Thể loại chi tiết</label>
                        <input type="text" class="form-control" name="name" minlength="5" >
                    </div>
                    <div class="form-group">
                        <label for="title">Từ khoá SEO</label>
                        <input type="text" class="form-control" name="meta_key" minlength="5" >
                    </div>
                    <div class="form-group">
                        <label for="title">Nội dung SEO</label>
                        <input type="text" class="form-control" name="meta_desc" minlength="5" >
                    </div>
                    <div class="form-group">
                        <label for="title">Thẻ ALT</label>
                        <input type="text" class="form-control" name="alt" minlength="5" >
                    </div>
                    <div class="form-group">
                        <label class="control-label">Trạng thái</label>
                            <div class="radio-list">
                                <label>
                                <input type="radio" name="status" value="0"/>Không hoạt động</label>
                                <br>
                                <label>
                                <input type="radio" name="status" value="1" checked="checked" />Hoạt động</label>
                            </div>
                    </div>
                    <div class="col-md-4">
                        <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                            <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                            <div>
                            <span class="btn btn-raised btn-round btn-default btn-file">
                                <span class="fileinput-new">Chọn Hình</span>
                                <span class="fileinput-exists">Thể Loại</span>
                                <input type="file" name="image" />
                            </span>
                                <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                            </div>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Thêm Chi Tiết Thể Loại
                </button>
                </form>
            </div>
        </div>
    </div>
                    {{-- /**include modal confirm **/--}}
@endsection
@section('script')

@endsection
