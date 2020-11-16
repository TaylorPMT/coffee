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
                <form action="{{Route('admin.bannerSave')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" name="title" minlength="5" maxlength="20" value="{{ old('title') }}" >
                    </div>


                    <div class="form-group">
                        <label for="title">Thẻ Miêu Tả</label>
                        <input type="text" class="form-control" value="{{ old('desc') }}" name="desc" minlength="5" maxlength="40" >

                    </div>
                    <div class="form-group">
                        <label for="title">Link Đường Dẫn</label>
                        <input type="text" value="{{ old('href') }}" class="form-control" name="href" minlength="5" maxlength="40" required>

                    </div>
                    <div class="form-group">
                        <label for="Chọn Vị Trí Banner" style="display: block;">Chọn Vị Trí Banner </label>
                        <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="order_id" id="inlineRadio1" checked value="1"> Trang Chủ
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>
                          <div class="form-check form-check-radio form-check-inline">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="order_id" id="inlineRadio2" value="2"> Sản Phẩm
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>
                          <div class="form-check form-check-radio form-check-inline disabled">
                            <label class="form-check-label">
                              <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled> Còn Nữa
                              <span class="circle">
                                  <span class="check"></span>
                              </span>
                            </label>
                          </div>
                    </div>

            </div>
            <div class="col-md-4">
                <div class="fileinput fileinput-new text-center" data-provides="fileinput">
                    <div class="fileinput-preview fileinput-exists thumbnail img-raised"></div>
                    <div>
                    <span class="btn btn-raised btn-round btn-default btn-file">
                        <span class="fileinput-new">Chọn Hình</span>
                        <span class="fileinput-exists">Ảnh Bìa</span>
                        <input type="file" name="image" required />
                    </span>
                        <a href="#pablo" class="btn btn-danger btn-round fileinput-exists" data-dismiss="fileinput"><i class="fa fa-times"></i> Remove</a>
                    </div>
                </div>

            </div>
        </div>
        <div class="row">
            <div class="col-md-12 d-flex justify-content-center">
                <button class="btn btn-primary btn-round" type="submit">
                    <i class="material-icons">add_box</i> Thêm Banner
                </button>
                </form>
            </div>
        </div>
    </div>
                    {{-- /**include modal confirm **/--}}
@endsection
@section('script')


@endsection
