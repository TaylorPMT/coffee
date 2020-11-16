<?php
namespace  App\Http\Repository\UploadImage;
use App\Http\Repository\UploadImage\InterFaceUpload;
use File;
use Str;
class  RepositoryUploadImage implements  InterFaceUpload{
    public $url;
    public  function  store($file){

    }
    //delete
    public function delete($file){
        Storage::delete($file);
        return true;
    }
    //lấy đường dẫn
    public  function  setUrl($value)
    {
        $this->url=$value;
      }
    public  function  geturl(){
        return strval($this->url);
    }

    public  function  createFolder()
    {
        $path =realpath(storage_path('app/public') ).$this->geturl() ;


        if(!File::exists($path))
        {
            $result=File::makeDirectory($path);
            return true;
        }else
        {
            return  false;//đã tồn tại
        }
    }
    //lấy ra thông tin meta data đó
    public  function  metaUpload($file){

    }
    //lấy ra thông tin upload
    public  function  infoUpload($file){

    }
    //lấy ra đường dẫn path
    public function  getFilePatch($file){

    }
    //compressImage
    public  function compresImage($file)
    {
        $info_file=[
            'image/png',
            'image/jpg',
            'image/jpeg',
            'image/gif'
        ];
        if($file)
        {
            if(!in_array($file->getmimeType(),$info_file))
            {
                return false;
            }else{
                $checkType=$file->getmimeType();
                $file_name = time();
                $file_name .= rand();
                $file_name = sha1($file_name);
                switch ($checkType)
                {
                    case  'image/png':
                        $ext='png';

                        break;
                    case   'image/jpg':
                        $ext='jpg';
                        break;
                    case  'image/gif':
                        $ext='gif';
                        break;
                    default:
                        $ext='jpg';


                }

                $imageUrl=$file_name.'.'.$ext;
                $this->createFolder();
                $file->move(realpath(storage_path('app/public'.$this->geturl())) , $imageUrl);
                $localhost='http://127.0.0.1:8000/';
             
                return $localhost.'storage'.$this->geturl().$imageUrl;
                


            }
        }else
        {
            return false;
        }
    }
}
