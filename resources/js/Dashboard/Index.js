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

                    <AllowedRoutes />
                    {/* <Route exact={true} title={'Home'} path={Routes.dashboard} component={Home} />
                    <Route exact={true} title={'ServicesApproveal'} path={Routes.servicesApproveal} component={ServicesApproveal} />
                <Route exact={true} title={'LoginPage'} path={Routes.loginPage} component={LoginPage} /> */}

                    {/* <Route component={NotFound} /> */}


            </Provider>

        </BrowserRouter>
    )

}

if (document.getElementById('dashboard'))
    ReactDOM.render(<Index />, document.getElementById('dashboard'))