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
                <form action="{{Route('admin.update',$dataAdmin->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="title">Email</label>
                        <input type="text" value="{{ $dataAdmin->name }}" class="form-control" name="name"  required>

                    </div>
                    <div class="form-group">
                        <label for="title">Email</label>
                        <input type="text" value="{{ $dataAdmin->email  }}" class="form-control" name="email"  required>

                    </div>
                    <div class="form-group">
                        <label for="title">Số Điện  Thoại</label>
                        <input type="text" value="{{ $dataAdmin->sdt }}" class="form-control" name="sdt"  required>

                    </div>

            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label for="title">Địa Chỉ</label>
                    <input type="text" value="{{ $dataAdmin->diachi }}" class="form-control" name="diachi"   required>

                </div>
                <div class="form-group">

                    <label class="size">Trạng thái sản phẩm</label>
                    <div class="radio-list">
                            <label>
                            <input type="radio" name="trangthai" value="0" {{ $dataAdmin->trangthai==0 ? 'checked':'' }}/>Không hoạt động</label>
                            <br>
                            <label>
                            <input type="radio" name="trangthai" value="1" {{ $dataAdmin->trangthai==1 ? 'checked':'' }} />Hoạt động</label>
                    </div>
                </div>
                <div class="form-group">

                    <label class="size">Phân quyền</label>
                    <div class="radio-list">
                            <label>
                            <input type="radio" name="role" {{ $dataAdmin->role==0 ? 'checked':'' }} value="0"/>Không Có Quyền</label>
                            <br>
                            <label>
                            <input type="radio" name="role" {{ $dataAdmin->role==1 ? 'checked':'' }} value="1" />Full Quyền</label>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Cập Nhật Banner
                </button>
                </form>
            </div>
        </div>
    </div>
                    {{-- /**include modal confirm **/--}}
@endsection
@section('script')


@endsection
