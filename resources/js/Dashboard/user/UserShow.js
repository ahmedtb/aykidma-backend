import React from "react";
import { useParams } from "react-router";
import {Api} from '../utility/Urls'
import { ApiCallHandler } from '../utility/helpers';

export default function UserShow(props) {
    const { id } = useParams()
    const [user, setuser] = React.useState(null)
    async function setup() {
        ApiCallHandler(
            async () => await Api.fetchUser(id),
            setuser,
            'UserShow',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])
    return (
        <div>
            <div>الاسم {user?.name}</div>
            <div>الاسم {user?.phone_number}</div>

            <img src={user?.image} height={'200'} className="rounded mx-auto d-block" alt="صورة ملف المستخدم" />

        </div>
    )
}