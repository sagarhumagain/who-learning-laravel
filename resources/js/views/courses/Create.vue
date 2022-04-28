<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Create Course</h1>
                        <hr/>
                        <form @submit.prevent="createCourse()" @keydown="form.onKeydown($event)">
                          <div class="form-group col-lg-8 col-md-12">
                              <label for="name" >Name *</label>
                              <input v-model="form.name" type="text" name="name" class="form-control" placeholder="Course Name" :class="{ 'is-invalid': form.errors.has('name')}" />
                              <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />
                          </div>
                          <div class="form-group col-lg-8 col-md-12">
                              <label for="description" >Description *</label>
                              <textarea v-model="form.description"  name="description" class="form-control" placeholder="Description" :class="{ 'is-invalid': form.errors.has('description')}" />
                              <div v-if="form.errors.has('description')" v-html="form.errors.get('description')" />
                          </div>
                          <div class="form-group col-lg-8 col-md-12">
                              <label for="url" >Course URL *</label>
                              <input v-model="form.url" type="text" name="url" placeholder="https://who.csod.com/ui/lms-learning-details/app/course/f526f260-fbdc-5ccb-84e0-04b6020f255b" class="form-control" :class="{ 'is-invalid': form.errors.has('url')}">
                              <div v-if="form.errors.has('url')" v-html="form.errors.get('url')" />
                          </div>
                          <div class="form-group col-lg-8 col-md-12">
                              <label for="credit_hours" >Credit Hours *</label>
                              <input v-model="form.credit_hours" type="number" name="credit_hours" placeholder="Credit Hours" class="form-control" :class="{ 'is-invalid': form.errors.has('credit_hours')}">
                              <div v-if="form.errors.has('credit_hours')" v-html="form.errors.get('credit_hours')" />
                          </div>
                          <div class="form-group col-lg-8 col-md-12">
                              <label for="due_date" >Due Date</label>
                              <input v-model="form.due_date" type="text" name="due_date" class="form-control" placeholder="Due Date" :class="{ 'is-invalid': form.errors.has('due_date')}" />
                              <!-- <v-date-picker v-model="form.due_date"  name="due_date" placeholder="Due Date" class="form-control" :class="{ 'is-invalid': form.errors.has('due_date')}"
                                model-config="{
                                  type: 'string',
                                  mask: 'YYYY-MM-DD',
                                }"
                                :masks="{ input: 'YYYY-MM-DD' }"
                                mode="date"
                              >
                                <template v-slot="{ inputValue, inputEvents }">
                                  <input
                                    class="bg-white border px-2 py-1 rounded"
                                    :value="inputValue"
                                    v-on="inputEvents"
                                  />
                                </template>
                              </v-date-picker> -->
                              <div v-if="form.errors.has('due_date')" v-html="form.errors.get('due_date')" />
                          </div>
                          
                          <button type="submit" :disabled="form.busy" class="btn-fill">
                            Create
                          </button>
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
import { useToast } from "vue-toastification"

export default {
    name:'create-user',
    components:{
      
    },
    data(){
        return {
            user:this.$store.state.auth.user,
            form: new Form({
              name: '',
              description: '',
              credit_hours: '',
              url: '',
              due_date: '',
            })
        }
    },
    methods:{
        ...mapActions({
            // signIn:'auth/login'
        }),
        async createCourse(){
            // const toast = useToast('create-course');
            
            try {
              await this.$api.courses.create(this.form);
              alert('Success');
              // this.emitter.emit('afterSuccess');
              // toast.success("Successfully created course.");
            } catch (e) { 
              alert(e.response.data.message);
              // toast.error(e.response.data.message);
            }
        },
    },
    created() {
        // this.emitter.on("afterSuccess", () => {
            
        // });
    }
}
</script>