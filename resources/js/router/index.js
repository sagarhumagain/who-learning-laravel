import * as VueRouter from 'vue-router'



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
const CourseApproveEdit = () => import('@/views/approvals/CourseApproveEdit.vue' /* webpackChunkName: "resource/js/components/courseapproveedit" */)
const Users = () => import('@/views/users/Users.vue' /* webpackChunkName: "resource/js/components/users" */)
const Courses = () => import('@/views/courses/Courses.vue' /* webpackChunkName: "resource/js/components/courses" */)
const Employee = () => import('@/views/users/Employee.vue' /* webpackChunkName: "resource/js/components/employee" */)
const Designation = () => import('@/components/Pages/Designation.vue' /* webpackChunkName: "resource/js/components/designation" */)
const ApproveCourses = () => import('@/views/approvals/Courses.vue' /* webpackChunkName: "resource/js/components/approvalcourses" */)
const ApproveCertificates = () => import('@/views/approvals/Certificates.vue' /* webpackChunkName: "resource/js/components/certificates" */)
const EnrolledCourse = () => import('@/views/courses/EnrolledCourse.vue' /* webpackChunkName: "resource/js/components/assignedcourse" */)
const Sync = () => import('@/views/Sync.vue' /* webpackChunkName: "resource/js/components/sync" */)
const CourseUserReport = () => import('@/components/Pages/CourseUserReport.vue' /* webpackChunkName: "resource/js/components/CourseUserReport" */)



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
            name:"course-user-report",
            path: '/course-user-report',
            component: CourseUserReport,
            meta:{
                title:`Course User Report`
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
                name:"approve-certificate",
                path: '/approve/certificate/user_id/:user_id/course_id/:course_id',
                component: CourseApproveEdit,
                meta:{
                    title:`Update Course`
                },
                props: true,
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
                {
                    name:"designation",
                    path: '/designations',
                    component: Designation,
                    meta:{
                        title:`Designation`
                    }
                },





          ];

const Routes = [
    // {
    //     name:"login",
    //     path:"/login",
    //     component:Login,
    //     meta:{
    //         middleware:"guest",
    //         title:`Login`
    //     }
    // },
    // {
    //     name:"register",
    //     path:"/register",
    //     component:Register,
    //     meta:{
    //         middleware:"guest",
    //         title:`Register`
    //     }
    // },
    {
        path: '/data-sync',
        name: "sync",
        component: Sync,
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

// router.beforeEach((to, from, next) => {
//     document.title = `${to.meta.title} - ${process.env.APP_NAME}`;
//     if(to.meta.middleware=="auth"){
//         if(store.state.auth.authenticated){
//             console.log(store.state.auth.authenticated, to.meta.middleware, 'auth')
//             next()
//         }else{
//             next({name:"login"})
//         }
//     }
//     else if(to.meta.middleware=="guest"){
//         if(store.state.auth.authenticated){
//             console.log(store.state.auth.authenticated, to.meta.middleware, 'guest')
//             next({name:"dashboard"})
//         }
//         next()
//     }
//     else{
//         next({name:"login"})
//     }
// })

export default router
