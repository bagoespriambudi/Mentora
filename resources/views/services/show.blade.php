<x-layouts.app>
    <div>
        <a href="{{ url()->previous() }}">Back</a>

        <h1>{{ $service->title }}</h1>

        @if($service->thumbnail)
            <img src="{{ Storage::url($service->thumbnail) }}" alt="{{ $service->title }}" width="300">
        @endif

        <p>Category: {{ $service->category->name }}</p>
        <p>By: {{ $service->user->name }}</p>
        <p>Price: ${{ number_format($service->price, 2) }}</p>

        <div>
            <h3>Description</h3>
            <p>{{ $service->description }}</p>
        </div>

        <div>
            <h3>Service Details</h3>
            <p>Delivery Time: {{ $service->duration_days }} days</p>
            <p>Status: {{ $service->is_active ? 'Active' : 'Inactive' }}</p>
        </div>

        @if($service->gallery && count($service->gallery) > 0)
            <h3>Gallery</h3>
            @foreach($service->gallery as $image)
                <img src="{{ Storage::url($image) }}" alt="Gallery image" width="200">
            @endforeach
        @endif

        @auth
            @if(auth()->user()->role === 'client' && $service->is_active)
                <h3>Order</h3>
                <p>Delivered in {{ $service->duration_days }} days</p>
                <p>Price: ${{ number_format($service->price, 2) }}</p>
                <a href="{{ route('orders.create', $service) }}">Order Now</a>
            @elseif(auth()->user()->role === 'freelancer' && $service->user_id === auth()->id())
                <h3>Manage</h3>
                <a href="{{ route('services.edit', $service) }}">Edit Service</a>
            @endif
        @else
            <p>Login to order this service</p>
            <a href="{{ route('login') }}">Login</a>
        @endauth

        <div>
            <h3>About Freelancer</h3>
            <p>{{ $service->user->name }}</p>
            <p>Member since {{ $service->user->created_at->format('M Y') }}</p>
        </div>
    </div>
</x-layouts.app>