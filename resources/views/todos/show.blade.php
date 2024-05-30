<x-layout>
    <section class="mt-4">
        <div class="flex justify-end">
            <div class="flex justify-between">
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
            </div>
        </div>
    </section>
    <div class="max-w-6xl mx-auto sm:px-6 lg:px-8 mt-8 bg-slate-50 dark:bg-slate-700 rounded-lg">
        <h1 class="text-3xl font-bold text-center text-indigo-600 dark:text-indigo-400">{{$todo -> title}}</h1>
        <main class="mt-4">
            <p class="text-lg text-center text-gray-700 dark:text-gray-400">{{$todo -> description}}</p>
        </main>
    </div>
</x-layout>