import React from "react";
import ApiEndpoints from "../utility/ApiEndpoints";
import { ApiCallHandler } from "../utility/helpers";
export default function ApprovedServicesIndex() {
    const [approvedservices, setapprovedservices] = React.useState([])
    async function setup() {
        ApiCallHandler(
            async () => await ApiEndpoints.fetchServices('true', ['ServiceProvider']),
            setapprovedservices,
            'ApprovedServicesIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>

        </div>
    )
}