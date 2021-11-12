import React from "react";
import {Api} from "../utility/Urls";
import { ApiCallHandler } from "../utility/helpers";
import ServiceProvidersTable from './components/ServiceProvidersTable'

export default function ServiceProvidersIndex(props) {
    const [providers, setproviders] = React.useState([])
    async function setup() {
        ApiCallHandler(async () => await Api.fetchProviders(null, ['user']),
            setproviders,
            'ServiceProvidersIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>
            <ServiceProvidersTable providers={providers} />
        </div>
    )
}