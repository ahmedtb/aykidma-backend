import React from 'react'
import axios from 'axios';
import { logError, ApiCallHandler } from './utility/helpers'
import { Api } from './utility/Urls';
import { Redirect } from 'react-router-dom'
import { Routes } from './utility/Urls';

function LoginPageScreen(props) {
    const [phone_number, setphone_number] = React.useState('')
    const [password, setpassword] = React.useState('')


    async function handleLogin(phone_number, password) {
        // try {
        //     await axios.get('/sanctum/csrf-cookie')
        //     const response = await axios.post(Api.login, { phone_number: phone_number, password: password })
        //     props.refreshUser(response.data)
        //     setredirect(Routes.dashboard())

        // } catch (error) {
        //     logError(error)
        // }

        ApiCallHandler(
            async () => await Api.login(phone_number, password),
            (data) => {
                props.refreshUser(data);
                setredirect(Routes.dashboard())
            },
            'LoginPageScreen handleLogin'
        )
    }

    React.useEffect(() => {
        if (props.user) {
            setredirect(Routes.dashboard())
        }
    }, [props.user])

    const [redirect, setredirect] = React.useState(null);

    if (redirect) {
        return <Redirect to={redirect} />
    }

    return (
        <div className='col-5 mx-auto'>
            <div className='card'>
                <h3 className='card-header text-center'>
                    تسجيل الدخول
                </h3>
                <div className='card-body'>
                    <label>رقم الهاتف</label>
                    <input type='phone_number' className='form-control' onChange={e => setphone_number(e.target.value)} />
                    <label>كلمة المرور</label>
                    <input type='password' className='form-control' onChange={e => setpassword(e.target.value)} />

                    <button type="button" className="btn btn-success" onClick={() => handleLogin(phone_number, password)}>دخول</button>

                </div>
            </div>

        </div>
    )
}


import { refreshUser } from './redux/stateActions'
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

export default connect(mapStateToProps, mapDispatchToProps)(LoginPageScreen)