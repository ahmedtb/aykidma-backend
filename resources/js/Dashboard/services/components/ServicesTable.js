import React from 'react'
import { Table } from 'react-bootstrap'
import AllowedLink from '../../components/AllowedLink'
import {Routes} from '../../utility/Urls'
import { getRandomKey } from '../../utility/helpers'
export default function ServicesTable(props) {
    const services = props.services

    return (
        <div>
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>موافق عليه</th>
                        <th>العنوان</th>
                        <th>مزود الخدمة</th>
                        <th>الوصف</th>
                        <th>التصنيف</th>
                        <th>الصورة</th>
                        <th>السعر</th>
                        <th>رقم الهاتف</th>

                    </tr>
                </thead>
                <tbody>
                    {
                        services?.map(service =>
                            <tr key={getRandomKey()} onClick={() => handleShow(service.id)}>
                                <td>
                                    <AllowedLink to={Routes.showService(service.id)}>
                                        {service.id}
                                    </AllowedLink>
                                </td>
                                <td>{service.approved ? 'مفعل' : 'غير مفعل'} </td>
                                <td> {service.title} </td>
                                <td>
                                    <AllowedLink to={Routes.showProvider(service.service_provider_id)}>
                                        {service.service_provider.name}
                                    </AllowedLink>
                                </td>
                                <td>{service.description}</td>
                                <td>
                                    {service.category.name}
                                    <img src={service.category.image} style={{ height: 40 }} />
                                </td>
                                <td>
                                    <img src={service.image} style={{ width: '100%' }} /></td>
                                <td>{service.price}</td>
                                <td>{service.phone_number}</td>

                            </tr>)
                    }
            </tbody>
        </Table>
        </div >
    )
}