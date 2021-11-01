import { combineReducers } from 'redux';

const INITIAL_STATE = {
    user: null,
    allowedRoutes: []
};

import PrivateRoutesConfig from '../routing/PrivateRoutesConfig'
import { intersection } from 'lodash';

const calculateAllowedRoutes = (user) => {
    
    const roles = user?.role?.length ? user.role : []
    return PrivateRoutesConfig.filter(
        ({ permission }) => {
            if (!permission) return true;
            else if (!(Array.isArray(permission) && permission.length)) return true;
            else return intersection(permission, roles).length;
        })
}

const stateReducer = (state = INITIAL_STATE, action) => {
    switch (action.type) {
        case 'refresh-user':
            return {
                ...state,
                user: action.user,
                allowedRoutes: calculateAllowedRoutes(action.user)
            };
        default:
            return state
    }
};

export default combineReducers({
    state: stateReducer
});