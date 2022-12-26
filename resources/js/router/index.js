import * as Vue from 'vue'
import * as VueRouter from 'vue-router'
import store from '@/store'
import { getRoles } from '@/helpers/auth'



/* Guest Component */
const Login = () => import('@/views/Login.vue' /* webpackChunkName: "resource/js/components/login" */)
const Register = () => import('@/views/Register.vue' /* webpackChunkName: "resource/js/components/register" */)
/* Guest Component */

/* Layouts */
const DahboardLayout = () => import('@/layouts/Dashboard.vue' /* webpackChunkName: "resource/js/components/layouts/dashboard" */)
/* Layouts */

/* Authenticated Component */
const Dashboard = () => import('@/views/Dashboard.vue' /* webpackChunkName: "resource/js/components/dashboard" */)
const CourseCreate = () => import('@/views/courses/Create.vue' /* webpackChunkName: "resource/js/components/coursecreate" */)
const CourseEdit = () => import('@/views/courses/Edit.vue' /* webpackChunkName: "resource/js/components/courseedit" */)
const Users = () => import('@/views/users/Users.vue' /* webpackChunkName: "resource/js/components/users" */)
const Courses = () => import('@/views/courses/Courses.vue' /* webpackChunkName: "resource/js/components/courses" */)
const Employee = () => import('@/views/users/Employee.vue' /* webpackChunkName: "resource/js/components/employee" */)
const ApproveCourses = () => import('@/views/approvals/Courses.vue' /* webpackChunkName: "resource/js/components/approvalcourses" */)
const ApproveCertificates = () => import('@/views/approvals/Certificates.vue' /* webpackChunkName: "resource/js/components/certificates" */)
const EnrolledCourse = () => import('@/views/courses/EnrolledCourse.vue' /* webpackChunkName: "resource/js/components/assignedcourse" */)
/* Authenticated Component */

// const roles = store.getters['auth/user'].roles || []

let routeChildrens;

        routeChildrens = [

          {
            name:"courses-list",
            path: '/courses',
            component: Courses,
            meta:{
                title:`Courses`
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
            name:"courses-edit",
            path: '/courses/:id/edit',
            component: CourseEdit,
            meta:{
                title:`Edit Course`
            },
            props: true,
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
                name:"courses-enrolled",
                path: '/enrolled/courses',
                component: EnrolledCourse,
                meta:{
                    title:`Enrolled Courses`
                }
              },
              {
                name:"approve-courses",
                path: '/approve/courses',
                component: ApproveCourses,
                meta:{
                    title:`Approve Courses`
                }
              },
            {
              name:"employee",
              path: '/user/profile',
              component: Employee,
              meta:{
                  title:`Profile Management`
              }
            },

            {
              name:"approve-certificates",
              path: '/approve/certificates',
              component: ApproveCertificates,
              meta:{
                  title:`Approve Certificates`
              }
            },
            {
                  name:"employee",
                  path: '/user/profile',
                  component: Employee,
                  meta:{
                      title:`Profile Management`
                  }
                },
                {
                    name:"dashboard",
                    path: '/dashboard',
                    component: Dashboard,
                    meta:{
                        title:`Dashboard`
                    }
                },




          ];

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
        children: routeChildrens
       },


]


const router = VueRouter.createRouter({
  history: VueRouter.createWebHistory(),
  routes: Routes,
  linkActiveClass: 'active'

})

router.beforeEach((to, from, next) => {
    document.title = `${to.meta.title} - ${process.env.APP_NAME}`;
    if(to.meta.middleware=="auth"){
        if(store.state.auth.authenticated){
            console.log(store.state.auth.authenticated, to.meta.middleware, 'auth')
            next()
        }else{
            next({name:"login"})
        }
    }
    else if(to.meta.middleware=="guest"){
        if(store.state.auth.authenticated){
            console.log(store.state.auth.authenticated, to.meta.middleware, 'guest')
            next({name:"dashboard"})
        }
        next()
    }
    else{
        next({name:"login"})
    }
})

export default router
