<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/ProductPreview.php");

class ProductCard
{
    public static function createWidget(ProductPreview $productPreview)
    {
        $productId = $productPreview->getProductId();
        $imageSource = $productPreview->getImageUrl();
        $name = $productPreview->getName();
        $price = number_format($productPreview->getPrice(), 2, '.', ',');
        $ratingValue = number_format($productPreview->getRating(), 2, '.', '');
        $ratingDisplay = ProductCard::createRatingDisplay($productPreview->getRating());
        return <<<EOF
            <a href="/view/pages/product.php?product_id=$productId" class="w-full max-w-sm bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:border-primary hover:border-2 transition-colors duration-300">
                <img class="mx-auto p-8 rounded-t-lg h-1/2" src="$imageSource" alt="product image" />
                <div class="px-5 pb-5">
                    <h5 class="text-xl font-semibold tracking-tight text-gray-900 dark:text-white">$name</h5>
                    <div class="flex items-center mt-2.5 mb-5">
                        $ratingDisplay
                        <span class="bg-secondary text-xs font-semibold mr-2 px-2.5 py-0.5 rounded dark:bg-blue-200 dark:text-blue-800 ml-3">$ratingValue</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-2xl font-bold text-gray-900 dark:text-white">₱$price</span>
                    </div>
                </div>
            </a>
        EOF;
    }

    public static function createRatingDisplay($rating)
    {
        $ratingDisplay = "";
        $maxRating = 5;
        $rating = intval($rating);
        for ($index = 1; $index <= $maxRating; $index++) {
            if ($index <= $rating) {
                $ratingDisplay .=
                    <<< EOF
                    <svg class="w-4 h-4 text-yellow-300 mr-1" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    EOF;
            } else {
                $ratingDisplay .=
                    <<< EOF
                    <svg class="w-4 h-4 text-gray-200 dark:text-gray-600" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 20">
                    <path d="M20.924 7.625a1.523 1.523 0 0 0-1.238-1.044l-5.051-.734-2.259-4.577a1.534 1.534 0 0 0-2.752 0L7.365 5.847l-5.051.734A1.535 1.535 0 0 0 1.463 9.2l3.656 3.563-.863 5.031a1.532 1.532 0 0 0 2.226 1.616L11 17.033l4.518 2.375a1.534 1.534 0 0 0 2.226-1.617l-.863-5.03L20.537 9.2a1.523 1.523 0 0 0 .387-1.575Z" />
                    </svg>
                    EOF;
            }
        }
        return $ratingDisplay;
    }
}
