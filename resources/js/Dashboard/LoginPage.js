import React from 'react'
import axios from 'axios';
import logError from './utility/logError'
import ApiEndpoints from './utility/ApiEndpoints';
import {Redirect} from 'react-router-dom'
import Routes from './utility/Routes';

export default function LoginPage(props) {
    const [username, setusername] = React.useState('')
    const [password, setpassword] = React.useState('')
    const [type, settype] = React.useState('admin')


    async function handleLogin(username, password) {
        try {
            await axios.get('/sanctum/csrf-cookie')
            const response = await axios.post(ApiEndpoints.login, { username: username, password: password })
            console.log('User signed in!', (response.data));
            props.refreshUser(response.data)
            setredirect(Routes.dashboard)

        } catch (error) {
            logError(error)
        }
    }
    
    React.useEffect(() => {
        if(props.user){
            setredirect(Routes.dashboard)  
        }
    }, [props.user])

    const [redirect, setredirect] = React.useState(null);

    if(redirect){
        return <Redirect to={redirect}/>
    }

    return (
        <div className='col-5 mx-auto'>
            <div className='card'>
                <h3 className='card-header text-center'>
                    تسجيل الدخول
                </h3>
                <div className='card-body'>
                    <label>اسم المستخدم</label>
                    <input type='username' className='form-control' onChange={e => setusername(e.target.value)} />
                    <label>كلمة المرور</label>
                    <input type='password' className='form-control' onChange={e => setpassword(e.target.value)} />
                    <label>نوع المستخدم</label>
                    <select onChange={e => settype(e.target.value)} className='form-control'>
                        <option value='admin'>admin</option>
                        <option value='employee'>موظف</option>
                        <option value='individual'>مستهدف</option>     
                        {/* <option value='coach'>coach</option> */}
                    </select>
                    <button type="button" className="btn btn-success" onClick={() => handleLogin(username, password)}>دخول</button>

                </div>
            </div>

        </div>
    )
}