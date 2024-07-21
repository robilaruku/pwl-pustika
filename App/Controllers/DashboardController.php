<?php

namespace App\Controllers;

use Core\Request;
use Core\ResponseFactory;

class DashboardController
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        // Ensure user is authenticated
        if (!$this->isAuthenticated()) {
            // Redirect to login page if not authenticated
            header('Location: /auth/index');
            exit();
        }
    }

    /**
     * Check if the user is authenticated using the auth helper function.
     *
     * @return bool
     */
    private function isAuthenticated()
    {
        // Retrieve user object from session using auth helper
        $user = auth(); // Fetches the user from session or returns a new user model if not set
        return $user instanceof \App\Models\User && isset($user->id); // Check if user is valid and has an ID
    }

    /**
     * Display the dashboard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // Render the dashboard view
        return ResponseFactory::view(app()->getConfig(), 'dashboard', ['user' => auth()]);
    }
}