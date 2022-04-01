import { Routes } from '../utility/Urls'
import Roles from './Roles'

import HomeScreen from '../HomeScreen'
import LoginPageScreen from '../LoginPageScreen'

import CategoriesScreen from '../CategoriesScreen'

import ServiceProviderShow from '../serviceprovider/ServiceProviderShow'
import ServiceProvidersIndex from '../serviceProvider/ServiceProvidersIndex'
import providerEnrollmentRequestsIndex from '../serviceProvider/ProviderEnrollmentRequestIndex'

import ApprovedServicesIndex from '../services/ApprovedServicesIndex'
import NotApprovedServicesIndex from '../services/NotApprovedServicesIndex'
import NewOrdersIndex from '../orders/NewOrdersIndex'
import ResumedOrdersIndex from '../orders/ResumedOrdersIndex'
import DoneOrdersIndex from '../orders/DoneOrdersIndex'
import ServiceShow from '../services/ServiceShow'
import UsersIndex from '../user/UsersIndex'
import UserShow from '../user/UserShow'
import UserNotificationsIndex from '../user/UserNotificationIndex'
import ProviderNotificationsIndex from '../serviceProvider/ProviderNotificationIndex'
import ReviewsIndex from '../orders/ReviewIndex'
import OrderShow from '../orders/OrderShow'
import ReportsIndex from '../report/ReportsIndex'
import ReportShow from '../report/ReportShow'

export default [
    {
        component: HomeScreen,
        path: Routes.dashboard(),
        title: 'dashboard',
        permission: [
            // Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: LoginPageScreen,
        path: Routes.LoginPageScreen(),
        title: 'LoginPageScreen',
        permission: [
            // Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: CategoriesScreen,
        path: Routes.CategoriesScreen(),
        title: 'CategoriesScreen',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: ServiceProviderShow,
        path: Routes.showProvider(),
        title: 'ServiceProviderShow',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: providerEnrollmentRequestsIndex,
        path: Routes.providerEnrollmentRequestsIndex(),
        title: 'providerEnrollmentRequestsIndex',
        permission: [
            Roles.ADMIN
        ],
        exact: true
    },
    {
        component: ServiceProvidersIndex,
        path: Routes.serviceProvidersIndex(),
        title: 'ServiceProvidersIndex',
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
        component: ReviewsIndex,
        path: Routes.reviewsIndex(),
        title: 'ReviewsIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: OrderShow,
        path: Routes.showOrder(),
        title: 'OrderShow',
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

    {
        component: UsersIndex,
        path: Routes.usersIndex(),
        title: 'UsersIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },

    {
        component: UserShow,
        path: Routes.showUser(),
        title: 'UserShow',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },

    {
        component: ReportsIndex,
        path: Routes.reportsIndex(),
        title: 'ReportsIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },

    {
        component: ReportShow,
        path: Routes.showReport(),
        title: 'ReportShow',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: UserNotificationsIndex,
        path: Routes.userNotificationsIndex(),
        title: 'UserNotificationsIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
    {
        component: ProviderNotificationsIndex,
        path: Routes.providerNotificationsIndex(),
        title: 'ProviderNotificationsIndex',
        permission: [
            Roles.ADMIN,
        ],
        exact: true,
    },
]