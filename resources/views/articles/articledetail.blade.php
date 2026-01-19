@extends('layouts.master')
@section('content')

<div class="grid grid-cols-2 mt-20">
    <div class="grid grid-cols-1 content-center ">
        <h3 class="text-5xl font-bold leading-tight mb-12">{{ Str::limit($article->title, 120) }}</h3>
        <div>
            <p>By <span class=" font-semibold">{{ $article->user->name }}</span></p>
            <div class="flex items-center">
                <p>{{ $article->created_at->format('j F Y') }}</p>
                <span class="w-1.5 h-1.5 mx-1.5 bg-black rounded-full"></span>
                <p>{{ $article->created_at->format('H:i') }}</p>
            </div>
        </div>
    </div>
    <div class="bg-cover rounded-lg shadow">
        @if($content && isset($content->blocks))
            @foreach($content->blocks as $block)
                {{-- Image --}}
                @if($block->type === 'image')
                    <img class="object-cover w-full h-full rounded-lg transition-transform duration-300 hover:scale-105" src="{{ $block->data->file->url ?? '#' }}" alt="">
                    @break
                @else
                    <img class="object-cover w-full h-full rounded-lg transition-transform duration-300 hover:scale-105" src="{{ Storage::url('images/banner.svg') }}" alt="">
                    @break
                @endif
            @endforeach
        @endif
    </div>
</div>

<article class="mt-28 mx-auto w-full max-w-2xl break-words">
    <div class="prose">
        @if($content && isset($content->blocks))
        @foreach($content->blocks as $block)
            {{-- Paragraph --}}
            @if($block->type === 'paragraph')
                <p class="text-gray-700 leading-relaxed">
                    {!! $block->data->text ?? '' !!}
                </p>

            @elseif($block->type === 'header')
            <h{{ $block->data->level ?? 3 }}>
                {{ $block->data->text }}
            </h{{ $block->data->level ?? 3 }}>

            {{-- Image --}}
            @elseif($block->type === 'image')
                <div>
                    <img
                        src="{{ $block->data->file->url ?? '#' }}"
                        alt="{{ $block->data->caption ?? 'Image' }}"
                        class="rounded-lg shadow-md w-full object-cover transition-transform duration-300 hover:scale-105"
                    >
                    @if(!empty($block->data->caption))
                        <p class="text-center text-sm text-gray-500 italic">
                            {{ $block->data->caption }}
                        </p>
                    @endif
                </div>

            {{-- List --}}
            @elseif($block->type === 'list')
                @if($block->data->style === 'ordered')
                    <ol class="list-decimal pl-6 mb-6 text-gray-700 space-y-2">
                        @foreach($block->data->items as $item)
                            <li class="text-base">{{ $item->content ?? '' }}</li>
                        @endforeach
                    </ol>
                @else
                    <ul class="list-disc pl-6 mb-6 text-gray-700 space-y-2">
                        @foreach($block->data->items as $item)
                            <li class="text-base">{{ $item->content ?? '' }}</li>
                        @endforeach
                    </ul>
                @endif

            {{-- Checklist --}}
            @elseif($block->type === 'checklist')
                <ul class="mb-6 space-y-2">
                    @foreach($block->data->items as $item)
                        <li class="flex items-center space-x-3">
                            <input
                                type="checkbox"
                                class="form-checkbox h-5 w-5 text-red-500 rounded border-gray-300 transition duration-300 focus:ring focus:ring-green-400"
                                {{ $item->checked ? 'checked' : '' }}
                            >
                            <span class="text-gray-700 text-base">{{ $item->text ?? '' }}</span>
                        </li>
                    @endforeach
                </ul>

            {{-- Quote --}}
            @elseif($block->type === 'quote')
                <blockquote class="border-l-4 border-red-600 py-3 pl-6 italic text-lg text-gray-600 mb-6">
                    {!! $block->data->text ?? '' !!}
                    @if(!empty($block->data->caption))
                        <footer class="text-sm text-gray-500">
                            - {{ $block->data->caption }}
                        </footer>
                    @endif
                </blockquote>
            {{-- Table --}}
            @elseif($block->type === 'table')
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-300 rounded-lg shadow-md">
                    <thead>
                        <tr class="bg-gray-100">
                            @foreach($block->data->content[0] as $header)
                                <th class="py-3 px-5 border-b border-gray-300 text-left text-sm font-semibold text-gray-700 uppercase tracking-wide">
                                    {{ $header }}
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(array_slice($block->data->content, 1) as $row)
                            <tr class="even:bg-gray-50 odd:bg-white">
                                @foreach($row as $cell)
                                    <td class="py-3 px-5 border-b border-gray-300 text-sm text-gray-800">
                                        {{ $cell }}
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @elseif($block->type === 'warning')
            <div class="border-l-4 border-yellow-400 bg-yellow-50 p-4 rounded-md shadow-sm">
                <h4 class="font-semibold text-yellow-700 mt-2">
                    {{ $block->data->title ?? 'Warning' }}
                </h4>
                <p class="text-sm text-yellow-800 mb-2">
                    {{ $block->data->message ?? 'No details provided.' }}
                </p>
            </div>
            @elseif($block->type === 'delimiter')
            <div class="text-center my-4">
                <span class="text-5xl text-gray-800">* * *</span>
            </div>

            {{-- Fallback for Unknown Types --}}
            @else
                <p class="text-sm text-red-500">
                    Unsupported block type: {{ $block->type }}
                </p>
            @endif
        @endforeach
    @else
        <p class="text-gray-500 italic">No content available</p>
    @endif
    <hr class="h-px my-10 bg-gray-400 border-0 dark:bg-gray-700">
    </div>
    <div class="flex space-x-4">
        <img class=" rounded-full" src="{{ Storage::url('images/profile.svg') }}" alt="">
        <div>
            <p class=" font-semibold">{{ $article->user->name}}</p>
            <p>{{ $article->created_at->diffForHumans()}}</p>
        </div>
    </div>
