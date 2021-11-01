import { createStore } from 'redux';

import stateReducer from './stateReducer';


const store = createStore(stateReducer);


export default store;