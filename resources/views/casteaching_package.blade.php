<x-casteaching-layout>
    <button id="getVideos" type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition">
        Get Button
    </button>
    <script>

        document.getElementById('getVideos').addEventListener('click',async function (){
            try {
                const videos = await window.casteaching.videos()
                console.log(videos)
            }catch (error){
                console.log('ERROR:');
                console.log(error);
            }
        })
    </script>
</x-casteaching-layout>
