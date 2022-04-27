<template>
    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">{{this.notifications.length}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notifications" style="left: inherit; right: 0px;">
        <span class="dropdown-header">{{this.notifications.length}} Notifications</span>
        <div class="dropdown-divider"></div>
        

        <a v-for="notification in notifications" :key="notification.id" class="dropdown-item notification d-flex justify-content-between">
        <div class="notification-content">
            <h5 class="m-0">{{notification.data.title}} </h5>
            <p>{{notification.data.excerpt}}</p>

        </div>
        <span class="float-right text-muted text-sm">{{$filters.duration(notification.created_at)}} ago</span>
        </a>
        
        <div class="dropdown-divider"></div>
        <a href="#" class="dropdown-item notification dropdown-footer">See All Notifications</a>
    </div>
</template>


<script>

export default {
    name: "notification",
    methods: {
      async fetchAllNotification () {
        let response = await this.$api.notification.fetchAllNotification();
        this.notifications = response.data.notifications;
      },
    },
    created(){
      this.fetchAllNotification();
    },
    data(){
        return {
            notifications:[],
        }
    }
}
</script>