</article>


{{-- blog --}}
<div class="mt-28 mb-20">
    <div class="flex justify-between ">
        <div class="space-y-4">
            <h6 class="text-base font-bold">Artikel</h6>
            <h1 class="text-5xl font-bold">Artikel Serupa</h1>
            <h5 class="text-base">Menampilkan artikel yang serupa dengan artikel ini untuk membantu Anda menemukan lebih banyak konten yang relevan.</h5>
        </div>
        <div class=" self-end">
            <button type="submit" class=" bg-red-600 rounded px-4 py-2 font-semibold text-white">Lihat Semuanya</button>
        </div>
    </div>
    <div class="grid lg:grid-cols-3 grid-cols-1 justify-between mt-10 lg:space-y-0 space-y-6 gap-10">
        @foreach($moreArticlesData as $moreArticleData)
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-1 lg:grid-rows-2 bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 transform hover:-translate-y-1 transition duration-300 hover:shadow-xl">
                <a class="hidden sm:block bg-cover h-72" href="{{ route('article.userShow', $moreArticleData['id']) }}">
                    <img class="rounded-s-lg lg:rounded-none lg:rounded-t-lg h-full object-cover w-full" src="{{ $moreArticleData['image'] }}" alt="" />
                </a>

                <div class="p-4 text-left">
                    <div class="">
                        <a href="{{ route('article.userShow', $moreArticleData['id']) }}">
                            <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">{{ $moreArticleData['title'] }}</h5>
                        </a>
                        <p class="mb-3 font-normal text-gray-700 dark:text-gray-400 break-words">{{ $moreArticleData['paragraph'] }}</p>
                    </div>
                    <div class="flex space-x-4 items-center mt-10">
                        <img class="rounded-full" src="{{ asset('assets/images/profile.svg') }}" alt="">
                        <div>
                            <p class="text-xs md:text-sm font-semibold">{{ $moreArticleData['created_by'] }}</p>
                            <p class="text-xs md:text-sm">{{ $moreArticleData['created_at'] }}</p>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
