<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

    <div class="cart-box">

        <div class="cart-title">
            Your bag
        </div>

        <div class="subtotal-box">
            <a href="checkout"> <button class="checkout" type="button">Proceed to checkout</button></a>
            <p class="subtotal-text">Subtotal: <span id="subtotal">$25</span></span> </p>
            <p class="checkout-info">Shipping prices, taxes, and time of arrival will be specified at the checkout.</p>
        </div>

        <div class="cart-item" id="1">
                <a href="item" style="text-decoration: none">
                    <div class="cart-item-image"> <img alt="name" src="public/item_1.png"></div>

                    <div class="cart-description">
                        <p class="cart-item-name">Baseball Cap</p>
                        <p class="cart-item-description">Baseball cap for sunny weather.</p>
                    </div>
                </a>

                <div class="quantity-box">
                    <input class="quantity_minus" type="button" value="-" />

                    <input class="quantity" type="text" value="1" />

                    <input class="quantity_plus" type="button" value="+" />

                    <div class="cart-item-price">
                        $<span>25</span>
                    </div>
                </div>

                <p class="remove"><a href="#delete_item">Remove</a></p>
        </div>
    </div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>