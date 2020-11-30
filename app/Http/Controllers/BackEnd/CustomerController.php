<?php

namespace App\Http\Controllers\BackEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\CategorysModel;
use App\Models\MenuModel;
use App\Models\ProductModel;
use Illuminate\Support\Facades\View;
use App\Models\OrderDetailModel;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Carbon\Carbon;
use App\Library\Helper;
use App\Models\CustomersModel;

class CustomerController extends Controller
{
    public $_controllerName = "Quản Lý Khách Hàng ";
    public $_controllersDes = "Quản Lý Khách Hàng ";
    public $_root = 'BackEnd/pages/customer/';
    protected $_model;
    public function __construct(CustomersModel $CustomersModel)
    {
        $this->_model = new RepositoryHome($CustomersModel);
        View::share('controllerName', $this->_controllerName);
        View::share('controllersDes', $this->_controllersDes);
    }
    public function message($message, $type)
    {
        return [
            "message" => $message,
            "type" => $type,
        ];
    }
    public function index()
    {
        return view($this->_root . 'index');
    }
    public function getDataAjax(Request $request)
    {
        if ($request->ajax()) {
            $queryTable = $this->_model->getAllE();
            return DataTables::of($queryTable)
                ->addColumn('ten', function ($queryTable) {
                    $ten = $queryTable->ten;
                    return $ten;
                })->addColumn('email', function ($queryTable) {
                    $email = $queryTable->email;
                    return $email;
                })->addColumn('diachi', function ($queryTable) {
                    $diachi = $queryTable->diachi;
                    return $diachi;
                })->addColumn('sdt', function ($queryTable) {
                    $sdt = $queryTable->sdt;
                    return $sdt;
                })->addColumn('ghichu', function ($queryTable) {
                    $ghichu = $queryTable->ghichu;
                    return $ghichu;
                })->addColumn('trangthai', function ($queryTable) {
                    $trangthai='<button class="btn btn-primary btn-fab btn-fab-mini btn-round"><span class="material-icons">';
                    $trangthai.=$queryTable->trangthai==0?"visibility_off":"visibility";
                    $trangthai.='<span></button>';
                    return $trangthai;
                })->addColumn('action', function ($queryTable) {

                    $action = '<a href="' . url('quan-ly/customer/update/' . $queryTable->id) . '" class="btn btn-primary btn-round">
                     <i class="material-icons">';
                    $action .= "update";
                    $action .= '</i></a>';
                    $action.='<button class="btn btn-primary btn-round update_status" value='.$queryTable->id.'>
                    <i class="material-icons">';
                    $action.="block";
                    $action.='</button></i>';
                    return $action;
                })
                ->rawColumns(['ten','email','diachi','sdt','ghichu','trangthai','action'])->make('true');
        }
    }
    public function updateCustomer(Request $request,$id)
    {
        if ($request->isMethod('GET')) {
            $customer = $this->_model->findOrFailE($id);
            return view($this->_root . 'update', compact('customer'));
        } else {
            $rules = [
                'ten' => 'required',
                'email' => 'required|email',
                'sdt' => 'required|regex:/(0)[0-9]{9}/',
                'password' => 'required',
                'diachi' => 'required',
            ];
            $validator = validator()->make($request->all(), $rules, [
                'ten.required' => 'Tên khách hàng không được để trống',
                'email.required' => 'Email không được bỏ trống',
                'email.email' => 'Không đúng định dạng email',
                'sdt.required' => 'Số điện thoại không được bỏ trống',
                'sdt.regex' => 'Không đúng định dạng số điện thoại',
                'password.required' => 'Mật khẩu không được bỏ trống',
                'diachi.required' => 'Địa chỉ không được bỏ trống',
            ]);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
            $updateCustomer = $this->_model->findOrFailE($id);
            $dataAdd = [
                'ten' => $request->ten,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'sdt' => $request->sdt,
                'diachi' => $request->diachi,
                'ghichu' => $request->ghichu,
                'trangthai' => $request->trangthai,
                'created_at' => Carbon::now('Asia/Ho_Chi_Minh'),
                'updated_at' => Carbon::now('Asia/Ho_Chi_Minh'),
            ];
            $updateCustomer->update($dataAdd);
            return redirect()->route('admin.customerIndex')->with("message", $this->message("Sửa Thành Công", "success"));
        }
    }
    public function updateStatusCustomer(Request  $request,$id)
    {
        try {
          if($request->ajax())
          {
              $query = $this->_model->findOrFailE($id);
              $query->trangthai=$query->trangthai==0?1:0;
              $query->save();
              return response()->json(['message'=>'Cập Nhật Trạng Thái Thành Công','status'=>200]);
          }else
          {
              return redirect()->back();
          }
        }catch (\Exception $e)
        {
            return redirect()->back();
        }
    }
}
