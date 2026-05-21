<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="banner-box">
    <img alt="banner" src="/assets/backgrounds/hero_banner.png">
</div>


<div class="item-list-box">

    <form action="" class="wall">
        <div class="filter-group">

            <p>Category:</p>

            <label class="checkbox-option">
                <input type="checkbox" name="category" value="hats">
                Hats
            </label>

            <label class="checkbox-option">
                <input type="checkbox" name="category" value="jeans">
                Jeans
            </label>

            <label class="checkbox-option">
                <input type="checkbox" name="category" value="shoes">
                Shoes
            </label>

            <label class="checkbox-option">
                <input type="checkbox" name="category" value="jackets">
                Jackets
            </label>

            <label class="checkbox-option">
                <input type="checkbox" name="category" value="coats">
                Coats
            </label>

        </div>
        <div>
            <label for="filter_gender">Gender:</label>
            <select class="catalogue-option" name="filter_gender" id="filter_gender">
                <option value="any">Any</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="unisex">Unisex</option>
            </select>
        </div>

        <div>
            <label for="filter_price">Price:</label>

            <select class="catalogue-option" name="filter_price" id="filter_price">
                <option value="any">Any</option>
                <option value="30">Under $30</option>
                <option value="40">Under $40</option>
                <option value="50">Under $50</option>
                <option value="60">Under $60</option>
            </select>
        </div>

        <button class="item-submit">Apply</button>
    </form>
    

    <div class="item-section">

        <div class="sort-box">  
            <select class="catalogue-option" name="sort_type" id="sort_by">
                <option value="name">Relevance</option>
                <option value="reviews">Popularity</option>
                <option value="price">Price (ascending)</option>
                <option value="price">Price (descending)</option>
            </select>
        </div>

        <div class="item-list">

        <?php foreach ($items as $item): ?>

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
                
                <div class="item-btn-section">
                    <form method="POST" action="/programme/${programme.id}/remove_cart" class="item-btn-form">
                    <button class="item-btn unpicked">Add to cart</button>
                    </form>
                </div>
            </a>

        <?php endforeach ?>
        </div>

    </div>
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