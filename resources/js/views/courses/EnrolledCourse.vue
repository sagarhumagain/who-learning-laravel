<template>
    <div class="container">
        <div class="row pt-5" >
            <search-filter :api_url="this.api_url" />
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Enrolled Courses</h3>

                        <!-- <div class="card-tools">
                            <button type="" class="btn btn-primary" @click="newModal"><i class="fa fa-user-plus fa-fw"></i> Add New Course</button>
                        </div> -->
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
                                <th> URL </th>
                                <th>Remarks</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(course, index) in courses" :key="course.id">
                                <td>{{index + 1}}</td>
                                <td>{{course.name}}
                                </td>
                                <td>{{course.credit_hours}}</td>
                                <td>{{course.due_date}}</td>
                                <td>
                                    <a :href="course.url" target="_blank" v-if="/^http/.test(course.url)">Course URL</a>
                                    <p v-else>Not Available</p>
                                </td>
                                <td>{{course.remarks}}</td>
                                <td>
                                    <p class="color-red" v-if=" course.completed_date == null">Incomplete</p>
                                    <p class="color-yellow" v-else-if="course.is_approved == null && course.completed_date">Approval Pending</p>
                                    <p class="color-green" v-else-if="course.is_approved == '1' && course.completed_date">Approved</p>
                                    <p class="color-red" v-else-if="course.is_approved == '0' && course.completed_date">Disapproved</p>
                                    <p class="color-red" v-else-if="course.is_approved == '2' && course.completed_date">Reverification</p>

                                </td>
                                <td>
                                    <router-link class="project-link mr-3" :to="{ name: 'courses-edit', params: { id: course.course_id} }">
                                        <i class="fa fa-edit"></i>
                                    </router-link>
                                    <a href="#" class="m-2 color-red" v-if="course.is_approved != 1" @click="withdrawCourse(course.id)" >
                                        <i class="fa fa-times" title="Withdraw Course"></i>
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
    import ErrorMsg from '@/components/error-msg';
    import SearchFilter from '@/components/SearchFilter';

    export default {
        name:'assigned-course',
        components: {
            Multiselect,
            HasError,
            Modal,
            ErrorMsg,
            SearchFilter
        },
        /*Filling the data into form*/
        data() {
            return {
                editmode: false,
                disabled: false,
                courses: {},
                errors:{},
                form: new Form({
                    id: null,
                    course_id: null,
                    completed_date: null,
                    is_approved: null,
                    certificate_path: null,
                    due_date: null,
                }),
                api_url: '/api/v1/course_user',
            }
        },
        methods: {
             onFileChange(e){
                this.form.certificate_path = e.target.files[0];
            },
            editCourseModal(course){
                this.form.reset();
                this.editmode = true;
                $('#addNewCourse').modal('show');
                this.form.fill(course);
            },
            async withdrawCourse(id){
                this.$Progress.start();

                const result  = await  this.$swal({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, withdraw it!'
                })
                if (result.value) {
                    try{
                        const response  =  await axios.post('/api/v1/withdraw-course/'+id)
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
                            this.$swal(
                                'Error!',
                                response.data.message,
                                'warning'
                            )
                        }
                    }
                    this.$Progress.finish();
                }
            },
            updateInfo() {
                this.$Progress.start();
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
                let formData = new FormData();
                formData.append('certificate_path', this.form.certificate_path);
                formData.append('completed_date', this.form.completed_date);
                formData.append('course_id', this.form.course_id);
                formData.append("_method", "PUT")
                axios.post('/api/v1/update-assigned-course', formData, config)
                    .then((response) => {
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
                            $('#addNewCourse').modal('hide');
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
                    }).catch(({response}) => {
                            this.errors = response.data.errors || {};
                            this.$swal(
                                'Error!',
                                "Something Went Wrong.",
                                'warning'
                            )
                            this.disabled=false;
                            this.$Progress.fail();
                    })

            },
            /*==== Start of Show existing User function ====*/
            async loadCourse() {
                const {data}  = await this.$api.courses.listUserEnrolledCourses();
                this.courses = data;
            },
        },
        created() {
            this.loadCourse(); //load the user in the table
            //Load the userlist if add or created a new user
            this.emitter.on("AfterCreate", () => {
                this.loadCourse();
            })
            this.emitter.on("AfterSearch", (data) => {
                  this.courses = data
              })


        }

    }
</script>

<style scoped>
.is-equal{

box-shadow: 0 0 0 0.2rem rgb(73 231 25 / 25%) !important;
}
.invalid-feedback{
    display: block;
    }
</style>


