import React from 'react'
import { Table } from 'react-bootstrap'
import { getRandomKey } from '../../utility/helpers'
import AllowedLink from '../../components/AllowedLink'
import {Routes} from '../../utility/Urls'

export default function ProviderNotificationsTable(props) {

    const providerNotifications = props.providerNotifications

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
                    providerNotifications?.map(notification =>
                        <tr key={getRandomKey()} onClick={() => handleShow(notification.id)}>
                            <td>{notification.id}</td>
                            <td>{notification.name}</td>
                            <td>{notification.phone_number}</td>
                            <td>
                                <img src={notification.image} height={100} />
                            </td>

                        </tr>
                    )
                }
            </tbody>
        </Table>
    )

}