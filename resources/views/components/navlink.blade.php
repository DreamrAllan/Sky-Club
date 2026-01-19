@props(['active'=>false])

<a {{ $attributes }}
class=" {{ $active ? ' text-red-600 font-semibold' : 'font-medium text-gray-900 hover:text-red-600' }} rounded-md px-3 py-2 text-sm"
aria-current="{{ $active ? 'page' : false }}">{{ $slot }}</a>
