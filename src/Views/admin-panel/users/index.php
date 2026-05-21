<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>

<div class="admin-panel-box">
    
    <div class="admin-panel-main">

        <span>Users</span>

        <table class="admin-panel-table">

        <tr>
            <th class="edit-column"></th>
            <th>User ID</th>
            <th>Username</th>
            <th>Email</th>
        </tr>

        <tr>
            <td class="edit-column">
                <a href="user-data?id=1">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>1</td>
            <td>john</td>
            <td>john@email.com</td>
        </tr>

        <tr>
            <td class="edit-column">
                <a href="user-data?id=2">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>2</td>
            <td>smith</td>
            <td>smith@email.com</td>
        </tr>

        <tr>
            <td class="edit-column">
                <a href="user-data?id=3">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>3</td>
            <td>michael</td>
            <td>michael@email.com</td>
        </tr>

        <tr>
            <td class="edit-column">
                <a href="user-data?id=4">Edit <i class="fa-solid fa-pencil"></i></a>
            </td>
            <td>4</td>
            <td>emily</td>
            <td>emily@email.com</td>
        </tr>
        </table>
        <div>
        <a href="user-data">
            <button type="submit" class="submit">Add user</button>
        </a>
        </div>

    </div>
</div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>