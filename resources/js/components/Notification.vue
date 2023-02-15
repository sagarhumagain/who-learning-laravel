<template>
    <a class="nav-link" data-bs-toggle="dropdown" href="#" aria-expanded="false">
        <i class="far fa-bell"></i>
        <span class="badge badge-warning navbar-badge">{{this.notifications.length}}</span>
    </a>
    <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right notifications" style="left: inherit; right: 0px;">
        <a href="#" class="dropdown-item notification dropdown-footer ">See All {{this.notifications.length}}  Notifications</a>
        <a href="#" @click="readNotifications()" class="dropdown-item notification dropdown-footer ">Mark all as read</a>


        <div class="dropdown-divider"></div>

        <a v-for="notification in notifications" :key="notification.id" class="dropdown-item notification d-flex justify-content-between">
        <div class="notification-content">
            <h5 class="m-0">{{notification.data.title}} </h5>
            <p class="m-0">{{notification.data.excerpt.substring(0,30)+'...'}}</p>
        </div>
        <div class="d-flex flex-column align-items-end">
        <span class=" text-muted text-sm">{{$filters.duration(notification.created_at)}} ago</span>
        <a class=" text-muted text-sm" :href="notification.data.link">Read More</a>
        </div>

        </a>

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
        async readNotifications () {
            this.$swal({
                title: 'Are you sure?',
                text: "You want to mark all notifications as read!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, mark all as read!'
            }).then((result) => {
                if (result.isConfirmed) {
                    this.$api.notification.readNotifications().then((response)=>{
                        this.fetchAllNotification();
                        this.$swal('Marked!', 'All notifications are marked as read.', 'success');
                    });
                }
            });

        },
    },

    created(){
        this.fetchAllNotification();
        this.emitter.on("AfterCourseCreate",()=>{
            this.fetchAllNotification();
        });


    },
    data(){
        return {
            notifications:[],
        }
    }
}
</script>
