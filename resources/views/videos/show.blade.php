<x-casteaching-layout>
    <div class="flex flex-col h-screen">

        <iframe
            class="md:p-6 h-4/5"
            src="https://www.youtube.com/embed/btGr3mPK1dU?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv"
            title="YouTube video player" frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>

        </iframe>

        <div class="md:p-6">
            <h2>{{ $video->title }}</h2>
        </div>

        <div class="md:p-6">
            {{ $video->description }}
        </div>
    </div>

</x-casteaching-layout>
