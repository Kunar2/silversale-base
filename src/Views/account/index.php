<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="middle-text-account">

    <form action="/account/update-user" method="POST" enctype="multipart/form-data" id="credentials-form">

    <p class="item-data-header">Account page</p>

    <img alt="profile-icon" name="image" src="<?= $user['image'] ?? '/assets/icons/icon.jpg' ?>" class="profile-icon" id="profile-icon">

    <div class="credentials-section"> 
        <div class="data-type">Username: <span><?= $user['username'] ?> </span></div>
        <div class="data-type">Email: <span><?= $user['email'] ?></span></div>
    </div>

    <div class="address-box">

        <div class="payment-title">
            Preferred delivery address
        </div>

        <div>
         <i class="fa-solid fa-star fa-xs"></i>
    
        <label for="recipient-name">Recipient name:</label>

        <input 
            id="recipient-name"
            name="recipient_name"
            class="credentials-input address-input"
            maxlength="50"
            type="text"
            value="<?= htmlspecialchars($address['recipient_name'] ?? '') ?>"
            disabled
        >
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i>
            <label for="recipient-phone">Recipient phone:</label>

            <input 
                id="recipient-phone"
                name="recipient_phone"
                class="credentials-input address-input"
                maxlength="20"
                type="text"
                value="<?= htmlspecialchars($address['recipient_phone'] ?? '') ?>"
                disabled
            >
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i>
            <label for="country">Country:</label>

            <input 
                id="country"
                name="country"
                class="credentials-input address-input"
                maxlength="25"
                type="text"
                value="<?= htmlspecialchars($address['country'] ?? '') ?>"
                disabled
            >
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i>
            <label for="city">City:</label>

            <input 
                id="city"
                name="city"
                class="credentials-input address-input"
                maxlength="25"
                type="text"
                value="<?= htmlspecialchars($address['city'] ?? '') ?>"
                disabled
            >
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i>
            <label for="address-line-1">Address line 1:</label>

            <input 
                id="address-line-1"
                name="address_line_1"
                class="credentials-input address-input"
                maxlength="25"
                type="text"
                value="<?= htmlspecialchars($address['address_line_1'] ?? '') ?>"
                disabled
            >
        </div>

        <div>
            <i class="fa-regular fa-star fa-xs"></i>
            <label for="address-line-2">Address line 2:</label>

            <input 
                id="address-line-2"
                name="address_line_2"
                class="credentials-input address-input"
                maxlength="25"
                type="text"
                value="<?= htmlspecialchars($address['address_line_2'] ?? '') ?>"
                disabled
            >
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i>
            <label for="postal-code">Postal code:</label>

            <input 
                id="postal-code"
                name="postal_code"
                class="credentials-input address-input"
                maxlength="5"
                type="text"
                value="<?= htmlspecialchars($address['postal_code'] ?? '') ?>"
                oninput="validateDigit(this, 'validateElementValue')"
                disabled
            >
        </div>

        <div>
            <label for="autofill">Autofilling enabled:</label> 
            <br>

            <input 
                id="autofill"
                name="autofill"
                class="address-checkbox"
                type="checkbox"
                <?= !empty($address['autofill']) ? 'checked' : '' ?>
                disabled
            >
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i> = required field
        </div>

        <div>
            <i class="fa-regular fa-star fa-xs"></i> = optional field
        </div>

    </div>

        <div style="text-align: center">
            <button type="button" class="submit" id="change-credentials-btn">
                Change credentials
            </button>
        </div>
    </form>

    <form action="/logout" method="POST" style="text-align: center">
        <input type="hidden" name="action" value="signout" >
        <div>
            <button type="submit" class="signout-btn" value="Submit" style="background-color: red;">Sign out</button>
        </div>
    </form>

</div>

<script>
const button = document.getElementById("change-credentials-btn");
const form = document.getElementById("credentials-form");

let editing = false;

button.addEventListener("click", function () {
    if (!editing) {
        editing = true;

        document.querySelectorAll(".credentials-input, .address-checkbox").forEach(input => {
            input.disabled = false;
        });

        document.querySelector(".credentials-section").innerHTML = `
            <div class="data-type">
                Username:
                <input name="username" class="credentials-input" type="text"
                       value="<?= htmlspecialchars($user['username']) ?>">
            </div>

            <div class="data-type">
                Email:
                <input name="email" class="credentials-input" type="email"
                       value="<?= htmlspecialchars($user['email']) ?>">
            </div>
        `;

        document.getElementById("profile-icon").insertAdjacentHTML("afterend", `
            <input id="profile-icon-input" name="image" type="file" accept="image/*">
        `);

        document.querySelector(".address-box").insertAdjacentHTML("beforebegin", `
            <div id="change-password-box" class="password-box">
                <div class="data-type">
                    New password:
                    <input name="password" class="credentials-input" type="password"
                           placeholder="Leave blank to keep current password">
                </div>
            </div>
        `);

        button.textContent = "Save changes";
    } else {
        form.submit();
    }
});
</script>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>