<?php 
require_once __DIR__ . '/../../../partials/head.php';
require_once __DIR__ . '/../../../partials/navbar.php';

$itemId = $items['item_id'] ?? 0;

$formAction = $itemId == 0
    ? '/admin-panel/items/insert'
    : '/admin-panel/items/update/' . $itemId;

$itemExists = ($items['item_id'] ?? 0) !== 0; 
?>

<div class="item-data-box">

    <div class="item-data-header">
        <p>Item data</p>
    </div>

    <form 
        class="item-data-form" 
        action="<?= $formAction ?>" 
        method="POST"
        enctype="multipart/form-data"
    >

        <div class="form-grid">

            <div class="form-group">
                <label>ID:</label>
                <input type="text" name="id" value="<?= $items['item_id'] ?? '' ?>" disabled>
            </div>

            <div class="form-group">
                <label>Name:</label>
                <input type="text" name="name" value="<?= $items['name'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Manufacturer:</label>
                <input type="text" name="manufacturer" value="<?= $items['manufacturer'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Description:</label>
                <input type="text" name="description" value="<?= $items['description'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Category:</label>
                <select name="category">
                    <option value="1" <?= ($items['category'] ?? '') === 'hats' ? 'selected' : '' ?>>Hats</option>
                    <option value="2" <?= ($items['category'] ?? '') === 'jeans' ? 'selected' : '' ?>>Jeans</option>
                    <option value="3" <?= ($items['category'] ?? '') === 'shirts' ? 'selected' : '' ?>>Shirts</option>
                    <option value="4" <?= ($items['category'] ?? '') === 'shoes' ? 'selected' : '' ?>>Shoes</option>
                </select>
            </div>

            <div class="form-group">
                <label>Gender:</label>
                <select name="gender">
                    <option value="male" <?= ($items['gender'] ?? '') === 'male' ? 'selected' : '' ?>>Male</option>
                    <option value="female" <?= ($items['gender'] ?? '') === 'female' ? 'selected' : '' ?>>Female</option>
                    <option value="unisex" <?= ($items['gender'] ?? '') === 'unisex' ? 'selected' : '' ?>>Unisex</option>
                </select>
            </div>

            <div class="form-group">
                <label>Sale price:</label>
                <input type="text" name="sale_price" value="<?= $items['sale_price'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Price:</label>
                <input type="text" name="price" value="<?= $items['price'] ?? '' ?>">
            </div>

            <div class="form-group">
                <label>Listed:</label>
                <select name="listed">
                    <option value="1" <?= ($items['listed'] ?? 1) == 1 ? 'selected' : '' ?>>Yes</option>
                    <option value="0" <?= ($items['listed'] ?? 1) == 0 ? 'selected' : '' ?>>No</option>
                </select>
            </div>

            <div class="form-group-img">
                <label>Image:</label>
                <br>

                <?php if (!empty($items['image'])): ?>
                    <img src="<?= $items['image'] ?>" style="width: 80px; height: 80px;">
                    <br>
                <?php endif; ?>

                <input type="file" name="image" accept="image/*">
            </div>

        </div>

        <table class="admin-panel-table order-items-table" style="margin: 50px 0 0 0">
            <tr>
                <th>Unit_Id</th>
                <th>Size</th>
                <th>Quantity</th>
            </tr>

            <?php foreach (($items['inventory'] ?? []) as $unit): ?>
                <tr>
                    <td>
                        <?= $unit['unit_id'] ?? '' ?>
                    </td>

                    <td>
                        <?= strtoupper($unit['size'] ?? '') ?>
                    </td>

                    <td>
                        <input 
                            type="text"
                            name="inventory[<?= $unit['unit_id'] ?>][quantity]"
                            value="<?= $unit['quantity'] ?? '' ?>"
                        >
                    </td>
                </tr>
            <?php endforeach; ?>

        </table>

        <div class="item-data-buttons">
            <button type="submit" class="accept-btn">Accept changes</button>
        </div>

    </form>

    <a href="/admin-panel/items" class="item-data-buttons">
        <button type="submit" class="discard-btn">Discard changes</button>
    </a>

    <?php if($itemExists): ?> 

    <form action="/admin-panel/items/delete/<?= $items['item_id'] ?>" method="POST" class="item-data-buttons">
        <button type="submit" class="delete-btn">Delete item</button>
    </form>

    <?php endif; ?> 

</div>

<?php require_once __DIR__ . '/../../../partials/footer.php'; ?>