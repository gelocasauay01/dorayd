<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="/assets/images/favicon.ico" type="image/x-icon">
    <title>Home | DO RAYD</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
    <script src="/assets/javascript/tailwind_config.js"></script>
</head>

<body>
    <div class="w-screen h-screen overflow-x-hidden">
        <?php include_once($_SERVER["DOCUMENT_ROOT"] . "/view/widgets/navbar.php") ?>
        <div class="m-auto flex flex-col md:flex-row w-5/6 h-[90%] overflow-x-hidden">
            <div class="md:ml-auto flex flex-col justify-center items-center w-full md:w-1/2 h-1/2 md:h-full">
                <img src="/assets/images/ceo.png" alt="CEO Image" class="max-sm:h-1/2 my-2 rounded-[50%]">
                <h1 class="font-bold text-xl">Henry Jeff R. Mardo</h1>
                <h3 class="font-semibold text-gray-500">Chief Executive Officer</h3>
            </div>
            <hr class="block md:hidden" />
            <div class="flex flex-col justify-center items-center w-full md:w-1/2 h-full">
                <h2 class="my-3 text-xl md:text-3xl font-bold tracking-widest">nice to meet you</h2>
                <div class="text-justify text-md md:text-lg">
                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Donec posuere enim ut auctor aliquet. Vestibulum eros est, volutpat non faucibus nec, gravida ac ante. Vestibulum nec enim scelerisque, congue tellus quis, fringilla tortor. Praesent cursus in felis ut placerat. Cras quis arcu vel purus rutrum luctus eu non nunc. Curabitur pulvinar ex lectus, eget iaculis mauris dignissim non. Interdum et malesuada fames ac ante ipsum primis in faucibus.

                    Nam non tellus non mauris euismod fermentum. Sed ut magna vel diam molestie mollis in sit amet augue. Donec non consequat quam. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Cras malesuada, elit quis tincidunt bibendum, est urna eleifend purus, ut feugiat nunc ligula eu velit. Proin ultricies eget augue quis tempor. Aliquam feugiat quam auctor est tempor congue.
                </div>
                <button class="my-3 mx-auto p-2 md:p-3 font-semibold bg-secondary rounded-2xl">Check Out Our Products</button>
            </div>
        </div>
</body>

</html>