<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>

<div class="admin-panel-box">
    
    <div class="admin-panel-main">

        <span>Users</span>

        <div>
            <a href="/admin-panel/users/user-data/0">
                <button type="submit" class="submit">Add user</button>
            </a>
        </div>

        <table class="admin-panel-table">

        <tr>
            <th class="edit-column"></th>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
        </tr>

        <?php foreach($users as $user): ?>

        <tr>
            <td class="edit-column">
                <a href="/admin-panel/users/user-data/<?= $user["user_id"] ?>">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td><?= $user["user_id"] ?></td>
            <td><?= $user["username"] ?></td>
            <td><?= $user["email"] ?></td>
        </tr>

        <?php endforeach; ?>

        </table>

    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>