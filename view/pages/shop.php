<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/config/mysql.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/controller/ShopController.php");
require_once($_SERVER["DOCUMENT_ROOT"] . "/utils/ShopQueryConditionsGenerator.php");

$shopController = new ShopController($dataSource, 0, 10);
$categories = $shopController->getCategories();
$conditions = ShopQueryConditionsGenerator::createQueryConditions($_GET);
$sortType = ShopQueryConditionsGenerator::createSortConditions();
$productCount = $shopController->getProductCount()[0]["ProductCount"];
$currentPage = $_GET["page"] ?? 1;
$queryRange = 16;

if (isset($_GET["sort_type"])) {
    $sortType = ShopQueryConditionsGenerator::createSortConditions($_GET["sort_type"]);
}

if (isset($_GET["page"])) {
    $productCardData = $shopController->getProductPreview($queryRange * ($_GET["page"] - 1) + 1, $queryRange, $sortType, $conditions);
} else {
    $productCardData = $shopController->getProductPreview(1, $queryRange, $sortType, $conditions);
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <title>Shop | DO RAYD</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="/assets/javascript/tailwind_config.js"></script>
</head>

<body>
    <div class="w-screen h-screen">
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/navbar.php") ?>
        <div class="flex flex-col md:flex-row w-full h-[90%] overflow-x-hidden">
            <div class="mx-auto md:mr-0 md:ml-auto w-5/6 md:w-1/6">
                <?php if (count($categories) > 0) : ?>
                    <div>
                        <h2 class="text-md font-semibold text-primary">Categories</h2>
                        <ul>
                            <?php foreach ($categories as $category) : ?>
                                <a href="/view/pages/shop.php?category=<?php echo $category["CategoryId"] ?>">
                                    <li class="text-sm text-gray-500 transition-all duration-5 hover:text-blue-500 hover:text-lg"><?php echo $category["CategoryName"] ?></li>
                                </a>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <hr class="my-1" />
                <div>
                    <h2 class="text-md font-semibold text-primary">Price Range</h2>
                    <form action="/view/pages/shop.php" method="get" class="flex">
                        <input type="number" name="min_price" class="text-xs w-[30%] border-gray-300 rounded-lg" min="1" />
                        <p class="mx-1">-</p>
                        <input type="number" name="max_price" class="text-xs w-[30%] border-gray-300 rounded-lg" min="1" />
                        <div class="flex justify-center items-center ml-2 p-2 bg-secondary rounded-lg transition-all duration-5 hover:scale-125"><button><img src="/assets/images/icons/filter.png" alt="Filter Icon" class="h-4"></button></div>
                    </form>
                </div>
                <hr class="my-1" />
                <div>
                    <h2 class="text-md font-semibold text-primary">Rating</h2>
                    <form action="/view/pages/shop.php" method="get">
                        <select class="border-gray-300" name="rating_min" onchange="this.form.submit()">
                            <option <?php if (isset($_GET["rating_min"]) && $_GET["rating_min"] == 5) echo "selected" ?> value="5">5 Star and up</option>
                            <option <?php if (isset($_GET["rating_min"]) && $_GET["rating_min"] == 4) echo "selected" ?> value="4">4 Star and up</option>
                            <option <?php if (isset($_GET["rating_min"]) && $_GET["rating_min"] == 3) echo "selected" ?> value="3">3 Star and up</option>
                            <option <?php if (isset($_GET["rating_min"]) && $_GET["rating_min"] == 2) echo "selected" ?> value="2">2 Star and up</option>
                            <option <?php if (isset($_GET["rating_min"]) && $_GET["rating_min"] == 1) echo "selected" ?> value="1">1 Star and up</option>
                        </select>
                    </form>
                </div>
            </div>
            <div class="max-sm:mt-2 mx-auto md:ml-0 md:mr-auto w-5/6 md:w-4/6 h-full">
                <form action="/view/pages/shop.php" method="get">
                    <label for="sort_type" class="text-primary font-semibold">Sort By:</label>
                    <select id="sort_type" name="sort_type" class="border-gray-300 rounded-xl" onchange="this.form.submit()">
                        <option <?php if (isset($_GET["sort_type"]) && $_GET["sort_type"] == 0) echo "selected" ?> value="0">Latest</option>
                        <option <?php if (isset($_GET["sort_type"]) && $_GET["sort_type"] == 1) echo "selected" ?> value="1">Price low to high</option>
                        <option <?php if (isset($_GET["sort_type"]) && $_GET["sort_type"] == 2) echo "selected" ?> value="2">Price high to low</option>
                    </select>
                </form>
                <hr class="my-2" />
                <ul class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <?php
                    require_once($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/product_card.php");
                    foreach ($productCardData as $productPreview) {
                        echo ProductCard::createWidget($productPreview);
                    }
                    ?>
                </ul>
                <?php if ($productCount / $queryRange > 1) : ?>
                    <div class="flex justify-center items-center py-5">
                        <a><img src="/assets/images/icons/back.png" alt="Back Icon" class="h-5"></a>
                        <ul class="flex">
                            <?php for ($pageNumber = 1; $pageNumber <= ceil($productCount / $queryRange); $pageNumber++) : ?>
                                <li class="font-bold mx-2"> <a href="/view/pages/shop.php?page=<?php echo $pageNumber ?>"><?php echo $pageNumber ?></a></li>
                            <?php endfor; ?>
                        </ul>
                        <a><img src="/assets/images/icons/next.png" alt="Next Icon" class="h-5"></a>
                    </div>
                <?php endif; ?>
            </div>

        </div>
    </div>

</body>

</html>