<template>
    <div class="container">
        <div class="row pt-5" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Course Management</h3>

                        <div class="card-tools">
                            <button type="" class="btn btn-primary" @click="newModal"><i class="fa fa-user-plus fa-fw"></i> Add New User</button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                            <tr class="bg-light">
                                <th>S.N.</th>
                                <th style="width:25%">Course Name</th>
                                <th>Credit Hours</th>
                                <th>Due Date</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(user, index) in courses.data" :key="user.id">
                                <td>{{index + 1}}</td>
                                <td>{{user.name}}
                                </td>
                                <td>{{user.credit_hours}}</td>
                                <td>{{user.due_date}}</td>
                                <td>{{user.description}}</td>

                                <td>
                                    <a href="#" @click="editModal(user)" class="btn btn-sm btn-success mr-2">Edit
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    
                                    <a href="#" @click="deleteUser(user.id)" class="btn btn-sm btn-danger mr-2">Delete
                                        <i class="fa fa-trash"></i>
                                    </a>
                                   
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    
                </div>
                <!-- /.card -->
            </div>
        </div>

      
    </div>
</template>
<script>
    import Multiselect from 'vue-multiselect'
    import Form from 'vform'
    import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'
    import Modal from '@/components/Modal';
    export default {
        components: {
            Multiselect,
            HasError,
            Modal
        },
        /*Filling the data into form*/
        data() {

            return {
                editmode: false,
                courses: {},
                
                form: new Form({
                    id: null,
                    name: null,
                    due_date: null,
                    description: null,
                    credit_hours: null,
                    url:null,
                }),
                
                api_url:null,
                
            }
        },
        methods: {

            /*===== Call add new user modal ====*/
            newModal() {
                this.editmode = false;
                this.form.reset();
                $('#addNewUser').modal('show');
            },
            /*Create User Function Starts*/
            createUser() {
                this.$Progress.start(); //start a progress bar
                this.form.post('/api/v1/courses') // POST form data
                    //Start Condition to check form is validate
                    .then(() => {
                        this.emitter.emit('AfterCreate'); //custom event to reload data
                        $("#addNewUser").modal('hide'); //Hide the model
                        //Sweetalert notification for the result
                        this.$swal({
                            type: 'success',
                            title: 'User Created Successfully',
                            icon: 'success',
                        })

                        this.$Progress.finish(); //End the progress bar
                    })
                    //if form is not valid of handle any errors
                    .catch(() => {
                        this.$swal(
                            'Error!',
                            'Something Went Wrong.',
                            'warning'
                        )

                        this.$Progress.fail(); //End the progress bar
                    })
            },

            /*==== End of User Create ====*/

            /*==== Call edit Modal with user data ====*/
            editModal(user) {
                this.editmode = true;
                this.form.reset();
                $('#addNewUser').modal('show');
                this.form.fill(user);
            },
            /*Edit User Function*/
            updateUser(id) {
                this.$Progress.start();
                this.form.put('/api/v1/courses/' + this.form.id)
                    .then(() => {
                        $("#addNewUser").modal('hide'); //Hide the model
                        this.$swal(
                            'Updated!',
                            'User info. has been updated.',
                            'success'
                        )
                        this.$Progress.finish();
                        this.emitter.emit('AfterCreate'); //Fire an reload event

                    }).catch(() => {
                    this.$swal(
                        'Error!',
                        'Something Went Wrong.',
                        'warning'
                    )
                    this.$Progress.fail();
                });
            },
            /*==== End of edit user function ====*/
            /*==== Call Delete Modal uith user id ====*/
            deleteUser(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

                    //send an ajax request to the server
                    if (result.value) {
                        this.form.delete('/api/v1/courses' + id).then(() => {
                            this.$swal(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                            this.emitter.emit('AfterCreate'); //Fire an reload event
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
            
            /*==== Start of Show existing User function ====*/
            async loadUsers() {
                const {data}  = await  axios.get("/api/v1/courses")
                this.courses = data.data,
                
                this.api_url = 'api/courses'
                /*==== End of existing User ====*/
            },
        },
        created() {
            this.loadUsers(); //load the user in the table
            //Load the userlist if add or created a new user
            this.emitter.on("AfterCreate", () => {
                this.loadUsers();
            })
            
        }
    
    }
</script>

<style scoped>
.is-equal{

box-shadow: 0 0 0 0.2rem rgb(73 231 25 / 25%) !important;
}
</style>


