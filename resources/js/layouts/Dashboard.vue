<template>
    <div>
        <div class="sidebar-main">
          <sidebar-menu :collapsed="collapsed" :menu="menu" v-model:collapsed="collapsed"
            @update:collapsed="onCollapse"
            @item-click="onItemClick"/>
        </div>
        <nav class="navbar navbar-expand-lg navbar-main" :class="[{'collapsed' : collapsed}, {'onmobile' : isOnMobile}]">
            <a href="/" class="navbar-brand">WHO Learning Tracker</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item active">
                        <router-link :to="{name:'dashboard'}" class="nav-link">Home <span class="sr-only">(current)</span></router-link>
                    </li>
                </ul>

                <div class="ml-auto">
                    <ul class="navbar-nav">
                        <li class="nav-item dropdown">
                          <Notification />
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ user.name }}
                            </a>
                            <div class="dropdown-menu profile-dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                <a class="dropdown-item text-danger  p-0" href="javascript:void(0)" @click="logout">Logout</a>
                            </div>
                        </li>
                    </ul>
                </div>
                
            </div>
        </nav>
        <main class="main-view mt-3" :class="[{'collapsed' : collapsed}, {'onmobile' : isOnMobile}]">
            <router-view></router-view>
        </main>
    </div>
</template>

<script>
import {mapActions} from 'vuex';
import Notification from '@/components/Notification';
import { getRoles } from '@/helpers/auth';
export default {
    name: "dashboard-layout",
    components: {
        Notification,
    },
    methods: {
      
      onCollapse (collapsed) {
        console.log(collapsed)
        // this.collapsed = collapsed
      },
      onItemClick (event, item) {
        console.log('onItemClick')
        // console.log(event)
        // console.log(item)
      },
      ...mapActions({
            signOut:"auth/logout"
        }),
        async logout(){
            await axios.post('/logout').then(({data})=>{
                this.signOut()
                this.$router.push({name:"login"})
            })
        },
        onResize () {
          if (window.innerWidth <= 767) {
            this.isOnMobile = true
            this.collapsed = true
          } else {
            this.isOnMobile = false
            this.collapsed = false
          }
        }
    },
    
    data(){
        const roles = getRoles();
        let menuItems;
        if (roles.includes('super-admin')) {
          menuItems = [
                {
                  header: 'Main Navigation',
                  hiddenOnCollapse: true
                },
                {
                  href: '/',
                  title: 'Dashboard',
                  icon: 'fa fa-gauge'
                },
                {
                  // href: '/courses',
                  title: 'Courses',
                  icon: 'fa fa-book',
                  child: [
                    {
                      href: '/courses/',
                      title: 'List Courses'
                    },
                    {
                      href: '/courses/create',
                      title: 'Create a New Course'
                    }
                  ]
                },
                {
                  href: '/users',
                  title: 'Users',
                  icon: 'fa fa-user',
                  child: [
                    {
                      href: '/user/profile',
                      title: 'View profile'
                    },
                    // {
                    //   href: '/users/add',
                    //   title: 'Add a New User'
                    // }
                  ]
                }
              ];
        } else {
          menuItems = [
                {
                  header: 'Main Navigation',
                  hiddenOnCollapse: true
                },
                {
                  href: '/',
                  title: 'Dashboard',
                  icon: 'fa fa-gauge'
                },
                {
                  // href: '/courses',
                  title: 'Courses',
                  icon: 'fa fa-book',
                  child: [
                    {
                      href: '/courses/',
                      title: 'List Courses'
                    },
                    {
                      href: '/courses/create',
                      title: 'Create a New Course'
                    }
                  ]
                },
              ];
        }
        return {
            isOnMobile: false,
            collapsed: false,
            user:this.$store.state.auth.user,
            menu: menuItems
        }
    }
}
</script>