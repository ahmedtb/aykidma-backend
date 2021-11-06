import React from "react";
import ApiEndpoints from "../utility/ApiEndpoints";
import { ApiCallHandler } from "../utility/helpers";
import ReportsTable from "./components/ReportsTable";

export default function ReportsIndex() {
    const [reports, setreports] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await ApiEndpoints.fetchReports(),
            setreports,
            'ReportsIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>
            <ReportsTable services={reports}/>
        </div>
    )
}