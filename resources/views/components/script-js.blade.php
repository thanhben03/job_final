<script src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<script src="{{ asset('/js/popper.min.js') }}"></script>
<script src="{{ asset('/js/bootstrap.min.js') }}"></script><!-- BOOTSTRAP.MIN JS -->
<script src="{{ asset('/js/magnific-popup.min.js') }}"></script><!-- MAGNIFIC-POPUP JS -->
<script src="{{ asset('/js/waypoints.min.js') }}"></script><!-- WAYPOINTS JS -->
<script src="{{ asset('/js/counterup.min.js') }}"></script><!-- COUNTERUP JS -->
<script src="{{ asset('/js/waypoints-sticky.min.js') }}"></script><!-- STICKY HEADER -->
<script src="{{ asset('/js/isotope.pkgd.min.js') }}"></script><!-- MASONRY  -->
<script src="{{ asset('/js/imagesloaded.pkgd.min.js') }}"></script><!-- MASONRY  -->
<script src="{{ asset('/js/owl.carousel.min.js') }}"></script><!-- OWL  SLIDER  -->
<script src="{{ asset('/js/theia-sticky-sidebar.js') }}"></script><!-- STICKY SIDEBAR  -->
<script src="{{ asset('/js/lc_lightbox.lite.js') }}"></script><!-- IMAGE POPUP -->
<script src="{{ asset('/js/bootstrap-select.min.js') }}"></script><!-- Form js -->
<script src="{{ asset('/js/dropzone.js') }}"></script><!-- IMAGE UPLOAD  -->
<script src="{{ asset('/js/jquery.scrollbar.js') }}"></script><!-- scroller -->
<script src="{{ asset('/js/bootstrap-datepicker.js') }}"></script><!-- scroller -->
<script src="{{ asset('/js/jquery.dataTables.min.js') }}"></script><!-- Datatable -->
<script src="{{ asset('/js/dataTables.bootstrap5.min.js') }}"></script><!-- Datatable -->
<script src="{{ asset('/js/chart.js') }}"></script><!-- Chart -->
<script src="{{ asset('/js/bootstrap-slider.min.js') }}"></script><!-- Price range slider -->
<script src="{{ asset('/js/swiper-bundle.min.js') }}"></script><!-- Swiper JS -->
<script src="{{ asset('/js/custom.js') }}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{{ asset('/js/toastr.min.js') }}"></script><!-- CUSTOM FUCTIONS  -->
<script src="{{ asset('/js/pusher.min.js') }}"></script>
<script>
    const toggleButton = document.querySelector('.toggle-chat');
    const chatPopUp = document.querySelector('#chat-bot');

    function scrollToBottom() {
        let chatContainer = document.querySelector('.card-body');
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function toggleOpenChat() {
        toggleButton.classList.toggle('chat-is-open');
        chatPopUp.classList.toggle('d-none')

        // Handle Scroll To Latest Message
        scrollToBottom()
        $("#message-to-bot").focus();
    }

    toggleButton.addEventListener('click', _ => {
        toggleOpenChat()

        // chatPopUp.classList.toggle('chat-display-on');
        // chatPopUp.classList.toggle('chat-visible');
    })
</script>
