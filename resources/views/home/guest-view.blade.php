<!-- Hero Section -->
<section class="bg-primary text-white py-20">
    <div class="container mx-auto px-4">
        <div class="max-w-3xl mx-auto text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">
                Find the Perfect Tutor for Your Learning Journey
            </h1>
            <p class="text-xl mb-8">
                Connect with skilled Telkom University students for tutoring and project help
            </p>
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('register') }}"
                   class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition text-center">
                    Get Started
                </a>
                <a href="{{ route('login') }}"
                   class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-blue-700 transition text-center">
                    Sign In
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Featured Services -->
@if($featuredServices->isNotEmpty())
    <section class="py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8">Featured Tutors</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($featuredServices as $service)
                    <a href="{{ route('tutors.show', $service) }}"
                       class="bg-white rounded-lg shadow-sm hover:shadow-md transition">
                        <div class="p-4">
                            <p class="text-sm text-primary mb-2">
                                {{ $service->category->name }}
                            </p>
                            <h3 class="font-semibold mb-2">{{ $service->title }}</h3>
                            <p class="text-gray-600 text-sm mb-4">
                                {{ Str::limit($service->description, 100) }}
                            </p>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">
                                    ${{ number_format($service->price, 2) }}
                                </span>
                                <span class="text-sm text-gray-500">
                                    by {{ $service->user->name }}
                                </span>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="text-center mt-8">
                <a href="{{ route('login') }}" class="text-primary font-semibold hover:text-blue-700">
                    Sign in to view more tutors →
                </a>
            </div>
        </div>
    </section>
@endif

<!-- Categories -->
@if($categories->isNotEmpty())
    <section class="bg-gray-50 py-16">
        <div class="container mx-auto px-4">
            <h2 class="text-3xl font-bold mb-8">Popular Subjects</h2>
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($categories as $category)
                    <a href="{{ route('login') }}"
                       class="bg-white p-6 rounded-lg shadow-sm hover:shadow-md transition text-center group">
                        <h3 class="font-semibold mb-2 group-hover:text-blue-600">
                            {{ $category->name }}
                        </h3>
                        <p class="text-sm text-gray-500">
                            {{ $category->services_count }} tutoring sessions
                        </p>
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endif

<!-- How It Works -->
<section class="py-16">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold mb-12 text-center">How Mentora Works</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-blue-600 text-xl font-bold">1</span>
                </div>
                <h3 class="font-semibold mb-2">Sign Up</h3>
                <p class="text-gray-600">Create your free Mentora account</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-blue-600 text-xl font-bold">2</span>
                </div>
                <h3 class="font-semibold mb-2">Find a Tutor</h3>
                <p class="text-gray-600">Browse and book tutoring sessions</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-blue-600 text-xl font-bold">3</span>
                </div>
                <h3 class="font-semibold mb-2">Achieve More</h3>
                <p class="text-gray-600">Learn, collaborate, and grow with Mentora</p>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="bg-primary text-white py-16">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Ready to Learn or Teach?</h2>
        <p class="text-xl mb-8">Join the Mentora community and unlock your potential</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('register') }}"
               class="bg-white text-primary px-8 py-3 rounded-lg font-semibold hover:bg-blue-50 transition">
                Create Account
            </a>
            <a href="{{ route('login') }}"
               class="border border-white text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary transition">
                Sign In
            </a>
        </div>
    </div>
</section>
