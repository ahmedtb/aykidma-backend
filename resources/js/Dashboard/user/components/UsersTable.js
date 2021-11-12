import React from 'react'
import { Table } from 'react-bootstrap'
import { getRandomKey } from '../../utility/helpers'
import AllowedLink from '../../components/AllowedLink'
import {Routes} from '../../utility/Urls'
export default function UsersTable(props) {

    const users = props.users

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
                    users?.map(user =>
                        <tr key={getRandomKey()} onClick={() => handleShow(user.id)}>
                            <td>{user.id}</td>
                            <td>{user.name}</td>
                            <td>{user.phone_number}</td>
                            <td>
                                <img src={user.image} height={100} />
                            </td>

                        </tr>
                    )
                }
            </tbody>
        </Table>
    )

}