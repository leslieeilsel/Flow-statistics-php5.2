<?php
class File
{
    //封装方法
    private $_dir;
    const EXT='.text';//文件后缀,定义为常量
    public function __contruct()
    {
        $this->_dir = dirname(__FILE__).'/files/';//默认存货缓存文件夹数据
    }

    //$key文件名,$path,路径
    public function cacheData($key,$value="",$path="")
    {
        $filename=$this->_dir.$path.$key.self::EXT;

        //有值,写入缓存
        if($value !=="") {
            $dir=dirname($filename);//判断目录是否存在
            if(!is_dir($dir)) {
                mkdir($dir, 0777);
            }
            return file_put_contents($filename, json_encode($value));//写入成功,返回数据,失败false
        }

        //读取缓存
        // if(!is_file($filename)){
        //     return FALSE;//文件不存在
        // }else{
        //     return json_decode(file_get_contents($filename),true);
        // }

    }
}
