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
        <section class="order">
            <h2>Order ID: 2442FAF</h2>

            <div class="order-items">
                <a class="order-item" href="/item">
                    <img src="public/item_1.png" alt="item">
                    <p>Name</p>
                    <p>Price</p>
                    <p>Rating</p>
                </a>

                <a class="order-item" href="/item">
                    <img src="public/item_1.png" alt="item">
                    <p>Name</p>
                    <p>Price</p>
                    <p>Rating</p>
                </a>

                <a class="order-item" href="/item">
                    <img src="public/item_1.png" alt="item">
                    <p>Name</p>
                    <p>Price</p>
                    <p>Rating</p>
                </a>
            </div>

            <div class="order-info">
                <p>Sum: $42</p>
                <p>Date: 04/05/2026</p>
                <p>Address: Samal-3, 25</p>
                <p>Expected delivery: 24/05/2026</p>
                <p>Status: Processing</p>
                <p><a href="/customer-order">Expanded info</a></p>
            </div>
        </section>

        <section class="order">
            <h2>Order ID: 2362dAF</h2>

            <div class="order-items">
                <a class="order-item" href="/item">
                    <img src="public/item_1.png" alt="item">
                    <p>Name</p>
                    <p>Price</p>
                    <p>Rating</p>
                </a>

                <a class="order-item" href="/item">
                    <img src="public/item_1.png" alt="item">
                    <p>Name</p>
                    <p>Price</p>
                    <p>Rating</p>
                </a>
            </div>

            <div class="order-info">
                <p>Sum: $24</p>
                <p>Date: 24/05/2026</p>
                <p>Address: Al-Farabi, 25</p>
                <p>Expected delivery: 14/05/2026</p>
                <p>Status: Shipped</p>
                <p><a href="/customer-order">Expanded info</a></p>
            </div>
        </section>
    </div>


<?php require_once __DIR__ . '/../partials/footer.php'; ?>