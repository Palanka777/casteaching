<template>
    <div>
        <a class="text-indigo-600 hover:text-red-600 cursor-pointer"
           @click="remove()" >Delete</a>

    </div>
</template>

<script>
import eventBus from "../eventBus";

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
                this.$emit('removed')
                eventBus.$emit('status', 'Video '+ this.video.title+ ' remove successfully')
            }catch(error){
                console.log(error)
            }
        }
    }
}

</script>

<style scoped>

</style>
