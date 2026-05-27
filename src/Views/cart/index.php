<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

    <div class="cart-box">

        <div class="cart-title">
            Your bag
        </div>

        <?php 
        $total = 0;
        foreach ($cartItems as $cartItem):
            $total = $total + $cartItem['line_subtotal'];
        endforeach ?>

        <div class="subtotal-box">
            <a href="checkout"> <button class="checkout" type="button">Proceed to checkout</button></a>
            <p class="subtotal-text">Total: <span id="subtotal">$ <?= $total ?> </span></span> </p>
            <p class="checkout-info">Shipping prices, taxes, and time of arrival will be specified at the checkout.</p>
        </div>

        <?php foreach ($cartItems as $cartItem): ?>

        <div class="cart-item" id="<?= $cartItem['unit_id'] ?>">
                <a href="item" style="text-decoration: none">
                    <div class="cart-item-image"> <img alt="name" src=<?= $cartItem['image'] ?>></div>

                    <div class="cart-description">
                        <p class="cart-item-name"><?= $cartItem['name'] . " (" . strtoupper($cartItem['size']) . ")" ?></p>
                        <p class="cart-item-description"><?= $cartItem['description'] ?></p>
                    </div>
                </a>

                <div class="quantity-box">
                    <form action="/cart/delete/<?= $cartItem['unit_id'] ?>" method="post" style="display:inline;">
                        <button class="quantity-minus" type="submit">-</button>
                    </form>

                    <input class="quantity" type="text" value="<?= $cartItem['item_quantity'] ?>" />

                    <form action="/cart/insert/<?= $cartItem['unit_id'] ?>" method="post" style="display:inline;">
                        <button class="quantity-plus" type="submit">+</button>
                    </form>

                    <div class="cart-item-price">
                        $<span><?= $cartItem['line_subtotal'] ?></span>
                    </div>
                </div>

                <form action="/cart/delete-full/<?= $cartItem["unit_id"] ?>" method="post">
                    <button type="submit">Remove</button>
                </form>
        </div>

        <?php endforeach ?>

    </div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>