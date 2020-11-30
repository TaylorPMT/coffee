<div class="sidebar" data-color="purple" data-background-color="white" data-image="{{asset('assets/img/sidebar-1.jpg')}}">

    <div class="logo"><a  class="simple-text logo-normal">
          Quản lý
      </a></div>
    <div class="sidebar-wrapper">
      <ul class="nav">
        <li class="nav-item ">
            <a class="nav-link" href="{{ Route('admin.tableadmin') }}">
              <i class="material-icons">groups</i>
              <p>Quản Lý Admin</p>
            </a>
          </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ Route('admin.bannerIndex') }}">
              <i class="material-icons">view_carousel</i>
              <p>Quản Lý Banner</p>
            </a>
          </li>
        <li class="nav-item ">
          <a class="nav-link" href="{{ Route('admin.categoryIndex') }}">
            <i class="material-icons">local_offer</i>
            <p>Quản Lý Loại Sản Phẩm</p>
          </a>
        </li>
        <li class="nav-item ">
            <a class="nav-link" href="{{ Route('admin.productIndex') }}">
              <i class="material-icons">content_paste</i>
              <p>Quản Lý Sản Phẩm</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="{{ Route('admin.orderIndex') }}">
              <i class="material-icons">shopping_cart</i>
              <p>Quản Lý Đơn Hàng</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="{{ Route('admin.customerIndex') }}">
              <i class="material-icons">group_add</i>
              <p>Quản Lý Khách Hàng</p>
            </a>
          </li>
          <li class="nav-item ">
            <a class="nav-link" href="{{ Route('admin.newsCategoryIndex') }}">
              <i class="material-icons">filter_frames</i>
              <p>Quản Lý Tin Tức</p>
            </a>
          </li>
        <li class="nav-item ">
          <a class="nav-link" href="./rtl.html">
            <i class="material-icons">language</i>
            <p>RTL Support</p>
          </a>
        </li>
      </ul>
    </div>
  </div>
