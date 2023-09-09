@props(['message'])
<div class="max-w-sm border shadow cursor-pointer p-4 text-center absolute left-2/4 -translate-x-2/4 rounded bg-emerald-100" id="alert">
    <p>{{ $message }}</p>
</div>

<script>
    const alert = document.getElementById('alert');
    alert.addEventListener('click', () => alert.classList.add('hidden'));
    setTimeout(() => alert.classList.add('hidden'), 3000);
</script>
