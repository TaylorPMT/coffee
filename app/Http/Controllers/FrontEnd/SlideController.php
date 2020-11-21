<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Http\Repository\Home\RepositoryHome;
use App\Models\SlideModel;
use Illuminate\Http\Request;

class SlideController extends Controller
{
    //.
    protected $_model;
    public function __construct(SlideModel $SlideModel)
    {
        $this->_model=new RepositoryHome($SlideModel);


    }
    public function getAll(Request $request)
    {
        return response()->json($this->_model->getAllE());
    }
}
