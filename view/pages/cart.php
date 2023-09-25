<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/auth.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/CartController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/cart_card.php");

if (!$auth->checkLoggedIn()) {
    header("Location: /index.php");
}

$cartController = new CartController($dataSource);
$cartController->intializeCart($auth->getUser()->getId());
$cart = $cartController->getCart();
$addOns["Shipping Fee"] = 50.00;

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <title>Cart | DO RAYD</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="/assets/javascript/tailwind_config.js"></script>
</head>

<body>
    <div class="w-screen h-screen md:bg-gray-100">
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/navbar.php") ?>
        <?php
        if (!empty($cart)) :
        ?>
            <form action="/api/cart.php" method="post" class="mx-auto flex flex-col md:flex-row w-5/6 overflow-x-hidden">
                <div class="mr-2 flex flex-col w-full md:w-2/3">
                    <div class="flex justify-between my-2 p-2 bg-white font-semibold">
                        <div class="flex items-center">
                            <input type="checkbox" id="select-all" onchange="setAllCartItemCheckbox(this.checked)" />
                            <label for="select-all" class="ml-1">Select All</label>
                        </div>
                        <button type="submit" name="action" value="delete" class="flex items-center">
                            <img src="/assets/images/icons/delete.png" alt="Delete Icon" class="h-5" />
                            <span>Delete</span>
                        </button>
                    </div>

                    <ul class="flex flex-col my-2 p-2 bg-white">
                        <?php
                        foreach ($cart as $item) {
                            echo CartCard::createWidget($item);
                        }
                        ?>
                    </ul>

                </div>
                <div class="my-2 px-3 w-full md:w-1/3 bg-white">
                    <h2 class="font-semibold text-lg mt-2">Location</h2>
                    <div class="flex items-center mt-2">
                        <img src="/assets/images/icons/pin.png" alt="Location Icon" class="h-5">
                        <p id="location" class="text-gray-500 text-sm">Getting Location..</p>
                    </div>
                    <hr class="mt-2" />
                    <h2 class="mt-2 font-semibold text-lg">Order Summary</h2>
                    <div class="mt-2 flex justify-between">
                        <p class="text-gray-500">Subtotal: </p>
                        <p class="font-semibold">₱<span id="subtotal">0.00</span></p>
                    </div>
                    <?php foreach ($addOns as $key => $value) : ?>
                        <div class="mt-2 flex justify-between">
                            <p class="text-gray-500"><?php echo $key ?></p>
                            <p class="font-semibold">₱<span class="add-on"><?php echo number_format($value, 2, '.', ',') ?></span></p>
                        </div>
                    <?php endforeach; ?>
                    <hr class="mt-2" />
                    <div class="my-2 flex justify-between">
                        <p class="text-gray-500">Total: </p>
                        <p class="font-semibold">₱<span id="total"><?php echo number_format(array_sum($addOns), 2, '.', ',') ?></span></p>
                    </div>
                    <button type="submit" class="w-full p-3 bg-primary text-white">Proceed to Checkout</button>
                </div>
            </form>
        <?php
        else :
        ?>
            <div class="flex flex-col justify-center items-center w-full h-[90%]">
                <h1 class="m-2 font-semibold text-3xl text-primary">No Items in the Cart</h1>
                <a href="/view/pages/shop.php" class="p-3 bg-secondary font-semibold rounded-2xl">Shop Now</a>
            </div>
        <?php endif; ?>
    </div>
    <script>
        function onCartChecked() {
            const subtotalNode = document.getElementById("subtotal");
            const totalNode = document.getElementById("total");
            const priceNodes = document.getElementsByClassName("item-subtotal");
            const checkboxNodes = document.getElementsByName("cart_id[]");
            const addOnNodes = document.getElementsByClassName("add-on");
            let newSubtotal = 0;
            let newTotal = 0;

            // Get the sum of add ons as initial total
            for (let addOnNode of addOnNodes) {
                newTotal += parseFloat(addOnNode.innerText.replaceAll(',', ''));
            }

            // Iterate thru checkboxes to check if item subtotal is gonna be added
            for (let index = 0; index < checkboxNodes.length; index++) {
                const checkboxNode = checkboxNodes[index];
                const priceNode = priceNodes[index];
                if (checkboxNode.checked) {
                    newSubtotal += parseFloat(priceNode.innerText.replaceAll(',', ''));
                }
            }

            newTotal += newSubtotal;
            subtotalNode.innerText = newSubtotal.toLocaleString('en-us');
            totalNode.innerText = newTotal.toLocaleString('en-us');

        }

        function onQuantityChanged(quantityNode) {
            const itemPriceNode = quantityNode.parentNode.parentNode.getElementsByClassName("price")[0];
            const itemSubtotalNode = quantityNode.parentNode.parentNode.getElementsByClassName("item-subtotal")[0];
            const checkbox = quantityNode.parentNode.parentNode.getElementsByClassName("cart-checkbox")[0];
            const itemPrice = parseFloat(itemPriceNode.value);
            let quantity = parseInt(quantityNode.value);
            const formData = new FormData();

            if (quantity > parseInt(quantityNode.max)) {
                quantity = parseInt(quantityNode.max);
            } else if (quantity < 1) {
                quantity = 1;
            }

            formData.append("action", "add_quantity");
            formData.append("cart_id", checkbox.value);
            formData.append("quantity", quantity);

            fetch("/api/cart.php", {
                    method: "post",
                    body: formData
                })
                .then((response) => response.text())
                .then((_) => {
                    quantityNode.value = quantity;
                    itemSubtotalNode.innerText = (itemPrice * quantity).toLocaleString('en-us');
                    if (checkbox.checked) {
                        onCartChecked();
                    }
                });
        }

        function setQuantity(quantity, increment) {
            const newQuantity = parseInt(quantity.value) + increment;
            if (newQuantity > 0 && newQuantity <= parseInt(quantity.max)) {
                quantity.value = parseInt(quantity.value) + increment;
                onQuantityChanged(quantity);
            }
        }

        function setAllCartItemCheckbox(value) {
            const checkboxes = document.getElementsByName("cart_id[]");
            let isChanged = false
            for (const checkbox of checkboxes) {
                if (checkbox.checked !== value) {
                    checkbox.checked = value;
                    isChanged = true;
                }
            }

            if (isChanged) onCartChecked();
        }

        function setLocation(text) {
            const location = document.getElementById("location");
            location.innerText = text;
        }

        async function reverseGeocode({
            longitude,
            latitude
        }) {
            const response = await fetch('http://nominatim.openstreetmap.org/reverse?format=json&lon=' + longitude + '&lat=' + latitude)
            return await response.json();
        }

        document.addEventListener("DOMContentLoaded", () => {
            navigator.geolocation.getCurrentPosition(
                    function(position) {
                        const latitude = position.coords.latitude;
                        const longitude = position.coords.longitude;
                        reverseGeocode(position.coords)
                            .then((response) => {
                                const address = response.address;
                                setLocation(`${address.road}, ${address.town}, ${address.state}`);
                            })
                            .catch((_) => {
                                setLocation("Failed to get Location");
                            });
                    }),
                function(_) {
                    setLocation("Failed to get Location");
                };
        });
    </script>
</body>

</html>