import React from "react";
import {Api} from "../utility/Urls";
import { ApiCallHandler } from "../utility/helpers";
import ServicesTable from "./components/ServicesTable";
export default function ApprovedServicesIndex() {
    const [approvedservices, setapprovedservices] = React.useState([])
    async function setup() {
        ApiCallHandler(
            async () => await Api.fetchServices('true', ['ServiceProvider','category']),
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
            <ServicesTable services={approvedservices}/>
        </div>
    )
}