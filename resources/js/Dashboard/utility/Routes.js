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
    reviewsIndex: () => '/dashboard/reviews',
    showOrder: (id) => id ? '/dashboard/orders/' + id : '/dashboard/orders/:id',

    showService: (id) => id ? '/dashboard/services/' + id : '/dashboard/services/:id',
    showProvider: (id) => id ? '/dashboard/providers/' + id : '/dashboard/providers/:id',

    usersIndex: () => '/dashboard/users',
    showUser: (id) => id ? '/dashboard/users/' + id : '/dashboard/users/:id',

    reportsIndex: () => '/dashboard/reports',
    showReport: (id) => id ? '/dashboard/reports/' + id : '/dashboard/reports/:id',

    userNotificationsIndex: () => '/dashboard/userNotifications',
    providerNotificationsIndex: () => '/dashboard/providerNotifications',

}
export default Routes;