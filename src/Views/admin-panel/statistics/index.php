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

    <form action="/admin-panel/statistics" method="GET">
        <select name="timeframe" id="timeframe" class="catalogue-option" onchange="this.form.submit()">
            <option value="all" <?= ($timeframe ?? 'all') === 'all' ? 'selected' : '' ?>>
                All time
            </option>

            <option value="week" <?= ($timeframe ?? '') === 'week' ? 'selected' : '' ?>>
                Past week
            </option>

            <option value="month" <?= ($timeframe ?? '') === 'month' ? 'selected' : '' ?>>
                Past month
            </option>

            <option value="year" <?= ($timeframe ?? '') === 'year' ? 'selected' : '' ?>>
                Past year
            </option>
        </select>
    </form>

    <p>
        Total orders: <?= $data['totalOrders'] ?>
    </p>
    <p>
        Total items sold: <?= $data['totalItemsSold'] ?>
    </p>
    <p>
        Current revenue: $<?= $data['revenue'] ?>
    </p>
    <p>
        Total users: <?= $data['totalUsers'] ?>
    </p>
    <p>
        Total items: <?= $data['totalItems'] ?>
    </p>

    <div class="item-data-form">

        <p class="items-title">Order status data:</p>

       <table class="admin-panel-table order-items-table">
            <tr>
                <th>Status</th>
                <th>Quantity</th>
            </tr>

            <?php foreach ($statusCounts as $status): ?>

                <tr>
                    <td><?= ucfirst($status['status']) ?></td>
                    <td><?= $status['quantity'] ?></td>
                </tr>

            <?php endforeach; ?>

        </table>
            
    </div>

    <div class="item-data-buttons">
        <button type="submit" class="accept-btn" onclick="window.print()">Export as PDF</button>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>