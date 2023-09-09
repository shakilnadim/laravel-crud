<x-layout>
    <section class="max-w-lg mx-auto my-2">
        <div class="mb-2 flex justify-between items-center">
            <h1 class="text-2xl">Tests</h1>
            <a class="bg-emerald-300 hover:bg-emerald-400 p-2 rounded transition" href="{{ route('test.create') }}">Create</a>
        </div>

        <ul class="border rounded p-4">
            @foreach($tests as $test)
                <li class="flex justify-between items-center gap-1 mb-2">
                    <a class="w-full block p-2 text-lg border rounded hover:bg-emerald-100 transition" href="{{ route('test.edit', $test->id) }}">{{ $test->title }}</a>
                    <form action="{{ route('test.delete', $test->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="p-1 bg-red-300 rounded hover:bg-red-400 transition" type="submit">Delete</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </section>
</x-layout>
