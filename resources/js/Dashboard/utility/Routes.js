const Routes = {
    dashboard: '/dashboard',

    LoginPageScreen: '/dashboard/LoginPageScreen',
    CategoriesScreen: '/dashboard/CategoriesScreen',

    serviceProvidersIndex: () => '/dashboard/providers',
    notApprovedServicesIndex: () => '/dashboard/notApprovedServices',
    approvedServicesIndex: () => '/dashboard/approvedServicesIndex',

    newOrders: () => '/dashboard/neworders/',
    resumedOrders: () => '/dashboard/resumedorders/',
    doneOrders: () => '/dashboard/doneorders/',

    showService: (id) => id ? '/dashboard/services/' + id : '/dashboard/services/:id',
    showProvider: (id) => id ? '/dashboard/providers/' + id : '/dashboard/providers/:id',
    
    usersIndex: () => '/dashboard/users',
    showUser: (id) => id ? '/dashboard/users/' + id : '/dashboard/users/:id',
       
    reportsIndex: () => '/dashboard/reports',
    showReport: (id) => id ? '/dashboard/reports/' + id : '/dashboard/reports/:id',

    userNotificationsIndex: () => '/dashboard/userNotifications',
}
export default Routes;