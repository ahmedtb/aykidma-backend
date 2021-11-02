import React from 'react'
import { Route, Switch } from 'react-router-dom'
import NotFound from '../NotFound'


function AllowedRoutes(props) {

    const [allowedRoutes, setallowedRoutes] = React.useState([])
    React.useEffect(() => {
        // console.log('AllowedRoutes', props.allowedRoutes)
        // console.log('AllowedRoutes', props.user)

        setallowedRoutes(props.allowedRoutes)
    }, [props.allowedRoutes])

    // React.useEffect(() => {
        // console.log('allowedRoutes', allowedRoutes)
    // }, [allowedRoutes])

    return <Switch>
        {
            allowedRoutes.map((route, index) => {
                return <Route
                    key={index}
                    exact={route.exact}
                    title={route.title}
                    path={route.path}
                    component={route.component}
                />
            })
        }
        <Route component={NotFound} />

    </Switch>

}

import { refreshUser } from '../redux/stateActions'
import { connect } from "react-redux"

const mapStateToProps = state => {
    return {
        user: state.state.user,
        allowedRoutes: state.state.allowedRoutes,

    }
}

const mapDispatchToProps = dispatch => {
    return {
        refreshUser: (user) => dispatch(refreshUser(user)),
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(AllowedRoutes)