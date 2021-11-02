export default {
    login: '/api/dashboard/loginAdmin',
    fetchAdmin: '/api/dashboard/fetchAdmin',
    logoutAdmin: '/api/dashboard/logoutAdmin',

    approveService: '/api/dashboard/approve/service',
    rejectService: '/api/dashboard/reject/service',
    approveProviderEnrollment: '/api/dashboard/approve/providerEnrollment/:id',
    activateProvider: '/api/dashboard/activateProvider/:id',
    deleteReview: '/api/dashboard/order/deleteReview',

    fetchCategories: '/api/dashboard/category',
    destroyCategory: '/api/dashboard/category/:id',
    createCategory: '/api/dashboard/category',
    editcategory: '/api/dashboard/category/:id',
}
