<?php

namespace Phpding\FastCache\FileCache;

/**
 * Created by PhpStorm.
 * User: hanli
 * Date: 16-4-21
 * Time: 上午11:46
 */
class FileCache
{
    /**
     * cache path
     * @var string
     */
    protected $path;

    /**
     * FileCache constructor.
     * @param $path
     */
    public function __construct($path)
    {
        $this->path=$path;
    }

    /**
     * @param $key
     * @param $value
     * @param int $second
     * @return int
     * @throws \Phpding\FastCache\FileCache\PutCacheFailException
     */
    public function put($key,$value,$second=9999999999)
    {
        if(!$this->createDirectory($fileName=$this->getFileName($key))){

            throw new PutCacheFailException('Put cache fail at path '.$this->path.' may not have permission ');
        }

        $value=(time()+$second).serialize($value);

        return file_put_contents($fileName,gzcompress($value),LOCK_EX);
    }

    /**
     * get cached value by key
     * @param $key
     * @return null|value
     */
    public function get($key){

        $fileName=$this->getFileName($key);

        if(!$value=file_get_contents($fileName)){
            return null;
        }

        $value=gzuncompress($value);

        $expire = substr($value, 0, 10);

        if(time()>=$expire){

            $this->delete($key);

            return null;
        }

        return unserialize(substr($value,10));
    }

    /**
     * delete cache
     * @param $key
     * @return bool
     */
    public function delete($key)
    {
        $fileName=$this->getFileName($key);

        if(!file_exists($fileName)){
            return false;
        }

        return unlink($fileName);
    }

    /**
     * get file name function
     * @param $key
     * @return string
     */
    protected function getFileName($key)
    {
        $sub=array_slice(str_split($hash=md5($key),4),0,2);

        return $this->path.'/'.implode('/',$sub).'/'.$hash;

    }

    /**
     * create sub directory
     * @param $fileName
     * @return bool
     */
    protected function createDirectory($fileName)
    {
        if(!file_exists($path=dirname($fileName))){

            return mkdir($path,0755,true);
        }

        return true;
    }

}
