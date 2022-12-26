<template>
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12 col-md-6 offset-md-3">
                <div class="card shadow sm mt-4 rounded-0">
                    <div class="card-body">
                        <div class="text-center">
                            <img src="/images/logo.png" alt="WHO Logo" height="100">
                        </div>

                        <h5 class="mt-8">Welcome Back !</h5>
                        <a href="#" class="mt-2"> Sign in to continue.</a>

                        <hr/>
                        <form action="javascript:void(0)" class="row" method="post">
                            <div class="form-group col-12 mb-3">
                                <label for="email" class="font-weight-bold">Email</label>
                                <input type="text" v-model="formData.email" name="email" id="email" class="form-control">
                            </div>
                            <div class="form-group col-12 mb-2">
                                <label for="password" class="font-weight-bold">Password</label>
                                <input type="password" v-model="formData.password" name="password" id="password" class="form-control">
                            </div>
                            <div class="col-12 mb-2 text-center mt-3 ">
                                <button type="submit" :disabled="processing" @click="login" class="btn-fill ">
                                    {{ processing ? "Please wait" : "Login" }}
                                </button>
                            </div>
                            <div class="col-12 text-center mt-3">
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
import { mapActions } from 'vuex';
export default {
    name:"login",
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
                const cookie = await this.$api.auth.getCsrfCookie();
                console.log(cookie);
                await this.$api.auth.login(this.formData);
                this.signIn();
                this.setEnums();
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

