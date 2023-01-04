<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Create Course</h1>
                        <hr/>
                        <form @submit.prevent="createCourse()" @keydown="form.onKeydown($event)">
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="name" >Name *</label>
                              <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Course Name" :class="{ 'is-invalid': form.errors.has('name')}" />
                              <error-msg :errors="errors" field="name"></error-msg>
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="description" >Description *</label>
                              <textarea v-model="form.description"  name="description" class="form-control" placeholder="Description" :class="{ 'is-invalid': form.errors.has('description')}" />
                              <error-msg :errors="errors" field="description"></error-msg>
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="url" >Course URL *</label>
                              <input v-model="form.url" type="text" name="url" placeholder="https://who.csod.com/ui/lms-learning-details/app/course/f526f260-fbdc-5ccb-84e0-04b6020f255b" class="form-control" :class="{ 'is-invalid': form.errors.has('url')}">
                              <error-msg :errors="errors" field="url"></error-msg>
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="credit_hours" >Credit Hours *</label>
                              <input v-model="form.credit_hours" type="text" name="credit_hours" placeholder="Credit Hours" class="form-control" :class="{ 'is-invalid': form.errors.has('credit_hours')}">
                              <error-msg :errors="errors" field="credit_hours"></error-msg>
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="url" >Source *</label>
                              <input v-model="form.source" type="text" name="source" placeholder="iLearn" class="form-control" :class="{ 'is-invalid': form.errors.has('source')}">
                              <error-msg :errors="errors" field="source"></error-msg>
                          </div>
                          <div class="form-group col-lg-12 col-md-12">
                              <label for="due_date" >Due Date</label>
                              <!-- <input v-model="form.due_date" type="text" name="due_date" class="form-control" placeholder="Due Date" :class="{ 'is-invalid': form.errors.has('due_date')}" /> -->
                              <v-date-picker v-model="form.due_date"  name="due_date" placeholder="Due Date" class="form-control" :class="{ 'is-invalid': form.errors.has('due_date')}"
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
                              <error-msg :errors="errors" field="due_date"></error-msg>
                          </div>
                           <h4>Course Category</h4>
                            <div class="form-group col-lg-12 col-md-12">
                              <multiselect v-model="form.course_category_ids"
                                  tag-placeholder="Category"
                                  placeholder="Select Category"
                                  label="name" track-by="name"
                                  :options="course_categories"
                                  :multiple="true"
                                  :taggable="true"
                                  >
                              </multiselect>
                            </div>
                          <div v-permission="'course_assignment'">
                            <h4>Assign To</h4>
                            <label for="pillars" >Pillars</label>
                            <multiselect v-model="form.pillar_ids"
                                tag-placeholder="Pillars"
                                placeholder="Select Pillars"
                                label="name" track-by="name"
                                :options="pillars"
                                :multiple="true"
                                :taggable="true"
                                >
                            </multiselect>
                            <label for="staff_types" >Staff Types</label>
                            <multiselect v-model="form.staff_type_ids"
                                tag-placeholder="Staff Types"
                                placeholder="Select Staff Types"
                                label="name" track-by="name"
                                :options="staff_types"
                                :multiple="true"
                                :taggable="true"
                              >
                            </multiselect>
                            <label for="contract_types" >Contract Types</label>
                            <multiselect v-model="form.contract_type_ids"
                                tag-placeholder="Contract Types"
                                placeholder="Select Contract Types"
                                label="name" track-by="name"
                                :options="contract_types"
                                :multiple="true"
                                :taggable="true"
                                >
                            </multiselect>
                            <label for="staff_categories" >Staff Categories</label>
                            <multiselect v-model="form.staff_category_ids"
                                tag-placeholder="Staff Category"
                                placeholder="Select Staff Category"
                                label="name" track-by="name"
                                :options="staff_categories"
                                :multiple="true"
                                :taggable="true"
                                >
                            </multiselect>
                            <label for="staff_designations" >Staff Designations</label>
                            <multiselect v-model="form.staff_designation_ids"
                                tag-placeholder="Designations"
                                placeholder="Select Designations"
                                label="name" track-by="name"
                                :options="designations"
                                :multiple="true"
                                :taggable="true"
                                >
                            </multiselect>

                          </div>
                          <div v-role:any="'normal-user|supervisor'">
                            <div class="form-group col-md-8">
                                <label for="completed_date" >Completed Date</label>
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

                            <div class="form-group col-md-8">
                                <label for="file" class="control-label">Certificate Image </label>
                                <input type="file" name="certificate_path"  @change="onFileChange"
                                        placeholder="File"
                                        class="btn btn-sm btn-info btn-file-upload">
                                <error-msg :errors="errors" field="certificate_path"></error-msg>
                            </div>
                          </div>
                            <div class="col-12 mb-2 text-center mt-3 ">


                          <button type="submit" :disabled="form.busy" class="btn-fill text-center">
                            Create
                          </button>
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

const mask = "YYYY-MM-DD";
export default {
    name:'course-create',
    components:{
      Multiselect,
      ErrorMsg
    },
    data(){
        return {
            user:this.$store.state.auth.user,
            pillars: this.$store.state.choice.pillars,
            staff_types: this.$store.state.choice.staffTypes,
            contract_types: this.$store.state.choice.contractTypes,
            staff_categories: this.$store.state.choice.staffCategories,
            designations: this.$store.state.choice.designations,
            course_categories: this.$store.state.choice.courseCategories,
            errors: {},
            masks: {
              input: mask
            },
            form: new Form({
              id:null,
              name: null,
              description: null,
              credit_hours: null,
              url: null,
              source: null,
              due_date: null,
              pillar_ids: null,
              staff_type_ids: null,
              contract_type_ids: null,
              staff_category_ids: null,
              staff_designation_ids: null,
              course_category_ids: null,
              completed_date: null,
              certificate_path: null,
            })
        }
    },
    methods:{
        onFileChange(event){
              const file = event.target.files[0];
              this.form.certificate_path = file
            },
        async createCourse() {
          this.disabled = true;
          this.$Progress.start();
            try {
                this.form.course_category_ids = JSON.stringify(this.form.course_category_ids);
                const response = await this.form.post('/api/v1/courses');
                this.form.course_category_ids = JSON.parse(this.form.course_category_ids);
                if(response.data.error == true){
                    this.$swal({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000,
                        icon: 'error',
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
                    this.emitter.emit('AfterCourseCreate'); //Fire an reload event
                    this.disabled=false
                    this.form.reset();
                    this.$Progress.finish();
                    this.$router.push({name:'courses-list'})
                }
            } catch ({response}) {
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
                this.form.course_category_ids = JSON.parse(this.form.course_category_ids);
                this.disabled=false;
                this.$Progress.fail();
            }
        },
    },
}
</script>
