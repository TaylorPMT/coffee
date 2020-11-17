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
                <form action="{{Route('admin.categorySave')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Tên thể loại</label>
                        <input type="text" class="form-control" name="name" minlength="5" >
                    </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Thêm Thể Loại
                </button>
                </form>
            </div>
        </div>
    </div>
                    {{-- /**include modal confirm **/--}}
@endsection
@section('script')

@endsection
