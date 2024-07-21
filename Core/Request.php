<?php

namespace Core;

class Request
{
    /** @var array All required superglobals stored here */
    protected $paramBag = [];
    protected $isUploadedFilesConstructed = false;

    /**
     * Constructor to initialize the Request object with superglobals.
     *
     * @param array $get
     * @param array $post
     * @param array $files
     * @param array $server
     * @param array $cookie
     * @param array $request
     */
    public function __construct($get, $post, $files, $server, $cookie, $request)
    {
        $this->paramBag = [
            'get' => $get,
            'post' => $post,
            'files' => $files,
            'server' => $server,
            'cookie' => $cookie,
            'request' => $request
        ];
    }

    /**
     * Retrieve GET array or specific field.
     *
     * @param string|null $field
     * @return mixed
     */
    public function query($field = null)
    {
        return is_null($field) ? $this->paramBag['get'] : ($this->paramBag['get'][$field] ?? null);
    }

    /**
     * Retrieve POST array or specific field.
     *
     * @param string|null $field
     * @return mixed
     */
    public function input($field = null)
    {
        return is_null($field) ? $this->paramBag['post'] : ($this->paramBag['post'][$field] ?? null);
    }

    /**
     * Retrieve SERVER array or specific field.
     *
     * @param string|null $field
     * @return mixed
     */
    public function server($field = null)
    {
        return is_null($field) ? $this->paramBag['server'] : ($this->paramBag['server'][$field] ?? null);
    }

    /**
     * Retrieve FILES array or specific field.
     *
     * @param string|null $field
     * @return array|UploadedFile|null
     */
    public function files($field = null)
    {
        if (!$this->isUploadedFilesConstructed) {
            foreach ($this->paramBag['files'] as $key => $file) {
                $this->paramBag['files'][$key] = new UploadedFile($file);
            }
            $this->isUploadedFilesConstructed = true;
        }
        return is_null($field) ? $this->paramBag['files'] : ($this->paramBag['files'][$field] ?? null);
    }

    /**
     * Check if a file exists in the FILES array.
     *
     * @param string $field
     * @return bool
     */
    public function hasFile($field)
    {
        return isset($this->paramBag['files'][$field]);
    }

    /**
     * Get all input data including files.
     *
     * @return array
     */
    public function all()
    {
        return array_merge($this->input(), $this->files());
    }

    /**
     * Check if the request is a GET request.
     *
     * @return bool
     */
    public function isGet()
    {
        return $this->server('REQUEST_METHOD') === 'GET';
    }

    /**
     * Check if the request is a POST request.
     *
     * @return bool
     */
    public function isPost()
    {
        return $this->server('REQUEST_METHOD') === 'POST';
    }
}