<x-layout>
    <div class="mt-4">
        <x-test.form method="PUT" :action="route('test.update', $test->id)" :test="$test"></x-test.form>
    </div>
</x-layout>
