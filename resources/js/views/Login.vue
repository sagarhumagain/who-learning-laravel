<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm">
                    <div class="card-body">
                      <img src="/images/logo.svg" alt="WHO Logo" height="100">

                        <h5 class="mt-8">Login</h5>
                        <hr/>
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
                email:"normaluser@who.int",
                password:"normaluser123"
            },
            processing:false
        }
    },
    methods:{
        ...mapActions({
            signIn:'auth/login',
            setEnums: 'choice/setEnums'
        }),
        async login(){
            this.processing = true;
            
            try {
              this.$Progress.start();
              await this.$api.auth.getCsrfCookie();
              await this.$api.auth.login(this.formData);
              await this.$api.auth.getProfile();
              this.setEnums();
              this.signIn();
              this.$Progress.finish();
            } catch (e) {
              this.$swal({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000,
                    icon: 'error',
                    title: e.response.data.message,
                });
                this.$Progress.fail();
            }
            this.processing = false;
        },
    }
}
</script>