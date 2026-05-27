<?php 
require_once __DIR__ . '/../../../partials/head.php';
require_once __DIR__ . '/../../../partials/navbar.php';
?>

<div class="item-data-box">

    <div class="item-data-header">
        <p>Order data</p>
    </div>

    <form class="item-data-form"> 

        <div class="section-title">
            <h2>Address data</h2>
        </div>
        
        <div class="form-grid">

            <div class="form-group">
                <label>Recipient name:</label>
                <input type="text" name="recipient_name" value="<?= $userOrders['recipient_name'] ?>">
            </div>

            <div class="form-group">
                <label>Recipient phone:</label>
                <input type="text" name="recipient_phone" value="<?= $userOrders['recipient_phone'] ?>">
            </div>

            <div class="form-group">
                <label>Country:</label>
                <input type="text" name="country" value="<?= $userOrders['country'] ?>">
            </div>

            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city" value="<?= $userOrders['city'] ?>">
            </div>

            <div class="form-group">
                <label>Address line 1:</label>
                <input type="text" name="address_line_1" value="<?= $userOrders['address_line_1'] ?>">
            </div>

            <div class="form-group">
                <label>Address line 2:</label>
                <input type="text" name="address_line_2" value="<?= $userOrders['address_line_2'] ?>">
            </div>

            <div class="form-group">
                <label>Postal code:</label>
                <input type="text" name="postal_code" value="<?= $userOrders['postal_code'] ?>">
            </div>
        </div>

        <div class="section-title">
            <h2>General order data</h2>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>Status:</label>
                <input type="text" name="status" value="<?= $userOrders['status'] ?>">
            </div>

            <div class="form-group">
                <label>Shipping agent:</label>
                <input type="text" name="shipping_agent" value="<?= $userOrders['shipping_agent'] ?>">
            </div>

            <div class="form-group">
                <label>Waybill number:</label>
                <input type="text" name="waybill_number" value="<?= $userOrders['waybill_number'] ?>">
            </div>

            <div class="form-group">
                <label>Date:</label>
                <input type="text" name="date_ordered" value="<?= date('d/m/Y', strtotime($userOrders['date_ordered'])) ?>">
            </div>

            <div class="form-group">
                <label>Total price:</label>
                <input type="text" name="total_price" value="<?= $userOrders['total_price'] ?>">
            </div>

            <div class="form-group">
                <label>Estimated delivery:</label>
                <input type="text" name="estimated_delivery" value="<?= date('d/m/Y', strtotime($userOrders['estimated_delivery'])) ?>">
            </div>

            <div class="form-group">
                <label>Delivered at:</label>
                <input 
                    type="text" 
                    name="delivered_at"
                    value="<?= $userOrders['delivered_at'] ? date('d/m/Y', strtotime($userOrders['delivered_at'])) : '' ?>"
                >
            </div>
        </div>

        <div class="section-title">
            <h2>User data</h2>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>User ID:</label>
                <input type="text" name="user_id" value="<?= $userOrders['user_id'] ?>">
            </div>

            <div class="form-group">
                <label>Username:</label>
                <input type="text" name="username" value="<?= $userOrders['username'] ?>">
            </div>

            <div class="form-group">
                <label>Email:</label>
                <input type="text" name="email" value="<?= $userOrders['email'] ?>">
            </div>
        </div>

        <p class="items-title">Items</p>

        <table class="admin-panel-table order-items-table">

            <tr>
                <th>Item_ID</th>
                <th>Unit_ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Date</th>
            </tr>

            <?php foreach ($userOrders['items'] as $item): ?>

                <tr>
                    <td><?= $item['item_id'] ?></td>
                    <td><?= $item['unit_id'] ?></td>
                    <td><?= $item['name'] ?></td>
                    <td><?= strtoupper($item['size']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= $item['unit_price_snapshot'] ?></td>
                    <td><?= date('d/m/Y', strtotime($userOrders['date_ordered'])) ?></td>
                </tr>

            <?php endforeach; ?>

        </table>

        <div class="item-data-buttons">
            <button type="submit" class="accept-btn">Export as PDF</button>
        </div>
        
    </form>

</div>

<?php require_once __DIR__ . '/../../../partials/footer.php'; ?>