import dashboard from './components/dashboard.vue'
import list_appointments from './pages/appointments/list_appointments.vue'
import list_users from './pages/users/list_users.vue'
import updatesetting from './pages/settings/updatesetting.vue'
import updateprofile from './pages/profiles/updateprofile.vue'

export default[
    {
        path:'/admin/dashboard',
        name:'admin.dashboard',
        component:dashboard
    },
    {
        path:'/admin/appointment',
        name:'admin.appointment',
        component:list_appointments
    },
    {
        path:'/admin/users',
        name:'admin.users',
        component:list_users
    },
    {
        path:'/admin/profile',
        name:'admin.profile',
        component:updateprofile
    },
    {
        path:'/admin/setting',
        name:'admin.setting',
        component:updatesetting
    },
    // {
    //     path:'/admin/logout ',
    //     name:'admin.logout',
    //     component:logout
    // }
]