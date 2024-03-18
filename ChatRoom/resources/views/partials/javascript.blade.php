<script>
    function openModal(modal_id){
        console.log("open modal")
        let addNewRoomFormModal =  document.getElementById(modal_id);
        addNewRoomFormModal.classList.remove('hidden');
        addNewRoomFormModal.classList.add('visible');
    }
    function closeModal(modal_id){
        console.log("close modal");
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

    function showRoom(room_id){
        console.log("show room ", room_id);
        $.ajax({
            type: 'POST',
            url: '{{ route("room.show") }}',
            data:{
                _token: '{{ csrf_token() }}',
                room_id: room_id
            },
            success: function (response){
                console.log(response)
                const info_room = response.infoRoom;
                const list_members = response.listMembers;
                console.log(list_members);
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
                                        <button class="mr-[10px]">
                                            <i class="fa-brands fa-facebook-messenger"></i>
                                        </button>
                                        <button>
                                            <i class="fa-solid fa-right-from-bracket"></i>
                                        </button>
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
                const TagNameOfRoom =document.getElementById('TagNameOfRoom');
                TagNameOfRoom.innerHTML += infoNameHTML;
                const TagListMember =document.getElementById('TagListMember');
                TagListMember.innerHTML += listMemHTML;
            }
        })
    }
</script>
