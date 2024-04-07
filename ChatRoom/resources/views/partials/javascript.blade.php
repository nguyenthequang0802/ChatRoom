<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    function openModal(modal_id){
        let addNewRoomFormModal =  document.getElementById(modal_id);
        addNewRoomFormModal.classList.remove('hidden');
        addNewRoomFormModal.classList.add('visible');
    }
    function closeModal(modal_id){
        let addNewRoomFormModal = document.getElementById(modal_id);
        addNewRoomFormModal.classList.remove('visible');
        addNewRoomFormModal.classList.add('hidden');
    }
    function turnOnNotifications(message, type){
        const notificationElement = document.getElementById('notification-'+type);
        const notificationMessageElement = document.getElementById('notification-'+type+'-message');
        notificationMessageElement.innerText = message;
        notificationElement.classList.remove('hidden');
        notificationElement.classList.add('visible');
        setTimeout(function (){
            notificationElement.classList.remove('visible');
            notificationElement.classList.add('hidden');
        }, 3000);
    }
    let roomID = -1;
    function showRoom(room_id){
        $('#TagNameOfRoom').empty();
        $('#TagListMember').empty();
        $.ajax({
            type: 'POST',
            url: '{{ route("room.show" ) }}',
            data:{
                _token: '{{ csrf_token() }}',
                room_id: room_id
            },
            success: function (response){
                const info_room = response.infoRoom;
                const list_members = response.listMembers;
                roomID = info_room.id;
                console.log(roomID)
                const infoNameHTML = `<div class="flex flex-wrap items-center" id="Room-${info_room.id}">
                                        <div class="h-12 w-12">
                                            <img src="${info_room.icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                        </div>
                                        <div class="grid grid-cols-1 p-2">
                                            <div class="font-bold text-lg text-white pb-1">
                                                <p>${ info_room.name }</p>
                                            </div>
                                            <div>
                                                <sub class="text-gray-400">13.0k Thành viên</sub>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex text-white text-lg">
                                        <a onclick="openModal('boxRoom'); chatBox(${info_room.id})">
                                            <button class="mr-[10px]">
                                                <i class="fa-brands fa-facebook-messenger"></i>
                                            </button>
                                        </a>
                                        <a href="">
                                            <button>
                                                <i class="fa-solid fa-right-from-bracket"></i>
                                            </button>
                                        </a>
                                    </div>`;
                let listMemHTML = '';
                for(let i = 0; i < list_members.length; i++) {
                    listMemHTML += `<div class="col-span-1 mb-5 w-full">
                                        <div class="h-[65px] bg-white flex rounded-lg">
                                            <div class="h-full p-2">
                                                <img src="${list_members[i].icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'}" alt="avatar" class="w-full h-full rounded-full border-2 border-red-500" />
                                            </div>
                                            <div class="grid grid-cols-1 p-4">
                                                <div class="font-bold text-lg text-gray-600 pb-1 ">
                                                    <p>${list_members[i].name}</p>
                                                </div>
                                            </div>

                                        </div>
                                    </div>`;
                }
                $('#TagNameOfRoom').html(infoNameHTML);
                $('#TagListMember').html(listMemHTML);
                console.log(roomID)
            }
        })
    }

    // console.log(roomID)
    function chatBox(room_id){
        $.ajax({
            type: 'POST',
            url: '{{ route("room.chatbox") }}',
            data:{
                _token: '{{ csrf_token() }}',
                room_id: room_id
            },
            success: function (response){
                const room = response.room;
                const members = response.listMembers;
                const me = response.me;
                const messages = room.messages;
                let listMessHtml = '';
                let infoRoomHTML = `<div class="flex w-full h-[10vh] bg-[#262948] rounded-lg mb-8" id="infoRoom-${room.id}">
                                        <div class="flex flex-wrap items-center mx-5" >
                                            <div class="h-14 w-14">
                                                @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                            </div>
                                            <div class="grid grid-cols-1 p-2">
                                                <div class="font-bold text-lg text-white pb-1">
                                                    <p>${ room.name }</p>
                                                </div>
                                                <div>
                                                    <sub class="text-gray-400">13.0k Thành viên</sub>
                                                </div>
                                            </div>
                                        </div>
                                    </div>`;
                for(let i = 0; i < messages.length; i++){
                    console.log(messages[i])
                    let time = new Date(messages[i].created_at);
                    let hours = time.getHours();
                    let minutes = time.getMinutes();
                    if(messages[i].user_id === me.id){
                        listMessHtml += `<div class="flex flex-row-reverse mb-2">
                                            <div class="h-10 w-10 m-[10px]">
                                                @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                            </div>
                                            <div class="bg-[#262948] rounded-lg p-2 text-white">
                                                <p>${messages[i].content}</p>
                                                <small class="float-left">${hours}:${minutes}</small>
                                            </div>
                                            <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>

                                        </div>`;
                    } else {
                        listMessHtml += `<div class="flex mb-2">
                                            <div class="h-10 w-10 m-[10px]">
                                                @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                            </div>
                                            <div class="bg-[#262948] rounded-lg p-2 text-white">
                                                <p>${messages[i].content}</p>
                                                <small class="float-right">${hours}:${minutes}</small>
                                            </div>
                                            <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                        </div>`;
                    }
                }
                const inputHTML = `<div class="w-full h-[46px] bg-[#262948] rounded-lg flex justify-center items-center px-2 py-[4px]" id="message-${room.id}">
                        <input type="text" class="w-full h-full px-2 bg-white rounded-full mr-2 content" name="content" id="content-${room.id}" >
                        <div class="mr-2">
                            <input type="file" class="hidden input_img" name="content_img" id="" onchange="openImage(event, '${room.id}')">
                            <button type="button" class="text-[20px] text-white btn-selectImage" id="" onclick=""><i class="fa-solid fa-camera"></i></button>
                        </div>
                        <button class="text-[20px] mr-2 text-white" id="btn_sendMessage" onclick="sendMessage('${room.id}')"><i class="fa-solid fa-paper-plane"></i></button>
                    </div>`
                $('#infoRoom').html(infoRoomHTML);
                $('#boxChat').html(listMessHtml);
                $('#form_mess').html(inputHTML);
                {{--let room_id = {{ $room->id }}--}}
                {{--console.log(room_id);--}}

            },
        })
    }

    function sendMessage(room_id){
        let content = $('.content').val();
        console.log(content);
        Pusher.logToConsole = true;

        var pusher = new Pusher('3de20a79a40ba2abe378', {
            cluster: 'ap1'
        });

        var channel = pusher.subscribe('channel-' + room_id);
        channel.bind('my-event', function(data) {
            console.log(data);
            if({{ \Illuminate\Support\Facades\Auth::user()->id }} != data.message.user_id){
                const html = `<div class="flex mb-2">
                                            <div class="h-10 w-10 m-[10px]">
                                                @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                </div>
                <div class="bg-[#262948] rounded-lg p-2 text-white">
                    <p>${data.message.content}</p>

                                            </div>
                                            <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                                        </div>`;
                $('#boxChat').append(html);
            }
        });
        $.ajax({
            type: 'POST',
            url: '{{ route("room.sendMessage") }}',
            data: {
                _token: '{{ csrf_token() }}',
                room_id: room_id,
                content: content,
                type: 'text',
                user_id: {{ \Illuminate\Support\Facades\Auth::user()->id }}
            },
            success: function (response) {
                console.log(response);
                let time = new Date(response.created_at);
                let hours = time.getHours();
                let minutes = time.getMinutes();
              const html = `<div class="flex flex-row-reverse mb-2">
                                <div class="h-10 w-10 m-[10px]">
                                    @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                </div>
                                <div class="bg-[#262948] rounded-lg p-2 text-white">
                                    <p>${response.content}</p>
                                    <small class="float-left">${hours}:${minutes}</small>
                                </div>
                                <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                            </div>`;
              $('#boxChat').append(html);
              $('.content').val('');
            },
        });
    }
    function selectFile(){
        $('.input_img').click()
    }
    // function openImage(event, room_id){
    //     let file = event.target.files[0]; // Lấy tệp ảnh từ sự kiện
    //
    //     // Tạo một đối tượng FileReader
    //     let reader = new FileReader();
    //
    //     // Xử lý sự kiện khi tệp được đọc
    //     reader.onload = function(event) {
    //         let fileData = event.target.result; // Lấy dữ liệu của tệp ảnh đã đọc
    //
    //         // Gọi hàm sendMessageWithImage để gửi tin nhắn với nội dung ảnh
    //         sendMessageWithImage(room_id, fileData);
    //         $('.content').val(reader.readAsDataURL(file));
    //
    //     };
    //
    //     // Đọc tệp ảnh như là một chuỗi dữ liệu
    // }
    function sendMessageWithImage(room_id, url){
        let content = $('.content').val();
        $.ajax({
            type: 'POST',
            url: '{{ route("room.sendMessage") }}',
            data: {
                _token: '{{ csrf_token() }}',
                room_id: room_id,
                content: content,
                type: 'image',
            },
            success: function (response) {
                console.log(response);
                let time = new Date(response.message.created_at);
                let hours = time.getHours();
                let minutes = time.getMinutes();
                const html = `<div class="flex flex-row-reverse mb-2">
                                    <div class="h-10 w-10 m-[10px]">
                                        @include('components.avatar', ['avatar_path' => $room->icon ?? 'https://inkythuatso.com/uploads/thumbnails/800/2022/03/4a7f73035bb4743ee57c0e351b3c8bed-29-13-53-17.jpg'])
                                    </div>
                                    <div class="bg-[#262948] rounded-lg p-2 text-white">
                                        <img src="${url}" height="40px" width="40px">
                                        <small class="float-left">${hours}:${minutes}</small>
                                     </div>
                                <div class="text-white m-[5px]"><i class="fa-solid fa-ellipsis-vertical"></i></div>
                            </div>`;
                $('#boxChat').append(html);
                $('.content').val('');
            },
        });
    }

</script>
