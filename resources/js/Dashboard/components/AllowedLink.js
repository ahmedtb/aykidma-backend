import React from 'react'
import { Link, matchPath } from 'react-router-dom'

function AllowedLink(props) {
    const to = props.to
    const children = props.children
    const className = props.className
    const target = props.target

    const hide = props.hide

    const allowedRoutes = props.allowedRoutes

    function isPathAllowed(path) {
        if (allowedRoutes.length) {
            for (let i = 0; i < allowedRoutes.length; i++) {
                if (matchPath(path, {
                    path: allowedRoutes[i].path,
                    exact: true,
                }) || matchPath(path.pathname, {
                    path: allowedRoutes[i].path,
                    exact: true,
                })) {
                    return true
                }
            }
            return false
        } else
            return false
    }

    React.useEffect(() => { }, [allowedRoutes])

    return (
        isPathAllowed(to) ?
            <Link target={target} className={className} to={to}>{children}</Link>
            : (hide ? null : <div className={className}>{children}</div>)
    )

}

import { connect } from "react-redux"

const mapStateToProps = state => {
    return {
        allowedRoutes: state.state.allowedRoutes,
    }
}

const mapDispatchToProps = dispatch => {
    return {

    }
}

export default connect(mapStateToProps, mapDispatchToProps)(AllowedLink)