<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Reported Content') }}
        </h2>
    </x-slot>
    <div class="py-8 max-w-5xl mx-auto">
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-semibold mb-4">All Reported Content</h3>
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr>
                        <th class="px-4 py-2">Content</th>
                        <th class="px-4 py-2">Reporter</th>
                        <th class="px-4 py-2">Reason</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $report)
                        <tr>
                            <td class="px-4 py-2">{{ $report->content->title ?? '-' }}</td>
                            <td class="px-4 py-2">{{ $report->reporter->name ?? '-' }}</td>
                            <td class="px-4 py-2">{{ Str::limit($report->reason, 40) }}</td>
                            <td class="px-4 py-2">{{ ucfirst($report->status) }}</td>
                            <td class="px-4 py-2">
                                <a href="{{ route('admin.contents.review_report', $report) }}" class="text-blue-600 hover:underline">Review</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="mt-4">{{ $reports->links() }}</div>
        </div>
    </div>
</x-app-layout> 