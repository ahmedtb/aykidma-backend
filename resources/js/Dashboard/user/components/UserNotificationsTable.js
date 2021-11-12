import React from 'react'
import { Table } from 'react-bootstrap'
import { getRandomKey } from '../../utility/helpers'
import AllowedLink from '../../components/AllowedLink'
import {Routes} from '../../utility/Urls'

export default function UserNotificationsTable(props) {

    const notifications = props.notifications

    return (
        <Table striped bordered hover>
            <thead>
                <tr>
                    <th>#</th>
                    <th>عناون</th>
                    <th>بدن الاشعار</th>
                    <th>النوع</th>
                    <th>اسم المستخدم</th>

                </tr>
            </thead>
            <tbody>
                {
                    notifications?.map((notification, index) =>
                        <tr key={index} onClick={() => handleShow(notification.id)}>
                            <td>{notification.id}</td>
                            <td>{notification.title}</td>
                            <td>{notification.body}</td>
                            <td>
                                {notification.type}
                            </td>
                            <td>
                                <AllowedLink to={Routes.showUser(notification.user_id) }>
                                    {notification.user.name}
                                </AllowedLink>
                            </td>

                        </tr>
                    )
                }
            </tbody>
        </Table>
    )

}