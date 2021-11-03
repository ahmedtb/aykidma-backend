import logError from "./logError"
import axios from "axios"
export default {
    login: '/api/dashboard/loginAdmin',
    fetchAdmin: '/api/dashboard/fetchAdmin',
    logoutAdmin: '/api/dashboard/logoutAdmin',

    approveService: '/api/dashboard/approve/service',
    rejectService: '/api/dashboard/reject/service',
    approveProviderEnrollment: '/api/dashboard/approve/providerEnrollment/:id',
    activateProvider: '/api/dashboard/activateProvider/:id',
    deleteReview: '/api/dashboard/order/deleteReview',

    fetchCategories: async () => { return await axios.get('/api/dashboard/category') },
    destroyCategory: async (id) => { return await axios.delete('/api/dashboard/category/' + id) },
    createCategory: async (name, image, parent_id) => { return await axios.post('/api/dashboard/category', { name: name, image: image, parent_id: parent_id }) },
    editcategory: async (id, name, image, parent_id) => {
        return await axios.put('/api/dashboard/category/' + id, {
            name: name,
            image: image,
            parent_id: parent_id,
        })
    },
}
