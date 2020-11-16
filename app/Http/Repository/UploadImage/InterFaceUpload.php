<?php
namespace  App\Http\Repository\UploadImage;
interface InterFaceUpload{
    //store upload
    public  function  store($file);
    public  function  setUrl($value);
    public function delete($file);
    //lấy đường dẫn
    public  function  geturl();
    //lấy ra thông tin meta data đó
    public  function  metaUpload($file);
    //lấy ra thông tin upload
    public  function  infoUpload($file);
    //lấy ra đường dẫn path
    public function  getFilePatch($file);
    //nén file hình lại
    public function  compresImage($file);
    // file
    public  function  createFolder();


}
