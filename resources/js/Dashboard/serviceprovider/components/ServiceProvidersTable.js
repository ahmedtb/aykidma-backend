import React from 'react'
import { Table } from 'react-bootstrap'
import { getRandomKey } from '../../utility/helpers'
import AllowedLink from '../../components/AllowedLink'
import {Routes} from '../../utility/Urls'
export default function ServiceProvidersTable(props) {

    const providers = props.providers

    return (
        <Table striped bordered hover>
            <thead>
                <tr>
                    <th>#</th>
                    <th>الاسم</th>
                    <th>حسابه الشخصي</th>
                    <th>مفعّل</th>
                    <th>اماكن تغطيته</th>
                    <th>صورة</th>
                </tr>
            </thead>
            <tbody>
                {
                    providers?.map(provider =>
                        <tr key={getRandomKey()} onClick={() => handleShow(provider.id)}>
                            <td>{provider.id}</td>
                            <td>{provider.name}</td>
                            <td>
                                <AllowedLink to={Routes.showProvider(provider.user.id)}>
                                    {provider.user.name}
                                </AllowedLink>
                            </td>
                            <td>{provider.activated}</td>
                            <td>{provider.coverage.map(coverage => (
                                <div key={getRandomKey()} className="m-1">{coverage['city']} {coverage['area']}</div>
                            ))}</td>
                            <td>
                                <img src={provider.image} height={100} />
                            </td>

                        </tr>)
                }
            </tbody>
        </Table>
    )

}