<template>
    <div class="container">
        <div class="row pt-5" >
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Course Management</h3>

                        <div class="card-tools">
                            <button type="" class="btn btn-fill" @click="newCourse"><i class="fa fa-book fa-fw"></i> Add New Course</button>
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
                                <th>Course Category</th>
                                <th>Status</th>
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
                                    <p v-for="(cat,index) in course.course_categories" :key="cat.id" >{{index+1+'). '}}{{cat.name}}</p> 
                                </td>
                                <td> 
                                    <span v-if="course.is_approved == 1" class="text-success">Approved</span>
                                    <span v-else class="text-warning">Pending</span>
                                </td>
                                <td class="w-15">
                                    <!-- <a href="#" @click="editCourse(course,course.id)" class="btn btn-sm btn-success mr-2">Edit
                                        <i class="fa fa-edit"></i>
                                    </a> -->
                                    <router-link class="project-link mr-3 color-sec-blue" :to="{ name: 'courses-edit', params: { course: course , id: course.id} }">
                                        <i class="fa fa-edit"  title="Edit"></i>
                                    </router-link>
                                  
                                    <a href="#" class="color-red" @click="deleteCourse(course.id)" >
                                        <i class="fa fa-trash"  title="Delete"></i>
                                    </a>
                                    <a href="#" class="mr-3" @click="approveCourse(course,true)" >
                                        <i class="fa fa-check"></i>
                                    </a>
                                    <a href="#" @click="approveCourse(course,false)" >
                                        <i class="fa fa-times"></i>
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
                    is_approved:null
                }),
                
                api_url:null,
                
            }
        },
        methods: {
            newCourse(){
                this.$router.push({name:'course-create'})
            },
            async approveCourse(course,val){
                const status = !val ? 'disapprove' : 'approve';

                const result  = await  this.$swal({
                    title: 'Are you sure?',
                    text: "You want to " + status +  " this course?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, ' + status +  ' it!'
                })
                if (result.value) {
                    try{
                        this.form.fill(course)
                        this.form.is_approved = val;
                        const response  = await this.form.put('/api/v1/courses/'+this.form.id)
                    
                        if(response.data.error == true){
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
                            this.$swal({
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                icon: 'success',
                                title: response.data.message,
                            })
                            this.emitter.emit('AfterCreate')
                            this.disabled=false
                            this.$Progress.finish();

                        }
                    }catch({response}){
                        this.disabled = false
                        if(response.status == 500) {
                        this.$swal(
                            'Error!',
                            "Something Went Wrong.",
                            'warning'
                        );
                        } else {
                            this.errors = response.data.errors;
                            this.$swal(
                                'Error!',
                                response.data.message,
                                'warning'
                            )
                        }
                    }
                    
                }
            

                

            },
            deleteCourse(id) {
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
            

            /*==== Start of Show existing Course function ====*/
            async loadCourses() {
                const {data}  = await  axios.get("/api/v1/courses")
                this.courses = data.data,
                
                this.api_url = 'api/courses'
                /*==== End of existing Course ====*/
            },
        },
        created() {
            this.loadCourses(); //load the course in the table
            //Load the courselist if add or created a new course
            this.emitter.on("AfterCreate", () => {
                this.loadCourses();
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


