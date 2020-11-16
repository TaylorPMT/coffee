@extends('BackEnd.layout.layoutsite')
@section('title', $controllerName)
@section('head')
    @include('BackEnd.scripts.css')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        {{-- <div class="col-md-10 d-flex justify-content-end">
            <a href="{{Route('admin.newsSave')}}" class="btn btn-primary btn-round"  style="color: white;">
                <i class="material-icons">add_circle_outline</i> Thêm Tin Tức
            </a>
        </div> --}}
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
                    <th>#</th>
                   <th>
                     Mã đơn hàng
                   </th>
                   <th>
                    Người cập nhật
                  </th>
                  <th>
                    Họ và tên khách hàng
                  </th>
                  <th>
                   Số điện thoại
                  </th>
                  <th>
                   Email
                  </th>
                  <th>
                   Tổng tiền
                  </th>
                  <th>
                    Trạng thái
                   </th>
                   <th>
                    Ngày lập đơn
                   </th>
                  <th>Hành động</th>
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
        $(document).ready(function(){
            var vietname="{{ asset('BackEnd/jtable/Vietnamese.json') }}";
            $('#myTable').DataTable({
                processing:true,
                serverSide:true,
                language: {
                    "url": vietname
                },
                ajax: '{{ Route('admin.ordersFetchIndex') }}',
                columns:[
                    {render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    {data:'id',name:'id'},
                    {data:'admin_id',name:'admin_id'},
                    {data:'full_name',name:'full_name'},
                    {data:'phone',name:'phone'},
                    {data:'email',name:'email'},
                    {data:'price',name:'price'},
                    {data:'status',name:'status'},
                    {data:'created_at',name:'created_at'},
                    {data:'action',name:'action'},
                ]
            });
              //phần này xử lý jquery ajax để xóa data hoặc update
            //xóa dữ liệu
            var id;
            $(document).on("click",".delete",function (){
               id= $(this).val();
               //gọi modal để xác nhận ý kiến nếu ok mới xóa dữ liệu
               $('.modal-delete').modal('show');

            });
            $("#btn-confirm").click(function (){
                let url ="{{Route('admin.ordersDelete',':id')}}";
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
                        setTimeout(function (){
                            $('.modal-delete').modal('hide');
                            $("#myTable").DataTable().ajax.reload();
                        },2000);
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
                let url ="{{Route('admin.ordersUpdateStatus',':id')}}";
                url=url.replace(':id',update);
                $.ajax({
                    url:url,
                    type:'GET',
                    success:function (data)
                    {
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
