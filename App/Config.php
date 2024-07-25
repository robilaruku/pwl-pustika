<?php

namespace App;

use Core\Config as BaseConfig;

class Config extends BaseConfig
{
    /**
     * Base Url of application
     * ex:
     * example.com/ => '' // Leave empty
     * example.com/myapp => 'myapp'
     * example.com/myapp/anotherapp => 'myapp/anotherapp'
     */
    const BASE_URL = 'pustika/public/';


    /**
     * Assets directory path relative to base_url
     */
    const ASSETS_PATH = 'assets';

    /**
     * Which namespace controllers of application resides
     * Deafault is App\Controllers
     */
    const CONTROLLER_NAMESPACE = 'App\\Controllers';


    /**
     * Which controller will be used for simple /action urls
     * Deafult is Site
     * ex:
     * example.com/about :
     *      will call about method on Site Controller.
     * example.com/about/1/edit :
     *      will be same as above but 1 and edit are params to function.
     */
    const DEFAULT_CONTROLLER = 'Site';


    /**
     * What action should / route trigger i.e. your landing site
     * By deafult it's index method in Deafult Controller(SiteController)
     */
    const ACTION_INDEX = 'index';


    /**
     * If unknown page is requested (i.e. 404)
     * By deafult it's page404 method in Deafult Controller(SiteController)
     */
    const ACTION_404 = 'page404';


    /**
     * Path where twig view templates are stored
     */
    const VIEW_PATH = __DIR__ . '/Views/';


    /**
     * Path where twig to store compiled templates
     */
    public static function getViewCachePath()
    {
        return dirname(__DIR__) . '/storage/views/';
    }


    /**
     * Path where twig to store compiled templates
     */
    public static function getPublicStoragePath()
    {
        return dirname(__DIR__) . 'public/storage/';
    }

    /**
     * Which superglobals to while making app instance
     */
    public static function getGlobals()
    {
        return [
            'get' => $_GET,
            'post' => $_POST,
            'files' => $_FILES,
            'server' => $_SERVER,
            'cookie' => $_COOKIE,
            'request' => $_REQUEST
        ];
    }


    /**
     * Default user model to use
     * default is App\Models\User
     */
    const USER_MODEL = 'User';


    /**
     * DB type currently only mysql. sqlite comming soon
     */
    const DB_TYPE = "mysql";


    /**
     * DB config used for connection
     */
    const DB_CONFIG = [
        "host" => "localhost",
        "dbname" => "tugas_klmpk_pwl",
        "username" => "root",
        "password" => "",
        "port" => 3306
    ];


    /**
     * Validation Messages
     * You can customize error messages by changing $messages array.
     * Ex. if you want to change required message, just
     * $messages = ["required" => "Custome Message"]
     * @param string $rule key like required, digits etc.
     * @param string $field is formatted field name.
     * @param array $params Paramters to validation like size:10 <- is param.
     * 
     * @return string validation message
     */
    public static function getMessage($rule, $field, $params, $messages = [])
    {
        return parent::getMessage($rule, $field, $params, $messages);
    }
}