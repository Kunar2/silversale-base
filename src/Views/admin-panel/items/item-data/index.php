<?php 
require_once __DIR__ . '/../../../partials/head.php';
require_once __DIR__ . '/../../../partials/navbar.php';



?>

<div class="item-data-box">

        <div class="item-data-header">
            <p>Item data</p>
        </div>

        <form class="item-data-form">

            <div class="form-grid">

                <div class="form-group">
                    <label>ID:</label>
                    <input type="text" name="id">
                </div>

                <div class="form-group">
                    <label>Name:</label>
                    <input type="text" name="name">
                </div>

                <div class="form-group">
                    <label>Manufacturer:</label>
                    <input type="text" name="listed">
                </div>

                <div class="form-group">
                    <label>Description:</label>
                    <input type="text" name="description">
                </div>

                <div class="form-group">
                    <label>Category:</label>
                    <input type="text" name="category">
                </div>

                <div class="form-group">
                    <label>Gender:</label>
                    <input type="text" name="gender">
                </div>

                <div class="form-group">
                    <label>Price:</label>
                    <input type="text" name="price">
                </div>

                <div class="form-group">
                    <label>Image:</label>
                    <input type="text" name="image">
                </div>

                <div class="form-group">
                    <label>Listed:</label>
                    <input type="text" name="listed">
                </div>

                <table class="admin-panel-table order-items-table" style="margin: 0">
                    <tr>
                        <th>Size</th>
                        <th>Quantity</th>
                    </tr>

                    <tr>
                        <td>S</td>
                        <td>15</td>
                    </tr>

                    <tr>
                        <td>M</td>
                        <td>2</td>
                    </tr>

                    <tr>
                        <td>L</td>
                        <td>52</td>
                    </tr>
                </table>

            </div>

            <div class="item-data-buttons">
                <button type="submit" class="accept-btn">Accept changes</button>
                <button type="submit" class="discard-btn">Discard changes</button>
                <button type="button" class="delete-btn">Delete item</button>
            </div>

        </form>

    </div>

<?php require_once __DIR__ . '/../../../partials/footer.php'; ?>