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
                <form action="{{Route('admin.guaranteeUpdate',$guarantee->id)}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Thời gian bảo hành</label>
                        <input type="text" class="form-control" value="{{ $guarantee->time }}" name="time" minlength="5" maxlength="20">
                    </div>
                    <div class="form-group">
                        <label class="control-label">Trạng thái</label>
                            <div class="radio-list">
                                <label>
                                <input type="radio" name="status" value="0" {{ $guarantee->status ==0 ?"checked":"" }} />Không hoạt động</label>
                                <br>
                                <label>
                                <input type="radio" name="status" value="1" {{ $guarantee->status ==1 ?"checked":"" }}  />Hoạt động</label>
                            </div>
                    </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Sửa Thời Gian Bảo Hành
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
