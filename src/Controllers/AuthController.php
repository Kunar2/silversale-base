<?php

namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;

class AuthController extends BaseController
{
    private User $user;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User($this->db);
    }

    public function login()
    {
        $data = [
            'pageTitle'   => 'Login',
            'currentPage' => 'login'
        ];

        $this->render('auth/login', $data);
    }

    public function register()
    {
        $data = [
            'pageTitle'   => 'Register',
            'currentPage' => 'login'
        ];

        $this->render('auth/register', $data);
    }

    public function authenticate()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        $user = $this->user->getByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];

            header('Location: /');
            exit;
        }

        $this->render('auth/login', [
            'pageTitle' => 'Login',
            'currentPage' => 'login',
            'error' => 'Invalid username or password'
        ]);
    }

    public function createAccount()
    {
        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';
        $email    = trim($_POST['email'] ?? '');

        if ($username === '' || $password === '' || $email === '') {
            return $this->render('auth/register', [
                'pageTitle' => 'Register',
                'currentPage' => 'register',
                'error' => 'Some fields are empty.'
            ]);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('auth/register', [
                'pageTitle' => 'Register',
                'currentPage' => 'register',
                'error' => 'Not a valid email address.'
            ]);
        }

        if (strlen($password) > 12) {
            return $this->render('auth/register', [
                'pageTitle' => 'Register',
                'currentPage' => 'register',
                'error' => 'Password must be at most 16 characters.'
            ]);
        }

        $created = $this->user->insertUser($username, $password, $email);

        if (!$created) {
            return $this->render('auth/register', [
                'pageTitle' => 'Register',
                'currentPage' => 'register',
                'error' => 'Error creating account.'
            ]);
        }

        $this->authenticate($username, $password);

        header('Location: /');
        exit;
    }

    public function logout()
    {
        session_unset();
        session_destroy();

        header('Location: /');
        exit;
    }
}