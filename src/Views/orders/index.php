<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

    <div class="orders-box">

        <h1>Orders</h1>
        
        <p><label for="sort_type">Timeframe filter:</label></p>
        <select class="catalogue-option" name="sort_type" id="sort_type">
            <option value="all">All</option>
            <option value="day">Today</option>
            <option value="reviews">This week</option>
            <option value="price">This month</option>
            <option value="price">This year</option>
        </select>

        <?php 

        $groupedOrders = [];

        foreach ($userOrders as $userOrder) {

            $orderId = $userOrder['order_id'];

            if (!isset($groupedOrders[$orderId])) {

                $groupedOrders[$orderId] = [
                    'order_id' => $userOrder['order_id'],
                    'status' => $userOrder['status'],
                    'total_price' => $userOrder['total_price'],
                    'estimated_delivery' => $userOrder['estimated_delivery'],
                    'delivered_at' => $userOrder['delivered_at'],
                    'date_ordered' => $userOrder['date_ordered'],
                    'items' => []
                ];
            }

            $groupedOrders[$orderId]['items'][] = [
                'item_id' => $userOrder['item_id'],
                'unit_id' => $userOrder['unit_id'],
                'name' => $userOrder['name'],
                'size' => $userOrder['size'],
                'image' => $userOrder['image'],
                'quantity' => $userOrder['quantity'],
                'unit_price_snapshot' => $userOrder['unit_price_snapshot']
            ];
        }

        $groupedOrders = array_values($groupedOrders);

        ?>

        <?php foreach ($groupedOrders as $groupedOrder): ?>
            <section class="order">

                <h2>Order ID: <?= $groupedOrder['order_id'] ?></h2>

                <div class="order-items">

                    <?php foreach ($groupedOrder['items'] as $item): ?>

                        <a class="order-item" href="/catalogue/item/<?= $item['item_id'] ?>">

                            <img src="<?= $item['image'] ?>" alt="item">

                            <p><?= $item['name'] ?> (<?= strtoupper($item['size']) ?>)</p>

                            <p>Quantity: <?= $item['quantity'] ?></p>

                            <p>$<?= $item['unit_price_snapshot'] ?></p>

                        </a>

                    <?php endforeach; ?>

                </div>

                <div class="order-info">

                    <p>Sum: $<?= $groupedOrder['total_price'] ?></p>

                    <p>Date: <?= date('d/m/Y', strtotime($groupedOrder['date_ordered'])) ?></p>

                    <?php if ($groupedOrder['delivered_at']): ?>

                        <p>Delivered at: <?= date('d/m/Y', strtotime($groupedOrder['delivered_at'])) ?></p>

                        <?php else: ?>

                        <p>Expected delivery: <?= date('d/m/Y', strtotime($groupedOrder['estimated_delivery'])) ?></p>

                    <?php endif; ?>

                    <p>Status: <?= $groupedOrder['status'] ?></p>

                    <p>
                        <a href="/customer-order/<?= $groupedOrder['order_id'] ?>">
                            Expanded info
                        </a>
                    </p>

                </div>

            </section>

        <?php endforeach ?>

    </div>


<?php require_once __DIR__ . '/../partials/footer.php'; ?>