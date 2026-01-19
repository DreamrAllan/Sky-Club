@extends('layouts.master')

@section('content')
    <div class="my-10 w-fit">
        <p class="mb-2 font-semibold rounded-full bg-rose-200 text-red-500 w-fit px-3">Article</p>
        <h1 class="font-bold text-4xl xs:text-56 my-6">Kumpulan Artikel</h1>
        <p>Artikel mengenai kegiatan dan event yang berlangsung pada Sky Club</p>
    </div>

    <div class="grid grid-cols-3 gap-4">
        <div x-data="carousel()" x-init="startAutoSlide()" class="relative col-span-3 lg:col-span-2">
            <div class="relative w-full h-[600px] lg:h-full overflow-hidden rounded-2xl">
                <template x-for="(slide, index) in slides" :key="index">
                    <div x-show="currentSlide === index" class="absolute inset-0 transition-all duration-1000 overflow-hidden"
                    x-transition:enter="transition ease-out duration-1000"
                     x-transition:enter-start="opacity-0 transform translate-x-full"
                     x-transition:enter-end="opacity-100 transform translate-x-0"
                     x-transition:leave="transition ease-in duration-1000"
                     x-transition:leave-start="opacity-100 transform translate-x-0"
                     x-transition:leave-end="opacity-0 transform -translate-x-full">
                        <img class="w-full h-full object-cover rounded-2xl" :src="slide.image" alt="">
                        <div class="absolute bottom-0 left-0 right-0 rounded-b-2xl backdrop-blur h-[30%] xxs:h-3/6 md:h-2/6 p-4 place-content-between flex flex-col break-words">
                            <div class="flex justify-between gap-8 md:gap-16 break-words">
                                <div class="space-y-4">
                                    <a :href="`{{ route('article.userShow', '') }}/${slide.id}`" class="text-3xl font-bold text-white break-words" x-text="slide.title"></a>
                                    <p class="xxs:block hidden break-words text-gray-200" x-text="slide.description"></p>
                                </div>
                                <a :href="`{{ route('article.userShow', '') }}/${slide.id}`" class="size-fit cursor-pointer">
                                    <svg class="w-6 h-6 text-white hover:text-gray-300 stroke-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 19.5 15-15m0 0H8.25m11.25 0v11.25" />
                                    </svg>
                                </a>
                            </div>
                            <div class="flex items-center">
                                <div class="space-x-2 mt-3 mr-12 xs:mr-24 items-center flex">
                                    <img class="rounded-full w-10 h-10" :src="slide.profileImage" alt="">
                                    <div>
                                        <p class="font-semibold text-white" x-text="slide.author"></p>
                                        <p class="xs:hidden text-white" x-text="slide.date"></p>
                                    </div>
                                </div>
                                <div class="hidden xs:flex space-x-2 mt-3 items-center ">
                                    <div class="size-10 rounded-full flex justify-center items-center ring-1 ring-gray-200">
                                        <svg class="w-6 h-6 text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 10h16M8 14h8m-4-7V4M7 7V4m10 3V4M5 20h14a1 1 0 0 0 1-1V7a1 1 0 0 0-1-1H5a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1Z"/>
                                        </svg>
                                    </div>
                                    <p class="font-semibold text-white" x-text="slide.date"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
            </div>
        </div>

        <div class="hidden lg:flex flex-col place-content-between">
            <p class=" text-3xl font-semibold">Recent Article</p>
            <div class="flex flex-col items-start">
                @foreach ($latestArticlesData as $latestArticle)
                    <a href="{{ route('article.userShow', $latestArticle['id']) }}" class="grid grid-flow-col py-4 border-b-2 gap-2">
                        <div class="size-20 bg-cover">
                            <img class="w-full h-full object-cover rounded-xl"
                                 src="{{ $latestArticle['image'] }}"
                                 alt="Image of {{ $latestArticle['title'] }}">
                        </div>
                        <div class="flex items-center">
                            <p class="font-semibold">{{ Str::limit($latestArticle['title'], 50) }}</p>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-flow-col mt-16 mb-8">
        <div class="flex items-center border-b-2">
            <p class="font-semibold text-4xl">All Article</p>
        </div>
        <div class=" justify-items-end mt-4">
            <form action="{{ route('article.userIndex') }}" method="GET" class="w-full lg:w-[500px]">
                <label for="default-search" class="mb-2 text-sm font-medium text-gray-900 sr-only dark:text-white">Search</label>
                <div class="relative">
                    <input type="search" name="search" id="default-search" class="block w-full p-4 ps-7 text-sm text-gray-900 border border-gray-300 rounded-full bg-gray-50 focus:ring-red-500 focus:border-red-500 " placeholder="Search articles..." required />
                    <button type="submit" class="text-white absolute end-2.5 bottom-2.5 font-medium rounded-lg text-sm px-4 py-2 bg-gray-50">
                        <svg class="w-4 h-4  text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div class="grid grid-cols-1 xs:grid-cols-2 lg:grid-cols-3 xxl:grid-cols-4 gap-4 mb-8 sm:gap-6 md:gap-10">
        @forelse ($articles as $article)
        <div class="max-w-full bg-white border border-gray-200 rounded-lg shadow dark:bg-gray-800 dark:border-gray-700 hover:shadow-xl transform hover:-translate-y-1 transition duration-300">
            <div class="h-70 bg-cover">
                <a href="{{ route('article.userShow', $article->id) }}">
                    @if ($article->content['image'])
                        <img class="rounded-t-lg object-cover w-full h-full" src="{{ $article->content['image'] }}" alt="" />
                    @else
                        <img class="rounded-t-lg object-cover w-full h-full" src="{{ asset('assets/images/album_1.svg')}}" alt="" />
                    @endif
                </a>
            </div>
            <div class=" p-2 md:p-5">
                <a href="{{ route('article.userShow', $article->id) }}">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"> {{ Str::limit($article['title'], 40) }}</h5>
                </a>
                <p class=" break-words font-normal text-gray-700 dark:text-gray-400">
                    {{ $article->content['paragraph'] }}
                </p>
                <div class="space-x-4 items-center flex mt-5">
                    <img class="rounded-full" src="{{ asset('assets/images/profile.svg') }}" alt="">
                    <div>
                        <p class="text-xs md:text-sm font-semibold">{{ $article->user->name }}</p>
                        <p class="text-xs md:text-sm">{{ $article->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
        @empty
            <div class="col-span-3 text-center text-gray-500 dark:text-gray-400">Tidak ada artikel tersedia</div>
        @endforelse
    </div>
    <!-- Pagination Links -->
    <div class="mb-4">
        {{ $articles->links() }}
    </div>
@endsection

@push('script')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('carousel', () => ({
            currentSlide: 0,
            slides: @json($slides),
            nextSlide() {
                if (this.currentSlide < this.slides.length - 1) {
                    this.currentSlide++;
                } else {
                    this.currentSlide = 0;
                }
            },
            startAutoSlide() {
                setInterval(() => {
                    this.nextSlide();
                }, 12000);
            }
        }))
    })
</script>
@endpush
