<?php

namespace App\Controllers;

use App\Models\User;
use Core\Request;
use Core\Security;

class AuthController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    public function index(Request $request)
    {
        // Generate CSRF token
        $csrfToken = Security::getCsrfToken();

        return view('login', ['name' => 'Pustika', 'csrfToken' => $csrfToken], 'auth');
    }

    public function page404(Request $request)
    {
        return view('page404')
            ->withStatus(404);
    }

    /**
     * Handle user login
     *
     * @param Request $request
     * @return Response
     */
    public function login(Request $request)
    {
        // Ensure the CSRF token is valid
        $csrfToken = $request->input('_token');
        if (!Security::checkCsrfToken($csrfToken)) {
            return redirect('/auth/index?error=Invalid CSRF token');
        }

        // Get credentials from request
        $username = $request->input('username');
        $password = $request->input('password');

        // Instantiate User model and check credentials
        $user = $this->userModel->first('username', $username);

        if ($user && password_verify($password, $user->password)) {
            // Set session and user information
            session('user_auth', $user); // Store user object in session

            // Redirect to the dashboard or any other page
            return redirect('/dashboard/index');
        } else {
            // Redirect to login page with error message
            return redirect('/auth/index?error=Invalid username or password');
        }
    }

     /**
     * Handle user logout
     *
     * @return Response
     */
    public function logout()
    {
        // Start session if not already started
        session_on_demand();

        // Clear session data
        session_unset();
        session_destroy();

        // Redirect to login page or home page
        return redirect('/auth/index');
    }

}