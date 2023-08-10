
<template>
    <div class="container">
        <div class="row pt-5 justify-content-center">
            <div class="col-md-5 col-12">
                <!-- Profile Image -->
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">

                        <div class="text-center">

                            <div class="profile-pic">
                            <label class="-label" for="file">
                                <span class="glyphicon glyphicon-camera"></span>
                                <span>Change Profile</span>
                            </label>
                            <input id="file" type="file"  @change="$function.imageUpload($event, form ,'profile')" name="profile" class="form-input">
                            <img v-if="form.profile != null"   class="profile-user-img img-fluid img-circle" :src="this.form.profile" alt="User profile picture">
                            <img  v-if="form.profile == null" src="https://www.gravatar.com/avatar/00000000000000000000000000000000?d=identicon&f=y" id="output" width="200" />
                            </div>
                        </div>
                        <ul class="list-group list-group-unbordered mb-3 mt-3">
                            <li class="list-group-item">
                                <a href="" traget="blank" class="float-right m-2"><i class="fa fa-user"></i> </a>
                                <b>{{form.name}}</b>
                            </li>
                            <li class="list-group-item">
                                <a href="" traget="blank" class="float-right m-2"><i class="fa fa-envelope"></i> </a>
                                <b>{{form.secondary_contact}}</b>
                            </li>
                            <li class="list-group-item">
                                <a href="" traget="blank" class="float-right m-2"><i class="fa fa-phone"></i> </a>
                                <b>{{form.primary_contact}}</b>
                            </li>


                        </ul>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.col -->
            <div class="col-md-12 mt-5">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active show" href="#settings" data-bs-toggle="tab">Profile Details</a></li>
                            <li class="nav-item"><a class="nav-link" href="#contract" data-bs-toggle="tab">Update Contract</a></li>
                            <li class="nav-item"><a class="nav-link" href="#activity" data-bs-toggle="tab">Update Password</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="tab-content">
                            <div class="tab-pane active show" id="settings">
                                <div class="card-body" >

                                    <div class="row">

                                        <div class="form-group col-md-4 col-12">
                                            <label for="inputName" >Name *</label>

                                                <input type="text" v-model="form.name" class="form-control"  placeholder="First Name" :class="{ 'is-invalid': form.errors.has('name') }">
                                                <has-error :form="form" field="name"></has-error>

                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label for="" >Primary Contact *</label>
                                                <input type="number" v-model="form.primary_contact" class="form-control"  placeholder="Primary Contact No." :class="{ 'is-invalid': form.errors.has('primary_contact') }">
                                                <has-error :form="form" field="primary_contact"></has-error>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label for="" >Secondary Contact *</label>
                                                <input type="email" v-model="form.secondary_contact" class="form-control"  placeholder="Secondary Contact" :class="{ 'is-invalid': form.errors.has('secondary_contact') }">
                                                <has-error :form="form" field="secondary_contact"></has-error>

                                        </div>


                                        <div class="form-group col-md-4 mt-2 col-12">
                                            <label for="" >Address *</label>

                                                <input type="text" v-model="form.address" class="form-control" placeholder="Address" :class="{ 'is-invalid': form.errors.has('address') }">
                                                <has-error :form="form" field="address"></has-error>

                                        </div>

                                        <div class="form-group col-md-4 mt-2 col-12">
                                            <label for="photo" class="control-label">Signature Image </label>
                                                <input type="file" accept="image/png" id="signature" @change="$function.imageUpload($event, form ,'signature')"  class="form-control">
                                                <img class="img-lg mb-3 elevation-3 float-right"  :src="form.signature"/>
                                            <has-error :form="form" field="signature"></has-error>
                                        </div>
                                        <div class="form-group col-md-4 mt-2 col-12">
                                            <label for="supervisor" class="control-label">Supervisor*</label>
                                            <multiselect v-model="form.supervisor_user_id"
                                                tag-placeholder="Select Supervisor"
                                                placeholder="Select Supervisor"
                                                label = "name"
                                                track_by = "id"
                                                :options="Object.keys(supervisors).map(Number)"
                                                :custom-label="opt => supervisors[opt]"
                                                :multiple="false"
                                                :allow-empty="false"
                                                :taggable="true">
                                            </multiselect>
                                        <has-error :form="form" field="supervisor_user_id"></has-error>
                                        </div>

                                        <div class="col-md-12">

                                        <div class="form-group ">
                                                <button @click.prevent="updateInfo" :disabled="disabled" type="submit" class="btn btn-success">Update</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane" id="contract">
                                <Contract></Contract>
                            </div>
                            <div class="tab-pane card-body" id="activity">
                                <!-- Post -->
                                <div class="post">
                                    <form class="form-horizontal">
                                        <div class="form-group">
                                            <label for="oldpassword" class=" control-label">Old password</label>
                                            <div class="col-md-12">
                                                <input type="password" v-model="form.oldpassword" class="form-control" id="oldpassword" placeholder="Password" :class="{ 'is-invalid': form.errors.has('oldpassword') }">
                                                <has-error :form="form" field="oldpassword"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="newpassword" class=" control-label">New password</label>
                                            <div class="col-md-12">
                                                <input type="password" v-model="form.newpassword" @input="check" class="form-control" v-bind:class="{ 'is-invalid': isActive, 'is-equal':fc}"  id="newpassword" placeholder="Password">
                                                <has-error :form="form" field="newpassword"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="confirmpassword" class=" control-label">Confirm password</label>
                                            <div class="col-md-12">
                                                <input type="password" v-model="form.confirmpassword" @input="check" class="form-control" v-bind:class="{ 'is-invalid': isActive, 'is-equal':fc}" id="confirmpassword" placeholder="Password">
                                                <has-error :form="form" field="confirmpassword"></has-error>
                                            </div>
                                        </div>
                                        <div class="form-group mt-3">
                                            <div class="col-sm-offset-2 col-sm-10">
                                                <button @click.prevent="updatePassword" type="submit" class="btn btn-success">Update</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <!-- /.post -->
                            </div>

                        </div>
                    </div><!-- /.card-body -->
                </div>
            </div>

            <!-- /.col -->
        </div>
    </div>

