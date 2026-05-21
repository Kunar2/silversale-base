<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>

<div class="admin-panel-box">
    
    <div class="admin-panel-main">

        <span>Items</span>

        <table class="admin-panel-table">
        <tr>
            <th class="edit-column"></th>
            <th>Item ID</th>
            <th>Name</th>
            <th>Manufacturer</th>
        </tr>

        <tr>
            <td class="edit-column">
            <a href="item-data?id=1">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>1</td>
            <td>Baseball Cap</td>
            <td>Mikes Corp.</td>
        </tr>

        <tr>
            <td class="edit-column">
            <a href="item-data?id=2">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>2</td>
            <td>White T-Shirt</td>
            <td>Fashion et al.</td>
        </tr>

        <tr>
            <td class="edit-column">
            <a href="item-data?id=3">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>3</td>
            <td>Denim Jacket</td>
            <td>Mikes Corp.</td>
        </tr>

        <tr>
            <td class="edit-column">
            <a href="item-data?id=4">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>4</td>
            <td>Cargo Pants</td>
            <td>Cho Corp.</td>
        </tr>
        </table>

        <div>
            <a href="item-data">
                <button type="submit" class="submit">Add item</button>
            </a>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>