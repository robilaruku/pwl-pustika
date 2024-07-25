<?php

namespace Core;

class UploadedFile
{
    /** @var array */
    protected $file = [];

    /**
     * Constructor
     *
     * @param array $file Uploaded file information from $_FILES
     */
    public function __construct(array $file)
    {
        $file['name'] = pathinfo($file['name']);
        $this->file = $file;
    }

    /**
     * Get Filename without Extension
     *
     * @return string
     */
    public function getFileName(): string
    {
        return $this->file['name']['filename'];
    }

    /**
     * Get Extension of file 
     *
     * @return string
     */
    public function getExtension(): string
    {
        return $this->file['name']['extension'];
    }

    /**
     * Get Filename with extension aka Basename
     *
     * @return string
     */
    public function getFileNameWithExt(): string
    {
        return $this->file['name']['basename'];
    }

    /**
     * Get Temp name with path
     *
     * @return string
     */
    public function getTempName(): string
    {
        return $this->file['tmp_name'];
    }

    /**
     * Get file size in kb
     *
     * @return float
     */
    public function getSize(): float
    {
        return $this->file['size'] / 1024;
    }

    /**
     * Move uploaded file to storage directory
     *
     * @param string $path Path inside the public storage directory
     * @param string $filename Filename without extension. Leave empty for a unique and random one
     * @param string $prefix Prefix to be attached
     * @return string|false Filename if successfully uploaded, false otherwise
     */
    public function moveTo(string $path = "", string $filename = "", string $prefix = "")
    {
        // Ensure the path is within the public/storage directory
        $fullPath = public_path('storage/' . $path);

        // Create the directory if it doesn't exist
        if (!is_dir($fullPath)) {
            mkdir($fullPath, 0777, true);
        }

        // Generate a unique filename if not provided
        $filename = ($filename ?: uniqid($prefix, true)) . '.' . $this->getExtension();

        // Move the file to the desired location
        $moved = move_uploaded_file($this->file['tmp_name'], $fullPath . '/' . $filename);

        return $moved ? $filename : false;
    }
}
