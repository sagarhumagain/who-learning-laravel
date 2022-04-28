import * as Vue from 'vue'
import * as VueRouter from 'vue-router'
import store from '@/store'



/* Guest Component */
const Login = () => import('@/views/Login.vue' /* webpackChunkName: "resource/js/components/login" */)
const Register = () => import('@/views/Register.vue' /* webpackChunkName: "resource/js/components/register" */)
/* Guest Component */

/* Layouts */
const DahboardLayout = () => import('@/layouts/Dashboard.vue' /* webpackChunkName: "resource/js/components/layouts/dashboard" */)
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import('@/views/Dashboard.vue' /* webpackChunkName: "resource/js/components/dashboard" */)
const CoursesList = () => import('@/views/courses/List.vue' /* webpackChunkName: "resource/js/components/courseslist" */)
const CourseCreate = () => import('@/views/courses/Create.vue' /* webpackChunkName: "resource/js/components/coursecreate" */)
const CourseView = () => import('@/views/courses/View.vue' /* webpackChunkName: "resource/js/components/courseview" */)
const CourseEdit = () => import('@/views/courses/Edit.vue' /* webpackChunkName: "resource/js/components/courseedit" */)
const Users = () => import('@/views/users/Users.vue' /* webpackChunkName: "resource/js/components/users" */)
const Courses = () => import('@/views/courses/Courses.vue' /* webpackChunkName: "resource/js/components/courses" */)
const Employee = () => import('@/views/users/Employee.vue' /* webpackChunkName: "resource/js/components/employee" */)

/* Authenticated Component */


const Routes = [
    {
        name:"login",
        path:"/login",
        component:Login,
        meta:{
            middleware:"guest",
            title:`Login`
        }
    },
    {
        name:"register",
        path:"/register",
        component:Register,
        meta:{
            middleware:"guest",
            title:`Register`
        }
    },
    {
        path:"/",
        component:DahboardLayout,
        meta:{
            middleware:"auth"
        },
        children:[
            {
                name:"dashboard",
                path: '/',
                component: Dashboard,
                meta:{
                    title:`Dashboard`
                }
            },
            {
              name:"courses-list",
              path: '/courses',
              component: Courses,
              meta:{
                  title:`List Courses`
              }
            },
            {
              name:"course-create",
              path: '/courses/create',
              component: CourseCreate,
              meta:{
                  title:`Create Courses`
              }
            },
            {
              name:"course-view",
              path: '/courses/:id',
              component: CourseView,
              meta:{
                  title:`View Course`
              }
            },
            {
              name:"courses-edit",
              path: '/courses/:id/edit',
              component: CourseEdit,
              meta:{
                  title:`Edit Course`
              }
            },
            {
                name:"users",
                path: '/users',
                component: Users,
                meta:{
                    title:`Users Management`
                }
              },
              {
                name:"employee",
                path: '/user/profile',
                component: Employee,
                meta:{
                    title:`Profile Management`
                }
              }
        ]
    },
    
]

const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes: Routes
})

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.APP_NAME}`
    if(to.meta.middleware=="guest"){
        if(store.state.auth.authenticated){
            next({name:"dashboard"})
        }
        next()
    }else{
        if(store.state.auth.authenticated){
            next()
        }else{
            next({name:"login"})
        }
    }
})

export default router