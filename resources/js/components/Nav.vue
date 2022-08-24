<template>
<div :data-role="roles" id="role-data"></div>
</template>
<script>
import { mapState} from 'vuex'
export default {
    computed:{
        ...mapState({
            roles:state=>state.auth.user.roles,
        })
    },
}
</script>
