<?php

namespace App\Controllers;

use App\Models\User;

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
        $rules = [
            'username' => 'required|max_length[255]',
            'password' => 'required|max_length[255]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Enter your username or email address and password.');
        }

        $identifier = trim((string) $this->request->getPost('username'));
        $password   = (string) $this->request->getPost('password');
        $user       = (new User())->findByUsernameOrEmail($identifier);

        if ($user === null || ! (bool) $user['is_active'] || ! password_verify($password, $user['password'])) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Invalid username, email, or password.');
        }

        session()->regenerate(true);
        session()->set([
            'logged_in'    => true,
            'isLogged'     => true,
            'user_id'      => $user['id'],
            'username'     => $user['username'],
            'display_name' => trim($user['first_name'] . ' ' . $user['last_name']),
        ]);

        return redirect()->to(base_url('accounts'));
    }

    public function logout()
    {
        session()->destroy();

        return redirect()->to(base_url('home'))
            ->with('success', 'You have been logged out.');
    }
}
