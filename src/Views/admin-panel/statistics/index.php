<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>

<div class="item-data-box">

    <div class="item-data-header">
        <p>Statistics</p>
    </div>

    <p style="margin-bottom: 0px;">
        <label for="sort_type">Timeframe</label>
    </p>

    <select class="catalogue-option" name="sort_type" id="sort_type">
        <option value="all">All</option>
        <option value="today">Today</option>
        <option value="week">This week</option>
        <option value="month">This month</option>
        <option value="year">This year</option>
        <option value="specific">Specific timeframe</option>
    </select>

    <p>
        Total users: 42
    </p>
    <p>
        Total items: 50
    </p>
    <p>
        Total orders: 34
    </p>
    <p>
        Total items sold: 67
    </p>
    <p>
        Most sold item: baseball cap
    </p>
    <p>
        Current revenue: $740
    </p>

    <div class="item-data-form">

        <p class="items-title">Order status data:</p>

        <table class="admin-panel-table order-items-table">
        <tr>
            <th>Status</th>
            <th>Quantity</th>
        </tr>

        <tr>
            <td>Processing</td>
            <td>30</td>    
        </tr>

        <tr>
            <td>Shipped</td>
            <td>52</td>
        </tr>

        <tr>
            <td>Received</td>
            <td>96</td>
        </tr>
        
        <tr>
            <td>Cancelled</td>
            <td>120</td>
        </tr>

        </table>
        
    </div>

    <div class="item-data-buttons">
        <button type="submit" class="accept-btn">Export as Excel</button>
    </div>

    <div class="item-data-buttons">
        <button type="submit" class="accept-btn">Export as PDF</button>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>