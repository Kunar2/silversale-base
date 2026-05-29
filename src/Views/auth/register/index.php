<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';
?>


    <div class="middle-text-register">
        <?= is_array($data['error']) 
            ? implode(', ', $data['error']) 
            : ($data['error'] ?? '') 
        ?>

        <form action="/register" method="POST" class="input-form">
            <div>
                <div class="data-type"><label for="username-input" class="data-type">Username</label></div>
                <input type="text" id="username-input" name="username" class="input-field" placeholder="Username">
            </div>

            <div>
                <div class="data-type"><label for="password-input" class="data-type">Password</label></div>
                <input type="password" id="password-input" name="password" class="input-field" placeholder="Password">
                <button type="button" class="inside" id="swap" onclick="textVisibility()">Show</button>
            </div>

            <div>
                <div class="data-type"><label for="email-input" class="data-type">Email</label></div>
                <input type="text" id="email-input" name="email" class="input-field" placeholder="Email">
            </div>

            <div class="submit-section">
                <button type="submit" class="submit" value="Submit">Submit</button>
            </div>
        </form>

        <div><a href="login">Already have an account?</a></div>

    </div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>