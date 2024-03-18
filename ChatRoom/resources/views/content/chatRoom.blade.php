<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    @vite('resources/css/app.css')
</head>
<body>
<div class="app h-screen w-full grid grid-cols-6 text-base">
    <div class="col-span-1 w-full h-full bg-[#262948]">
        <div class="w-full py-8 px-4">
            <div class="flex justify-start items-center gap-4">
                <div class="w-12 h-12 rounded-full">
                    @include('components.avatar', ['avatar_path' => 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                </div>
                <div class="font-bold text-lg text-white">
                    @guest()
                        <p>Guest</p>
                    @else
                        <p>{{ Auth::user()->name }}</p>
                    @endguest
                </div>
            </div>
        </div>

        <div class="w-full py-4 px-6 text-white font-semibold">
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4" href="">
                    <i class="fa-solid fa-house"></i>
                    <p>Dashboard</p>
                </a>
                @include('components.countNotification', ['number' => 1])
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4" href="">
                    <i class="fa-solid fa-users"></i>
                    <p>Chat Room</p>
                </a>
                @include('components.countNotification', ['number' => 2])
            </div>
            <div class="flex justify-between items-center py-2">
                <a class="flex justify-start items-center gap-4" href="">
                    <i class="fa-solid fa-calendar-days"></i>
                    <p>Calendar</p>
                </a>
                @include('components.countNotification', ['number' => 1])
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
        <div class="grid grid-cols-3 gap-1 h-full">
{{--            column 1--}}
            <div class="col-span-2 h-full bg-[#202441] text-white text-base w-full pl-12 pr-12 py-8">
                <div class="font-bold  text-3xl flex justify-between">
                    <div class="flex justify-start items-center gap-4">
                        <i class="fa-solid fa-users"></i>
                        <p> Chat Room</p>
                    </div>
                    <div class="flex justify-start items-center gap-4">
                        <button type="button" onclick="openModal('searchRoomModal')" class="text-white hover:text-orange-400">
                            <i class="fa-solid fa-magnifying-glass"></i>
                        </button>
                        <button type="button" onclick="openModal('addNewRoomFormModal')" class="text-white hover:text-orange-400">
                            <i class="fa-solid fa-plus"></i>
                        </button>
                    </div>
                </div>
                <div class="w-ful pl-4 mt-12">
                    <p class="font-semibold">My rooms</p>

                    <div class="w-full" id="rooms_list">
                        @foreach($rooms as $room)
                            <a href="#" class="w-full bg-[#262948] hover:bg-[#4289f3] py-3 px-4 my-4 rounded-lg grid grid-cols-3 gap-2 relative" id="Room-{{ $room->id }}" onclick="showRoom('{{ $room->id }}')">
                                <div class="col-span-1">
                                    <div class="flex justify-start items-center gap-4">
                                        <div class="w-8 h-8 rounded-full">
                                            @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                        </div>
                                        <p class="font-bold">{{$room->name}}</p>
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <p> {{$room->description}}</p>
                                </div>
                                <div class="absolute top-0 right-0 text-sm mr-2 mt-1  flex justify-end items-center gap-4">
                                    <p class="text-gray-400">2 min ago</p>
                                    @include('components.countNotification', ['number' => 1])
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="w-full pl-4 mt-12">
                    <p class="font-semibold">Joined rooms</p>

                    <div class="w-full" id="joined_rooms_list">
                        @foreach($joined_rooms as $room)
                            <a href="#" class="w-full bg-[#262948] hover:bg-[#4289f3] py-3 px-4 my-4 rounded-lg grid grid-cols-3 gap-2 relative" id="Room-{{ $room->id }}" onclick="showRoom('{{ $room->id }}')">
                                <div class="col-span-1">
                                    <div class="flex justify-start items-center gap-4">
                                        <div class="w-8 h-8 rounded-full">
                                            @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                        </div>
                                        <p class="font-bold">{{$room->name}}</p>
                                    </div>
                                </div>
                                <div class="col-span-2">
                                    <p> {{$room->description}}</p>
                                </div>
                                <div class="absolute top-0 right-0 text-sm mr-2 mt-1  flex justify-end items-center gap-4">
                                    <p class="text-gray-400">2 min ago</p>
                                    @include('components.countNotification', ['number' => 1])
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>

            </div>
{{--            column-2--}}
            <div class="col-span-1 w-full h-full bg-[#212540] px-4" id="column_detail_room">
                <div id="InfoRoom" class="">
                    <div class="h-[15vh] bg-[#262948] mb-3 rounded-lg flex items-center p-[20px] justify-between" id="TagNameOfRoom">
{{--                        <div class="hidden" >--}}
{{--                            <div class="flex flex-wrap items-center">--}}
{{--                                <div class="h-12 w-12">--}}
{{--                                    @include('components.avatar', ['avatar_path' => 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])--}}
{{--                                </div>--}}
{{--                                <div class="grid grid-cols-1 p-2">--}}
{{--                                    <div class="font-bold text-lg text-white pb-1">--}}
{{--                                        <p>Phòng VIP1</p>--}}
{{--                                    </div>--}}
{{--                                    <div>--}}
{{--                                        <sub class="text-gray-400">13.0k Thành viên</sub>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="flex text-white text-lg">--}}
{{--                                <button class="mr-[10px]">--}}
{{--                                    <i class="fa-brands fa-facebook-messenger"></i>--}}
{{--                                </button>--}}
{{--                                <button>--}}
{{--                                    <i class="fa-solid fa-right-from-bracket"></i>--}}
{{--                                </button>--}}
{{--                            </div>--}}
{{--                        </div>--}}
                    </div>
                    <div class="relative">
                        <label>
                            <input type="text" class="w-full h-[40px] rounded-[5px] p-2">
                            <button class="absolute right-[24px] text-lg pt-2"><i class="fa-solid fa-magnifying-glass"></i></button>
                        </label>
                    </div>
                    <div class="h-[85vh] px-8 bg-[#262948] mt-4 pt-5 rounded-lg overflow-auto" id="TagListMember">
                        {{--Show list members--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@include('components.modals.createFormModal')
@include('components.modals.searchRoomModal')
@include('components.modals.notification')
@include('partials.javascript')

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function(e){
        $('#createRoomForm').submit(function (e){
            e.preventDefault();
            console.log("Form submit");
            $.ajax({
                type: 'POST',
                url: '{{ route("room.store") }}',
                data: $(this).serialize(),
                success: function(response) {
                    console.log(response);
                    if(response.icon === null){
                        response.icon = 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg';
                    }
                    if(response.description === null){
                        response.description = '';
                    }
                    let html = '';
                    html += `
                    <a href="#" class="w-full bg-[#262948] hover:bg-[#4289f3] py-3 px-4 my-4 rounded-lg grid grid-cols-3 gap-2 relative">
                            <div class="col-span-1">
                                <div class="flex justify-start items-center gap-4">
                                    <div class="w-8 h-8 rounded-full">
                                        <img src="${response.icon}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                    </div>
                                    <p class="font-bold">${response.name}</p>
                                </div>
                            </div>
                            <div class="col-span-2">
                                <p>${response.description}</p>
                            </div>
                        </a>`;
                    console.log(html);
                    $('#rooms_list').prepend(html);
                    closeModal('addNewRoomFormModal');
                },
                error: function (error){
                    console.log(error);
                    closeModal('addNewRoomFormModal');
                },
            });
            $('#createRoomForm')[0].reset();
        });
    })
</script>
</body>
</html>
