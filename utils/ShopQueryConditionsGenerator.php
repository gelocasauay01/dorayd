<?php

class ShopQueryConditionsGenerator
{
    public static function createQueryConditions(array $conditions)
    {
        $conditionQuery = "";
        $isMultipleQuery = false;
        foreach ($conditions as $key => $value) {

            switch ($key) {
                case "min_price": {
                        if ($isMultipleQuery) $conditionQuery .= " AND";
                        else $conditionQuery = "WHERE";
                        $conditionQuery .= " Price >= $value";
                        $isMultipleQuery = true;
                        break;
                    }
                case "max_price": {
                        if ($isMultipleQuery) $conditionQuery .= " AND";
                        else $conditionQuery = "WHERE";
                        $conditionQuery .= " Price <= $value";
                        $isMultipleQuery = true;
                        break;
                    }
                case "rating_min": {
                        if ($isMultipleQuery) $conditionQuery .= " AND";
                        else $conditionQuery = "WHERE";
                        $conditionQuery .= " RatingAverage >= $value";
                        $isMultipleQuery = true;
                        break;
                    }
                case "category": {
                        if ($isMultipleQuery) $conditionQuery .= " AND";
                        else $conditionQuery = "WHERE";
                        $conditionQuery .= " CategoryId = $value";
                        $isMultipleQuery = true;
                        break;
                    }
            }
        }

        return $conditionQuery;
    }

    public static function createSortConditions(int $sortType = 0)
    {
        $sortQuery = " ORDER BY Products.ProductId DESC";
        if ($sortType == 1) {
            $sortQuery = " ORDER BY Price ASC";
        } else if ($sortType == 2) {
            $sortQuery = " ORDER BY Price DESC";
        }
        return $sortQuery;
    }
}