</template>

<script>
import Multiselect from 'vue-multiselect'

    import Form from 'vform'
    import {mapActions} from 'vuex'
    import { Button, HasError, AlertError } from 'vform/src/components/bootstrap5'
    import Contract from '@/views/users/Contract.vue';
    export default {
        components: {
            Multiselect,
            HasError,
            Contract,
        },
        data() {
            return {
                isActive:true,
                fc:false,
                hide:true,
                updated:true,
                user: this.$store.state.auth.user,
                supervisors: this.$store.state.choice.supervisors,
                form: new Form({
                    id: null,
                    name:null,
                    secondary_contact: null,
                    user_id:null,
                    primary_contact: null,
                    profile:null,
                    supervisor_user_id:null,
                    signature:null,
                    address: null,
                    group_id:null,
                    code:null,
                    password: null,
                    newpassword: null,
                    oldpassword: null,
                    confirmpassword: null,
                }),
                disabled: false,

            }
        },

        methods: {

            check(){
                if(this.form.newpassword == this.form.confirmpassword){
                    this.isActive = false ;
                    this.fc = true;
                }
                else{
                    this.isActive = true ;
                    this.fc = false;
                }
            },

            updatePassword() {
                this.$Progress.start();
                if(this.form.newpassword == this.form.confirmpassword){
                    this.form.post('/api/v1/updatePassword')
                   .then(res =>{
                             this.$swal(
                                res.data.result,
                                res.data.message,
                                res.data.type,
                            )
                            this.form.oldpassword = null,
                            this.form.newpassword = null,
                            this.form.confirmpassword = null,
                            this.fc = false
                            this.$Progress.finish(); //End the progress bar
                        })
                        //if form is not valid of handle any errors
                        .catch(()=>{
                            this.$swal(
                                'Error!',
                                'Something Went Wrong.',
                                'warning'
                            )
                            this.$Progress.fail(); //End the progress bar
                        })
                }else{
                    this.$swal(
                        'Opps..!',
                        'Password do not match',
                        'warning'
                    )
                }
            },
            async updateInfo() {
                this.$Progress.start();
                this.disabled = true;
                try{
                    const response = await this.form.put('/api/v1/profile/'+this.form.id);
                    if(response.data.error == 'false'){
                        this.$swal(
                                'Updated!',
                                response.data.message,
                                'success'
                            )
                            await this.$store.dispatch("auth/login");
                        this.emitter.emit('AfterProfileUpdate'); //Fire an reload event
                        this.updated = true
                        this.$Progress.finish();
                        this.disabled = false;
                    }else{

                        this.$swal(
                                'Error!',
                                response.data.message,
                                'warning'
                            )
                        this.disabled = false;
                        this.$Progress.fail();
                    }
                }catch(error){

                    this.$swal(
                        'Error!',
                        error.response.data.message,
                        'warning'
                    )
                    this.$Progress.fail();
                    this.disabled = false;
                }
                this.$Progress.finish();
                this.disabled = false;

            },
            async loadProfile(){
                //check if user is logged in
                if(!this.user){
                    await this.signIn();
                }
                //get user profile
                if(this.$store.state.auth.user.employee){
                        this.form.fill(this.$store.state.auth.user.employee);
                }else{
                    this.form.user_id = this.$store.state.auth.user.id;
                }
                    this.form.name = this.$store.state.auth.user.name;
                    this.form.secondary_contact = this.$store.state.auth.user.email;
            }
        },
       ...mapActions({
            signIn:'auth/login',
        }),
        created() {
            this.loadProfile();
            this.emitter.on("AfterProfileUpdate",()=>{
                this.loadProfile();
            })

        }

    }
</script>
