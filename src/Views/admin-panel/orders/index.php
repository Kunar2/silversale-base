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
                <th>Customer</th>
                <th>Date</th>
                <th>Total</th>
                <th>Status</th>
            </tr>

            <tr>
                <td class="edit-column">
                <a href="order-data?id=1">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td>1</td>
                <td>John</td>
                <td>2026-04-01</td>
                <td>$89</td>
                <td>Shipped</td>
            </tr>

            <tr>
                <td class="edit-column">
                    <a href="order-data?id=2">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td>2</td>
                <td>Smith</td>
                <td>2026-04-02</td>
                <td>$45</td>
                <td>Processing</td>
            </tr>

            <tr>
                <td class="edit-column">
                    <a href="order-data?id=3">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td>3</td>
                <td>Lee</td>
                <td>2026-04-03</td>
                <td>$100</td>
                <td>Delivered</td>
            </tr>

            <tr>
                <td class="edit-column">
                    <a href="order-data?id=4">View <i class="fa-solid fa-pencil"></i></a>
                </td>
                <td>4</td>
                <td>Michael</td>
                <td>2026-04-04</td>
                <td>$62</td>
                <td>Cancelled</td>
            </tr>
        </table>

    </div>

    </div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>