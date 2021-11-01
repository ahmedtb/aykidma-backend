const Routes = {
    dashboard: '/dashboard',
    servicesApproveal: '/dashboard/servicesApproveal',

}
export default Routes;

export function currentRoute(){
    return Object.keys(Routes).find(key => Routes[key] === window.location.pathname);
}