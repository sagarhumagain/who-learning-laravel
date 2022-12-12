<template>
    <section class="content">
        <div class="container-fluid mb-5">
            <h2 class="text-center ">Search Courses</h2>
                <div class="row">
                    <div class="col-md-8 offset-md-2">
                        <div class="input-group">
                            <input type="search" @input="searchContent"  v-model="search" class="form-control form-control-lg" placeholder="Type your keywords here">
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
        }
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
