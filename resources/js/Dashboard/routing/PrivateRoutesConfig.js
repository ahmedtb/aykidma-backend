import Routes from '../utility/Routes'
import Roles from './Roles'

import Home from '../Home'
import LoginPage from '../LoginPage'
import ServicesApprovealScreen from '../ServicesApprovealScreen'

import CategoriesScreen from '../CategoriesScreen'

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
        component: ServicesApprovealScreen,
        path: Routes.ServicesApprovealScreen,
        title: 'ServicesApprovealScreen',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: CategoriesScreen,
        path: Routes.CategoriesScreen,
        title: 'CategoriesScreen',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
]