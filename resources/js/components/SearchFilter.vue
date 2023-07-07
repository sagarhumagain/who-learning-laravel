<template>
    <section class="content">
        <div class="container-fluid mb-5">
            <h2 class="text-center ">Search {{title}}</h2>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="input-group">
                            <input type="search" @input="searchContent"  v-model="search" class="form-control form-control-lg" :placeholder="placeholder">
                        </div>
                </div>
            </div>
        </div>
    </section>
</template>
<script>

export default {
    props:{
        api_url:{
            type:String,
            required:true
        },
        placeholder:{
            type:String,
            required:true,
            default : 'Type course name, source, url, or course category name'
        },
        title:{
            type:String,
            required:true,
            default : 'Course'
        },
    },
    data(){
        return{
            search:'',

        }
    },
    methods:{
            async searchContent() {
                this.$Progress.start();
                const {data}  = await  axios.get(this.api_url + '?search=' + this.search)
                this.emitter.emit('AfterSearch',data)
                this.$Progress.finish();
            },


    }

}
</script>
