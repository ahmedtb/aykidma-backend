import React from "react";

import { Table, Modal, Button } from "react-bootstrap";
import { Routes } from '../utility/Urls'
import AllowedLink from './AllowedLink'

export default function ProviderEnrollmentRequestsTable(props) {
    const requests = props.requests
    const accept = props.accept
    const reject = props.reject

    function hasUser(Object, OR = null) {
        if (requests[0]?.user)
            return Object
        else
            return OR
    }
    function hasAccept(Object, OR = null) {
        if (accept)
            return Object
        else
            return OR
    }
    function hasReject(Object, OR = null) {
        if (reject)
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
                        {hasAccept(<th></th>)}
                        {hasReject(<th></th>)}

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

                                {hasAccept(<th>
                                    <Button onClick={() => accept(request.id)} >قبول</Button>
                                </th>)}
                                {hasReject(<th>
                                    <Button onClick={() => reject(request.id)}>رفض</Button>
                                </th>)}

                            </tr>
                        )
                    }
                </tbody>
            </Table>
        )
    else return null
}