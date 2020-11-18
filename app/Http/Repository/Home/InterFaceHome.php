<?php
namespace App\Http\Repository\Home;

interface InterFaceHome{
    //lấy ra tất cả của tk đó
    public function getAllE();
    //tìm 1 tk
    public function findOrFailE($id);
    //tìm kiếm dk
    public function whereE(array $where);

    //xóa theo id
    public function deleteIdE($id);
    //thêm sản phẩm
    public function createDataE(array $data);


}
