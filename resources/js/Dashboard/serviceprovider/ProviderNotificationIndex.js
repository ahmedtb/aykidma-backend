import React from "react";
import {Api} from "../utility/Urls";
import { ApiCallHandler } from "../utility/helpers";
import ProviderNotificationsTable from "./components/ProviderNotificationsTable";

export default function ProviderNotificationsIndex() {
    const [providerNotifications, setproviderNotifications] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await Api.fetchProviderNotifications(),
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