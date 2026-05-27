<?php
namespace App\Controllers\Admin;

use App\Core\BaseController;
use App\Models\User;
use App\Models\Order;

class AdminUserController extends BaseController
{

    private User $user;
    private Order $order;

    public function __construct()
    {
        parent::__construct();
        $this->user = new User($this->db);
        $this->order = new Order($this->db);
    }

    public function index()
    {
        $userSnapshot = $this->user->getUserAdminSnapshot();        

        $data = [
            'pageTitle'   => 'Users',
            'currentPage' => 'admin-panel',
            'users' => $userSnapshot
        ];

        $this->render('admin-panel/users', $data);
    }

    public function show(array $params)
    {
        $id = $params['id'] ?? null;

        // Create
        if ($id === 0) {

            $data = [
                'pageTitle'   => 'Add user',
                'currentPage' => 'admin-panel',
                'users' => []
            ];

            $this->render('admin-panel/users/user-data', $data);
            return;
        }

        // Edit
        $userDetailed = $this->user->getUserAdminDetailed($id);

        $data = [
            'pageTitle'   => 'User details',
            'currentPage' => 'admin-panel',
            'users' => $userDetailed
        ];

        $this->render('admin-panel/users/user-data', $data);
    }

    public function addUser(array $params)
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = trim($_POST['role'] ?? 'user');

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $this->user->insertUserAdmin([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => $role,
        ]);

        header('Location: /admin-panel/users');
        exit;
    }

    public function updateUser(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            header('Location: /admin-panel/users');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $role = trim($_POST['role'] ?? 'user');

        $data = [
            'username' => $username,
            'email' => $email,
            'role' => $role,
        ];

        if ($password !== '') {
            $data['password'] = password_hash($password, PASSWORD_DEFAULT);
        } else {
            $data['password'] = null;
        }

        $this->user->updateUser($id, $data);

        header('Location: /admin-panel/users/user-data/' . $id);
        exit;
    }

    public function deleteUser(array $params)
    {
        $id = $params['id'] ?? null;

        if (!$id) {
            header('Location: /admin-panel/users');
            exit;
        }

        $this->user->deleteUser($id);

        header('Location: /admin-panel/users');
        exit;
    }

}