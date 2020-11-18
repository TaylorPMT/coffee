@extends('BackEnd.layout.layoutsite')
@section('title', $controllerName)
@section('head')
@include('BackEnd.scripts.css')
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
        <div class="col-md-10 d-flex justify-content-end">
            <a href="{{Route('admin.productSave')}}" class="btn btn-primary btn-round" style="color: white;">
                <i class="material-icons">add_circle_outline</i> Thêm Sản Phẩm
            </a>
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
                    <div class="table-responsive">
                        <table class="table" id="myTable">
                            <thead class=" text-primary">

                                <th>
                                    #
                                </th>
                                <th>
                                    Tên Sản Phẩm
                                </th>
                                <th>
                                    Mô tả
                                </th>
                                <th>
                                    Hình Ảnh
                                </th>
                                <th>
                                    Giá
                                </th>
                                <th>
                                    Giá khuyến mãi
                                </th>
                                <th>
                                    Loại danh mục
                                </th>
                                <th>Trạng thái</th>

                                <th>Hành Động</th>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
                @include('BackEnd.pages.banner.modal.confirm')
                @endsection

                @section('script')
                @include('BackEnd.scripts.js')
                <script>
                    $(document).ready(function () {
                        var vietname = "{{ asset('BackEnd/jtable/Vietnamese.json') }}";
                        $('#myTable').DataTable({
                            processing: true,
                            serverSide: true,
                            language: {
                                "url": vietname
                            },
                            ajax: '{{ Route('admin.productAjax') }}',
                            columns: [{
                                    render: function (data, type, row, meta) {
                                        return meta.row + meta.settings._iDisplayStart + 1;
                                    }
                                },
                                {
                                    data: 'name',
                                    name: 'name'
                                },
                                {
                                    data: 'mota',
                                    name: 'mota'
                                },
                                {
                                    data: 'hinhanh',
                                    name: 'hinhanh'
                                },
                                {
                                    data: 'gia',
                                    name: 'gia'
                                },

                                {
                                    data: 'gia_km',
                                    name: 'gia_km'
                                },
                                {
                                    data: 'id_madm',
                                    name: 'id_madm'
                                },
                                {
                                    data: 'trangthai',
                                    name: 'trangthai'
                                },

                                {
                                    data: 'action',
                                    name: 'action'
                                },

                            ]
                        });
                          //phần này xử lý jquery ajax để xóa data hoặc update
            //xóa dữ liệu
            var id;
            $(document).on("click",".delete",function (){
               id= $(this).val();
               $("#btn-confirm").text("Đồng Ý");
               //gọi modal để xác nhận ý kiến nếu ok mới xóa dữ liệu
               $('.modal-delete').modal('show');

            });
            $("#btn-confirm").click(function (){

                let url ="{{ Route('admin.productDelete',':id') }}";

                url=url.replace(':id',id);
                $.ajax({
                    url:url,
                    beforeSend:function (){
                        $("#btn-confirm").text("Đang Xóa");
                    },
                    type:'GET',
                    success:function (data)
                    {
                        console.log(data);
                        $("#btn-confirm").text(data.message);
                        if(data.type ==true)
                        {
                            setTimeout(function (){
                                $('.modal-delete').modal('hide');
                                $("#myTable").DataTable().ajax.reload();
                            },2000);
                        }
                    }
                });
            });
            //end xóa dữ liệu
            //notify
            function showNotification(from, align,message){
                $.notify({
                    icon: "add_alert",
                    message: message,

                },{
                    type: 'success',
                    timer: 1000,
                    placement: {
                        from: from,
                        align: align
                    }
                });
                };

                // var update
                var update;
                $(document).on("click",".update_status",function (){
                update=$(this).val();
                console.log(update);
                let url ="{{Route('admin.productUpdateStatus',':id')}}";
                url=url.replace(':id',update);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function (data)
                    {
                        console.log(data)
                        showNotification('top','right',data.message);
                        setTimeout(function (){
                            $('#myTable').DataTable().ajax.reload();
                        },2000);
                    },
                });
            });
            //End Update
                    });
                </script>
                @endsection
