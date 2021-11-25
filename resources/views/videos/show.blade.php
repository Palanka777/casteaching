<x-casteaching-layout>
    <div class="flex flex-col space-x4 space-y-4 lg:space-x-6 lg:space-y-4 xl:space-x-15 xl:space-y-5 2xl:space-x-20 2xl:space-y-10 items-center">

    <iframe
        class="md:p-3 lg:p-5 xl:px10 xl:py5 2xl:px-20 2xl:py-10 h-4/5 w-full"
        style="height: 75vh;"
        src="https://www.youtube.com/embed/btGr3mPK1dU?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>

    </iframe>

        <h2 class="text-gray-900 uppercase font-bold text-2xl tracking-tight">
            {{ $video->title }}
        </h2>

<!-- el prose no funciona be amb els diferents tamanys -->
        <div class="prose prose-sm md:prose lg:prose-xl 2xl:prose-2xl">
            {!! Str::markdown($video->description) !!}
        </div>
    </div>

</x-casteaching-layout>
