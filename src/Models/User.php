<?php 

namespace App\Models;

use PDO;

class User
{
    private $pdo;

    public function __construct(PDO $pdo)
    {
        $this->pdo = $pdo;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM silversale.users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserId($username)
    {
        $stmt = $this->pdo->prepare(
            'SELECT user_id FROM silversale.users WHERE username = ?'
        );

        $stmt->execute([$username]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByUsername(string $username)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM silversale.users WHERE username = ?'
        );

        $stmt->execute([$username]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail(string $email)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM silversale.users WHERE email = ?'
        );

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($username, $password, $email)
    {
        
        $customerRole = 'Customer';

        $username = trim($username);
        $email = trim($email);

        if ($username === '' || $password === '' || $email === '') {
            return false;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return false;
        }

        if ($this->getByUsername($username)) {
            return false;
        }

        if ($this->getByEmail($email)) {
            return false;
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->pdo->prepare(
            'INSERT INTO silversale.users (username, password, email, role)
            VALUES (?, ?, ?, ?)'
        );

        return $stmt->execute([
            $username,
            $hashedPassword,
            $email,
            $customerRole
        ]);
    }

    public function show()
    {
        $stmt = $this->pdo->query('SELECT * FROM silversale.users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
