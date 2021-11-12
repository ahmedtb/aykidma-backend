import React from "react";

import { Table, Modal, Button } from "react-bootstrap";
import { Routes } from '../utility/Urls'
import AllowedLink from './AllowedLink'

export default function ProviderEnrollmentRequestsTable(props) {
    const requests = props.requests

    function hasUser(Object, OR = null) {
        if (requests[0]?.user)
            return Object
        else
            return OR
    }
    
    if (requests)
        return (

            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الاسم</th>
                        {hasUser(<th>المستخدم</th>, <th>user id</th>)}
                        {/* <th>السعر</th> */}
                    </tr>
                </thead>
                <tbody>
                    {
                        requests.map((request, index) =>
                            <tr key={index} >
                                <td>{request.id}</td>
                                <td>{request.name}</td>
                                {hasUser(
                                    <td>
                                        <AllowedLink to={Routes.showService(request.user?.id)}>
                                            {request.user?.name}
                                        </AllowedLink>
                                    </td>,
                                    <td>
                                        <AllowedLink to={Routes.showService(request.user_id)}>
                                            {request.user_id}
                                        </AllowedLink>
                                    </td>
                                )}

                                {/* <td>{request.coverage} $</td> */}
                            </tr>
                        )
                    }
                </tbody>
            </Table>
        )
    else return null
}