<?php 
require_once __DIR__ . '/../partials/head.php';
require_once __DIR__ . '/../partials/navbar.php';
?>


    <div class="item-data-box">

        <div class="item-data-header">
            <p>Submit inquiry</p>
        </div>

        <p> 
            Email: al@gmail.com
        </p>


        <p style="margin-bottom: 10px;">
            <label for="category">Category:</label>
        </p>

        <select class="catalogue-option" name="category" id="category">
            <option value="general">General inquiry</option>
            <option value="items">Items/products</option>
            <option value="orders">Orders</option>
            <option value="shipping">Shipping & delivery</option>
            <option value="returns">Returns & refunds</option>
            <option value="account">Account issues</option>
            <option value="payment">Payment problems</option>
            <option value="technical">Technical support</option>
        </select>

        <p>
            Message:
        </p>

        <textarea class="inquiry-textbox" placeholder="Ask us a question!" id="inquiry"></textarea>

        <div class="item-data-buttons">
            <button type="submit" class="accept-btn" onclick="sendInquiry()">Send</button>
        </div>

        <script>

            function sendInquiry() {
                document.getElementById("inquiry").value = "";
                alert("Message sent!");
            }

        </script>

    </div>

<?php require_once __DIR__ . '/../partials/footer.php'; ?>