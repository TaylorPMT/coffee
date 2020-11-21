<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\NewsCategory;
use App\Models\NewsModel;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    //
    protected $_model;
    public function __construct(NewsModel $NewsModel)
    {
        $this->_model=new RepositoryHome($NewsModel);


    }
    public function getAll(Request $request)
    {
        return response()->json($this->_model->getAllE());
    }
    public function getCategory(Request $request,$id_dm)
    {
        return response()->json($this->_model->whereE([['id_dmtintuc','=',$id_dm]]));
    }
}
