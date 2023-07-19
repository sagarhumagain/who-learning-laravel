import * as VueRouter from 'vue-router'



/* Guest Component */
/* Guest Component */

/* Layouts */
import NotificationDetails from '@/components/NotificationDetails.vue'
import CourseUserReport from '@/components/Pages/CourseUserReport.vue'
import Designation from '@/components/Pages/Designation.vue'
import DashboardLayout from '@/layouts/Dashboard.vue'
import Dashboard from '@/views/Dashboard.vue'
import Sync from '@/views/Sync.vue'
import ApproveCertificates from '@/views/approvals/Certificates.vue'
import CourseApproveEdit from '@/views/approvals/CourseApproveEdit.vue'
import ApproveCourses from '@/views/approvals/Courses.vue'
import Courses from '@/views/courses/Courses.vue'
import CourseCreate from '@/views/courses/Create.vue'
import CourseEdit from '@/views/courses/Edit.vue'
import EnrolledCourse from '@/views/courses/EnrolledCourse.vue'
import Employee from '@/views/users/Employee.vue'
import Users from '@/views/users/Users.vue'
/* Layouts */





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
                {
                    name: 'notification-details',
                    path: '/notification-details/:title/:excerpt/:link',
                    component: NotificationDetails,
                    meta: {
                      title: 'Notification Details'
                    },
                    props: true
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
        component:DashboardLayout,
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

const excludedRoutes = ['/login', '/register', '/password/reset', '/password/reset/{token}' ];


function redirectToLogin() {
  window.location.href = '/login';
}

router.beforeEach(async (to, from, next) => {
    const isExcluded = excludedRoutes.some((route) => to.fullPath.startsWith(route));

    if (isExcluded) {
      next();
      return;
    }
    try {
        const response = await axios.get('/api/session-status');
        if (response.data.status === 'logged in') {
        next();
        } else {
        redirectToLogin();
        }
    } catch (error) {
        redirectToLogin();
    }
});


export default router
