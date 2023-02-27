<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Approve Course for {{this.course.createdBy}}</h1>
                        <h4 class="text-center" v-if="form.remarks">Remarks: {{form.remarks}}</h4>
                        <hr/>
                        <form @submit.prevent="approveCourse()" @keydown="form.onKeydown($event)">
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="name" >Name *</label>
                              <input :disabled="course_disabled" v-model="form.name" type="text" name="name" class="form-control" placeholder="Course Name" :class="{ 'is-invalid': form.errors.has('name')}" />
                              <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="description" >Description *</label>
                              <textarea v-model="form.description"  :disabled="course_disabled" name="description" class="form-control" placeholder="Description" :class="{ 'is-invalid': form.errors.has('description')}" />
                              <div v-if="form.errors.has('description')" v-html="form.errors.get('description')" />
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="url" >Course URL *</label>
                              <input v-model="form.url" :disabled="course_disabled" type="text" name="url" placeholder="https://who.csod.com/ui/lms-learning-details/app/course/f526f260-fbdc-5ccb-84e0-04b6020f255b" class="form-control" :class="{ 'is-invalid': form.errors.has('url')}">
                              <div v-if="form.errors.has('url')" v-html="form.errors.get('url')" />
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="credit_hours" >Credit Hours *</label>
                              <input v-model="form.credit_hours" :disabled="course_disabled" type="text" name="credit_hours" placeholder="Credit Hours" class="form-control" :class="{ 'is-invalid': form.errors.has('credit_hours')}">
                              <div v-if="form.errors.has('credit_hours')" v-html="form.errors.get('credit_hours')" />
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="url" >Source *</label>
                              <input v-model="form.source" :disabled="course_disabled" type="text" name="source" placeholder="iLearn" class="form-control" :class="{ 'is-invalid': form.errors.has('source')}">
                              <div v-if="form.errors.has('source')" v-html="form.errors.get('source')" />
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="due_date" >Due Date</label>
                              <!-- <input v-model="form.due_date" type="text" name="due_date" class="form-control" placeholder="Due Date" :class="{ 'is-invalid': form.errors.has('due_date')}" /> -->
                              <v-date-picker v-model="form.due_date" :disabled="course_disabled" name="due_date" placeholder="Due Date" class="form-control" :class="{ 'is-invalid': form.errors.has('due_date')}"
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
                              <div v-if="form.errors.has('due_date')" v-html="form.errors.get('due_date')" />
                          </div>


                          <div>
                            <div class="form-group col-md-8">
                                <label for="completed_date" >Completed Date</label>
                                <v-date-picker v-model="form.completed_date"  name="completed_date" placeholder="Completed Date" class="form-control" :class="{ 'is-invalid': form.errors.has('completed_date')}"
                                  :disabled="course_user_disabled"
                                  :model-config="{
                                    type: 'string',
                                    mask: 'YYYY-MM-DD',
                                  }"
                                  :masks="masks"
                                  mode="date"
                                >
                                  <template v-slot="{ inputValue, inputEvents }">
                                    <input
                                      :disabled="course_user_disabled"
                                      class="custom-datepicker"
                                      :value="inputValue"
                                      v-on="inputEvents"
                                    />
                                  </template>
                                </v-date-picker>
                                <error-msg :errors="errors" field="completed_date"></error-msg>
                            </div>

                            <div class="form-group col-md-8">
                                <label for="file" class="control-label">Certificate Image </label>
                                <input type="file" name="certificate_path"  @change="onFileChange"
                                        placeholder="File"
                                        :disabled="course_user_disabled"
                                        class="btn btn-sm btn-info btn-file-upload">
                                <error-msg :errors="errors" field="certificate_path"></error-msg>
                            </div>
                          </div>
                        <div class="col-12 mb-2 text-center mt-3 ">

                          <button type="submit" :disabled="disabled || course_user_disabled" class="btn-fill text-center">
                            Approve Course
                          </button>
                        </div>
                           <div class="modal-body">
                            <iframe :src="'/'+form.certificate_path" v-if="form.certificate_path && form.certificate_path.length > 8" width="100%" height="500px"></iframe>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { mapActions } from 'vuex'
import Form from 'vform'
import Multiselect from 'vue-multiselect'
import ErrorMsg from '@/components/error-msg'
import axios from 'axios'

export default {
    name:'approve-edit',
    components:{
      Multiselect,
      ErrorMsg
    },
    data(){
        return {

            disabled:false,
            errors:{},

            form: new Form({
              course_id: null,
                user_id:null,
              name: null,
              description: null,
              credit_hours: null,
              url: null,
              remarks: null,
              source: null,
              due_date: null,
              pillar_ids: null,
              staff_type_ids: null,
              contract_type_ids: null,
              staff_category_ids: null,
              staff_designation_ids: null,
              course_category_ids: null,
              completed_date: null,
              certificate_path:null,
              assigned_by_user_id: null,
              is_approved: null,
            }),
            masks: {
                    input: 'YYYY-MM-DD',
                },
            course : {},

        }
    },
    methods:{
        approveCourse(){
            this.$Progress.start();
            this.form.reset();
            this.form.fill(this.course);
            this.form.post('/api/v1/approve-course')
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
        },
        async loadCourse(){
                this.$Progress.start();
                try{
                    const response  = await  axios.get("/api/v1/approve/certificate?user_id=" + this.$route.params.user_id + "&course_id=" + this.$route.params.course_id);
                    this.form.fill(response.data);
                    this.course = response.data;
                }catch(e){
                }
                this.$Progress.finish();

        },

    },
    async created() {
        await this.loadCourse();
    }
}
</script>
