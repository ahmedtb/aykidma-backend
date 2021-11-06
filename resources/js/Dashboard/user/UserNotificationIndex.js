import React from "react";
import ApiEndpoints from "../utility/ApiEndpoints";
import { ApiCallHandler } from "../utility/helpers";
import UserNotificationsTable from "./components/UserNotificationsTable";

export default function UserNotificationsIndex() {
    const [userNotifications, setuserNotifications] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await ApiEndpoints.fetchUserNotifications(),
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
            <UserNotificationsTable services={userNotifications}/>
        </div>
    )
}