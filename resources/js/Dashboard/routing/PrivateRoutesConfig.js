import Routes from '../utility/Routes'
import Roles from './Roles'

import HomeScreen from '../HomeScreen'
import LoginPageScreen from '../LoginPageScreen'
import ServicesApprovealScreen from '../ServicesApprovealScreen'

import CategoriesScreen from '../CategoriesScreen'
import ServiceProviderShow from '../serviceprovider/ServiceProviderShow'
import ApprovedServicesIndex from '../services/ApprovedServicesIndex'
import { NotApprovedServicesIndex } from '../services/NotApprovedServicesIndex'
import NewOrdersIndex from '../orders/NewOrdersIndex'
import ResumedOrdersIndex from '../orders/ResumedOrdersIndex'
import DoneOrdersIndex from '../orders/DoneOrdersIndex'
import ServiceShow from '../services/ServiceShow'

export default [
    {
        component: HomeScreen,
        path: Routes.dashboard,
        title: 'dashboard',
        permission: [
            // Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: LoginPageScreen,
        path: Routes.LoginPageScreen,
        title: 'LoginPageScreen',
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
    {
        component: ServiceProviderShow,
        path: Routes.ServiceProviderShow(),
        title: 'ServiceProviderShow',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    
    {
        component: ApprovedServicesIndex,
        path: Routes.approvedServicesIndex(),
        title: 'ApprovedServicesIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    
    {
        component: NotApprovedServicesIndex,
        path: Routes.notApprovedServicesIndex(),
        title: 'NotApprovedServicesIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    
    {
        component: NewOrdersIndex,
        path: Routes.newOrders(),
        title: 'NewOrdersIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: ResumedOrdersIndex,
        path: Routes.resumedOrders(),
        title: 'ResumedOrdersIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: DoneOrdersIndex,
        path: Routes.doneOrders(),
        title: 'DoneOrdersIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: ServiceShow,
        path: Routes.showService(),
        title: 'ServiceShow',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
]