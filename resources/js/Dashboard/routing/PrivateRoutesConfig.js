import Routes from '../utility/Routes'
import Roles from './Roles'

import Home from '../Home'
import LoginPage from '../LoginPage'
import ServicesApproveal from '../ServicesApproveal'


export default [
    {
        component: Home,
        path: Routes.dashboard,
        title: 'dashboard',
        permission: [
            // Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: LoginPage,
        path: Routes.loginPage,
        title: 'LoginPage',
        permission: [
            // Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: ServicesApproveal,
        path: Routes.servicesApproveal,
        title: 'ServicesApproveal',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
]