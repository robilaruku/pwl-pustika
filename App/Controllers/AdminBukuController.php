<?php

namespace App\Controllers;

use Core\Request;
use Core\Security;

class AdminBukuController
{
    /**
     * DashboardController constructor.
     */
    public function __construct()
    {
        // Ensure user is authenticated
        if (!auth()->username) {
            redirect('/auth/index?error=Please sign in to access this page');
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
        return view('admin/buku/index', ['user' => auth()], 'admin');
    }
}