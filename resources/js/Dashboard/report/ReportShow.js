import React from "react";
import { useParams } from "react-router";
import {Api} from '../utility/Urls'
import { ApiCallHandler } from '../utility/helpers';

export default function ReportShow(props) {
    const { id } = useParams()
    const [report, setreport] = React.useState(null)
    async function setup() {
        ApiCallHandler(
            async () => await Api.fetchReport(id),
            setreport,
            'ReportShow',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])
    return (
        <div>
            <div>الاسم {report?.name}</div>
            <div>الاسم {report?.phone_number}</div>

            <img src={report?.image} height={'200'} className="rounded mx-auto d-block" alt="صورة ملف المستخدم" />

        </div>
    )
}