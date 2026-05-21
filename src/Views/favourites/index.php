<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="item-list-favourite">

    <div class="favourites-title">
        <h1>Favourites</h1>
    </div>

    <?php foreach ($favourites as $favourite): ?>

        <a class="grid-item" href="catalogue/item/<?= $favourite['item_id'] ?>">

            <img alt="item" src="<?= $favourite['image'] ?>">
            <p class="item-price"> 

            <?php 
                if ($favourite['sale_price'] === $favourite['price']) {
                    echo "<span class='item-price'>$" . $favourite['price'] . "</span>";
                } else {

                $discountPercentage = round(
                    (($favourite['price'] - $favourite['sale_price']) / $favourite['price']) * 100
                );

                echo "<span class='item-price-sale'>$" . $favourite['sale_price'] . "</span> ";
                echo "<span class='item-price-original'>$" . $favourite['price'] . "</span> ";
                echo "<span class='item-price-percentage'>-" . $discountPercentage . "%</span>";
            }
            ?>
            <p><?= $favourite['name'] ?></p>
            <p>
                <i class="fa-solid fa-star fa-xs"></i>
                <span><?= $favourite['rating'] ?> (<?= $favourite['reviews'] ?>)</span>
            </p>
            <div class="item-btn-section">
                <form method="POST" action="/programme/${programme.id}/remove_cart" class="item-btn-form">
                <button class="item-btn picked">Add to cart</button>
                </form>
            </div>
        </a>

    <?php endforeach ?>
    
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>