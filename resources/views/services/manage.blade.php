<x-layouts.app>
    <div class="p-4">
        @if (session('success'))
            <p style="color: green">{{ session('success') }}</p>
        @endif
        @if (session('error'))
            <p style="color: red">{{ session('error') }}</p>
        @endif

        <h2>Mentora - My Services</h2>

        <a href="{{ route('services.create') }}">+ Add Service</a>

        @if($services->isEmpty())
            <p>No services yet. <a href="{{ route('services.create') }}">Make one</a></p>
        @else
            <table border="1" cellpadding="6" cellspacing="0">
                <thead>
                    <tr>
                        <th>Service</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Delivery</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($services as $service)
                        <tr>
                            <td>{{ $service->title }}</td>
                            <td>{{ $service->category->name }}</td>
                            <td>${{ number_format($service->price, 2) }}</td>
                            <td>{{ $service->is_active ? 'Active' : 'Inactive' }}</td>
                            <td>{{ $service->duration_days }} days</td>
                            <td>
                                <a href="{{ route('services.show', $service) }}">View</a> |
                                <a href="{{ route('services.edit', $service) }}">Edit</a> |
                                <form action="{{ route('services.destroy', $service) }}" method="POST" style="display:inline;" onsubmit="return confirm('Are you sure?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color:red;background:none;border:none;padding:0;cursor:pointer;">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div style="margin-top: 10px;">
                {{ $services->links() }}
            </div>
        @endif
    </div>
</x-layouts.app>