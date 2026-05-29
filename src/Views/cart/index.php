<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<?php 
$total = 0;
foreach ($cartItems as $cartItem):
    $total = $total + $cartItem['line_subtotal'];
endforeach ?>

<div class="cart-box">

    <h1 class="cart-title">Your bag</h1>

    <?php 
    $total = 0;
    foreach ($cartItems as $cartItem):
        $total += $cartItem['line_subtotal'];
    endforeach;
    ?>

    <div class="cart-items">
        <?php foreach ($cartItems as $cartItem): ?>
        <div class="cart-item" id="<?= $cartItem['unit_id'] ?>">
            
            <div class="cart-item-image">
                <a href="item">
                    <img src="<?= $cartItem['image'] ?>" alt="<?= $cartItem['name'] ?>">
                </a>
            </div>

            <div class="cart-item-details">
                <a href="item" class="cart-item-name">
                    <?= htmlspecialchars($cartItem['name']) ?> (<?= strtoupper($cartItem['size']) ?>)
                </a>
                <p class="cart-item-description"><?= htmlspecialchars($cartItem['description']) ?></p>

                <div class="quantity-box">
                    <form action="/cart/delete/<?= $cartItem['unit_id'] ?>" method="post" style="display: inline;">
                        <button class="quantity-minus" type="submit">-</button>
                    </form>

                    <input class="quantity" type="text" value="<?= $cartItem['item_quantity'] ?>" readonly>

                    <form action="/cart/insert/<?= $cartItem['unit_id'] ?>" method="post" style="display: inline;">
                        <button class="quantity-plus" type="submit">+</button>
                    </form>
                </div>

                <div class="cart-item-price">
                    $<span><?= $cartItem['line_subtotal'] ?></span>
                </div>

                <form action="/cart/delete-full/<?= $cartItem['unit_id'] ?>" method="post">
                    <button type="submit" class="remove-btn">Remove</button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php if ($total > 0): ?>
    <div class="cart-summary">
        <div class="summary-content">
            <div class="total">
                Total: <span id="subtotal">$<?= $total ?></span>
            </div>
            <p class="shipping-note">Shipping prices, taxes, and time of arrival will be specified at the checkout.</p>
            
            <a href="checkout" style="text-decoration: none;">
                <button class="checkout" type="button">Proceed to checkout</button>
            </a>
        </div>
    </div>
    <?php endif ?>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>