const Routes = {
    dashboard: '/dashboard',
    ServicesApprovealScreen: '/dashboard/ServicesApprovealScreen',
    LoginPageScreen: '/dashboard/LoginPageScreen',
    CategoriesScreen: '/dashboard/CategoriesScreen',
    ServiceProviderShow: (id) => id ? '/dashboard/ServiceProviderShow/' + id : '/dashboard/ServiceProviderShow/:id',

    serviceProvidersIndex: () => '/dashboard/providers',
    notApprovedServicesIndex: () => '/dashboard/notApprovedServices',
    approvedServicesIndex: () => '/dashboard/approvedServicesIndex',

    newOrders: () => '/dashboard/neworders/',
    resumedOrders: () => '/dashboard/resumedorders/',
    doneOrders: () => '/dashboard/doneorders/',

    showService: (id) => id ? '/dashboard/services/' + id : '/dashboard/services/:id',

}
export default Routes;

// export function currentRoute(){
//     return Object.keys(Routes).find(key => Routes[key] === window.location.pathname);
// }