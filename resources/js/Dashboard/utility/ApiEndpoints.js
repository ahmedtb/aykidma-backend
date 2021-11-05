import { logError } from './/helpers'
import axios from "axios"
export default {
    login: '/dashboardAPI/loginAdmin',
    fetchAdmin: '/dashboardAPI/fetchAdmin',
    logoutAdmin: '/dashboardAPI/logoutAdmin',

    approveService: '/dashboardAPI/approve/service',
    rejectService: '/dashboardAPI/reject/service',
    approveProviderEnrollment: '/dashboardAPI/approve/providerEnrollment/:id',
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

    fetchProvider: async (id) => await axios.get('/dashboardAPI/providers/' + id),

    fetchOrders: async (status = null, withUser = false, withProvider = false, withService = false) => await axios.get('/dashboardAPI/orders/', {
        params: {
            status: status ? status : undefined,
            user: withUser ? true : undefined,
            provider: withProvider ? true : undefined,
            service: withService ? true : undefined,
        }
    }),

    fetchService: async(id, withs = [] ) => await axios.get('/dashboardAPI/services/' + id, {
        params: {
            with: withs,
        }
    })

}
