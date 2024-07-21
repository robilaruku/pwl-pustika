<?php

namespace App\Controllers;

use Core\Request;
use Core\ResponseFactory;
use Core\Security;
use App\Models\User;

class DashboardController
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        // Ensure user is authenticated
        if (!auth()) {
            // Redirect to login page if not authenticated
            redirect('/auth/index?error=Please login to access this page');
        }
    }

    /**
     * Display the dashboard.
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        // Generate CSRF token
        $csrfToken = Security::getCsrfToken();

        // Render the dashboard view with the user data and CSRF token
        return view('admin/dashboard', ['user' => auth(), 'csrfToken' => $csrfToken], 'admin');
    }
}