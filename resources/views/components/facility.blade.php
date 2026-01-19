@props(['icon', 'name'])

<div class="rounded-lg flex items-center space-x-4 text-xl border border-gray-800 p-2 cursor-pointer font-semibold">
    <img class="w-10 h-10" src="{{ asset('assets/icons/' . $icon) }}" alt="">
    <p>{{ $name }}</p>
</div>
