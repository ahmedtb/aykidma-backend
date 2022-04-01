import { logError } from './helpers'
import axios from "axios"

export const Routes = {
    dashboard: () => '/dashboard',

    LoginPageScreen: () => '/dashboard/LoginPageScreen',
    CategoriesScreen: () => '/dashboard/CategoriesScreen',

    serviceProvidersIndex: () => '/dashboard/providers',
    providerEnrollmentRequestsIndex: () => '/dashboard/providerEnrollmentRequests',

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


export const Api = {
    login: async (phone_number, password) => await axios.post('/dashboardAPI/loginAdmin', { phone_number: phone_number, password: password }),
    fetchAdmin: async () => await axios.get('/dashboardAPI/fetchAdmin'),
    logoutAdmin: '/dashboardAPI/logoutAdmin',
    home: async () => await axios.get('/dashboardAPI/home'),

    approveService: async (id) => await axios.put('/dashboardAPI/approve/service', { service_id: id }),
    rejectService: async (id) => await axios.delete('/dashboardAPI/reject/service', { params: { service_id: id } }),
    approveProviderEnrollment: async (id) => id ? await axios.get(`/dashboardAPI/approve/providerEnrollment/${id}`) : await axios.get('/dashboardAPI/approve/providerEnrollment/:id'),
    rejectProviderEnrollment: async (id) => id ? await axios.delete(`/dashboardAPI/reject/providerEnrollment/${id}`) : await axios.delete('/dashboardAPI/reject/providerEnrollment/:id'),

    activateProvider: '/dashboardAPI/activateProvider/:id',
    deleteReview: '/dashboardAPI/order/deleteReview',

    fetchCategories: async () => { return await axios.get('/dashboardAPI/category') },
    destroyCategory: async (id) => { return await axios.delete('/dashboardAPI/category/' + id) },
    createCategory: async (name, image, parent_id) => { return await axios.post('/dashboardAPI/category', { name: name, image: image, parent_id: parent_id }) },
    editcategory: async (id, name, image, parent_id) => {
        return await axios.put('/dashboardAPI/category/' + id, {
            name: name,
            image: image,
            parent_id: parent_id,
        })
    },
    fetchProviders: async (activated = null, withs = []) => await axios.get('/dashboardAPI/providers/', {
        params: {
            activated: activated ? activated : undefined,
            with: withs,
        }
    }),
    fetchProvider: async (id) => await axios.get('/dashboardAPI/providers/' + id),
    fetchProviderEnrollmentRequests: async () => await axios.get('/dashboardAPI/providerEnrollmentRequests'),

    fetchOrders: async (status = null, withs = []) => await axios.get('/dashboardAPI/orders/', {
        params: {
            status: status ? status : undefined,
            with: withs,
        }
    }),

    fetchServices: async (approved = null, withs = []) => await axios.get('/dashboardAPI/services/', {
        params: {
            approved: approved ? approved : undefined,
            with: withs,
        }
    }),
    fetchService: async (id, withs = []) => await axios.get('/dashboardAPI/services/' + id, { params: { with: withs, } }),

    fetchUsers: async (withs = []) => await axios.get('/dashboardAPI/users', { params: { with: withs } }),
    fetchUser: async (id, withs = []) => await axios.get('/dashboardAPI/users/' + id, { params: { with: withs } }),

    fetchReports: async (withs = []) => await axios.get('/dashboardAPI/reports', { params: { with: withs } }),
    fetchReport: async (id, withs = []) => await axios.get('/dashboardAPI/reports/' + id, { params: { with: withs } }),

    fetchUserNotifications: async (withs = []) => await axios.get('/dashboardAPI/userNotifications', { params: { with: withs } }),

    fetchProviderNotifications: async (withs = []) => await axios.get('/dashboardAPI/providerNotifications', { params: { with: withs } }),

    fetchReviews: async (withs = []) => await axios.get('/dashboardAPI/reviews', { params: { with: withs } }),
}
