import logError from "./logError"
import axios from "axios"
export default {
    login: '/dashboard/loginAdmin',
    fetchAdmin: '/dashboard/fetchAdmin',
    logoutAdmin: '/dashboard/logoutAdmin',

    approveService: '/dashboard/approve/service',
    rejectService: '/dashboard/reject/service',
    approveProviderEnrollment: '/dashboard/approve/providerEnrollment/:id',
    activateProvider: '/dashboard/activateProvider/:id',
    deleteReview: '/dashboard/order/deleteReview',

    fetchCategories: async () => { return await axios.get('/dashboard/category') },
    destroyCategory: async (id) => { return await axios.delete('/dashboard/category/' + id) },
    createCategory: async (name, image, parent_id) => { return await axios.post('/dashboard/category', { name: name, image: image, parent_id: parent_id }) },
    editcategory: async (id, name, image, parent_id) => {
        return await axios.put('/dashboard/category/' + id, {
            name: name,
            image: image,
            parent_id: parent_id,
        })
    },

    fetchProvider: async (id) => await axios.get('/dashboard/providers/' + id),
}
