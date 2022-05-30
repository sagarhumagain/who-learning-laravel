<template>
    <div class="container">
        <div class="row pt-5" >
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
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                            <tr v-for="(course, index) in courses" :key="course.id">
                                <td>{{index + 1}}</td>
                                <td>{{course.name}}
                                </td>
                                <td>{{course.credit_hours}}</td>
                                <td>{{course.due_date}}</td>
                                <td>{{course.description}}</td>
                                <td>
                                    <p class="color-red" v-if="course.pivot && course.pivot.completed_date == null">Incomplete</p>
                                    <p class="color-yellow" v-else-if="course.pivot && course.pivot.is_approved == null && course.pivot.completed_date">Approval Pending</p>
                                    <p class="color-green" v-else-if="course.pivot && course.pivot.is_approved == '1' && course.pivot.completed_date">Approved</p>
                                    <p class="color-red" v-else-if="course.pivot && course.pivot.is_approved == '0' && course.pivot.completed_date">Disapproved</p>
                                </td>
                                <td>
                                    <router-link class="project-link mr-3" :to="{ name: 'courses-edit', params: { course: course.pivot , id: course.id} }">
                                        <i class="fa fa-edit"></i>
                                    </router-link>
                                    
                                </td>
                            </tr>
                            </tbody></table>
                    </div>
                    
                </div>
                <!-- /.card -->
            </div>
        </div>

        <div class="modal fade" id="addNewCourse" tabindex="-1" role="dialog" aria-labelledby="addNewCourseLabel'" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" >Add New </h5>
                    <h5 class="modal-title" v-show="editmode" >Update </h5>
                    
                </div>
                <form  @submit.prevent="editmode ? updateInfo() : createInfo()">
                    <div class="modal-body">
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="completed_date" >Completed Date*</label>
                                <!-- <input type="text" v-model="form.completed_date" class="form-control"  placeholder="Completed Date" :class="{ 'is-invalid': form.errors.has('completed_date') }"> -->
                                <v-date-picker v-model="form.completed_date"  name="completed_date" placeholder="Completed Date" class="form-control" :class="{ 'is-invalid': form.errors.has('completed_date')}"
                                  :model-config="{
                                    type: 'string',
                                    mask: 'YYYY-MM-DD',
                                  }"
                                  :masks="masks"
                                  mode="date"
                                >
                                  <template v-slot="{ inputValue, inputEvents }">
                                    <input
                                      class="custom-datepicker"
                                      :value="inputValue"
                                      v-on="inputEvents"
                                    />
                                  </template>
                                </v-date-picker>
                                <error-msg :errors="errors" field="completed_date"></error-msg>
                            </div>
                        
                            <div class="form-group col-md-6">
                                <label for="file" class="control-label">Certificate Image *</label>
                                <input type="file" name="certificate_path"  @change="onFileChange"
                                        placeholder="File"
                                        class="btn btn-sm btn-info btn-file-upload">
                                <error-msg :errors="errors" field="certificate_path"></error-msg>
                            </div>                        
                        </div>
                        <div class="modal-body">
                            <iframe :src="'/'+form.certificate_path" v-if="form.certificate_path && form.certificate_path.length > 8" width="100%" height="500px"></iframe>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-red" data-bs-dismiss="modal"><i class="fas fa-times fa-fw"></i>Close</button>
                        <button v-show="editmode" :disabled="disabled" type="submit" class="btn btn-green"><i class="fas fa-plus fa-fw"></i>Update</button>
                        <button v-show="!editmode" :disabled="disabled" type="submit" class="btn btn-primary-blue"><i class="fas fa-plus fa-fw"></i>Create</button>
                    </div>
                </form>
            </div>
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

    export default {
        name:'assigned-course',
        components: {
            Multiselect,
            HasError,
            Modal,
            ErrorMsg
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
                }),                
            }
        },
        methods: {
             onFileChange(e){
                console.log(e.target.files[0]);
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
                            this.errors = response.data.errors
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
                this.courses = data.data;
            },
        },
        created() {
            this.loadCourse(); //load the user in the table
            //Load the userlist if add or created a new user
            this.emitter.on("AfterCreate", () => {
                this.loadCourse();
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


