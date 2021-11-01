
export const refreshUser = (user) => {
    return {
        type: 'refresh-user',
        user: user
    }
}

export const setAllowedRoutes = (allowedRoutes) => {
    return {
        type: 'setAllowedRoutes',
        allowedRoutes: allowedRoutes
    }
}
