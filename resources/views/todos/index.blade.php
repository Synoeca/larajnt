<x-layout>
    <x-header>Todos Index Page</x-header>
    @auth
        <section>
            <div class="flex justify-end">
                <a href="{{route('todos.create')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</a>
            </div>
        </section>
    @endauth
    

<div class="relative overflow-x-auto">
    <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3">
                    ID
                </th>
                <th scope="col" class="px-6 py-3">
                    Title
                </th>
                <th scope="col" class="px-6 py-3">
                    Description
                </th>
                <th scope="col" class="px-6 py-3">
                    Completed
                </th>
                <th scope="col" class="px-6 py-3">
                    Actions
                </th>
            </tr>
        </thead>
        <tbody>
           @forelse ($todos as $todo)
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    {{$todo->id}}
                </th>
                <td class="px-6 py-4">
                    <a href="{{route('todos.show', $todo->id)}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800"> {{$todo->title}}</a>
                   
                </td>
                <td class="px-6 py-4">
                    {{$todo->description}}
                </td>
                <td class="px-6 py-4">
                    <button class="toggle-status-button text-white {{ $todo->is_completed ? 'bg-green-700 hover:bg-green-800' : 'bg-red-700 hover:bg-red-800' }} focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2" data-id="{{ $todo->id }}">
                        {{ $todo->is_completed ? 'Completed' : 'Incompleted' }}
                    </button>
                    
                </td>
                <td class="px-6 py-4 flex space-x-2">
                    @can('update', $todo)
                    <a href="{{route('todos.edit', $todo->id)}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>
                    @endcan
                    @can('delete', $todo)
                    <form action="{{route('todos.destroy', $todo->id)}}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-blue-red font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Delete</a>
                    </form>
                    @endcan
                </td>
            </tr>
           @empty
            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    No Posts
                </th>
            </tr>
           @endforelse
           <div class="mt-6">{{$todos->links()}}</div>
        </tbody>
    </table>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.toggle-status-button').forEach(button => {
            button.addEventListener('click', function () {
                const todoId = this.dataset.id;
                const url = `{{ url('/todos') }}/${todoId}/toggle`;

                fetch(url, {
                    method: 'PATCH',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        this.classList.toggle('bg-green-700');
                        this.classList.toggle('bg-red-700');
                        this.classList.toggle('hover:bg-green-800');
                        this.classList.toggle('hover:bg-red-800');
                        this.textContent = data.new_status;
                    }
                })
                .catch(error => console.error('Error:', error));
            });
        });
    });
</script>

</x-layout>