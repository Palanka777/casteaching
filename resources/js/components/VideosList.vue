<template>
      <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                <div class="bg-white px-4 py-5 border-b border-gray-200 sm:px-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">
                        Videos
                        <button @click="refresh" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 ml-10">
                            Refresh
                        </button>
                    </h3>
                </div>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Id
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Title
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Description
                        </th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            URL
                        </th>
                        <th scope="col" class="relative px-6 py-3">
                            <span class="sr-only">Actions</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <!-- Odd row -->

                    <tr class="bg-white" v-for="video in videos">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ video.id }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ video.title }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ video.description }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ video.url }}
                        </td>
                        <td class="flex px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <video-show-link class="ml-1" :video="video" ></video-show-link>
                            <video-edit-link class="ml-1" :video="video" ></video-edit-link>
                            <video-destroy-link class="ml-1" :video="video" @removed="refresh()" ></video-destroy-link>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import VideoShowLink from "./VideoShowLink";
import VideoEditLink from "./VideoEditLink";
import VideoDestroyLink from "./VideoDestroyLink";
import eventBus from '../eventBus'



export default {
    name: "VideosList",
    components: {
        'video-show-link' : VideoShowLink,
        'video-edit-link' : VideoEditLink,
        'video-destroy-link' : VideoDestroyLink,
    },
    data() {
        return {
/*        {"id": 1,
            "title": "Ubuntu 101",
            "description": "# Here description",
            "url": "https://www.youtube.com/embed/EjYOBTK8NMQ?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv",
            "published_at": null,
        },
        {"id": 2,
            "title": "Video 1",
            "description": "# Here description",
            "url": "https://www.youtube.com/embed/DzZKgGM7swk?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv",
            "published_at": null,
        },
        {"id": 3,
            "title": "Video 2",
            "description": "# Here description",
            "url": "https://www.youtube.com/embed/zyABmm6Dw64?list=PLyasg1A0hpk07HA0VCApd4AGd3Xm45LQv",
            "published_at": null,
        },*/
            videos: []
        }
    },
    async created(){
        try{
            this.getVideos();
            eventBus.$on('created',() => {
                this.refresh()
            });
            eventBus.$on('updated',() => {
                this.refresh()
            });
        }catch(err){

        }
    },

    methods: {
        async getVideos() {
            this.videos=await window.casteaching.videos()
        },
        async refresh(){
            this.getVideos()
        }
    }

}
</script>

<style scoped>


</style>
