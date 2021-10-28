import React, { Component } from 'react'
import ReactDOM from 'react-dom'
import { BrowserRouter, Route, Switch } from 'react-router-dom'
import ServicesApproveal from './components/ServicesApproveal'
import SideMenue from './components/SideMenue'

export default function Index() {

    return (
        <BrowserRouter>
            <div className="row">
                <SideMenue />
                <ServicesApproveal />
            </div>

        </BrowserRouter>
    )

}

if (document.getElementById('dashboard'))
    ReactDOM.render(<Index />, document.getElementById('dashboard'))