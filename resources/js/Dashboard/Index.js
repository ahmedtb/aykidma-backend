import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'

import AllowedRoutes from './routing/AllowedRoutes'
import store from './redux/store';
import { Provider } from 'react-redux';
import TopMenue from './components/TopMenue'

export default function Index() {

    return (
        <BrowserRouter>
            <Provider store={store}>

                <TopMenue />
                <div class="container-fluid">

                    <AllowedRoutes />
                </div>

            </Provider>

        </BrowserRouter>
    )

}

if (document.getElementById('dashboard'))
    ReactDOM.render(<Index />, document.getElementById('dashboard'))