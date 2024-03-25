<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    <div class="app h-screen w-full grid grid-cols-6 text-base">
        <div class="col-span-1 w-full h-full bg-[#262948]">
            <div class="w-full py-8 px-4">
                <div class="flex justify-start items-center gap-4">
                    <div class="w-12 h-12 rounded-full">
                        <img src="https://tse4.mm.bing.net/th?id=OIP.uI2ngOndNh0BIfas55xB5AHaHa&pid=Api&P=0&h=220" class="w-full h-full rounded-full" />
                    </div>
                    <div class="font-bold text-lg text-white"><p>N.The Quang</p></div>
                </div>
            </div>

            <div class="w-full py-4 px-6 text-white font-semibold">
                <div class="flex justify-between items-center py-2">
                    <a class="flex justify-start items-center gap-4" href="">
                        <i class="fa-solid fa-house"></i>
                        <p>Dashboard</p>
                    </a>
                </div>
                <div class="flex justify-between items-center py-2">
                    <a class="flex justify-start items-center gap-4" href="">
                        <i class="fa-solid fa-users"></i>
                        <p>Chat Room</p>
                    </a>
                </div>
                <div class="flex justify-between items-center py-2">
                    <a class="flex justify-start items-center gap-4" href="">
                        <i class="fa-solid fa-calendar-days"></i>
                        <p>Calendar</p>
                    </a>
                    <button class="w-5 h-5 text-sm bg-red-500 rounded-full">1</button>
                </div>
            </div>
            <div class="w-full absolute bottom-0 py-8 px-6 text-white font-semibold">
                <a href="#" class="flex justify-start items-center gap-4 py-2 hover:text-red-400">
                    <i class="fa-solid fa-gear"></i>
                    <p>Setting</p>
                </a>
                <a href="{{ route('logout') }}" class="flex justify-start items-center gap-4 py-2 hover:text-red-500"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <p> Logout</p>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>

        <div class="col-span-5 w-full h-full bg-blue-200 gap-1">
            <div class="grid grid-cols-2 gap-1 h-full">
                <div class="col-span-1 w-full h-full bg-[#202441]">

                </div>
                <div class="col-span-1 w-full h-full bg-[#212540]">

                </div>
            </div>
        </div>
    </div>
</body>
</html>
