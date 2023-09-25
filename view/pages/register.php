<?php
include_once($_SERVER["DOCUMENT_ROOT"] . "/config/auth.php");
if ($auth->checkLoggedIn()) {
    header("Location: /index.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <title>Register | DO RAYD</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="/assets/javascript/tailwind_config.js"></script>
</head>

<body>
    <div class="w-screen h-screen">
        <?php include($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/navbar.php"); ?>
        <div class="flex justify-center items-center bg-gradient-to-r from-fromGradient from-10% via-sky-500 via-30% to-toGradient to-90% w-screen h-[90%]">

            <form action="/api/auth.php" method="post" class="flex flex-col justify-center p-5 bg-white rounded-xl h-4/6 w-4/5 md:w-2/6">
                <h1 class="m-3 text-center text-xl font-bold">REGISTER</h1>
                <div class="flex flex-col m-1">
                    <label for="first_name" class="text-sm text-gray-500">First Name</label>
                    <input name="first_name" id="first_name" type="text" class="outline-none border-t-0 border-l-0 border-r-0 border-b-2 border-gray-300" required />
                </div>
                <div class="flex flex-col m-1">
                    <label for="last_name" class="text-sm text-gray-500">Last Name</label>
                    <input name="last_name" id="last_name" type="text" class="outline-none border-t-0 border-l-0 border-r-0 border-b-2 border-gray-300" required />
                </div>
                <div class="flex flex-col m-1">
                    <label for="email" class="text-sm text-gray-500">Email</label>
                    <input name="email" id="email" type="email" class="outline-none border-t-0 border-l-0 border-r-0 border-b-2 border-gray-300" required />
                </div>
                <div class="flex flex-col m-1">
                    <label for="password" class="text-sm text-gray-500">Password</label>
                    <input name="password" id="password" type="password" class="outline-none border-t-0 border-l-0 border-r-0 border-b-2 border-gray-300" required />
                </div>

                <button type="submit" class="mt-5 p-2 bg-gradient-to-r from-secondary to-primary text-white rounded-2xl">Register</button>
                <a href="/view/pages/login.php" class="m-2 text-center text-gray-400 text-sm">I already have an account</a>
            </form>
        </div>
    </div>

</body>

</html>