<x-casteaching-layout>
    <div class="flex flex-col h-screen">

        <iframe
            class="md:p-3 lg:p-5 xl:px10 xl:py5 2xl:px-20 2xl:py-10 h-4/5"
            src="https://www.youtube.com/embed/btGr3mPK1dU?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>

        </iframe>

        <div class="p-4 lg:p-5 xl:p-10 2xl:p-20">
            {{ $video->title }}
        </div>

        <div class="p-4 lg:p-5 xl:p-10 2xl:p-20">
            {{ $video->description }}
        </div>
    </div>

</x-casteaching-layout>
