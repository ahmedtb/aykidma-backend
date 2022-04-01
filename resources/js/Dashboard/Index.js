import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'

import AllowedRoutes from './routing/AllowedRoutes'
import store from './redux/store';
import { Provider } from 'react-redux';
import TopMenue from './components/TopMenue'
import SideMenue from './components/SideMenue';
import { Row, Col } from 'react-bootstrap'

export default function Index() {

    return (
        <BrowserRouter>
            <Provider store={store}>

                <TopMenue />
                <div className="container-fluid">
                    <Row>
                        <SideMenue />
                        <Col xs={9}>
                            <AllowedRoutes />
                        </Col>
                    </Row>
                </div>

            </Provider>

        </BrowserRouter>
    )

}

if (document.getElementById('dashboard'))
    ReactDOM.render(<Index />, document.getElementById('dashboard'))