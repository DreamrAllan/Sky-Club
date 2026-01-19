<div x-data="{
    activeSlide: 0,
    slides: [
        { image: '{{ Storage::url('images/slider/album_1.png') }}', title: 'Rumput Standar FIFA', text: 'Di SKY CLUB, kami menggunakan rumput sintetis berstandar FIFA yang dirancang khusus untuk mini soccer. Dengan rumput berkualitas ini, kami memastikan pengalaman bermain Anda lebih nyaman, aman, dan optimal.' },
        { image: '{{ Storage::url('images/slider/album_2.png') }}', title: 'Fasilitas Lengkap', text: 'Di SKY CLUB, kami menyediakan fasilitas lengkap untuk mendukung kenyamanan Anda, termasuk ruang ganti modern dengan shower dan loker pribadi. Dengan fasilitas ini, Anda dapat bersiap dan bersantai dengan mudah sebelum dan sesudah bermain.' },
        { image: '{{ Storage::url('images/slider/album_3.png') }}', title: 'Parkir Luas', text: 'SKY CLUB memiliki area parkir yang luas, kami memastikan kenyamanan dan kemudahan bagi setiap pengunjung. Anda tidak perlu khawatir mencari tempat parkir, karena area kami dirancang untuk menampung kendaraan dalam jumlah besar dengan akses yang mudah dan aman.' }
    ],
    nextSlide() {
        this.activeSlide = (this.activeSlide + 1) % this.slides.length;
    },
    prevSlide() {
        this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
    }
}"
x-init="setInterval(() => nextSlide(), 7000)" class="mt-16 space-y-5">

    <!-- Heading and Subheading -->
    <h1 class="md:text-5xl text-4xl font-bold mx-4 md:mx-0 md:w-1/2 md:text-left text-center">Keuntungan menyewa lapangan Mini Soccer di Sky Club</h1>
    <h6 class="text-base md:text-left text-center">Rasakan fasilitas terlengkap di sekitaran Bogor</h6>

    <!-- Content Section -->
    <div class="flex flex-col-reverse md:flex-row gap-20 md:items-stretch mx-10 md:mx-0">
        <!-- Buttons Section -->
        <div class="hidden md:grid grid-row-3 content-around w-full">
            <template x-for="(slide, index) in slides" :key="index">
                <div @click="activeSlide = index" class="cursor-pointer pl-8"
                        :class="{'border-l-2 border-red-600': activeSlide === index}">
                    <h1 class="text-2xl font-bold mb-4" x-text="slide.title"></h1>
                    <p class="text-base" x-text="slide.text"></p>
                </div>
            </template>
        </div>

        <!-- Image Display Section -->
        <div class="relative bg-cover rounded-xl overflow-hidden w-full md:h-[650px] h-80 items-stretch">
            <template x-for="(slide, index) in slides" :key="index">
                <div x-show="activeSlide === index" class="absolute inset-0 w-full h-full flex items-center justify-center">
                    <img :src="slide.image"
                         x-transition:enter="transition-opacity duration-1000 ease-in-out"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-transition:leave="transition-opacity duration-1000 ease-in-out"
                         x-transition:leave-start="opacity-100"
                         x-transition:leave-end="opacity-0"
                         class="absolute inset-0 w-full h-full object-cover" alt="carousel-image">
                    <div class="md:hidden absolute bottom-0 left-0 right-0 p-4 bg-black bg-opacity-50 text-center text-white">
                        <h1 class="text-2xl font-bold mb-4" x-text="slide.title"></h1>
                        <p class="text-base" x-text="slide.text"></p>
                    </div>
                </div>
            </template>
            <button @click="prevSlide"
                class="md:hidden absolute left-1 top-1/2 transform -translate-y-1/2 size-14 flex items-center justify-center z-10">
                <svg class="w-6 h-6 text-gray-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"/>
                </svg>
            </button>
            <button @click="nextSlide"
                class="md:hidden absolute right-1 top-1/2 transform -translate-y-1/2 size-14 flex items-center justify-center z-10">
                <svg class="w-6 h-6 text-gray-300 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"/>
                </svg>
            </button>
        </div>
    </div>
</div>
