<template>

</template>

<script>

import { mapActions } from 'vuex'
import store from '@/store';

export default {
    name: 'dashboard',
    data(){
        return{
        user:null,
        }
    },
    methods: {
        ...mapActions({
            signIn:'auth/login',
            setEnums: 'choice/setEnums'
        }),
        async setACL(){
            await this.$gates.setPermissions(store.state.auth.user.permissions);
            await this.$gates.setRoles(store.state.auth.user.roles);
        },
    },
    async created() {
        await this.signIn();
        await this.setACL();
        this.setEnums();
        this.$router.push({name:'dashboard'});
    },
}
</script>
