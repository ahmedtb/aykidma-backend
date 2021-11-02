import React from 'react'
import axios from 'axios'
// import ArrayOfFieldsRender from './components/ArrayOfFieldsRender'
import ApiEndpoints from './utility/ApiEndpoints'
import logError from './utility/logError'
import ArrayOfFieldsRender from './FieldsTypes/ArrayOfFieldsRender'
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
        <div className='row'>
            {
                services.map((service, index) => (
                    <div key={index} className="col-5 border border-primary">

                        <div className="border border-dark">

                            <strong className="">مزود الخدمة</strong>
                            <div className="row">

                                <img src={'data:image/jpg;base64,' + service.service_provider.image} className="img-thumbnail w-50 p-1" alt="صورة مزود الخدمة" />
                                <div className="w-50 p-1">
                                    <strong className="">{service.service_provider.name}</strong>
                                    <div>{service.service_provider.phone_number}</div>
                                    <div>{service.service_provider.email}</div>

                                    <div className="row">
                                        <strong>اماكن التخطية</strong>
                                        {
                                            service.service_provider.coverage.map((coverage, index) => (
                                                <div key={index} className="m-1">{coverage['city']}</div>
                                            ))
                                        }
                                    </div>
                                </div>
                            </div>

                        </div>


                        <p>This is service {service.id}</p>
                        <p>{service.title}</p>
                        <p>the structure of the fields of the serivce preposed are</p>

                        <div className="border border-dark rounded">{service.description}</div>

                        <ArrayOfFieldsRender array_of_fields={service.array_of_fields} />


                        <div className=" d-flex flex-row justify-content-around">

                            <button className="btn btn-secondary" onClick={() => rejectService(service.id)}>
                                رفض عرض الخدمة
                            </button>

                            <button className="btn btn-success" onClick={() => approveService(service.id)}>
                                موافقة على عرض الخدمة
                            </button>
                        </div>
                    </div >

                ))
            }

        </div>

    )
}