<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Update Course</h1>
                        <hr/>
                        <form @submit.prevent="updateCourse()" @keydown="form.onKeydown($event)">
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
                              <input v-model="form.credit_hours" :disabled="course_disabled" type="number" name="credit_hours" placeholder="Credit Hours" class="form-control" :class="{ 'is-invalid': form.errors.has('credit_hours')}">
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
                                      :disabled="course_disabled"
                                      :value="inputValue"
                                      v-on="inputEvents"
                                    />
                                  </template>
                                </v-date-picker>
                              <div v-if="form.errors.has('due_date')" v-html="form.errors.get('due_date')" />
                          </div>
                           <h4>Course Category</h4>
                            <div class="form-group col-lg-12 col-md-12">
                              <multiselect v-model="form.course_category_ids"
                                  tag-placeholder="Category"
                                  placeholder="Select Category"
                                  label="name" track-by="id"
                                  :options="course_categories"
                                  :disabled="course_disabled"
                                  :multiple="true"
                                  :taggable="true"
                                  >
                              </multiselect>
                            </div>
                          <div v-role="'course_assignment'">
                            <h4>Assign To</h4>
                            <multiselect v-model="form.pillar_ids"
                                tag-placeholder="Pillars"
                                placeholder="Select Pillars"
                                label="name" track-by="id"
                                :options="pillars"
                                :multiple="true"
                                :taggable="true"
                                >
                            </multiselect>
                            <multiselect v-model="form.staff_type_ids"
                                tag-placeholder="Staff Types"
                                placeholder="Select Staff Types"
                                label="name" track-by="name"
                                :options="staff_types"
                                :multiple="true"
                                :taggable="true"
                              >
                            </multiselect>
                            <multiselect v-model="form.contract_type_ids"
                                tag-placeholder="Contract Types"
                                placeholder="Select Contract Types"
                                label="name" track-by="name"
                                :options="contract_types"
                                :multiple="true"
                                :taggable="true"
                                >
                            </multiselect>
                            <multiselect v-model="form.staff_category_ids"
                                tag-placeholder="Staff Category"
                                placeholder="Select Staff Category"
                                label="name" track-by="name"
                                :options="staff_categories"
                                :multiple="true"
                                :taggable="true"
                                >
                            </multiselect>
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
                          <div v-role="'normal-user'">
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

                          <button type="submit" :disabled="disabled" class="btn-fill">
                            Update
                          </button>
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
    name:'courses-edit',
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
            disabled:false,
            errors:{},
            course_disabled: true,
            course_user_disabled: true,
            form: new Form({
              id: null,
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
              certificate_path:null,
            }),
            course : this.$route.params.course

        }
    },
    methods:{
        ...mapActions({
            // signIn:'auth/login'
        }),
        onFileChange(event){
            const file = event.target.files[0];
            this.form.certificate_path = file
        },
        async updateCourse(){
            this.disabled = true
            try{
                this.$Progress.start();

                const config = {
                    headers: {
                        'Content-Type': 'multipart/form-data'
                    }
                }
                const formData = new FormData();
                formData.append('id', this.form.id)
                formData.append('name', this.form.name)
                formData.append('description', this.form.description)
                formData.append('credit_hours', this.form.credit_hours)
                formData.append('url', this.form.url)
                formData.append('source', this.form.source)
                formData.append('due_date', this.form.due_date)
                formData.append('pillar_ids', JSON.stringify(this.form.pillar_ids))
                formData.append('staff_type_ids', JSON.stringify(this.form.staff_type_ids))
                formData.append('contract_type_ids', JSON.stringify(this.form.contract_type_ids))
                formData.append('staff_category_ids', JSON.stringify(this.form.staff_category_ids))
                formData.append('staff_designation_ids', JSON.stringify(this.form.staff_designation_ids))
                formData.append('course_category_ids', JSON.stringify(this.form.course_category_ids))
                formData.append('completed_date', this.form.completed_date)
                formData.append('certificate_path', this.form.certificate_path)
                formData.append('_method', 'PUT')

                const response  = await axios.post('/api/v1/update-assigned-course', formData, config)
                this.disabled = true
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

                    this.disabled=false
                    this.$Progress.finish();
                    this.$router.push({name:'courses-list'})

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
        },
        async loadCourse(){
            try{
                const response  = await  axios.get("/api/v1/courses?id=" + this.$route.params.id);
                this.form.fill(response.data);
                this.form.is_course_approved = response.data.is_approved;
                this.form.course_category_ids =  response.data.course_categories;
                if(response.data.users){
                    this.form.completed_date = response.data.users[0].pivot.completed_date;
                    this.form.certificate_path = response.data.users[0].pivot.certificate_path;
                    this.form.course_user_approved = response.data.users[0].pivot.is_approved;
                }
                if(response.data.course_assignment){
                    //filter out the pillar_ids
                    this.form.pillar_ids = this.pillars.filter(pillar => {
                        return response.data.course_assignment.pillar_ids ? response.data.course_assignment.pillar_ids.includes(pillar.id) : null
                    })
                    //filter out the staff_type_ids
                    this.form.staff_type_ids = this.staff_types.filter(staff_type => {
                        return response.data.course_assignment.staff_type_ids ? response.data.course_assignment.staff_type_ids.includes(staff_type.id) : null
                    })
                    //filter out the contract_type_ids
                    this.form.contract_type_ids = this.contract_types.filter(contract_type => {
                        return response.data.course_assignment.contract_type_ids ? response.data.course_assignment.contract_type_ids.includes(contract_type.id) : null
                    })
                    //filter out the staff_category_ids
                    this.form.staff_category_ids = this.staff_categories.filter(staff_category => {
                        return response.data.course_assignment.staff_category_ids ? response.data.course_assignment.staff_category_ids.includes(staff_category.id) : null
                    })
                    //filter out the staff_designation_ids
                    this.form.staff_designation_ids = this.designations.filter(designation => {
                        return response.data.course_assignment.staff_designation_ids ? response.data.course_assignment.staff_designation_ids.includes(designation.id) : null
                    })
                }
            }catch(e){
            }
        },
        setFormDisabled(){
          if(this.$gates.hasAnyRole('super-admin|course-admin')){
            this.course_disabled = false;
          }
          // #TODO check if course created by normal user, & let edit if course is not approved
          // if(this.role.isNormalUser() && !this.form.is_course_approved){
          //   this.course_disabled = false;
          // }
          if(this.$gates.hasRole('normal-user') && this.form.course_user_approved !== 1){
            this.course_user_disabled = false;
          }
        }
    },
    async created() {
        await this.loadCourse();
        this.setFormDisabled();
    }
}
</script>
