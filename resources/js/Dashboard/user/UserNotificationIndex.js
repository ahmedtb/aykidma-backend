import React from "react";
import {Api} from "../utility/Urls";
import { ApiCallHandler } from "../utility/helpers";
import UserNotificationsTable from "./components/UserNotificationsTable";

export default function UserNotificationsIndex() {
    const [userNotifications, setuserNotifications] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await Api.fetchUserNotifications(['user']),
            setuserNotifications,
            'UserNotificationsIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>
            <UserNotificationsTable notifications={userNotifications}/>
        </div>
    )
}