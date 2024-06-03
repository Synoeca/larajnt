<x-layout>
    <x-header>About Me Index Page</x-header>
    @auth
        @php
            // Check if the user is an admin
            $isAdmin = auth()->user()->is_admin;
            // Check if the user has already created an "About Me" page
            $hasCreatedAboutMe = $aboutmes->contains('user_id', auth()->id());
        @endphp
        
        @if($isAdmin || !$hasCreatedAboutMe)
            <section>
                <div class="flex justify-end">
                    <a href="{{route('aboutmes.create')}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Create</a>
                </div>
            </section>
        @endif
    @endauth
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach ($aboutmes as $aboutme)
            <div class="max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700">
                @if($aboutme->thumbnail)
                    <img src="{{ URL($aboutme->thumbnail) }}" alt="JNT logo" class="mb-4">
                @endif
                <a href="/aboutmes/{{$aboutme->id}}">
                    <h5 class="mb-4 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{$aboutme -> name}}</h5>
                </a>
                <p class="mb-3 font-bold text-gray-700 dark:text-gray-400">{{$aboutme->title}}</p>
                <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">{{$aboutme->content}}</p>
                <div class="flex justify-left space-x-2">
                    @can('update', $aboutme)
                        <a href="{{route('aboutmes.edit', $aboutme->id)}}" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Edit</a>
                    @endcan
                    @can('delete', $aboutme)
                        <form action="{{route('aboutmes.destroy', $aboutme->id)}}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-white bg-red-700 hover:bg-red-800 focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 focus:outline-none dark:focus:ring-red-800">Delete</button>
                        </form>
                    @endcan
                </div>
            </div>
        @endforeach
        <div class="mt-6">{{$aboutmes->links()}}</div>
    </div>
</x-layout>
