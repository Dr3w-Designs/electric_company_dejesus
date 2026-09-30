<?php

namespace App\Controllers;

class Auth extends BaseController
{
    public function index()
    {
        return view('auth/login', [
            'title' => 'Login - Puihaha Electric',
        ]);
    }

    public function login()
    {
        // Temporary login: credentials are not checked yet.
        session()->set([
            'logged_in'    => true,
            'display_name' => 'Administrator',
        ]);

        return redirect()->to(base_url('accounts'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url());
    }
}