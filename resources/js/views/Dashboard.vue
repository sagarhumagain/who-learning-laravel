<template>
    <div class="container">
              <button @click="loadModal()" key="modal" class="btn btn-primary">Load Modal</button>

      <div v-role:any="'super-admin|course-admin'">
        <admin-dashboard/>
      </div>
      <div v-role:any="'normal-user|supervisor'">
        <user-dashboard/>
      </div>

    </div>
    <modal-view title="Update your profile" :modal_data="modal_data">
        <div class="card-body p-4">
            <h4>Please fill in your profile details and contract details.</h4>
            <p>

            This will notify your supervisor about your profile.
            Once your profile is approved, you will be able to create and enroll courses.
            </p>
            <router-link to="user/profile" class="btn btn-primary" @click="closeModal()">Redirect to Profile Page</router-link>
        </div>
    </modal-view>

</template>
<script>

import AdminDashboard from '@/views/AdminDashboard'
import UserDashboard from '@/views/UserDashboard'
import store from '@/store'
import ModalView from '@/components/ModalView'

export default {
    name:"dashboard",
    components: {
        AdminDashboard,
        UserDashboard,
        ModalView
    },
    data(){
        return{
            modal_data:{
                modal_name:'first-login-modal',
                modal_size:'modal-lg',
                title:'Update your profile'
            }
        }
    },
    methods:{
        loadModal(){
            if(this.$store.state.auth.user.is_first_time_login){
                $('#first-login-modal').modal('show');
            }
        },
        closeModal(){
            $('#first-login-modal').modal('hide');
        }
    },
    mounted(){
        this.loadModal();

    }
}
</script>
