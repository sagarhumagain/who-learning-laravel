<template>
    <div class="container">

      <div v-role:any="'super-admin|course-admin'">
        <admin-dashboard/>
      </div>
      <div v-role:any="'normal-user|supervisor'">
        <user-dashboard/>
      </div>
    </div>
</template>
<script>

import AdminDashboard from '@/views/AdminDashboard'
import UserDashboard from '@/views/UserDashboard'

export default {
    name:"dashboard",
    components: {
        AdminDashboard,
        UserDashboard,
    },
}
</script>
