<footer class="site-footer">
    <div class="container">
        <div class="row">
            <!-- About Section -->
            <div class="col-lg-4">
                <div class="widget">
                    <img
                        src="{{ asset('images/nav.svg') }}"
                        alt="Purrfect Tails"
                        class="img logo-img"
                        style="width: 150px; height: 100%;">
                    <p>
                        Passionate about providing the best care and information for your furry
                        friends. Whether you are a seasoned pet owner or new to the world of pets, we
                        have something for everyone.
                    </p>
                </div>

                <div class="widget">
                    <h3>Follow Us</h3>
                    <ul class="list-unstyled social">
                        <li>
                            <a href="https://www.instagram.com/yourprofile" target="_blank"><span class="bi bi-instagram"></span> </a>
                        </li>
                        <li>
                            <a href="https://twitter.com/yourprofile" target="_blank"><span class="bi bi-twitter"></span> </a>
                        </li>
                        <li>
                            <a href="https://www.facebook.com/yourprofile" target="_blank"><span class="bi bi-facebook"></span> </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="col-lg-4 ps-lg-5">
                <div class="widget">
                    <h3 class="mb-4">Categories</h3>
                    <ul class="list-unstyled float-start links">
                        @foreach($categories as $category)
                            <li> <a href="{{ route('users.category', $category->id) }}">
                                {{ $category->name }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Recent Posts Section -->
            <div class="col-lg-4">
    <div class="widget">
        <h3 class="mb-4">Recent Posts</h3>
                <div class="post-entry-footer">
                    <ul>
                    @foreach($recentPosts as $post)
                        <li>
                            <a href="{{ route('post.show', $post->id) }}">
                                @php
                                    $firstImage = explode(',', $post->photo)[0];  
                                @endphp
                                <img
                                    src="{{ asset('storage/posts/' . $firstImage) }}" 
                                    alt="{{ $post->title }}"
                                    class="me-4 rounded"
                                    style="width: 50px; height: 50px; object-fit: cover;">
                                <div class="text">
                                    <h4>{{ $post->title }}</h4>
                                    <div class="post-meta">
                                        <span class="mr-2">{{ \Carbon\Carbon::parse($post->created_at)->format('M. jS, Y') }}</span>
                                    </div>
                                </div>
                            </a>
                        </li>
                    @endforeach

                    </ul>
                </div>
            </div>
        </div>

        </div>
        <!-- Footer Bottom -->
        <div class="row">
            <div class="col-12 text-center">
                <p>&copy; {{ now()->year }} Purrfect Tails. All Rights Reserved.</p>
            </div>
        </div>
    </div>
</footer>
