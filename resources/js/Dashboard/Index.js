import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import SideMenue from './components/SideMenue'
// import { Provider } from 'react-redux';
// import store from './redux/store';

// import AllowedRoutes from './routing/AllowedRoutes'

function Index() {

    return (
        <BrowserRouter>

            {/* <Provider store={store}> */}
                <SideMenue />
                {/* <main className="container-fluid"> */}
                    {/* <AllowedRoutes /> */}
                {/* </main> */}
            {/* </Provider> */}

        </BrowserRouter>
    )

}
if (document.getElementById('dashboard'))
    ReactDOM.render(<Index />, document.getElementById('dashboard'))