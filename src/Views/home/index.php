<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<a class="banner-box" href="/catalogue">
    <img alt="banner" src="/assets/backgrounds/hero_banner.png">
</a>

<div class="home-main">
    <h1>Silversale: Find your style</h1>

    <form class="main-search" action="catalogue" method="GET">
        <input type="text" name="keywords" placeholder="Search for an item..." />
        <button type="submit">
        <i class="fa-solid fa-magnifying-glass"></i>
        </button>
    </form>

        <div class="item-list">


        </div>

    <section class="featured-section">
        <h2>Featured items:</h2>

        <div class="featured-list">

        <?php foreach ($popularItems as $item): ?>

            <a class="grid-item" href="catalogue/item/<?= $item['item_id'] ?>">

                <img alt="item" src="<?= $item['image'] ?>">
                <p class="item-price"> 
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
                <p><?= $item['name'] ?></p>
                <p>
                    <i class="fa-solid fa-star fa-xs"></i>
                    <span><?= $item['rating'] ?> (<?= $item['reviews'] ?>)</span>
                </p>
                <div class="item-btn-section">
                    <form method="POST" action="/programme/${programme.id}/remove_cart" class="item-btn-form">
                    <button class="item-btn unpicked">Add to cart</button>
                    </form>
                </div>
            </a>

        <?php endforeach ?>

        </div>
    </section>

    <section class="featured-section">
        <h2>Popular categories:</h2>

        <a href="catalogue"><button class="category-btn picked">Hats</button></a>
        <a href="catalogue"><button class="category-btn picked">Jeans</button></a>
        <a href="catalogue"><button class="category-btn picked">Shirts</button></a>
        <div class="featured-list">
        
        <?php foreach ($popularCategories as $item): ?>

            <a class="grid-item" href="catalogue/item/<?= $item['item_id'] ?>">

                <img alt="item" src="<?= $item['image'] ?>">
                <p class="item-price"> 
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
                <p><?= $item['name'] ?></p>
                <p>
                    <i class="fa-solid fa-star fa-xs"></i>
                    <span><?= $item['rating'] ?> (<?= $item['reviews'] ?>)</span>
                </p>
                <div class="item-btn-section">
                    <form method="POST" action="/programme/${programme.id}/remove_cart" class="item-btn-form">
                    <button class="item-btn unpicked">Add to cart</button>
                    </form>
                </div>
            </a>

        <?php endforeach ?>
        </div>
    </section>


    <section class="featured-section">
        <h2>New arrivals:</h2>

        <div class="featured-list">

            <?php foreach ($recentItems as $item): ?>

                <a class="grid-item" href="catalogue/item/<?= $item['item_id'] ?>">

                    <img alt="item" src="<?= $item['image'] ?>">
                    <p class="item-price"> 
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
                    <p><?= $item['name'] ?></p>
                    <p>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <span><?= $item['rating'] ?> (<?= $item['reviews'] ?>)</span>
                    </p>
                    <div class="item-btn-section">
                        <form method="POST" action="/programme/${programme.id}/remove_cart" class="item-btn-form">
                        <button class="item-btn unpicked">Add to cart</button>
                        </form>
                    </div>
                </a>

            <?php endforeach ?>

        </div>
    </section>

    <a class="catalogue-link" href="catalogue">To catalogue</a>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>