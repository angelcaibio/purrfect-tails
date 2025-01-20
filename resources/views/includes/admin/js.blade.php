  
    <script src="{{asset('inspinia/js/popper.min.js')}}"></script>
    <script src="{{asset('inspinia/js/jquery-3.1.1.min.js')}}"></script>
    <script src="{{asset('inspinia/js/bootstrap.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>

    <script src="{{asset('inspinia/js/plugins/flot/jquery.flot.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/flot/jquery.flot.tooltip.min.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/flot/jquery.flot.spline.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/flot/jquery.flot.resize.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/flot/jquery.flot.pie.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/flot/jquery.flot.symbol.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/flot/jquery.flot.time.js')}}"></script>


    <script src="{{asset('inspinia/js/plugins/peity/jquery.peity.min.js')}}"></script>
    <script src="{{asset('inspinia/js/demo/peity-demo.js')}}"></script>

    <script src="{{asset('inspinia/js/inspinia.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/pace/pace.min.js')}}"></script>

    <script src="{{asset('inspinia/js/plugins/jquery-ui/jquery-ui.min.js')}}"></script>

    <script src="{{asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
    <script src="{{asset('inspinia/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

    <script src="{{asset('inspinia/js/plugins/easypiechart/jquery.easypiechart.js')}}"></script>


    <script src="{{ asset('inspinia/js/plugins/summernote/summernote-bs4.js') }}"></script>

 
    <script src="{{asset('inspinia/js/plugins/sparkline/jquery.sparkline.min.js')}}"></script>
    <script src="{{asset('inspinia/js/demo/sparkline-demo.js')}}"></script>


    <script src="{{ asset('inspinia/js/plugins/footable/footable.all.min.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            document.querySelector('#inputGroupFile02').addEventListener('change', function(event) {
                var fileName = event.target.files.length > 1 
                    ? event.target.files.length + ' files selected' 
                    : event.target.files[0].name;
                event.target.nextElementSibling.innerText = fileName;
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#content').summernote({
                height: 300,
                placeholder: 'Enter blog content...',
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['para', ['ul', 'ol', 'paragraph']]
                ],
                tooltip: false
            });
        });
    </script>

    <script>
        $('#photoModal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget); 
            var photo = button.data('photo'); 
            var title = button.data('title');
            var modal = $(this);
            modal.find('.modal-title').text(title);
            modal.find('#modalPhoto').attr('src', photo);
        });
    </script>

<script>
    function deletePhoto(photoName, button) {
        if (confirm("Are you sure you want to delete this photo?")) {
            const blogId = document.getElementById('photos-container').dataset.blogId;

            fetch(`/blogs/${blogId}/delete-photo`, { 
                method: "DELETE",
                headers: {
                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({ photo: photoName })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(data.message);
                    button.closest('div').remove();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
                alert("Failed to delete the photo. Please try again.");
            });
        }
    }
</script>
