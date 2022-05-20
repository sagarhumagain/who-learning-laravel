<template>
    <div class="container">
        <div class="row pt-5" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Course Management</h3>

                        <div class="card-tools">
                            <button type="" class="btn btn-primary" @click="newCourse"><i class="fa fa-book fa-fw"></i> Add New Course</button>
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
                            <tr v-for="(course, index) in courses.data" :key="course.id">
                                <td>{{index + 1}}</td>
                                <td>{{course.name}}
                                </td>
                                <td>{{course.credit_hours}}</td>
                                <td>{{course.due_date}}</td>
                                <td>{{course.description}}</td>

                                <td>
                                    <!-- <a href="#" @click="editCourse(course,course.id)" class="btn btn-sm btn-success mr-2">Edit
                                        <i class="fa fa-edit"></i>
                                    </a> -->
                                    <router-link class="project-link mr-3" :to="{ name: 'courses-edit', params: { course: course , id: course.id} }">
                                        <i class="fa fa-edit"></i>
                                    </router-link>
                                    
                                    
                                    <a href="#" @click="deleteUser(course.id)" >
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
        name:'courses-list',
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
            newCourse(){
                this.$router.push({name:'course-create'})

            },
            deleteUser(id) {
                this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {

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
.mr-3{
    margin-right:15px;
}
</style>


