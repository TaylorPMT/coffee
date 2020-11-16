<link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<!doctypehtml>
<html>
   <head>
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <!-- jQuery library -->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
      <!-- Latest compiled JavaScript -->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
      <link rel="stylesheet" href="path/to/font-awesome/css/font-awesome.min.css">
      <link rel="stylesheet" href="{{ asset('BackEnd\css\login.css') }}">
      <link rel="stylesheet" type="text/css" href="personal-style.css">
   </head>
   <body>
      <div class="container">
         <br/>
         <br/>
         <br/>
         <br/>
         <br/>
         <div class="row">
            <div class="col-md-12" id="login">
               <form action="{{ Route('admin.postLogin') }}" method="POST" enctype="multipart/form-data">
                @csrf
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon" id="iconn"> <i class="glyphicon glyphicon-user"></i></span>
                        <input type="text" class="form-control" id="text1" name="email" placeholder="Tài khoản" required>
                     </div>
                  </div>
                  <div class="form-group">
                     <div class="input-group">
                        <span class="input-group-addon" id="iconn1"> <i class="glyphicon glyphicon-lock"></i></span>
                        <input type="password" class="form-control" id="text2" name="password" placeholder="Mật khẩu" required>
                     </div>
                  </div>
                  <div class="form-group">
                    <div style="margin-top:50px;" class="d-flex justify-content-center">
                        {{--  <input type="submit" class="btn btn-success" value="Đăng Nhập" style="border-radius:30px; width: 100%">  --}}
                        <button type="submit" class="btn btn-success" style="border-radius:30px;">
                            Đăng Nhập
                        </button>

                    </div>
                  </div>
                  <br/><br/><br/>

               </form>
            </div>



         </div>
      </div>
   </body>
</html>
