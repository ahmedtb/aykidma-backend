import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import ServicesApproveal from './ServicesApproveal'
import SideMenue from './components/SideMenue'
import Routes from './utility/Routes'
import Home from './Home'
import NotFound from './NotFound'

export default function Index() {

    return (
        <BrowserRouter>
            <div className="row">
                <SideMenue />

                <Switch>
                    <Route exact={true} title={'Home'} path={Routes.dashboard} component={Home} />
                    <Route exact={true} title={'ServicesApproveal'} path={Routes.servicesApproveal} component={ServicesApproveal} />

                    <Route component={NotFound} />

                </Switch>
            </div>

        </BrowserRouter>
    )

}

if (document.getElementById('dashboard'))
    ReactDOM.render(<Index />, document.getElementById('dashboard'))