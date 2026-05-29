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

    public function getUseradminSnapshot()
    {
        $stmt = $this->pdo->query('SELECT users.user_id, users.username, users.email, users.role FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function insertUseradmin($data)
    {
        $stmt = $this->pdo->prepare(
            "INSERT INTO users (
                username,
                email,
                password,
                role
            )
            VALUES (?, ?, ?, ?)"
        );

        $stmt->execute([
            $data['username'],
            $data['email'],
            $data['password'],
            $data['role']
        ]);

        return $this->pdo->lastInsertId();
    }

    public function userEmailExists($email)
    {
        $stmt = $this->pdo->prepare(
            "SELECT user_id
            FROM users
            WHERE email = ?"
        );

        $stmt->execute([
            $email,
        ]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUserAdmin($userId, $data)
    {
        
        if ($data['password'] !== null) {

            $stmt = $this->pdo->prepare(
                "UPDATE users
                SET
                    username = ?,
                    email = ?,
                    password = ?,
                    role = ?,
                    image = COALESCE(?, image)
                WHERE user_id = ?"
            );

            return $stmt->execute([
                $data['username'],
                $data['email'],
                $data['password'] ?? null,
                $data['role'] ?? 'Customer',
                $data['image'] ?? '',
                $userId
            ]);
        }

        // Update without password
        $stmt = $this->pdo->prepare(
            "UPDATE users
            SET
                username = ?,
                email = ?,
                role = ?,
                image = COALESCE(?, image)
            WHERE user_id = ?"
        );

        return $stmt->execute([
            $data['username'],
            $data['email'],
            $data['role'] ?? "customer",
            $data['image'] ?? null,
            $userId
        ]);
    }

    public function updateUserNoEmail($userId, $data)
    {
        // Update with password
        if ($data['password'] !== null) {

            $stmt = $this->pdo->prepare(
                "UPDATE users
                SET
                    username = ?,
                    password = ?,
                    role = ?,
                    image = COALESCE(?, image)
                WHERE user_id = ?"
            );

            return $stmt->execute([
                $data['username'],
                $data['password'],
                $data['role'],
                $data['image'],
                $userId
            ]);
        }

        // Update without password
        $stmt = $this->pdo->prepare(
            "UPDATE users
            SET
                username = ?,
                role = ?,
                image = COALESCE(?, image)
            WHERE user_id = ?"
        );

        return $stmt->execute([
            $data['username'],
            $data['role'],
            $data['image'],
            $userId
        ]);
    }

    public function deleteUser($userId)
    {
        $stmt = $this->pdo->prepare(
            "DELETE FROM users
            WHERE user_id = ?"
        );

        return $stmt->execute([$userId]);
    }

    public function getUseradminDetailed($userId)
    {
        $stmt = $this->pdo->prepare('SELECT users.*, order_main.* 
        FROM users 

        JOIN order_main 
        ON order_main.user_id = users.user_id

        WHERE users.user_id = ?');

        $stmt->execute([$userId]);

        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $user = null;

        foreach ($rows as $row) {

            if ($user === null) {
                $user = [
                    'user_id' => $row['user_id'],
                    'username' => $row['username'],
                    'email' => $row['email'],
                    'password' => $row['password'],
                    'role' => $row['role'],
                    'order' => [],
                ];
            }

            $user['order'][] = [
                'order_id' => $row['order_id'],
                'date_ordered' => $row['date_ordered'],
                'date_delivered' => $row['date_ordered'],
                'total_price' => $row['total_price'],
                'status' => $row['status'],
            ];
        }

    return $user;
    }

    public function getAll()
    {
        $stmt = $this->pdo->query('SELECT * FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserId($username)
    {
        $stmt = $this->pdo->prepare(
            'SELECT user_id FROM users WHERE username = ?'
        );

        $stmt->execute([$username]);

        return $stmt->fetchColumn();
    }

    public function getByUsername(string $username)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE username = ?'
        );

        $stmt->execute([$username]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function getById($userId)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE user_id = ?'
        );

        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getByEmail(string $email)
    {
        $stmt = $this->pdo->prepare(
            'SELECT * FROM users WHERE email = ?'
        );

        $stmt->execute([$email]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function insertUser($username, $password, $email)
    {
        
        $customerRole = 'customer';

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
            'INSERT INTO users (username, password, email, role)
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
        $stmt = $this->pdo->query('SELECT * FROM users');
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
