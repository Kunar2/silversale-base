<?php 
require_once __DIR__ . '/../../partials/head.php';
require_once __DIR__ . '/../../partials/navbar.php';

// if (isset($_SESSION['user_id'])) {
//     echo "User is logged in";
// } else {
//     echo "User is not logged in";
// }
?>

    <div class="login-box">
        <div class=login-main>
            <span>Sign in</span>
            <form action="/login" method="POST">
                <div>
                    <span><input type="text" class="input-field" placeholder="Username" name="username"> </span>
                </div>
                <div>
                    <input type="password" class="input-field" id="password-input" placeholder="Password" name="password">
                    <button type="button" class="inside" id="swap" onclick="textVisibility()">Show</button>
                </div>
                <div>
                    <button type="submit" class="submit" value="Submit">Submit</button>
                </div>
            </form>
        </div>

        <div class="register-main">
            <span class="noaccount">No account?</span>
            <div>
                <a href="register">
                <button type="submit" class="submit" value="Submit">Create account</button>
                </a>
            </div>
        </div>
    </div>

<?php require_once __DIR__ . '/../../partials/footer.php'; ?>