<?php
namespace App\Controllers;

use App\Core\BaseController;
use App\Models\User;
use App\Models\Address;

class AccountController extends BaseController
{

    private User $users;
    private Address $address;

    public function __construct()
    {
        parent::__construct();
        $this->users = new User($this->db);
        $this->address = new Address($this->db);
    }

    public function index()
    {
        $username = $_SESSION['username'] ?? '';
        $id = $_SESSION['user_id'] ?? '';
        $user = $this->users->getById($id);
        $address = $this->address->getAddressAccount($id);

        $data = [
            'pageTitle'   => 'Account',
            'currentPage' => 'account',
            'user' => $user,
            'address' => $address
        ];

        $this->render('account', $data);
    }

    public function updateUsercustomer(array $params)
    {
        $id = $_SESSION['user_id'] ?? '';

        if (!$id) {
            header('Location: /login');
            exit;
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');

        $recipientName = trim($_POST['recipient_name'] ?? '');
        $recipientPhone = trim($_POST['recipient_phone'] ?? '');
        $country = trim($_POST['country'] ?? '');
        $city = trim($_POST['city'] ?? '');
        $addressLine1 = trim($_POST['address_line_1'] ?? '');
        $addressLine2 = trim($_POST['address_line_2'] ?? '');
        $postalCode = trim($_POST['postal_code'] ?? '');
        $autofill = isset($_POST['autofill']) ? 1 : 0;
        $image = $_FILES['image'] ?? null;

        if (!(
            empty($recipientName) ||
            empty($recipientPhone) ||
            empty($country) ||
            empty($city) ||
            empty($addressLine1) ||
            empty($postalCode))
        ) {
            $addressData = [
            'user_id' => $id,
            'recipient_name' => $recipientName,
            'recipient_phone' => $recipientPhone,
            'country' => $country,
            'city' => $city,
            'address_line_1' => $addressLine1,
            'address_line_2' => $addressLine2,
            'postal_code' => $postalCode,
            'autofill' => $autofill
            ];
        
        $this->address->updateInsertUserAddress($addressData);
        }

        $imagePath = null;

        if ($image && $image['error'] === UPLOAD_ERR_OK) {

            $uploadDir = __DIR__ . '/../../public/assets/icons/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            $extension = pathinfo($image['name'], PATHINFO_EXTENSION);

            $fileName = uniqid('image_', true) . '.' . $extension;

            move_uploaded_file(
                $image['tmp_name'],
                $uploadDir . $fileName
            );

            $imagePath = '/assets/icons/' . $fileName;
        }

        $hashedPassword = null;

        // Only update password if entered
        if ($password !== '') {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        }

        $userEmailExists = $this->users->userEmailExists (
            $email
        );

        if ($userEmailExists) {
            $this->users->updateUserNoEmail($id, [
            'username' => $username,
            'password' => $hashedPassword,
            'role' => 'customer',
            'image' => $imagePath
            ]);
        }
        else {
            $this->users->updateUser($id, [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => 'customer',
            'image' => $imagePath
            ]);
        }


        $user = $this->users->getById($id);

        header('Location: /account');
        exit;
    }
}
