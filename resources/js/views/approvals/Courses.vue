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
                                <th>Created By</th>
                                <th>Credit Hours</th>
                                <th>Due Date</th>
                                <th>Description</th>
                                <th>Course Category</th>
                                <th>Status</th>
                                <th>Remarks</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(course, index) in courses.data" :key="course.id">
                                <td>{{index + 1}}</td>
                                <td>{{course.name}}</td>
                                <td>
                                    <span v-if="course.course_assignment == null">Course Admin</span>
                                    <span v-else>{{course.course_assignment.created_by.name}}</span>
                                </td>
                                <td>{{course.credit_hours}}</td>
                                <td>{{course.due_date}}</td>
                                <td>{{course.description}}</td>
                                <td>
                                    <p v-for="(cat,index) in course.course_categories" :key="cat.id" >{{index+1+') '}}{{cat.name}}</p>
                                </td>
                                <td>
                                    <span v-if="course.is_approved == null" class="color-yellow">Approval Pending</span>
                                    <span v-else-if="course.is_approved == 1" class="color-green">Approved</span>
                                    <span v-else-if="course.is_approved == 0" class="color-red">Disapproved</span>
                                    <span v-else-if="course.is_approved == 2" class="color-red">Reverification</span>
                                </td>
                                <td>{{course.remarks}}</td>
                                <td class="w-15" >
                                    <!-- <a href="#" @click="editCourse(course,course.id)" class="btn btn-sm btn-success mr-2">Edit
                                        <i class="fa fa-edit"></i>
                                    </a> -->
                                    <router-link class="project-link m-2 color-sec-blue" :to="{ name: 'courses-edit', params: { id: course.id} }">
                                        <i class="fa fa-edit"  title="Edit Course"></i>
                                    </router-link>

                                    <a href="#" v-role:any="'super-admin|course-admin|supervisor'" class="m-2 color-red" @click="deleteCourse(course.id)" >
                                        <i class="fa fa-trash"  title="Delete Course"></i>
                                    </a>
                                    <a href="#" v-role:any="'super-admin|course-admin|supervisor'" class="m-2 color-green" @click="approveCourse(course,true)" >
                                        <i class="fa fa-check" title="Approve Course"></i>
                                    </a>
                                    <a href="#" v-role:any="'super-admin|course-admin|supervisor'" class="m-2 color-red" @click="approveCourse(course,false)" >
                                        <i class="fa fa-times" title="Disapprove Course"></i>
                                    </a>

                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <div class="card-footer">
                        <pagination-wrapper class="mt-3" :data="this.courses" :has_param="false" :api_url="api_url" pagination_title="Courses"></pagination-wrapper>
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
    import PaginationWrapper from '@/components/Pagination/PaginationWrapper.vue';

    export default {
        name:'courses-list',
        components: {
            Multiselect,
            HasError,
            Modal,
            PaginationWrapper,
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
                    is_approved:null,
                    remarks:null,
                }),
                api_url: '/api/v1/approve/courses',

            }
        },
        methods: {
            newCourse(){
                this.$router.push({name:'course-create'})
            },
            async approveCourse(course,val){
                this.$Progress.start();
                const status = !val ? 'disapprove' : 'approve';
                this.form.fill(course)

                const result = status == 'disapprove' ? await this.$swal({
                    title: 'Please write remarks',
                    input: 'text',
                    inputPlaceholder: 'Remarks',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "You want to " + status +  " this course?",
                    inputValidator: (value) => {
                        if (!value) {
                        return 'You need to write something!'
                        }
                    }
                }) :  await  this.$swal({
                    title: 'Are you sure?',
                    text: "You want to " + status +  " this course?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, ' + status +  ' it!'
                })

                if (result.value) {
                    try{

                        this.form.is_approved = val;
                        this.form.remarks = result.value;
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
                            this.errors = response.data.errors || {};
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
                        this.form.delete('/api/v1/courses/' + id).then(() => {
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
                const {data}  = await  axios.get(this.api_url)
                this.courses = data
                /*==== End of existing Course ====*/
            },
        },
        created() {
            this.loadCourses(); //load the course in the table
            //Load the courselist if add or created a new course
            this.emitter.on("AfterCreate", () => {
                this.loadCourses();
            })
            this.emitter.on('paginating',(item)=>{
                this.courses = item
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


