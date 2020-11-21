<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\CategorysModel;
use Illuminate\Http\Request;

class CategorysController extends Controller
{
    //
    protected $_model;
    public function __construct(CategorysModel $CategorysModel)
    {
        $this->_model=new RepositoryHome($CategorysModel);


    }
    public function getAll(Request $request)
    {
        return response()->json($this->_model->getAllE());
    }
}
