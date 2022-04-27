<template>
    <div class="modal fade" id="addNewContent" tabindex="-1" role="dialog" aria-labelledby="addNewContentLabel" aria-hidden="true">
        <div :class="modal_data.modal_size" class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewContentLabel">Add New </h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewContentLabel">Update </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form  @submit.prevent="editmode ? updateInfo() : createInfo()">
                    <slot></slot>
                
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger" data-dismiss="modal"><i class="fas fa-times fa-fw"></i>Close</button>
                        <button v-show="editmode" :disabled="disabled" type="submit" class="btn btn-success"><i class="fas fa-plus fa-fw"></i>Update</button>
                        <button v-show="!editmode" :disabled="disabled" type="submit" class="btn btn-primary"><i class="fas fa-plus fa-fw"></i>Create</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</template>
<script>

import { useToast } from "vue-toastification";

const toast = useToast();
export default {

    props: {
    modal_data: {
      type: Object,
      default: () => {

      }
    },
    form: {
      type: Object,
      default: () => {
      }
    },
    api_url: {
      type: String,
      default: ''
    }
    },
    data(){
        return{
            disabled:false,
            editmode:false,
        }
    },
    methods:{

        createInfo(){
            this.$Progress.start();
            this.disabled=true,
            this.form.post('/api/'+this.api_url).then((res)=>{
            toast.success(
                        res.data.message,
                    )
            this.disabled=false;
            $('#addNewContent').modal('hide');
            this.emitter.emit('AfterCreate'); //Fire an reload event
            this.form.reset();
            this.$Progress.finish();
            })
            .catch((res)=>{
                toast.error(
                        'Something Went Wrong.'
                    )

                this.$Progress.fail(); 
                this.disabled=false
            })
        },
        updateInfo(){
            this.$Progress.start();
            this.disabled=true,
            this.form.put('/api/'+this.api_url+'/'+this.form.id).then((res)=>{
                toast.success(
                        res.data.message
                    )
            
            this.disabled=false;
            $('#addNewContent').modal('hide');
            this.emitter.emit('AfterCreate'); //Fire an reload event
            this.form.reset();
            this.$Progress.finish();
            })
            .catch((res)=>{
               toast.error('Something Went Wrong.')
                this.$Progress.fail(); 
                this.disabled=false
            })
        },
    },
    created(){
        this.emitter.on('editing',(item)=>{ 
            this.form.reset();
            $('#addNewContent').modal('show');
            this.form.fill(item);
        })
       
    }
    
}
</script>