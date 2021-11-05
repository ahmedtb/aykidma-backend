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
}
export default Routes;

// export function currentRoute(){
//     return Object.keys(Routes).find(key => Routes[key] === window.location.pathname);
// }