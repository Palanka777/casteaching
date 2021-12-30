<template>
    <a :href="'/manage/videos/' + video.id" class="text-indigo-600 hover:text-indigo-900">Edit</a>
</template>

<script>
export default {
    name: "VideoEditLink",
    props: {
        video: {
            type: Object,
            required: false
        }
    }
}
</script>

<style scoped>

</style>
