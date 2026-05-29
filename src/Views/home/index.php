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
            <input type="text" name="search" placeholder="Search for an item..." />
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

                    <?php if (!empty($item['is_favourited'])): ?>

                        <form action="/favourites/remove/<?= $item['item_id'] ?>" method="POST">
                            <button type="submit" class="favourite-heart picked">
                                <i class="fa-solid fa-heart fa-lg"></i>
                            </button>
                        </form>

                    <?php else: ?>

                        <form action="/favourites/insert/<?= $item['item_id'] ?>" method="POST">
                            <button type="submit" class="favourite-heart">
                                <i class="fa-regular fa-heart fa-lg"></i>
                            </button>
                        </form>

                    <?php endif; ?>

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
                        <?php if (!empty($item['item_in_cart'])): ?>

                        <button class="item-btn picked" href="/catalogue/item/<?= $item['item_id'] ?>" >Manage item</button>

                    <?php else: ?>

                        <button class="item-btn unpicked" href="/catalogue/item/<?= $item['item_id'] ?>" >Add to cart</button>

                    <?php endif; ?>

                    </div>
                </a>

            <?php endforeach ?>

            </div>
        </section>

        <section class="featured-section">
            <h2>Popular categories:</h2>

            <a href="/catalogue?category[]=hats"><button class="category-btn picked">Hats</button></a>
            <a href="/catalogue?category[]=jeans"><button class="category-btn picked">Jeans</button></a>
            <a href="/catalogue?category[]=shirts"><button class="category-btn picked">Shirts</button></a>
            <div class="featured-list">
            
            <?php foreach ($popularCategories as $item): ?>

                <a class="grid-item" href="/catalogue/item/<?= $item['item_id'] ?>">

                    <?php if (!empty($item['is_favourited'])): ?>
                        <form action="/favourites/remove/<?= $item['item_id'] ?>" method="POST">
                            <button type="submit" class="favourite-heart picked">
                                <i class="fa-solid fa-heart fa-lg"></i>
                            </button>
                        </form>
                    <?php else: ?>
                        <form action="/favourites/insert/<?= $item['item_id'] ?>" method="POST">
                            <button type="submit" class="favourite-heart">
                                <i class="fa-regular fa-heart fa-lg"></i>
                            </button>
                        </form>
                    <?php endif; ?>

                    <img alt="item" src="<?= $item['image'] ?>">

                    <p class="item-price">
                        <?php if ($item['sale_price'] === $item['price']): ?>
                            <span class="item-price">$<?= $item['price'] ?></span>
                        <?php else: ?>
                            <?php $discountPercentage = round((($item['price'] - $item['sale_price']) / $item['price']) * 100); ?>
                            <span class="item-price-sale">$<?= $item['sale_price'] ?></span>
                            <span class="item-price-original">$<?= $item['price'] ?></span>
                            <span class="item-price-percentage">-<?= $discountPercentage ?>%</span>
                        <?php endif; ?>
                    </p>

                    <p><?= $item['name'] ?></p>

                    <p>
                        <i class="fa-solid fa-star fa-xs"></i>
                        <span><?= $item['rating'] ?> (<?= $item['reviews'] ?>)</span>
                    </p>

                    <div class="item-btn-section">
                        <?php if (!empty($item['item_in_cart'])): ?>
                            <button class="item-btn picked" type="button">Manage item</button>
                        <?php else: ?>
                            <button class="item-btn unpicked" type="button">Add to cart</button>
                        <?php endif; ?>
                    </div>
                </a>

            <?php endforeach ?>
            </div>
        </section>


        <section class="featured-section">
            <h2>New arrivals:</h2>

            <div class="featured-list">

                <?php foreach ($recentItems as $item): ?>

                <a class="grid-item" href="/catalogue/item/<?= $item['item_id'] ?>">

            <?php if (!empty($item['is_favourited'])): ?>
                <form action="/favourites/remove/<?= $item['item_id'] ?>" method="POST">
                    <button type="submit" class="favourite-heart picked">
                        <i class="fa-solid fa-heart fa-lg"></i>
                    </button>
                </form>
            <?php else: ?>
                <form action="/favourites/insert/<?= $item['item_id'] ?>" method="POST">
                    <button type="submit" class="favourite-heart">
                        <i class="fa-regular fa-heart fa-lg"></i>
                    </button>
                </form>
            <?php endif; ?>

            <img alt="item" src="<?= $item['image'] ?>">

            <p class="item-price">
                <?php if ($item['sale_price'] === $item['price']): ?>
                    <span class="item-price">$<?= $item['price'] ?></span>
                <?php else: ?>
                    <?php $discountPercentage = round((($item['price'] - $item['sale_price']) / $item['price']) * 100); ?>
                    <span class="item-price-sale">$<?= $item['sale_price'] ?></span>
                    <span class="item-price-original">$<?= $item['price'] ?></span>
                    <span class="item-price-percentage">-<?= $discountPercentage ?>%</span>
                <?php endif; ?>
            </p>

            <p><?= $item['name'] ?></p>

            <p>
                <i class="fa-solid fa-star fa-xs"></i>
                <span><?= $item['rating'] ?> (<?= $item['reviews'] ?>)</span>
            </p>

            <div class="item-btn-section">
                <?php if (!empty($item['item_in_cart'])): ?>
                    <button class="item-btn picked" type="button">Manage item</button>
                <?php else: ?>
                    <button class="item-btn unpicked" type="button">Add to cart</button>
                <?php endif; ?>
            </div>
        </a>
                <?php endforeach ?>

            </div>
        </section>

        <a class="catalogue-link" href="catalogue">To catalogue</a>
    </div>

    <script>
        const hearts = document.querySelectorAll(".favourite-heart");
            hearts.forEach(heart => {

                heart.addEventListener("click", () => {

                    const icon = heart.querySelector("i");

                    icon.classList.toggle("fa-regular");
                    icon.classList.toggle("fa-solid");

                });

            });
    </script>   

    <?php require_once __DIR__ . '/../partials/footer.php'; ?>