<template>
    <div class="container">
        <search-filter :api_url='this.api_url' title="Certificate"  />
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3>Approve Certificates</h3>

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
                                <th>User</th>
                                <th>Completed Date</th>
                                <th>Approval Status</th>
                                <th>Action</th>
                            </tr>
                            <tr v-for="(course, index) in courses.data" :key="course.id">
                                <td>{{index + 1}}</td>
                                <td>{{course.name}}</td>
                                <td>{{course.credit_hours}}</td>
                                <td>{{course.due_date}}</td>
                                <td>{{course.email}}</td>
                                <td>{{course.completed_date}}</td>

                                <td>
                                    <p class="color-red" v-if="course.completed_date == null">Incomplete</p>
                                    <p class="color-yellow" v-else-if="course.is_approved == null && course.completed_date">Approval Pending</p>
                                    <p class="color-green" v-else-if="course.is_approved == '1' && course.completed_date">Approved</p>
                                    <p class="color-red" v-else-if="course.is_approved == '0' && course.completed_date">Disapproved</p>
                                </td>
                                <td>
                                    <a href="#" @click="coureseDetail(course.certificate)">
                                        <i class="fa fa-file mr-2"></i>
                                    </a>
                                    <a href="#"  class="color-green" @click="approveCourse(course,1)">
                                        <i class="fa fa-check mr-2"></i>
                                    </a>
                                    <a href="#" class="color-red"  @click="approveCourse(course,0)">
                                        <i class="fa fa-times mr-2"></i>
                                    </a>

                                    <router-link :to="'/approve/certificate/user_id/'+course.user_id+ '/course_id/'+course.course_id" class="ml-2">
                                        <i class="fa fa-eye "></i>
                                    </router-link>

                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    <div class="card-footer">
                        <pagination-wrapper class="mt-3" :data="this.courses" :has_param="false" :api_url="api_url" pagination_title="Approval List"></pagination-wrapper>
                    </div>

                </div>
                <!-- /.card -->
            </div>
        </div>


    </div>
    <modal-view :modal_data="v_modal_data">
        <div class="card-body table-responsive p-0" style="height: 80vh; width: 100%;">
            <iframe :src="'/'+certificate+'#toolbar=0'" style="width: 100%; height: 100%;" frameborder="0"></iframe>
        </div>
    </modal-view>


</template>
<script>
    import Multiselect from 'vue-multiselect'
    import Form from 'vform'
    import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'
    import Modal from '@/components/Modal';
    import ErrorMsg from '@/components/error-msg';
    import ModalView from '@/components/ModalView';
    import PaginationWrapper from '@/components/Pagination/PaginationWrapper.vue';
    import SearchFilter from '@/components/SearchFilter.vue';


    export default {
        name:'approve-certificates',
        components: {
            Multiselect,
            HasError,
            Modal,
            ErrorMsg,
            ModalView,
            PaginationWrapper,
            SearchFilter
        },
        /*Filling the data into form*/
        data() {
            return {
                editmode: false,
                disabled: false,
                courses: {},
                errors:{},
                certificate:null,
                form: new Form({
                    id: null,
                    course_id: null,
                    user_id:null,
                    completed_date: null,
                    is_approved: null,
                    certificate_path: null,
                    remarks: null,
                }),
                v_modal_data:{
                    modal_size:'modal-lg',
                    modal_name:'viewCourseDetails',
                    title:'Certificate'
                },
                api_url:'/api/v1/approvals/courses',
            }
        },
        methods: {
            async approveCourse(val, status){
                this.form.reset();
                this.form.fill(val);
                this.form.is_approved = status;
                const result = status == '0' ? await this.$swal({
                    title: 'Please write remarks',
                    input: 'text',
                    inputPlaceholder: 'Remarks',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: "You want to disapprove this certificate?",
                    inputValidator: (value) => {
                        if (!value) {
                        return 'You need to write something!'
                        }
                    }
                }) :  await  this.$swal({
                    title: 'Are you sure?',
                    text: "You want to approve this certificate?",
                    icon: 'warning',
                    html: '<div><p>Confirmation message...</p><iframe src="/' + val.certificate + '#toolbar=0" width="100%" height="330px"></iframe></div>',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Approve it!'
                });
                if (result.value) {
                this.$Progress.start();
                this.disabled=true;
                this.form.remarks = result.value;
                if(result.value == true){
                    this.form.remarks = null;
                }
                this.form.post('/api/v1/approve-certificate')
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
                            this.$swal(
                                'Error!',
                                "Something Went Wrong.",
                                'warning'
                            )
                            this.disabled=false;
                            this.$Progress.fail();
                    })


                }
            },
            coureseDetail(val){
                this.certificate = null
                this.certificate = val
                $('#'+this.v_modal_data.modal_name).modal('show');
            },
             onFileChange(e){
                this.form.certificate_path = e.target.files[0];
            },
            editCourseModal(course){
                this.form.reset();
                this.editmode = true;
                $('#addNewCourse').modal('show');
                this.form.fill(course);
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
                const response  = await  this.$api.courses.listUnapprovedCourse();
                this.courses = response.data
            },
        },
        created() {
            this.loadCourse(); //load the user in the table
            //Load the userlist if add or created a new user
            this.emitter.on("AfterCreate", () => {
                this.loadCourse();
            })

            this.emitter.on("AfterSearch", (item) => {
                this.courses = item
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
.invalid-feedback{
    display: block;
    }.mr-2{
        margin-right:10px
    }
</style>


