<?php 
require_once __DIR__ . '/../../../partials/head.php';
require_once __DIR__ . '/../../../partials/navbar.php';
?>

<div class="item-data-box">

    <div class="item-data-header">
        <p>User data</p>
    </div>

    <form class="item-data-form">

        <div class="form-grid">
            <div class="form-group">
                <label>ID:</label>
                <input type="text" name="id">
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email">
            </div>

            <div class="form-group">
                <label>Role:</label>
                <input type="text" name="role">
            </div>
        </div>

        <h2 class="items-title">Orders</h2>

        <table class="admin-panel-table order-items-table">
            <tr>
                <th class="edit-column"></th>
                <th>Order_ID</th>
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            <tr>
                <td class="edit-column">
                    <a href="/admin-panel/orders/order-data?id=2">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td>1</td>
                <td>Smith</td>
                <td>01-05-2026</td>
                <td>$89</td>
                <td>Shipped</td>
            </tr>

            <tr>
                <td class="edit-column">
                <a href="/admin-panel/orders/order-data?id=2">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td>2</td>
                <td>Smith</td>
                <td>07-05-2026</td>
                <td>$45</td>
                <td>Processing</td>
            </tr>
        </table>

        <div class="item-data-buttons">
            <button type="submit" class="accept-btn">Accept changes</button>
            <button type="submit" class="discard-btn">Discard changes</button>
            <button type="button" class="delete-btn">Delete item</button>
        </div>

    </form>

</div>

<?php require_once __DIR__ . '/../../../partials/footer.php'; ?>