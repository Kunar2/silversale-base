<?php 
require_once __DIR__ . '/../../../partials/head.php';
require_once __DIR__ . '/../../../partials/navbar.php';

$userId = $users['user_id'] ?? 0;

$formAction = $userId == 0
    ? '/admin-panel/users/insert'
    : '/admin-panel/users/update/' . $userId;

$passwordField = $userId == 0
    ? '<div class="form-group">
            <label>Password:</label>
            <input type="text" name="password">
        </div>'
    : '';

$userExists = ($users['user_id'] ?? 0) !== 0; 
    
?>

<div class="item-data-box">

    <div class="item-data-header">
        <p>User data</p>
    </div>

    <form 
        class="item-data-form" 
        action="<?= $formAction ?>" 
        method="POST"
    >

        <div class="form-grid">
            <div class="form-group">
                <label>ID:</label>
                <input type="text" name="id" value="<?= $users['user_id'] ?? '' ?>" disabled>
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?= $users['username'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?= $users['email'] ?? '' ?>">
            </div>

            <?= $passwordField ?>

            <div class="form-group">
                <label>Role:</label>
                <select name="role">
                    <option value="customer" <?= ($users['role'] ?? '') === 'customer' ? 'selected' : '' ?>>Customer</option>
                    <option value="admin" <?= ($users['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
        </div>

        <?php if($userExists): ?> 

        <h2 class="items-title">Orders</h2>

        <table class="admin-panel-table order-items-table">
            <tr>
                <th class="edit-column"></th>
                <th>Order_ID</th>
                <th>customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            <?php foreach(($users['order'] ?? [])  as $order): ?>

            <tr>
                <td class="edit-column">
                    <a href="/admin-panel/orders/order-data/<?= $order['order_id'] ?>">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td><?= $order['order_id'] ?> </td>
                <td><?= $users['username'] ?></td>
                <td><?= $order['date_ordered'] ?></td>
                <td>$<?= $order['total_price'] ?></td>
                <td><?= $order['status'] ?></td>
            </tr>

            <?php endforeach; ?>

        </table>

        <?php endif; ?>

        <div class="item-data-buttons">
            <button type="submit" class="accept-btn">Accept changes</button>
        </div>

    </form>
    
    <a href="/admin-panel/users" class="item-data-buttons">
        <button type="submit" class="discard-btn">Discard changes</button>
    </a>

    <?php if($userExists): ?> 

    <form action="/admin-panel/users/delete/<?= $users['user_id'] ?>" method="POST" class="item-data-buttons">
        <button type="submit" class="delete-btn" <?= ($users['role'] ?? '') === 'admin' ? 'disabled' : '' ?> >Delete user</button>
    </form>

    <?php endif; ?> 

</div>

<?php require_once __DIR__ . '/../../../partials/footer.php'; ?>