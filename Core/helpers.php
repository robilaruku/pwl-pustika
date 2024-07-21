<?php

use Core\Pustika;
use Core\ResponseFactory;

if (!function_exists('view')) {
    function view($views, $data = [], $layout = null)
    {
        $data['layout'] = $layout;
        return ResponseFactory::view(app()->getConfig(), $views, $data);
    }
}

if (!function_exists('json')) {
    function json($data, $options = 0, $depth = 512)
    {
        return ResponseFactory::json($data, $options, $depth);
    }
}

if (!function_exists('session_on_demand')) {
    function session_on_demand()
    {
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
    }
}

if (!function_exists('session')) {
    function session($key, ...$value)
    {
        session_on_demand();
        if (count($value) == 1) {
            $_SESSION[$key] = $value[0];
        }
        return $_SESSION[$key] ?? null;
    }
}

if (!function_exists('auth')) {
    /**
     * Get or Set user object in session
     *
     * @param \App\Models\User ...$user
     * @return \App\Models\User
     */
    function auth(...$user)
    {
        // If a user object is passed, store it in the session
        if (count($user) === 1) {
            session('user_auth', $user[0]);
        }

        // Retrieve the user model from the session or create a new instance
        $modelClass = 'App\\Models\\User'; // Make sure this path is correct

        if (class_exists($modelClass)) {
            return session('user_auth') ?? new $modelClass;
        }

        // Throw an exception if the model class does not exist
        throw new \Exception('User model configuration is missing or invalid.');
    }
}




if (!function_exists('app')) {
    function app()
    {
        return Pustika::getInstance();
    }
}

if (!function_exists('redirect')) {
    /**
     * Redirect to a given URL
     *
     * @param string $url The URL to redirect to
     * @return void
     */
    function redirect($url): void
    {
        header("Location: $url");
        exit; // Ensure that no further code is executed
    }
}