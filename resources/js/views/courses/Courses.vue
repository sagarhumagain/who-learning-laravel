<template>
    <div class="container">
        <div class="row" >
            <search-filter :api_url='this.api_url' />

            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Courses</h3>
                        <div class="d-flex justify-contents-between">

                            <div class="card-tools">
                                <button type="" class="btn btn-fill" @click="newCourse"><i class="fa fa-book fa-fw"></i> Add New Course</button>
                            </div>
                            <!-- <div class="card-tools" v-role:any="'super-admin|course-admin'" >
                                <button type="" class="btn btn-fill" @click="assignCourseToNewUsers"><i class="fa fa-book
                                 fa-fw"></i> Assign Courses to New Users</button>
                            </div> -->
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
                                <th v-role:any="'super-admin|course-admin'">Status</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(course, index) in courses.data" :key="course.id">
                                <td>{{index + 1}}</td>
                                <td>{{course.name}}</td>
                                <td>{{course.credit_hours}}</td>
                                <td>{{course.due_date}}</td>
                                <td>{{course.description}}</td>
                                <td>
                                    <p v-for="(cat,index) in course.course_categories" :key="cat.id" >{{index+1+') '}}{{cat.name}}</p>
                                </td>
                                <td v-role:any="'super-admin|course-admin'">
                                    <span v-if="course.is_approved == null" class="color-yellow">Approval Pending</span>
                                    <span v-else-if="course.is_approved == 1" class="color-green">Approved</span>
                                    <span v-else-if="course.is_approved == 0" class="color-red">Disapproved</span>
                                </td>
                                <td class="w-15">
                                    <!-- <a href="#" @click="editCourse(course,course.id)" class="btn btn-sm btn-success mr-2">Edit
                                        <i class="fa fa-edit"></i>
                                    </a> -->
                                    <div v-role:any="'normal-user|supervisor'">
                                       <a href="#" class="m-2 color-primary" @click="enrollCourse(course.id)" >
                                        <i class="fa fa-circle-arrow-right"  title="Enroll Course"></i>
                                      </a>
                                    </div>
                                    <div v-role:any="'super-admin|course-admin'">
                                        <router-link class="project-link m-2 color-sec-blue" :to="{ name: 'courses-edit', params: { course: course , id: course.id} }">
                                          <i class="fa fa-edit"  title="Edit Course"></i>
                                        </router-link>

                                        <a href="#" class="m-2 color-red" @click="deleteCourse(course.id)" >
                                            <i class="fa fa-trash"  title="Delete Course"></i>
                                        </a>
                                        <a href="#" class="m-2 color-green" @click="approveCourse(course,true)" >
                                            <i class="fa fa-check" title="Approve Course"></i>
                                        </a>
                                        <a href="#" class="m-2 color-red" @click="approveCourse(course,false)" >
                                            <i class="fa fa-times" title="Disapprove Course"></i>
                                        </a>
                                    </div>


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
    import SearchFilter from '@/components/SearchFilter';
    import PaginationWrapper from '@/components/Pagination/PaginationWrapper.vue';

    export default {
        name:'courses-list',
        components: {
            Multiselect,
            HasError,
            Modal,
            SearchFilter,
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
                    is_approved:null
                }),

                api_url: '/api/v1/courses',
                search: '',

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
            enrollCourse(id) {
                this.$swal({
                    title: 'Are you sure to enroll to this course?',
                    text: "",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, enroll!'
                }).then(async (result) => {
                    if (result.value) {
                        try {
                          let response = await this.$api.courses.enrollToCourse({course_id: id});
                          this.$swal(
                                'Enrolled!',
                                'You have successfully enrolled to the course.',
                                'success'
                            );
                            this.emitter.emit('AfterCreate')
                        } catch(e) {
                          this.$swal(
                              'Warning!',
                              'Could not enroll to course.',
                              'warning'
                          )
                        }
                    }

                })
            },
            // async assignCourseToNewUsers(){

            //     const result  = await  this.$swal({
            //         title: 'Are you sure?',
            //         text: "You want to perform this task?",
            //         icon: 'warning',
            //         showCancelButton: true,
            //         confirmButtonText: 'Yes'
            //     })
            //     if (result.value) {
            //     try{
            //         const response = await this.$api.courses.assignCourseToNewUsers();
            //         if(response.data.error == true){
            //             this.$swal({
            //                 toast: true,
            //                 position: 'top-end',
            //                 showConfirmButton: false,
            //                 timer: 3000,
            //                 icon: 'warning',
            //                 title: response.data.message,
            //             })
            //             this.$Progress.fail();
            //             this.disabled=false;
            //         }
            //         else{
            //             this.$swal({
            //                 toast: true,
            //                 position: 'top-end',
            //                 showConfirmButton: false,
            //                 timer: 3000,
            //                 icon: 'success',
            //                 title: response.data.message,
            //             })
            //             this.disabled=false
            //             this.$Progress.finish();

            //         }
            //     }
            //     catch(e){
            //         this.disabled = false
            //         if(e.response.status == 500) {
            //         this.$swal(
            //             'Error!',
            //             "Something Went Wrong.",
            //             'warning'
            //         );
            //         } else {
            //             this.errors = e.response.data.errors || {};
            //             this.$swal(
            //                 'Error!',
            //                 e.response.data.message,
            //                 'warning'
            //             )
            //         }


            //     }
            //     }

            // },

            /*==== Start of Show existing Course function ====*/
            async loadCourses() {
                const {data}  = await  axios.get(this.api_url)
                this.courses = data
            },
            /*==== End of Show existing Course function ====*/


        },
        created() {

              this.loadCourses(); //load the course in the table
              //Load the courselist if add or created a new course
              this.emitter.on("AfterCreate", () => {
                  this.loadCourses();
              })
              this.emitter.on("AfterSearch", (data) => {
                  this.courses = data
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


