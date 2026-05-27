<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php'; ?>

<div class="banner-box">
    <img alt="banner" src="/assets/backgrounds/hero_banner.png">
</div>


<div class="item-list-box">

    <form action="/catalogue" method="GET" class="wall">

        <input 
        type="hidden" 
        name="search" 
        id="filterSearch"
        value="<?= $_GET['search'] ?? '' ?>"
        >

        <?php
        $selectedCategories = $_GET['category'] ?? [];
        $selectedGender = $_GET['gender'] ?? 'any';
        $selectedPrice = $_GET['filter_price'] ?? 'any';

        // In case only one checkbox is selected
        if (!is_array($selectedCategories)) {
            $selectedCategories = [$selectedCategories];
        }
        ?>

        <div class="filter-group">

            <p>Category:</p>

            <label class="checkbox-option">
                <input 
                    type="checkbox" 
                    name="category[]" 
                    value="hats"
                    <?= in_array('hats', $selectedCategories) ? 'checked' : '' ?>
                >
                Hats
            </label>

            <label class="checkbox-option">
                <input 
                    type="checkbox" 
                    name="category[]" 
                    value="jeans"
                    <?= in_array('jeans', $selectedCategories) ? 'checked' : '' ?>
                >
                Jeans
            </label>

            <label class="checkbox-option">
                <input 
                    type="checkbox" 
                    name="category[]" 
                    value="shoes"
                    <?= in_array('shoes', $selectedCategories) ? 'checked' : '' ?>
                >
                Shoes
            </label>

            <label class="checkbox-option">
                <input 
                    type="checkbox" 
                    name="category[]" 
                    value="shirts"
                    <?= in_array('shirts', $selectedCategories) ? 'checked' : '' ?>
                >
                Shirts
            </label>

        </div>

        <div>
            <label for="gender">Gender:</label>

            <select class="catalogue-option" name="gender" id="gender">

                <option value="any" <?= $selectedGender === 'any' ? 'selected' : '' ?>>
                    Any
                </option>

                <option value="Male" <?= $selectedGender === 'Male' ? 'selected' : '' ?>>
                    Male
                </option>

                <option value="Female" <?= $selectedGender === 'Female' ? 'selected' : '' ?>>
                    Female
                </option>

                <option value="Unisex" <?= $selectedGender === 'Unisex' ? 'selected' : '' ?>>
                    Unisex
                </option>

            </select>
        </div>

        <div>
            <label for="filter_price">Price:</label>

            <select class="catalogue-option" name="max_price" id="filter_price">

                <option value="any" <?= $selectedPrice === 'any' ? 'selected' : '' ?>>
                    Any
                </option>

                <option value="30" <?= $selectedPrice === '30' ? 'selected' : '' ?>>
                    Under $30
                </option>

                <option value="40" <?= $selectedPrice === '40' ? 'selected' : '' ?>>
                    Under $40
                </option>

                <option value="50" <?= $selectedPrice === '50' ? 'selected' : '' ?>>
                    Under $50
                </option>

                <option value="60" <?= $selectedPrice === '60' ? 'selected' : '' ?>>
                    Under $60
                </option>

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

                    </form>
                </div>
            </a>

        <?php endforeach ?>
        </div>

    </div>
</div>

<script>

document.getElementById('filterForm').addEventListener('submit', function () {
    const searchBar = document.getElementById('searchBar');
    const filterSearch = document.getElementById('filterSearch');

    if (searchBar && filterSearch) {
        filterSearch.value = searchBar.value;
    }
});

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