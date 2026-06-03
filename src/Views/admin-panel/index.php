<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="admin-panel-box">
    <div class=admin-panel-main>
        <span>Admin panel</span>
            <div>
                <a href="/admin-panel/users"><button type="submit" class="submit">Modify users</button></a>
            </div>

            <div>
                <a href="/admin-panel/items"><button type="submit" class="submit">Modify items</button></a>
            </div>

            <div>
                <a href="/admin-panel/orders"><button type="submit" class="submit">Modify orders</button></a>
            </div>

            <div>
                <a href="/admin-panel/statistics"><button type="submit" class="submit">Statistics</button></a>
            </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>