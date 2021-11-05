import React from 'react'
import axios from 'axios'
import ApiEndpoints from './utility/ApiEndpoints'
import {logError} from './utility/helpers'
import ArrayOfFieldsRender from './FieldsTypes/ArrayOfFieldsRender'
import Routes from './utility/Routes'
import { Link } from 'react-router-dom'

export default function ServicesApprovealScreen(props) {
    const [services, setservices] = React.useState([])

    async function fetchServices() {
        const response = await axios.get('/dashboard')
        // console.log('ServicesApprovealScreen', response.data)
        setservices(response.data)
    }

    async function rejectService(id) {
        try {
            const response = await axios.delete(ApiEndpoints.rejectService, { params: { service_id: id } })
            console.log('ServicesApprovealScreen rejectService', response.data)
            fetchServices()
        } catch (error) {
            logError(error, 'ServicesApprovealScreen rejectService')
        }
    }

    async function approveService(id) {
        try {
            const response = await axios.put(ApiEndpoints.approveService, { service_id: id })
            console.log('ServicesApprovealScreen approveService', response.data)
            fetchServices()
        } catch (error) {
            logError(error, 'ServicesApprovealScreen approveService')
        }
    }

    React.useEffect(() => {
        fetchServices()
    }, [])

    return (
        <div className='row justify-content-center'>
            {
                services.map((service, index) => (
                    <div key={index} className="col-5 p-1 m-1 border border-primary rounded">

                        <div className="col-12">
                            <Link to={Routes.ServiceProviderShow(service.service_provider.id)}>
                                <div className="text-center"><strong>{service.service_provider.name}</strong></div>
                            </Link>
                            <div className="my-2">
                                <div className="text-center">عنوان الخدمة المقترحة</div>
                                <div className="text-center">{service.id}: {service.title}</div>
                            </div>

                            <img src={service.service_provider.image} height={'200'} className="rounded mx-auto d-block" alt="صورة مزود الخدمة" />

                            <div className="d-flex flex-row">
                                <div>اماكن تخطية الخدمة</div>
                                {
                                    service.service_provider.coverage.map((coverage, index) => (
                                        <div key={index} className="m-1">{coverage['city']} {coverage['area']}</div>
                                    ))
                                }
                            </div>




                            <div className="border border-dark rounded">وصف الخدمة المقترحة: {service.description}</div>

                            <p>تركيبة حقول الخدمة المقترحة: </p>
                            <div className='col-8 mx-auto'>
                                <ArrayOfFieldsRender array_of_fields={service.array_of_fields} />
                            </div>


                            <div className=" d-flex flex-row justify-content-around">

                                <button className="btn btn-secondary" onClick={() => rejectService(service.id)}>
                                    رفض عرض الخدمة
                                </button>

                                <button className="btn btn-success" onClick={() => approveService(service.id)}>
                                    موافقة على عرض الخدمة
                                </button>
                            </div>
                        </div>

                    </div >

                ))
            }

        </div>

    )
}