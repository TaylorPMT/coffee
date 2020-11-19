@extends('BackEnd.layout.layoutsite')
@section('title', $controllerName)
@section('head')
    @include('BackEnd.scripts.css')
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
<div class="container-fluid">
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
    <div class="col-md-12">
    <div class="card">
       <div class="card-header card-header-primary">
        <h4 class="card-title ">{{ $controllerName }}</h4>
        <p class="card-category">{{$controllersDes}}</p>
       </div>
       <div class="card-body">
        <form action="{{ Route('admin.updateProfile') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="row">

              <div class="col-md-8">
                <div class="form-group">
                  <label class="bmd-label-floating">Tên Đầy Dủ </label>
                  <input type="text" name="full_name" value="{{ Auth::guard('admin')->user()->name }}" class="form-control">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label class="bmd-label-floating">Email </label>
                  <input type="email" name="email" value="{{ Auth::guard('admin')->user()->email}}"  class="form-control">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label class="bmd-label-floating">Mật Khẩu Mới </label>
                  <input type="text" name="password" class="form-control">
                </div>
              </div>

            </div>


            <button type="submit" class="btn btn-primary pull-right">Cập Nhật Thông Tin</button>
            <div class="clearfix"></div>
          </form>
       </div>
       @include('BackEnd.pages.banner.modal.confirm')
@endsection

@section('script')
    @include('BackEnd.scripts.js')

@endsection
