<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                      <img src="/images/logo.svg" alt="WHO Logo" height="100">

                        <h5 class="mt-8">Login</h5>
                        <hr/>
                        <!-- <FormKit
                          type="form"
                          v-model="formData"
                          :form-class="submitted ? 'hide' : 'show'"
                          submit-label="Login"
                          @submit="login"
                        >
                          <FormKit
                            type="text"
                            name="email"
                            label="Email"
                            placeholder="jane@who.int"
                            help="What email should we use?"
                            validation="required|email"
                          />
                          <FormKit
                            type="password"
                            name="password"
                            label="Password"
                            validation="required"
                            :validation-messages="{
                              matches: 'Password field cannot be empty',
                            }"
                            placeholder="Your password"
                          />
                        </FormKit>
                        <h2>Modeled group values</h2>
                        <pre class="form-data">{{ formData }}</pre> -->
                        <form action="javascript:void(0)" class="row" method="post">
                            <div class="form-group col-12">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="text" v-model="formData.email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group col-12 mb-2">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" v-model="formData.password" name="password" id="password" class="form-control">
                            </div>
                            <div class="col-12 mb-2">
                                <button type="submit" :disabled="processing" @click="login" class="btn-fill">
                                    {{ processing ? "Please wait" : "Login" }}
                                </button>
                            </div>
                            <div class="col-12 text-center">
                                <label>Don't have an account? <router-link :to="{name:'register'}">Register Now!</router-link></label>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { ref } from 'vue'
import { mapActions } from 'vuex';
import { useToast } from "vue-toastification";

export default {
    name:"login",
    // setup() {
    //   const formData = ref({});
    //   return {
    //     formData
    //   }
    // },
    data(){
        return {
            formData:{
                email:"",
                password:""
            },
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login'
        }),
        async login(){
          
          const toast = useToast();
            this.processing = true;
            
            try {
              await this.$api.auth.getCsrfCookie();
              await this.$api.auth.login(this.formData);
              this.signIn();
            } catch (e) { 
              toast.error(e.response.data.message);
            }
            this.processing = false;
        },
    }
}
</script>