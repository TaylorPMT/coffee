@extends('BackEnd.layout.layoutsite')
@section('title', $controllerName)
@section('head')
    @include('BackEnd.scripts.css')
@endsection
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-md-10 d-flex justify-content-end">
            <a href="{{Route('admin.productSave')}}" class="btn btn-primary btn-round"  style="color: white;">
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
                      Trạng Thái
                    </th>
                  <th>
                        Hình Ảnh
                  </th>
                  <th>
                    Giá / Giá Giảm
                  </th>

                    <th>
                        Người Tạo / Người Cập Nhật
                    </th>
                    <th>
                        Loại Sản Phẩm
                    </th>
                  <th>Thương Hiệu</th>
                   <th>Bảo Hành</th>
                   <th>Xuất Xứ</th>
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
        $(document).ready(function(){
            var vietname="{{ asset('BackEnd/jtable/Vietnamese.json') }}";
            $('#myTable').DataTable({
                processing:true,
                serverSide:true,
                language: {
                    "url": vietname
                },
                ajax: '{{ Route('admin.productFetchIndex') }}',
                columns:[
                    {render: function (data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }},
                    {data:'name',name:'name'},
                    {data:'status',name:'status'},
                    {data:'image',name:'image'},
                    {data:'price',name:'price'},

                    {data:'created_by',name:'created_by'},
                    {data:'category_detail_id',name:'category_detail_id'},
                    {data:'brands_id',name:'brands_id'},
                    {data:'guarantee_id',name:'guarantee_id'},
                    {data:'origin_id',name:'origin_id'},
                    {data:'action',name:'action'},


                ]
            });
             //phần này xử lý jquery ajax để xóa data hoặc update
            //xóa dữ liệu
            var id;
            $(document).on("click",".delete",function (){
               id= $(this).val();
               //gọi modal để xác nhận ý kiến nếu ok mới xóa dữ liệu
               $("#btn-confirm").text("Đồng Ý");
               $('.modal-delete').modal('show');

            });
            $("#btn-confirm").click(function (){
                let url ="{{Route('admin.productDelete',':id')}}";
                url=url.replace(':id',id);
                $.ajax({
                    url:url,
                    beforeSend:function (){
                        $("#btn-confirm").text("Đang Xóa");
                    },
                    type:'GET',
                    success:function (data)
                    {

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
                console.log(update);
                let url ="{{Route('admin.productUpdateStatus',':id')}}";
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
