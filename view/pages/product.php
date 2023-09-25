<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/auth.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Product.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ProductController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/product_card.php");

$isExist = true;

if (isset($_GET["product_id"])) {
    $productController = new ProductController($dataSource);
    try {
        $product = $productController->getProductData($_GET["product_id"]);
        $ratingAvg = $product->getRatingAverage();
    } catch (TypeError) {
        $isExist = false;
    }
} else {
    $isExist = false;
}

if (!$isExist) {
    header("Location: /index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <title><?php echo $product->getName() ?> | DO RAYD</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="/assets/javascript/tailwind_config.js"></script>
</head>

<body>
    <div class="w-screen h-screen overflow-x-hidden bg-gray-100">
        <?php include($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/navbar.php"); ?>
        <div class="flex p-2 mt-3 mx-auto w-5/6 md:h-4/6 bg-white">
            <div class="flex flex-col md:flex-row h-full w-full">
                <div class="w-full md:mr-2 md:w-2/6 h-2/6 md:h-full">
                    <img src="<?php echo $product->getVariations()[0]->getImageUrls()[0] ?>" alt="Product Icon" id="product-preview" class="mx-auto h-5/6">
                    <ul class="mt-2 flex relative w-full h-1/6 overflow-x-auto overflow-y-hidden">
                        <?php foreach ($product->getVariations() as $variant) :
                            foreach ($variant->getImageUrls() as $imageUrl) :  ?>
                                <li onclick="setImageDisplay(this)" class="flex items-center min-w-[20%] md:min-w-[12%] mr-2 transition-all duration-300 hover:scale-125 cursor-pointer border">
                                    <img src="<?php echo $imageUrl ?>" alt="<?php echo $variant->getName() ?>" class="w-full">
                                </li>
                        <?php endforeach;
                        endforeach; ?>
                    </ul>
                </div>
                <div class="w-full md:w-4/6 h-full">
                    <div class="p-3">
                        <h1 class="text-3xl font-bold"><?php echo $product->getName(); ?></h1>
                        <div class="flex items-center text-gray-400">
                            <h2 class="mr-1">Category: </h2>
                            <p><?php echo $product->getCategory()->getName(); ?></p>
                        </div>
                    </div>
                    <hr />
                    <div class="p-2 flex justify-between items-center">
                        <h2 class="text-blue-500 text-2xl font-semibold">₱<span id="price-display"><?php echo number_format($product->getVariations()[0]->getPrice(), 2, '.', ',') ?></span></h2>
                        <div class="flex items-center">
                            <h2 class="mr-2 font-semibold">Rating</h2>
                            <span class="flex"><?php echo ProductCard::createRatingDisplay((int) $ratingAvg) ?></span>
                            <p class="text-gray-400 text-sm">(<?php echo $ratingAvg ?>)</p>
                        </div>
                    </div>
                    <hr />
                    <form action="/api/product.php" method="post">
                        <div class="p-2">
                            <h3 class="font-bold">Variations: </h3>
                            <p class="text-gray-500"><?php echo $product->getVariations()[0]->getName() ?></p>
                            <ul id="variant-selection" class="mt-2 relative flex overflow-x-scroll">
                                <?php foreach ($product->getVariations() as $variant) : ?>
                                    <li class="variant-parent flex justify-center items-center w-[20%] border-2 mr-2 cursor-pointer">
                                        <label for="variant-<?php echo $variant->getId() ?>">
                                            <img src="<?php echo $variant->getImageUrls()[0] ?>" alt="<?php echo $variant->getName() ?> Icon" class="h-12 md:h-20 mr-3 cursor-pointer">
                                        </label>
                                        <input class="hidden" type="radio" name="variant_id" id="variant-<?php echo $variant->getId() ?>" value="<?php echo $variant->getId() ?>" required />
                                        <input class="hidden" type="number" name="variant_price" value="<?php echo $variant->getPrice() ?>" />
                                        <input class="hidden" type="number" name="variant_quantity" value="<?php echo $variant->getStock() ?>" />

                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        <div class="p-2 flex items-center">
                            <h3 class="font-bold mr-2">Quantity:</h3>
                            <input id="quantity" name="quantity" type="number" min="1" max="<?php echo $product->getVariations()[0]->getStock() ?>" value="1" class="w-1/5 text-sm border-gray-400 rounded-xl" />
                        </div>
                        <hr />
                        <div class="p-2 flex justify-end font-semibold">
                            <button type="submit" class="p-1 md:p-2 mr-1 w-2/6 md:w-1/6 bg-primary text-white rounded-xl transition-all duration-300 hover:scale-110" name="action" value="buy_now">Buy Now</button>
                            <button type="submit" class="p-1 md:p-2 w-2/6 md:w-1/6 bg-secondary rounded-xl transition-all duration-300 hover:scale-110" name="action" value="add_to_cart">Add to Cart</button>
                        </div>
                    </form>
                </div>

            </div>

        </div>
        <div class="mx-auto my-3 w-5/6 bg-white">
            <h2 class="p-2 text-xl font-semibold">Product Description</h2>
            <hr />
            <p class="p-2 text-justify text-lg">
                <?php echo $product->getDescription() ?>
            </p>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const variantParents = document.getElementsByClassName('variant-parent');
            const variantRadioButtons = document.getElementsByName('variant_id');
            const variantPrices = document.getElementsByName('variant_price');
            const variantQuantities = document.getElementsByName('variant_quantity');
            const quantity = document.getElementById("quantity");
            let hasSelected = false;

            for (let index = 0; index < variantParents.length; index++) {
                variantRadioButtons[index].addEventListener('change', (event) => {
                    highlightWidgetFromGroup(variantParents[index], variantParents);
                    quantity.value = 1;
                    quantity.max = variantQuantities[index].value;
                    changePrice(parseFloat(variantPrices[index].value), 1);
                });
            }

            quantity.addEventListener('change', (event) => {
                for (let index = 0; index < variantParents.length; index++) {
                    if (variantRadioButtons[index].checked) {
                        changePrice(parseFloat(variantPrices[index].value), parseInt(variantQuantities[index].value));
                    }
                }
            });
        });

        function setImageDisplay(selected) {
            const imageDisplay = document.getElementById("product-preview");
            const imgTag = selected.children[0];
            imageDisplay.src = imgTag.src;
        }

        function changePrice(price, quantity) {
            document.getElementById("price-display").innerText = (price * quantity).toLocaleString('en-us');
        }

        function highlightWidgetFromGroup(selected, group) {
            selected.classList.add("border-primary")
            for (const widget of group) {
                if (widget !== selected) {
                    widget.classList.remove("border-primary");
                }
            }
        }
    </script>

</body>


</html>