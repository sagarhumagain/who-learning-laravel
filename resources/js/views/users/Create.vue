<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                        <h1 class="text-center">Create Course</h1>
                        <hr/>
                        <form @submit.prevent="createCourse" @keydown="form.onKeydown($event)">
                          <input v-model="form.name" type="text" name="name" placeholder="Full Name">
                          <div v-if="form.errors.has('name')" v-html="form.errors.get('name')" />

                          <input v-model="form.email" type="" name="email" placeholder="Email">
                          <div v-if="form.errors.has('email')" v-html="form.errors.get('email')" />

                          <button type="submit" :disabled="form.busy">
                            Log In
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

export default {
    name:'create-user',
    components:{
      FormKitSchema
    },
    data(){
        return {
            form: new Form({
              name: '',
              description: '',
              credit_hours: '',
              url: '',
              due_date: ''
            }),
            processing:false
        }
    },
    methods:{
        ...mapActions({
            // signIn:'auth/login'
        }),
        async createCourse(){
            this.processing = true
            await axios.post('/register',this.user).then(response=>{
                this.signIn()
            }).catch(({response:{data}})=>{
                alert(data.message)
            }).finally(()=>{
                this.processing = false
            })
        }
    }
}
</script>