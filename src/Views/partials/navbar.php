<header>
    <?php 
    $selectedPrice = $_GET['search'] ?? '';
    ?>
    <div class="navigation-container">

        <a class="title" href="/">Silversale</a>

        <!-- Common links for everyone -->
        <a href="/catalogue" class="nav-item <?= ($currentPage === 'catalogue') ? 'active' : '' ?>">
            <i class="fa-solid fa-list fa-lg"></i>
            <span>Catalogue</span>
        </a>

        <div class="search">
            <form method="GET" action="/catalogue" class="search-form">
                <input class="search-bar" placeholder="Search.." type="text" name="search" value="<?= $selectedPrice ?>" id="searchBar">
                <button class="search-button" type="submit">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </form>
        </div>

        <?php if ($isLoggedIn): ?>

            <!-- Logged-in user navbar -->
            <a href="/favourites" class="nav-item <?= ($currentPage === 'favourites') ? 'active' : '' ?>">
                <i class="fa-solid fa-heart fa-lg"></i>
                <span>Favourites</span>
            </a>

            <a href="/cart" class="nav-item <?= ($currentPage === 'cart') ? 'active' : '' ?>">
                <i class="fa-solid fa-bag-shopping fa-lg"></i>
                <span>Cart</span>
            </a>

            <a href="/orders" class="nav-item <?= ($currentPage === 'orders') ? 'active' : '' ?>">
                <i class="fa-solid fa-box fa-lg"></i>
                <span>Orders</span>
            </a>

            <a href="/account" class="nav-item <?= ($currentPage === 'account') ? 'active' : '' ?>">
                <i class="fa-solid fa-user fa-lg"></i>
                <span><?= htmlspecialchars($username ?? 'Account') ?></span>
            </a>

            <?php if ($_SESSION['role'] === "admin"): ?>

            <a href="/admin-panel" class="nav-item <?= ($currentPage === 'admin-panel') ? 'active' : '' ?>">
                <i class="fa-solid fa-gear fa-lg"></i>
                <span>Admin panel</span>
            </a>

            <?php endif; ?>
 

        <?php else: ?>

            <!-- Guest navbar -->

            <a href="/favourites" class="nav-item <?= ($currentPage === 'favourites') ? 'active' : '' ?>">
                <i class="fa-solid fa-heart fa-lg"></i>
                <span>Favourites</span>
            </a>

            <a href="/cart" class="nav-item <?= ($currentPage === 'cart') ? 'active' : '' ?>">
                <i class="fa-solid fa-bag-shopping fa-lg"></i>
                <span>Cart</span>
            </a>

            <a href="/orders" class="nav-item <?= ($currentPage === 'orders') ? 'active' : '' ?>">
                <i class="fa-solid fa-box fa-lg"></i>
                <span>Orders</span>
            </a>

            <a href="/login" class="nav-item <?= ($currentPage === 'login') ? 'active' : '' ?>">
                <i class="fa-solid fa-right-to-bracket fa-lg"></i>
                <span>Log in</span>
            </a>

        <?php endif; ?>

    </div>
</header>