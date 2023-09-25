<?php include_once($_SERVER["DOCUMENT_ROOT"] . "/config/auth.php") ?>
<nav class="flex flex-col md:flex-row bg-white border-gray-200 bg-gray-200 dark:bg-gray-900 md:h-[10%]">
    <div class="w-5/6 flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="/" class="flex items-center mx-auto md:mx-0 my-2 md:my-0">
            <img src="/assets/images/icons/logo.png" class="h-8 mr-3" alt="Do Rayd Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">DO RAYD</span>
        </a>
        <div class="flex items-center p-1 max-sm:w-full border border-gray-300 rounded-2xl">
            <input type="text" class="border-none max-sm:w-4/5 outline-none rounded-xl text-sm" />
            <button><img src="/assets/images/icons/search.png" alt="Search Icon" class="h-7 mx-3" /></button>
        </div>

        <div class="w-full block md:w-auto" id="navbar-default">
            <ul class="font-medium flex flex-col p-4 md:p-0 mt-4 border border-gray-100 rounded-lg bg-gray-50 md:flex-row md:space-x-8 md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="/view/pages/shop.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Shop</a>
                </li>
                <li>
                    <a href="#" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Rental</a>
                </li>
                <?php if ($auth->checkLoggedIn()) : ?>
                    <li>
                        <a href="/api/auth.php?action=logout" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Logout</a>
                    </li>
                    <li>
                        <a href="/view/pages/cart.php" class="hidden md:block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            <img src="/assets/images/icons/cart.png" class="h-8" alt="Cart Icon" />
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block md:hidden py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            Cart
                        </a>
                    </li>
                    <li>
                        <a href="#" class="hidden md:block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            <img src="<?php echo $auth->getUser()->getImageUrl() ?? "/assets/images/default-profile.png" ?>" class="h-8" alt="Cart Icon" />
                        </a>
                    </li>
                    <li>
                        <a href="#" class="block md:hidden py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">
                            Profile
                        </a>
                    </li>
                <?php else : ?>
                    <li>
                        <a href="/view/pages/login.php" class="block py-2 pl-3 pr-4 text-gray-900 rounded hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-blue-700 md:p-0 dark:text-white md:dark:hover:text-blue-500 dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent">Login</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>