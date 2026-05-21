<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
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
                <input type="text" name="recipient_name">
            </div>

            <div class="form-group">
                <label>Country:</label>
                <input type="text" name="country">
            </div>

            <div class="form-group">
                <label>City:</label>
                <input type="text" name="city">
            </div>

            <div class="form-group">
                <label>Address line 1:</label>
                <input type="text" name="address_line_1">
            </div>

            <div class="form-group">
                <label>Address line 2:</label>
                <input type="text" name="address_line_2">
            </div>

            <div class="form-group">
                <label>Postal code:</label>
                <input type="text" name="postal_code">
            </div>
        </div>

        <div class="section-title">
            <h2>General order data</h2>
        </div>

        <div class="form-grid">

            <div class="form-group">
                <label>Status:</label>
                <input type="text" name="status">
            </div>

            <div class="form-group">
                <label>Shipping agent:</label>
                <input type="text" name="date">
            </div>

            <div class="form-group">
                <label>Waybill number:</label>
                <input type="text" name="total_price">
            </div>

            <div class="form-group">
                <label>Date:</label>
                <input type="text" name="date">
            </div>

            <div class="form-group">
                <label>Total price:</label>
                <input type="text" name="total_price">
            </div>
        </div>

        <p class="items-title">Items</p>

        <table class="admin-panel-table order-items-table">
            <tr>
                <th>Item_ID</th>
                <th>Name</th>
                <th>Size</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Date</th>
            </tr>

            <tr>
                <td>52</td>
                <td>Hat</td>
                <th>S</th>
                <td>2</td>
                <td>$20</td>
                <td>08/05/2026</td>
            </tr>

            <tr>
                <td>61</td>
                <td>Jacket</td>
                <th>L</th>
                <td>1</td>
                <td>$10</td>
                <td>08/05/2026</td>
            </tr>
        </table>

        <div class="item-data-buttons">
            <button type="submit" class="accept-btn">Export as PDF</button>
        </div>
    </form>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>