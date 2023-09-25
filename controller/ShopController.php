<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/data_source/DataSource.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/model/ProductPreview.php");

class ShopController
{
    private DataSource $dataSource;

    public function __construct(DataSource $dataSource)
    {
        $this->dataSource = $dataSource;
    }

    public function getProductPreview(int $start, int $range, string $sortType = "", string $conditions = "")
    {
        return $this->dataSource->executeGetQueryWithSerializer(
            " SELECT Products.ProductId, ProductName, RatingAverage, ImageUrl, Price
            FROM Products
            INNER JOIN (
                SELECT ProductRatings.ProductId, AVG(RatingValue) AS RatingAverage
                FROM ProductRatings
                GROUP BY ProductRatings.ProductId 
            ) AS pr ON pr.ProductId = Products.ProductId
            INNER JOIN (
                SELECT ProductDisplays.DisplayId, ProductVariants.VariantId, ProductVariants.ProductId, ImageUrl, ProductVariants.Price
                FROM ProductVariants
                INNER JOIN ProductDisplays ON ProductDisplays.VariantId = ProductVariants.VariantId
                AND ProductDisplays.DisplayId = (
                        SELECT MIN(pd.DisplayId)
                        FROM ProductDisplays pd
                        WHERE pd.VariantId = ( 
                            SELECT MIN(pv.VariantId)
                            FROM ProductVariants pv
                            WHERE pv.ProductId = ProductVariants.ProductId
                    )
                )
            ) AS pd on pd.ProductId = Products.ProductId
            $conditions
            $sortType
            LIMIT $start, $range
            ",
            "",
            function (array $productPreview) {
                return ProductPreview::fromAssocArray($productPreview);
            }
        );
    }

    public function getProductCount()
    {
        return $this->dataSource->executeGetQuery("SELECT COUNT(DISTINCT ProductId) AS ProductCount FROM ProductVariants", "");
    }

    public function getCategories()
    {
        return $this->dataSource->executeGetQuery("SELECT * FROM Categories", "");
    }
}
