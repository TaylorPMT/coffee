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
        <div class="row">
            <div class="col-md-8">
                <form action="{{Route('admin.customerUpdate',$customer->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tên khách hàng</label>
                        <input type="text" class="form-control" value="{{ $customer->ten }}" name="ten">
                    </div>
                    <div class="form-group">
                        <label for="title">Email</label>
                        <input type="text" class="form-control" value="{{ $customer->email }}" name="email">
                    </div>
                    <div class="form-group">Mật khẩu</label>
                        <input type="password" class="form-control" value="{{ $customer->password }}" name="password">
                    </div>
                    <div class="form-group">
                        <label for="title">Địa chỉ</label>
                        <input type="text" class="form-control" value="{{ $customer->diachi }}" name="diachi">
                    </div>
                    <div class="form-group">
                        <label for="title">Số điện thoại</label>
                        <input type="text" class="form-control" value="{{ $customer->sdt }}" name="sdt">
                    </div>
                    <div class="form-group">
                        <label for="title">Ghi chú</label>
                        <textarea name="ghichu" class="form-control"> {{ $customer->ghichu }}</textarea>
                    </div>
                    <div class="form-group">
                        <label class="size">Trạng thái</label>
                        <div class="radio-list">
                                <label>
                                <input type="radio" name="trangthai" value="0" {{ $customer->trangthai==0 ? 'checked':'' }}/>Chưa kích hoạt</label>
                                <br>
                                <label>
                                <input type="radio" name="trangthai" value="1" {{ $customer->trangthai==1 ? 'checked':'' }} />Kích hoạt</label>
                        </div>
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Sửa Khách Hàng
                </button>
                </form>
            </div>
        </div>
    </div>
                    {{-- /**include modal confirm **/--}}
@endsection
@section('script')
    @include('BackEnd.scripts.js')
@endsection
