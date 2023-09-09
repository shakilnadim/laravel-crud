@props(['action', 'method' => 'POST', 'test' => null])
<div class="max-w-md mx-auto border rounded p-4">
    <h1 class="text-center text-xl">Test</h1>
    <form action="{{ $action }}" method="post">
        @if($method !== 'POST')
            @method($method)
        @endif
        @csrf

        <label for="test-input">Title</label>
        <div>
            <input id="test-input" class="rounded w-full" type="text" name="title" value="{{ old('title', $test !== null ? $test->title : '') }}">
        </div>
        @error('title')
            <div class="text-red-600 text-sm">{{ $message }}</div>
        @enderror

        <div class="text-right mt-2">
            <button type="Submit" class="py-1 px-2 bg-emerald-300 hover:bg-emerald-400 transition rounded">Submit</button>
        </div>

    </form>
</div>
