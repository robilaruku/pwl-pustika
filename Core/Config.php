<?php

namespace Core;

class Config
{
    /**
     * Base Url of application
     * ex:
     * example.com/ => '' // Leave empty
     * example.com/myapp => 'myapp'
     * example.com/myapp/anotherapp => 'myapp/anotherapp'
     */
    const BASE_URL = 'pustika/public';


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
        return dirname(__DIR__) . '/storage/public/';
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
        "port" => 3307
    ];


    /**
     * Default user model to use
     * default is App\Models\User
     */
    const USER_MODEL = 'User';

    /**
     * Validation Messages
     */
    public static function getMessage($rule, $field, $params, $messages = [])
    {
        $params = $params ?: [""];
        $messages = array_merge([
            "required" => "$field is required.",
            "digits" => "$field must be {$params[0]} digits long.",
            "string" => "$field must be a valid string.",
            "boolean" => "$field must be an either yes or no.",
            "confirmed" => "$field and $field Confirmed do not match.",
            "email" => "$field is not a valid email.",
            "file" => "$field is not a valid file.",
            "image" => "$field is not a valid image.",
            "date" => "$field is not a valid date.",
            "date_equals" => "$field must be different from {$params[0]}.",
            "date_after" => "$field must be after {$params[0]}.",
            "date_before" => "$field must be before {$params[0]}.",
            "different" => "$field and {$params[0]} should not be same.",
            "same" => "$field and {$params[0]} should not be different.",
            "present" => "$field must be present.",
            "max" => "$field maximum size allowed is {$params[0]}.",
            "min" => "$field minimum size allowed is {$params[0]}.",
        ], $messages);

        return $messages[$rule];
    }
}