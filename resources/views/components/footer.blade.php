<footer class="bg-white border-t">
    <div class="container mx-auto px-4 py-8">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
            <!-- Company Info -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Mentora</h3>
                <p class="text-gray-600">
                    Connect with talented professionals and get your work done.
                </p>
            </div>

            <!-- Categories -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Categories</h3>
                <ul class="space-y-2">
                    @foreach(\App\Models\Category::take(5)->get() as $category)
                        <li>
                            <a href="{{ route('subjects.show', $category) }}"
                               class="text-gray-600 hover:text-blue-600">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            <!-- Quick Links -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Quick Links</h3>
                <ul class="space-y-2">
                    <li>
                        <a href="#" class="text-gray-600 hover:text-blue-600">About Us</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 hover:text-blue-600">How it Works</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 hover:text-blue-600">Terms of Service</a>
                    </li>
                    <li>
                        <a href="#" class="text-gray-600 hover:text-blue-600">Privacy Policy</a>
                    </li>
                </ul>
            </div>

            <!-- Contact -->
            <div>
                <h3 class="text-lg font-semibold mb-4">Contact</h3>
                <ul class="space-y-2">
                    <li class="text-gray-600">support@mentora.com</li>
                    <li class="text-gray-600">+1 234 567 890</li>
                </ul>
            </div>
        </div>

        <div class="mt-8 pt-8 border-t text-center text-gray-600">
            <p>&copy; {{ date('Y') }} Mentora. All rights reserved.</p>
        </div>
    </div>
</footer>
