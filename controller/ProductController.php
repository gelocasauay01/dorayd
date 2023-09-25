<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/data_source/DataSource.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Product.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/ProductVariation.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Category.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/Rating.php");


class ProductController
{
    private DataSource $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function getProductData(int $productId)
    {
        $productData = $this->dataSource->executeGetQuery("SELECT ProductId, ProductName, Products.CategoryId, CategoryName, ProductDescription FROM Products INNER JOIN Categories ON Products.CategoryId = Categories.CategoryId WHERE Products.ProductId = ? LIMIT 1", "i", $productId)[0];
        $ratings = $this->dataSource->executeGetQueryWithSerializer("SELECT productratings.RatingId, productratings.RatingValue, productratings.RatingComment, productratings.UserId, Email, FirstName, LastName, Passkey, UserType, ImageUrl FROM ProductRatings INNER JOIN Users ON ProductRatings.UserId = Users.UserId WHERE ProductId = ?", "i", function ($rawRating) {
            return Rating::FromAssocArray($rawRating);
        }, $productId);
        $variations = $this->createVariations($this->dataSource->executeGetQuery("SELECT * FROM ProductVariants INNER JOIN ProductDisplays ON ProductDisplays.VariantId = ProductVariants.VariantId WHERE ProductId = ?", "i", $productId));
        return new Product(
            $productData["ProductId"],
            $productData["ProductName"],
            $productData["ProductDescription"],
            Category::fromAssocArray($productData),
            $ratings,
            $variations
        );
    }

    public function addToCart(int $userId, int $variantId, int $quantity)
    {
        $this->dataSource->executePostQuery("INSERT INTO Cart(UserId, VariantId, Quantity) VALUES(?, ?, ?)", "iii", $userId, $variantId, $quantity);
    }

    public function checkInCart($userId, $variantId)
    {
        return $this->dataSource->executeGetQuery("SELECT CartId FROM Cart WHERE UserId = ? AND VariantId = ? LIMIT 1", "ii", $userId, $variantId);
    }

    private function createVariations(array $rawVariations)
    {
        $variations = [];
        $encountered = [];
        $itemCount = 0;
        foreach ($rawVariations as $variant) {
            if (isset($encountered[$variant["VariantId"]])) {
                $index = $encountered[$variant["VariantId"]];
                $variations[$index]->insertToImageUrls($variant["ImageUrl"]);
            } else {
                $encountered[$variant["VariantId"]] = $itemCount;
                array_push($variations, ProductVariation::fromAssocArray($variant));
                $itemCount++;
            }
        }
        return $variations;
    }
}
