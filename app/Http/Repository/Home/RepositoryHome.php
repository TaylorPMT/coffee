<?php

namespace App\Http\Repository\Home;

use App\Http\Repository\Home\InterFaceHome;

use Illuminate\Database\Eloquent\Model;

class RepositoryHome implements InterFaceHome{

    protected $_modelCall;
    public function __construct(Model $model)
    {
        $this->_modelCall=$model;
    }
    public function getAllE()
    {
        return $this->_modelCall->all();
    }
    //tìm kiếm theo id nếu lỗi không thấy thì redirect 404
    public function findOrFailE($id)
    {
        return $this->_modelCall->findOrFail($id);
    }
    public  function whereE(array $where)
    {

        return $this->_modelCall->where($where)->get();
    }
    public function deleteIdE($id)
    {
        return $this->_modelCall->findOrFail($id)->delete();
    }
    public function createDataE(array $data)
    {
        return $this->_modelCall->create($data);
    }
    public function updateDataE($id,array $data)
    {
        return $this->_modelCall->findOrFail($id)->update($data);
    }
    public function searchLikeE($column,$data)
    {
        return $this->_modelCall->where($column,'LIKE',"%{$data}%")->get();
    }

}
