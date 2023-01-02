
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
                                <a href="" traget="blank" class="float-right"><i class="fa fa-user"></i> </a>
                                <span class="m-2"> <b>{{ form.name}}</b></span>
                            </li>
                            <li class="list-group-item">
                                <a href="" traget="blank" class="float-right"><i class="fa fa-envelope"></i> </a>
                                <span class="m-2"> <b>{{ form.secondary_contact}}</b></span>
                            </li>
                            <li class="list-group-item">
                                <a href="" traget="blank" class="float-right"><i class="fa fa-phone"></i> </a>
                                <span class="m-2"> <b>{{ form.primary_contact}}</b></span>
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
                            <li class="nav-item"><a class="nav-link" href="#activity" data-bs-toggle="tab">Update Password</a></li>
                        </ul>
                    </div><!-- /.card-header -->
                    <div class="card-body">
                        <div class="tab-content">
                            <div class="tab-pane" id="activity">
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


                                        <div class="form-group col-md-4 col-12">
                                            <label for="" >Address *</label>

                                                <input type="text" v-model="form.address" class="form-control" placeholder="Address" :class="{ 'is-invalid': form.errors.has('address') }">
                                                <has-error :form="form" field="address"></has-error>

                                        </div>

                                        <div class="form-group col-md-4 col-12">
                                            <label for="photo" class="control-label">Signature Image *</label>
                                                <input type="file" accept="image/png" id="signature" @change="$function.imageUpload($event, form ,'signature')"  class="form-control">
                                                <img class="img-lg mb-3 elevation-3 float-right"  :src="form.signature"/>
                                            <has-error :form="form" field="signature"></has-error>
                                        </div>
                                        <div class="form-group col-md-4 col-12">
                                            <label for="supervisor" class="control-label">Supervisor*</label>
                                            <multiselect v-model="form.supervisor_user_id" disabled
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

                                        <div class="form-group mt-3">
                                                <button @click.prevent="updateInfo" type="submit" class="btn btn-success">Update</button>
                                        </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.tab-pane -->
                        </div>
                        <!-- /.tab-content -->
                    </div><!-- /.card-body -->
                </div>
                <!-- /.nav-tabs-custom -->
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
    export default {
        components: {
            Multiselect,
            HasError
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
                })
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
                const response = await this.form.put('/api/v1/profile/'+this.form.id);
                try{
                    if(response.data.error == 'false'){
                        this.$swal(
                                'Updated!',
                                response.data.message,
                                'success'
                            )
                            await this.$store.dispatch("auth/login");
                        this.emitter.emit('AfterProfileUpdate'); //Fire an reload event
                        this.updated = true
                    }else{
                        this.$swal(
                                'Error!',
                                response.data.message,
                                'warning'
                            )
                        this.$Progress.fail();
                    }
                }catch(error){
                    this.$swal(
                                'Error!',
                                'Something Went Wrong.',
                                'warning'
                            )
                    this.$Progress.fail();
                }
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
<style  scoped>
[type="date"]::-webkit-calendar-picker-indicator {
  display: none;
}
[type="file"]::-webkit-file-upload-button {
    line-height: 20px;
}
.invalid-feedback{
    display: block;
}
.is-equal{
        border-color: green;
        box-shadow: 0 0 0 0.2rem rgba(73, 231, 25, 0.25) !important;
    }
.card-primary.card-outline {
    border-top: 3px solid #ff2300;
}
.profile-pic {
  color: transparent;
  transition: all 0.3s ease;
  display: flex;
  justify-content: center;
  align-items: center;
  position: relative;
  transition: all 0.3s ease;
}
.profile-pic input {
  display: none;
}
.profile-pic img {
  position: absolute;
  object-fit: cover;
  width: 100px;
  height: 100px;
  box-shadow: 0 0 10px 0 rgba(255, 255, 255, 0.663);
  border-radius: 100px;
  z-index: 0;
}
.profile-pic .-label {
  cursor: pointer;
  height: 100px;
  width: 100px;
  margin-bottom: 0;
}
.profile-pic:hover .-label {
  display: flex;
  justify-content: center;
  align-items: center;
  background-color: rgba(0, 0, 0, 0.173);
  z-index: 10000;
  color: #fafafa;
  border-radius: 100px;
  margin-bottom: 0;
}
.profile-pic span {
  display: inline-flex;
  padding: 0.2em;
  height: 2em;
}
.img-lg {
  width: 200px;
}
</style>
