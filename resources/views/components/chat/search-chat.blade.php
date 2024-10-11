<div class="wt-dashboard-msg-search">
    <div class="input-group">
        <input oninput="searchMessage(this)" id="search-chat" class="form-control" placeholder="Search Messages 1" type="text">
        <button class="btn" type="button"><i class="fa fa-search"></i></button>
    </div>
</div>


@push('js')
    <script>
        $( document ).ready(function() {
            let search = $("#search-chat")


        });
        function searchMessage(e) {
            let findDescriptionMessage = $(`.msg-user-discription:contains(${e.value})`)
            let parent = findDescriptionMessage.closest(".wt-dashboard-msg-search-list-wrap");
            console.log(parent.css('background', 'red'))

        }
    </script>

@endpush
