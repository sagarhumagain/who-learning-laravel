<template>
    <div class="container">
        <div class="row pt-5" >
            <div class="col-md-12">
                <div class="card rounded-0">
                    <div class="card-header d-flex justify-content-between p-2">
                        <h3>{{component_name}} Management</h3>

                        <div class="card-tools">
                            <button type="" class="btn btn-primary" @click="newModal"><i class="fa fa-user-plus fa-fw"></i> Add New {{component_name}}</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover m-0">
                            <tbody>
                            <tr class="bg-light">
                                <th>S.N.</th>
                                <th style="width:25%">Name</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(designation, index) in records.data" :key="designation.id">
                                <td>{{index + 1}}</td>
                                <td>{{designation.name}}</td>
                                <td> {{designation.description}} </td>
                                <td>
                                    <a href="#" @click="editModal(designation)" class=" text-success mr-2">
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" @click="deleteContent(designation.id)" class=" text-danger mr-2">
                                        <i class="fa fa-trash"></i>
                                    </a>

                                </td>


                            </tr>
                            </tbody></table>
                    </div>
                    <!-- /.card-body -->
                    <div class="card-footer">
                        <pagination-wrapper class="mt-3" :data="this.records" :has_param="false" :api_url="api_url" :pagination_title="component_name"></pagination-wrapper>
                    </div>
                </div>
                <!-- /.card -->
            </div>
        </div>


        <!-- contact Modal -->
         <modal :form="form" :modal_data="modal_data" :editmode="editmode" :api_url="'v1/designation'">
                    <div class="form-group row">
                        <label class="col-md-12  col-form-label">Name <span class="text-danger">*</span></label>
                        <div class="col-md-12">
                            <input type="text" class="form-control" v-model="form.name" id="designation" placeholder="Enter Name" autocomplete="off" required>
                        </div>
                        <has-error :form="form" field="name"></has-error>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-12 col-form-label">Designation Description</label>
                        <div class="col-md-12">
                            <textarea class="form-control" v-model="form.description"  placeholder="Enter Designation Description"></textarea>
                        </div>
                        <has-error :form="form" field="description"></has-error>
                    </div>
        </modal>

    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import Form from 'vform'
    import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'
    import PaginationWrapper from '../Pagination/PaginationWrapper.vue';
    import Modal from '../Modal.vue';


    export default {
        components: {
            Multiselect,
            HasError,
            PaginationWrapper,
            Modal,

        },
        /*Filling the data into form*/
        data() {

            return {
                groups: this.$store.state.groups,
                component_name : 'Designation',
                editmode: false,
                disabled: false,
                records:{},
                modal_data:{
                    modal_size:'',
                    modal_name:'addNewDesignation'
                },
                form: new Form({
                    id: null,
                    name: null,
                    description: null,

                }),
                api_url : 'api/v1/designation',

            }
        },
        methods: {
            /*===== Call add new user modal ====*/
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#'+this.modal_data.modal_name).modal('show');
            },

            editModal(val){
                this.editmode = true;
                $('#'+this.modal_data.modal_name).modal('show');
                this.emitter.emit('editing', val);
            },
            deleteContent(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    //send an ajax request to the server
                    if (result.value) {
                        this.$Progress.start();
                        this.disabled=true,

                        this.form.delete('/'+this.api_url+'/' + id).then((response) => {

                        if(response.data.error == 'true'){
                                this.$swal({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    icon: 'warning',
                                    title: response.data.message,
                                })
                                this.$Progress.fail();
                                this.disabled=false;
                            }
                            else{
                                $('#'+this.modal_data.modal_name).modal('hide'); //Hide the model
                                this.$swal({
                                    toast: true,
                                    position: 'top-end',
                                    showConfirmButton: false,
                                    timer: 3000,
                                    icon: 'success',
                                    title: response.data.message,
                                })
                                this.disabled=false
                                this.emitter.emit('AfterCreate'); //Fire an reload event
                                this.$Progress.finish();
                            }


                        }).catch(() => {
                            this.$swal(
                                'Warning!',
                                'Unauthorized Access to delete.',
                                'warning'
                            )
                        })
                    }

                })
            },
            async loadData() {
                const {data}  = await  axios.get("/"+this.api_url);
                this.records = data
            },
        },
        created() {
            this.loadData(); //load the user in the table
            //Load the userlist if add or created a new user
            this.emitter.on("AfterCreate", () => {
                this.loadData();
            })
            //emit event on pagination
            this.emitter.on('paginating',(item)=>{
                this.records = item
            })
        }
    }
</script>



