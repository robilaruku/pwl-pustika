<?php

namespace Core;

class UploadedFile
{

    /** @var array */
    protected $file = [];

    public function __construct($file)
    {
        $file['name'] = pathinfo($file['name']);
        $this->file = $file;
    }


    /**
     * Get Filename without Extension
     *
     * @return string
     */
    public function getFileName()
    {
        return $this->file['name']['filename'];
    }


    /**
     * Get Extension of file 
     *
     * @return string
     */
    public function getExtension()
    {
        return $this->file['name']['extension'];
    }


    /**
     * Get Filename with extension aka Basename
     *
     * @return string
     */
    public function getFileNameWithExt()
    {
        return $this->file['name']['basename'];
    }


    /**
     * Get Temp name with path
     *
     * @return string
     */
    public function getTempName()
    {
        return $this->file['tmp_name'];
    }


    /**
     * Get file size in kb
     *
     * @return float
     */
    public function getSize()
    {
        return $this->file['size'] / 1024;
    }


    /**
     * Move uploaded file tp storage{App\Config} directory
     *
     * @param string $path path inside storage directory can contain filename 
     * @param string $filename Filename without extension. Leave empty for unique and random one 
     * @param string $prefix Prefix to be attached
     * @return boolean Whether or not file was successfully uploaded
     */
    public function moveTo($path = "", $filename = "", $prefix = "")
    {
        $path = app()->getConfig()::getPublicStoragePath() . $path . '/';
        if (!is_dir($path)) mkdir($path, 0777, true);
        $filename = ($filename ?: uniqid($prefix, true)) . '.' . $this->getExtension();
        $res = move_uploaded_file(
            $this->file['tmp_name'],
            $path . $filename
        );
        return $filename;
    }
}