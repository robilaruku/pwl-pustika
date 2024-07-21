<?php

namespace Core;

class Security
{
    /**
     * Simple XSS clean function
     * 
     * @param array|string $field Field to be cleaned
     * 
     * @return array|string cleaned data 
     */
    public static function xssClean($field)
    {
        if (is_array($field)) return array_map([self::class, 'xssClean'], $field);
        return htmlspecialchars($field, ENT_QUOTES);
    }

    /**
     * Get/Generate CSRF token and store in $_SESSION['_token'] field
     */
    public static function getCsrfToken()
    {
        // Ensure session is started before accessing session data
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Initialize token if not set or expired
        if (empty($_SESSION['_token']) || (time() - $_SESSION['_token_time']) / 60 >= 10) {
            $_SESSION['_token'] = bin2hex(random_bytes(32));
            $_SESSION['_token_time'] = time();
        }
        return $_SESSION['_token'];
    }

    /**
     * Check whether CSRF token is valid or not
     * 
     * @param string $token Token to be matched with one in session
     * 
     * @return bool
     */
    public static function checkCsrfToken($token)
    {
        // Ensure session is started before accessing session data
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        // Fetch the token from session
        $sessionToken = $_SESSION['_token'] ?? '';

        // Check if the provided token matches the session token and if it's not expired
        return !empty($sessionToken) && hash_equals($sessionToken, $token) && (time() - $_SESSION['_token_time']) / 60 < 10;
    }
}