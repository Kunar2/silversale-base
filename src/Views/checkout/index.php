<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>

<div class="checkout-boxes">

    <div class="address-box">

        <div class="payment-title">
            Delivery details
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="recipient-name">Recipient name:</label>
            <input id="recipient-name" class="credentials-input address-input" maxlength="25" type="text">
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="phone-number">Phone number:</label>
            <input id="phone-number" class="credentials-input address-input" maxlength="25" type="text">
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="country">Country:</label>
            <input id="country" class="credentials-input address-input" maxlength="25" type="text">
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="city">City:</label>
            <input id="city" class="credentials-input address-input" maxlength="25" type="text">
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="address-line-1">Address line 1:</label>
            <input id="address-line-1" class="credentials-input address-input" maxlength="25" type="text">
        </div>

        <div>
            <i class="fa-regular fa-star fa-xs"></i><label for="address-line-2">Address line 2:</label>
            <input id="address-line-2" class="credentials-input address-input" maxlength="25" type="text">
        </div>

        <div>
            <i class="fa-solid fa-star fa-xs"></i><label for="postal-code">Postal code:</label>
            <input id="postal-code" class="credentials-input address-input" maxlength="5" type="text"
                oninput="validateDigit(this, 'validateElementValue')">
        </div>

        <div><i class="fa-solid fa-star fa-xs"></i> = required field</div>
        <div><i class="fa-regular fa-star fa-xs"></i> = optional field</div>

    </div>

    <div class="price-box">
        <div>Subtotal: $120</div>
        <div>Items: $100</div>
        <div>Shipping tax: $20</div>
        <div>Expected delivery: 20th of May</div>
        <a href="/orders">
            <button class="checkout2" type="button">Order</button>
        </a>
    </div>

    <div class="cc-box">

        <div class="payment-title">
            <i class="fa-solid fa-star fa-xs"></i><span>Credit card payment</span>
        </div>

        <div class=cc-section>
            <label for="cc-number1" class="input-field-type">Card number:</label>
            <div class="cc-number">
                <input id="cc-number1" data-previous-value="" class="credentials-input cc-number-input"
                    maxlength="4" type="text" placeholder="xxxx" onfocus="focusNumber(this)"
                    oninput="modifyNumber(this, 'cc-number')">
                <input id="cc-number2" data-previous-value="" class="credentials-input cc-number-input"
                    maxlength="4" type="text" placeholder="xxxx" onfocus="focusNumber(this)"
                    oninput="modifyNumber(this, 'cc-number')">
                <input id="cc-number3" data-previous-value="" class="credentials-input cc-number-input"
                    maxlength="4" type="text" placeholder="xxxx" onfocus="focusNumber(this)"
                    oninput="modifyNumber(this, 'cc-number')">
                <input id="cc-number4" data-previous-value="" class="credentials-input cc-number-input"
                    maxlength="4" type="text" placeholder="xxxx" onfocus="focusNumber(this)"
                    oninput="modifyNumber(this, 'cc-number')">
            </div>
        </div>

        <div class="cc-section">
            <label for="cc-name">Cartholder's name:</label>
            <input id="cc-name" class="credentials-input cc-name-input" maxlength="26" type="text"
                placeholder="Name" oninput="modifyNumber(this, 'cardholder-name')">
        </div>

        <div class="cc-section">
            <div class="cc-expiration-cvv-box">
                <div>
                    <label for="expiration-date">Expiration date:</label>
                    <input id="expiration-date" class="credentials-input cc-expiration-cvv-input" maxlength="5"
                        type="text" placeholder="MM/YY" oninput="modifyNumber(this, 'expiration-date')">
                </div>

                <div class="cc-cvv">
                    <label for="cvv">CVV:</label>
                    <input id="cvv" class="credentials-input cc-expiration-cvv-input" maxlength="3" type="text"
                        placeholder="CVV" oninput="validateDigit(this, 'validateElementValue')">
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>