import React from "react";
import ProviderEnrollmentRequestsTable from "../components/ProviderEnrollmentRequestsTable";
import { ApiCallHandler } from '../utility/helpers'
import { Api, Routes } from '../utility/Urls'

export default function ProviderEnrollmentRequestIndex(props) {
    const [providerEnrollmentRequests, setProviderEnrollmentRequests] = React.useState()

    function fetchRequests(){
        ApiCallHandler(
            async () => await Api.fetchProviderEnrollmentRequests(),
            setProviderEnrollmentRequests,
            'ProviderEnrollmentRequestIndex',
            true
        )
    }

    React.useEffect(() => {
        fetchRequests()
    }, [])

    function accept(id) {
        ApiCallHandler(
            async () => await Api.approveProviderEnrollment(id),
            fetchRequests,
            'ProviderEnrollmentRequestIndex accept',
            true
        )
    }

    function reject(id) {
        ApiCallHandler(
            async () => await Api.rejectProviderEnrollment(id),
            fetchRequests,
            'ProviderEnrollmentRequestIndex reject',
            true
        )
    }

    return <ProviderEnrollmentRequestsTable requests={providerEnrollmentRequests} accept={accept} reject={reject} />
}