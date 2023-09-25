<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Cart.php");
class CartCard
{
    public static function createWidget(Cart $cart)
    {
        $id = $cart->getId();
        $imageUrl = $cart->getImageUrl();
        $productName = $cart->getProductName();
        $variantName = $cart->getVariantName();
        $stock = $cart->getStock();
        $categoryId = $cart->getCategory()->getId();
        $categoryName = $cart->getCategory()->getName();
        $quantity = $cart->getQuantity();
        $price = $cart->getVariantPrice();
        $subtotal = number_format($cart->getSubtotal(), 2, '.', ',');
        return <<<EOF
            <li class="flex flex-col md:flex-row justify-evenly items-center w-full">
                <input onchange="onCartChecked()" type="checkbox" name="cart_id[]" value="$id" class="cart-checkbox max-sm:self-start"/>
                <img src="$imageUrl" alt="Product Icon" class="h-10 md:h-20">
                <div>
                    <h2 class="text-xs md:text-md md:text-xl font-semibold">$productName</h2>
                    <h4 class="text-xs md:text-sm text-gray-400">Variant: $variantName</h4>
                    <a href="/view/pages/shop.php?category=$categoryId" class="text-xs md:text-sm text-gray-400">Category: $categoryName</a>
                </div>
                <span class="font-semibold text-xs md:text-lg text-primary">₱<span class="item-subtotal">$subtotal</span></span>
                <div class="max-sm:flex justify-center w-full md:w-1/5">
                    <button type="button" onclick="setQuantity(this.parentNode.getElementsByClassName('quantity')[0], -1)" class="p-2 bg-secondary font-semibold">-</button>
                    <input value="$quantity" onchange="onQuantityChanged(this)" type="number" min="1" max="$stock" class="quantity w-1/5 md:w-3/5" />
                    <button type="button" onclick="setQuantity(this.parentNode.getElementsByClassName('quantity')[0], 1)" class="p-2 bg-secondary font-semibold">+</button>
                    <input value="$price"type="number" class="price hidden" />
                </div>
            </li>
            <hr class="my-2" />
        EOF;
    }
}
