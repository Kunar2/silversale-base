<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="middle-text-account">

    <p class="item-data-header">Account page</p>

    <img alt="item" src="/assets/icons/icon.jpg" class="profile-icon">

    <div class="credentials-section"> 
        <div class="data-type">Username: <span><?= $user['username'] ?> </span></div>
        <div class="data-type">Email: <span><?= $user['email'] ?></span></div>
    </div>

    <div class="address-box">

        <div class="payment-title">
            Preferred delivery address
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="country">Country:</label>
            <input id="country" class="credentials-input address-input" maxlength="25" type="text" disabled>
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="city">City:</label>
            <input id="city" class="credentials-input address-input" maxlength="25" type="text" disabled>
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="address-line-1">Address line 1:</label>
            <input id="address-line-1" class="credentials-input address-input" maxlength="25" type="text" disabled>
        </div>

        <div>
            <i class="fa-regular fa-star fa-xs"></i><label for="address-line-2">Address line 2:</label>
            <input id="address-line-2" class="credentials-input address-input" maxlength="25" type="text" disabled>
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="postal-code">Postal code:</label>
            <input id="postal-code" class="credentials-input address-input" maxlength="5" type="text"
                oninput="validateDigit(this, 'validateElementValue')" disabled>
        </div>

        <div>
            <label for="autofill">Autofilling enabled:</label> 
            <br>
            <input id="autofill" class="address-checkbox" type="checkbox" disabled>
        </div>

        <div><i class="fa-solid fa-star fa-xs"></i> = required field</div>
        <div><i class="fa-regular fa-star fa-xs"></i> = optional field</div>

    </div>

    <form action="" method="POST">
        <div>
            <button type="submit" class="submit" value="Submit">Change credentials</button>
        </div>
    </form>

    <form action="/logout" method="POST">
        <input type="hidden" name="action" value="signout">
        <div>
            <button type="submit" class="signout-btn" value="Submit" style="background-color: red;">Sign out</button>
        </div>
    </form>

</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>