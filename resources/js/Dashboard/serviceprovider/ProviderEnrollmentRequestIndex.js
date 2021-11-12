import React from "react";
import ProviderEnrollmentRequestsTable from "../components/ProviderEnrollmentRequestsTable";
import { ApiCallHandler } from '../utility/helpers'
import { Api, Routes } from '../utility/Urls'

export default function ProviderEnrollmentRequestIndex(props) {
    const [providerEnrollmentRequests, setProviderEnrollmentRequests] = React.useState()

    React.useEffect(() => {
        ApiCallHandler(
            async () => await Api.fetchProviderEnrollmentRequests(),
            setProviderEnrollmentRequests,
            'ProviderEnrollmentRequestIndex',
            true
        )
    }, [])
    
    return <ProviderEnrollmentRequestsTable requests={providerEnrollmentRequests} />
}