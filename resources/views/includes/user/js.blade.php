<script src="{{ asset('blogy/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('blogy/js/tiny-slider.js') }}"></script>
<script src="{{ asset('blogy/js/flatpickr.min.js') }}"></script>
<script src="{{ asset('blogy/js/aos.js') }}"></script>
<script src="{{ asset('blogy/js/glightbox.min.js') }}"></script>
<script src="{{ asset('blogy/js/navbar.js') }}"></script>
<script src="{{ asset('blogy/js/counter.js') }}"></script>
<script src="{{ asset('blogy/js/custom.js') }}"></script>
<script src="{{ asset('blogy/js/jquery-3.6.0.min.js') }}"></script>

<script>
    $(document).ready(function () {
        // Handle the Like button click
        $('#likeButton').click(function (e) {
            e.preventDefault();

            var postId = $(this).data('post-id');
            $.ajax({
                url: "{{ route('likePost', ':postId') }}".replace(':postId', postId),
                type: "POST",
                data: {
                    _token: '{{ csrf_token() }}',
                },
                success: function (response) {
                    if (response.liked !== undefined) {
                        if (response.liked) {
                            $('#likeButton').html('<i class="bi bi-heart-fill"></i>'); // Change icon to filled heart
                        } else {
                            $('#likeButton').html('<i class="bi bi-heart"></i>'); // Change icon to empty heart
                        }
                        $('#likeCount').text(response.likeCount + ' Likes'); // Update like count display
                    } else {
                        alert('Error: Unexpected response format');
                    }
                },
                error: function () {
                    alert('Error while processing your request.');
                }
            });
        });

    });
</script>
