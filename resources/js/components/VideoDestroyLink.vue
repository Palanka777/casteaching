<template>
    <div>
        <a class="text-indigo-600 hover:text-red-600 cursor-pointer"
           @click="remove()" >Delete</a>

    </div>
</template>

<script>
export default {
    name: "VideoShowLink",
    props: {
        video: {
            type: Object,
            required: true
        },
    },
    methods:{
        async remove(){
            try{
                await window.casteaching.video.destroy(this.video.id)
            }catch{

            }
        }
    }
}

</script>

<style scoped>

</style>
