<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>

<div class="admin-panel-box">
    
    <div class="admin-panel-main">

        <span>Orders</span>

        <table class="admin-panel-table">
            <tr>
                <th class="edit-column"></th>
                <th>Order ID</th>
                <th>customer</th>
                <th>Date ordered</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

        <?php foreach ($userOrders as $userOrder): ?>

            <tr>
                <td class="edit-column">
                    <a href="/admin-panel/orders/order-data/<?= $userOrder['order_id'] ?>">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td><?= $userOrder['order_id'] ?></td>
                <td><?= $userOrder['username'] ?></td>
                <td><?= $userOrder['date_ordered'] ?></td>
                <td>$<?= $userOrder['total_price'] ?></td>
                <td><?= $userOrder['status'] ?></td>
            </tr>

        <?php endforeach ?>

        </table>

    </div>

    </div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>