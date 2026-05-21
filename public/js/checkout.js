function modifyQuantity(action, itemId, price, write_quantity = null) {
  var quantity = document.getElementById("quantity" + itemId);
  var priceBox = document.getElementById("price" + itemId);
  var subtotal = document.getElementById("subtotal");
  var previousValue = "data-previous-value";

  if (action == "subtract" && parseInt(quantity.value) != 1) {
    quantity.value = parseInt(quantity.value) - 1;
  } else if (action == "add") {
    quantity.value = parseInt(quantity.value) + 1;
  }

  if (quantity.value.trim() == "") {
    write_quantity = 1;
    quantity.value = 1;
  } else if (
    quantity.value <= 0 ||
    isNaN(quantity.value) ||
    quantity.value.includes(".")
  ) {
    write_quantity = null;
    quantity.value = quantity.getAttribute(previousValue);
  }

  currentQuantity = parseFloat(quantity.value);
  previousQuantity = parseFloat(quantity.getAttribute(previousValue));

  difference = currentQuantity - previousQuantity;
  adjustment = difference * price;

  subtotal.innerHTML = parseFloat(subtotal.innerHTML) + adjustment;
  quantity.setAttribute(previousValue, currentQuantity);

  finalPrice = parseFloat(price) * parseFloat(quantity.value);
  priceBox.innerHTML = finalPrice;

  var xhttp;

  xhttp = new XMLHttpRequest();

  if (write_quantity == null) {
    xhttp.open(
      "GET",
      "/website1/scripts/php/modify-list.php?action=" +
        "modify_quantity&action_quantity=" +
        action +
        "&item_id=" +
        itemId,
      true
    );
  } else {
    xhttp.open(
      "GET",
      "/website1/scripts/php/modify-list.php?action=" +
        "modify_quantity&action_quantity=" +
        action +
        "&item_id=" +
        itemId +
        "&write_quantity=" +
        write_quantity,
      true
    );
  }

  xhttp.send();
}

function loadMore(user_id, round) {
  var newElement = document.createElement("div");
  newElement.className = "load-more";

  var xhttp;
  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      newElement.innerHTML = this.responseText;
      document.getElementById("loadMoreBtn").replaceWith(newElement);
    }
  };

  xhttp.open(
    "GET",
    "/website1/scripts/php/load-more.php?user_id=" +
      user_id +
      "&round=" +
      round,
    true
  );

  xhttp.send();
}

function removeItem(item_id) {
  var xhttp;
  var price = document.getElementById("price" + item_id);
  var subtotal = document.getElementById("subtotal");

  xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("item" + item_id).remove();

      subtotal.innerHTML =
        parseFloat(subtotal.innerHTML) - parseFloat(price.innerHTML);
    }
  };

  xhttp.open(
    "GET",
    "/website1/scripts/php/modify-list.php?action=delete_cart&item_id=" +
      item_id,
    true
  );

  xhttp.send();
}

function validateDigit(number, action = null) {
  
  // Regex means all the values that fit a condition within the string. / \D / means all non digits. 
  // Everything between / / is the condition. g means that the search is global within the entire string.
  const regex = /\D/g;

  // If the action is to remove any non-digit characters, the characters specified by the regex are replaced by nothing.
  // Also, in this scenario the number is an element.

  if (action === "validateElementValue") {
    number.value = number.value.replace(regex, "");
    return;
  } 
  
  // If the point is to simply check whether a value is a digit/has a digit or not, this happens.

  else {
    if (regex.test(number)) {
      return true;
    } else {
      return false;
    }
  }
}

function focusNumber(ccNumber) {
  var numberField = ccNumber.id;
  var numberValue = ccNumber.value;

  var previousField = ccNumber.previousElementSibling;
  var nextField = ccNumber.nextElementSibling;

  document
    .getElementById(numberField)
    .addEventListener("keydown", function (event) {
      var newCaret = document.getElementById(numberField).selectionStart;

      if (
        event.key === "Backspace" &&
        newCaret === 0 &&
        numberValue.length === 0 &&
        numberField !== "cc-number1"
      ) {
        previousField.focus();
        previousField.setSelectionRange(4, 4);
      }
      if (
        event.key === "ArrowLeft" &&
        newCaret === 0 &&
        numberField !== "cc-number1"
      ) {
        previousField.focus();
        previousField.setSelectionRange(4, 4);
        event.preventDefault();
      } else if (
        event.key === "ArrowRight" &&
        newCaret === numberValue.length &&
        numberField !== "cc-number4" &&
        (nextField.value.length > 0 || numberValue.length === 4)
      ) {
        nextField.focus();
        nextField.setSelectionRange(0, 0);
        event.preventDefault();
      } else if (/\d/.test(event.key) && numberValue.length === 4) {
        nextField.focus();
      }
    });

  if (numberField != "cc-number1" && numberValue.length === 0) {
    if (previousField.value.length < 4) {
      previousField.focus();
    }
  }
}

function modifyNumber(ccNumber, action = null) {
  var numberId = ccNumber.id;
  var nextField = ccNumber.nextElementSibling;

  if (action === "cc-number") {
    ccNumber.value = ccNumber.value.replace(/\D/g, "");
    if (ccNumber.value.length === 4 && numberId !== "cc-number4") {
      nextField.focus();
    }
    if (ccNumber.value.length === 4 && numberId === "cc-number4") {
      document.getElementById("cc-name").focus();
    }
  }

  if (action === "cardholder-name") {
    ccNumber.value = ccNumber.value.replace(/[^a-zA-Z ]+/g, "");

    ccNumber.addEventListener("keydown", function (event) {
      if (event.key === "Enter") {
        document.getElementById("expiration-date").focus();
      }
    });
  }

  if (action === "expiration-date") {
    ccNumber.value = ccNumber.value.replace(/\D/g, "");
    if (ccNumber.value.length > 2) {
      ccNumber.value =
        ccNumber.value.slice(0, 2) + "/" + ccNumber.value.slice(2);
    }
    if (ccNumber.value.length === 5 && numberId !== "cc-number4") {
      document.getElementById("cvv").focus();
    }

    ccNumber.addEventListener("keydown", function (event) {
      if (ccNumber.value.length === 5 && event.key !== "Backspace") {
        ccNumber.setSelectionRange(6, 6);
        event.preventDefault();
      }
    });

    ccNumber.addEventListener("click", function (event) {
      ccNumber.setSelectionRange(6, 6);
      event.preventDefault();
    });
  }
}
