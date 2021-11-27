<x-casteaching-layout>
    <div class="flex flex-col items-center">

    <iframe
        class="md:p-4 lg:p-5 xl:px10 xl:py5 2xl:px-20 2xl:py-10 h-4/5 w-full"
        style="height: 75vh;"
        src="https://www.youtube.com/embed/btGr3mPK1dU?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv"
        title="YouTube video player" frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
        allowfullscreen>

    </iframe>
        <div class="inline-block max-w-2xl p-4 bg-white rounded-lg shadow-lg px-4 py-4 md:px-6 xl:px-15 xl:py-5 2xl:px-20 2xl-py-10 m-4git">
            <h2 class="text-gray-900 uppercase font-bold text-2xl tracking-tight ">
                {{ $video->title }}
            </h2>
        </div>
<!-- el prose no funciona be amb els diferents tamanys -->
        <div class="prose prose-sm md:prose lg:prose-xl 2xl:prose-2xl mx:auto px-4 py-4 md:px-6 xl:px-15 xl:py-5 2xl:px-20 2xl-py-10">
            {!! Str::markdown($video->description) !!}
        </div>
    </div>

</x-casteaching-layout>
