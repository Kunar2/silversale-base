<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>

<div class="item-container">

    <img alt="item" class="image-position" src="<?= $item['image'] ?>">

    <div class="item-header">
        <div class="item-category"><?= $item['category'] ?></div>
        <div class="description-top"><?= $item['name'] ?></div>
        <div class="item-manufacturer"><?= $item['manufacturer'] ?></div>
        <div class="review-data">
            <i class="fa-solid fa-star fa-xs"></i>
            <span><?= $item['rating'] ?> (<?= $item['reviews'] ?>)</span>
        </div>

        <div class="item-description"><?= $item['description'] ?></div> 

        <div class="description-top">Size:</div>

        <div class="description-main">
            <?php foreach ($inventory as $unit): ?> 

                <button 
                    class="size-btn <?= $unit['quantity'] > 0 ? 'unpicked' : 'disabled' ?>"
                    type="button"
                    data-unit-id="<?= $unit['unit_id'] ?>"
                    data-quantity="<?= $unit['quantity'] ?>"
                    data-unit-in-cart="<?= $unit['unit_in_cart'] ? '1' : '0' ?>"
                    <?= $unit['quantity'] == 0 ? 'disabled' : '' ?>
                >
                    <?= strtoupper($unit['size']) ?>
                </button>

            <?php endforeach; ?>
        </div>

    

        <div class="description-top">

        <?php 
            if ($item['sale_price'] === $item['price']) {

                echo "<span class='item-price'>$" . $item['price'] . "</span>";

            } else {

                $discountPercentage = round(
                    (($item['price'] - $item['sale_price']) / $item['price']) * 100
                );

                echo "<span class='item-price-sale'>$" . $item['sale_price'] . "</span> ";
                echo "<span class='item-price-original'>$" . $item['price'] . "</span> ";
                echo "<span class='item-price-percentage'>-" . $discountPercentage . "%</span>";
            }
        ?>
        </div>

        <div class="description-top">
            Available: <span id="availableQuantity">Select a size</span>
        </div>

        <div>
            <form action="cart/insert" method="POST" id="cart-form">
                <input type="hidden" name="unit_id" id="selectedUnitId">
                <button class="cart-btn" id="cart-btn" disabled>Add to cart</button>
            </form>
        </div>

        <?php if ($item['is_favourited']): ?>

            <form action="/favourites/remove/<?= $item['item_id'] ?>" method="POST">
                <button class="cart-btn picked">
                    Unfavourite
                </button>
            </form>

        <?php else: ?>

            <form action="/favourites/insert/<?= $item['item_id'] ?>" method="POST">
                <button class="cart-btn">
                    Favourite
                </button>
            </form>

        <?php endif; ?>

    </div>

</div>

<script>
    const sizeButtons = document.querySelectorAll('.size-btn');
    const quantityText = document.getElementById('availableQuantity');
    const selectedUnitInput = document.getElementById('selectedUnitId');
    const cartButton = document.getElementById('cart-btn');
    const cartForm = document.getElementById('cart-form');

    sizeButtons.forEach(button => {

        button.addEventListener('click', () => {

            cartButton.disabled = false;

            sizeButtons.forEach(btn => {
                btn.classList.remove('picked');
                btn.classList.add('unpicked');
            });

            button.classList.remove('unpicked');
            button.classList.add('picked');

            const quantity = button.dataset.quantity;
            const unitId = button.dataset.unitId;
            const isInCart = button.dataset.unitInCart === '1';

            quantityText.textContent = quantity;
            selectedUnitInput.value = unitId;

            if (isInCart) {
                cartButton.textContent = 'Remove from cart';

                cartButton.classList.remove('unpicked');
                cartButton.classList.add('picked');
                cartForm.action = '/cart/delete/' + selectedUnitInput.value;

            } else {
                cartButton.textContent = 'Add to cart';

                cartButton.classList.remove('picked');
                cartButton.classList.add('unpicked');
                cartForm.action = '/cart/insert/' + selectedUnitInput.value;
            }
        });

    });
</script>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>