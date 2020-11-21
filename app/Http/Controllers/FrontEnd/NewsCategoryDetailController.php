<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryDetailController extends Controller
{
    //
    protected $_model;
    public function __construct(NewsCategory $NewsCategory)
    {
        $this->_model=new RepositoryHome($NewsCategory);


    }
    public function getAll(Request $request)
    {
        return response()->json($this->_model->getAllE());
    }

}
