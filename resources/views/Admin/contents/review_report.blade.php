<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Review Reported Content
        </h2>
    </x-slot>
    <div class="py-8 max-w-3xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">Report Details</h3>
            <div class="mb-4">
                <strong>Content:</strong> {{ $report->content->title ?? '-' }}<br>
                <strong>Reporter:</strong> {{ $report->reporter->name ?? '-' }}<br>
                <strong>Reason:</strong> {{ $report->reason }}<br>
                <strong>Status:</strong> {{ ucfirst($report->status) }}<br>
                <strong>Admin Notes:</strong> {{ $report->admin_notes ?? '-' }}
            </div>
            <div class="mb-4">
                <strong>Content Preview:</strong>
                <div class="border p-3 mt-2 bg-gray-50">{!! nl2br(e($report->content->body ?? '')) !!}</div>
            </div>
            @if($report->status === 'pending')
            <form method="POST" action="{{ route('admin.contents.resolve_report', $report) }}" class="mb-2">
                @csrf
                <label for="admin_notes" class="block font-medium">Admin Notes (optional):</label>
                <textarea name="admin_notes" id="admin_notes" class="w-full border rounded p-2 mb-2"></textarea>
                <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded">Resolve</button>
            </form>
            <form method="POST" action="{{ route('admin.contents.reject_report', $report) }}">
                @csrf
                <label for="admin_notes_reject" class="block font-medium">Admin Notes (optional):</label>
                <textarea name="admin_notes" id="admin_notes_reject" class="w-full border rounded p-2 mb-2"></textarea>
                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded">Reject</button>
            </form>
            @endif
            <a href="{{ route('admin.contents.reported') }}" class="text-blue-600 hover:underline mt-4 inline-block">Back to Reports</a>
        </div>
    </div>
</x-app-layout> 