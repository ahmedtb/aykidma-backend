import React from "react";
import {Api} from "../utility/Urls";
import { ApiCallHandler } from "../utility/helpers";
import ReportsTable from "../components/ReportsTable";

export default function ReportsIndex() {
    const [reports, setreports] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await Api.fetchReports(),
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