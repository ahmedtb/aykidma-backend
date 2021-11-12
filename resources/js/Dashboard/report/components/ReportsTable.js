import React from 'react'
import { Table } from 'react-bootstrap'
import AllowedLink from '../../components/AllowedLink'
import {Routes} from '../../utility/Urls'
export default function ReportsTable(props) {

    const reports = props.reports

    return (
        <Table striped bordered hover>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>رقم الهاتف</th>
                    <th>صورة</th>
                </tr>
            </thead>
            <tbody>
                {
                    reports?.map((report, index) =>
                        <tr key={index} onClick={() => handleShow(report.id)}>
                            <td>{report.id}</td>
                            <td>{report.name}</td>
                            <td>{report.phone_number}</td>
                            <td>
                                <img src={report.image} height={100} />
                            </td>

                        </tr>
                    )
                }
            </tbody>
        </Table>
    )

}