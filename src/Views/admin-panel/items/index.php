<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>

<div class="admin-panel-box">
    
    <div class="admin-panel-main">

        <span>Items</span>

        <div>   
            <a href="/admin-panel/items/item-data/0">
                <button type="submit" class="submit">Add item</button>
            </a>
        </div>

        <table class="admin-panel-table">
        <tr>
            <th class="edit-column"></th>
            <th>Item ID</th>
            <th>Name</th>
            <th>Manufacturer</th>
        </tr>

        <?php foreach ($items as $item): ?>

        <tr>
            <td class="edit-column">
            <a href="/admin-panel/items/item-data/<?= $item['item_id'] ?>">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td><?= $item['item_id'] ?></td>
            <td><?= $item['name'] ?></td>
            <td><?= $item['manufacturer'] ?></td>
        </tr>

        <?php endforeach; ?>

        </table>
    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>