import React from "react";
import ApiEndpoints from "../utility/ApiEndpoints";
import { ApiCallHandler } from "../utility/helpers";
import ProviderNotificationsTable from "./components/ProviderNotificationsTable";

export default function ProviderNotificationsIndex() {
    const [providerNotifications, setproviderNotifications] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await ApiEndpoints.fetchProviderNotifications(),
            setproviderNotifications,
            'ProviderNotificationsIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>
            <ProviderNotificationsTable services={providerNotifications}/>
        </div>
    )
}