<!-- Share Modal -->
<div class="modal fade" id="shareModal" tabindex="-1" aria-labelledby="shareModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="shareModalLabel">Share</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p class="mb-4">Share this post on your favorite social media platform:</p>
                <div class="d-flex justify-content-center mb-4">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-primary me-2 rounded-circle shadow">
                        <i class="bi bi-facebook fs-4"></i>
                    </a>
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-info me-2 rounded-circle shadow">
                        <i class="bi bi-twitter fs-5"></i>
                    </a>
                    <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(url()->current()) }}" target="_blank" class="btn btn-outline-primary me-2 rounded-circle shadow">
                        <i class="bi bi-linkedin fs-4"></i>
                    </a>
                </div>

                <hr>

                <p class="mb-3">Or copy the link directly:</p>
                <div class="input-group mb-3">
                    <input type="text" id="postLink" class="form-control border-secondary shadow-none" value="{{ url()->current() }}" readonly>
                    <button class="btn btn-outline-secondary" type="button" id="copyButton" data-bs-toggle="tooltip" data-bs-placement="top" title="Copy Link">
                        <i class="bi bi-clipboard"></i> Copy
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
