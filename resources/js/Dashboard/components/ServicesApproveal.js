import React from 'react'
import axios from 'axios'
import ArrayOfFieldsRender from './ArrayOfFieldsRender'

export default function ServicesApproveal(props) {
    const [services, setservices] = React.useState([])
    async function fetchServices() {
        const response = await axios.get('/dashboard')
        console.log('ServicesApproveal', response.data)
        setservices(response.data)
    }

    async function rejectService(id) {
        try {

            const response = await axios.delete('/reject/service/', { service_id: id })
            console.log('ServicesApproveal rejectService', response.data)
            fetchServices()
        } catch (error) {
            console.error('ServicesApproveal rejectService error', error)
        }
    }

    async function approveService(id) {
        try {

            const response = await axios.delete('/approve/service/', { service_id: id })
            console.log('ServicesApproveal approveService', response.data)
            fetchServices()
        } catch (error) {
            console.error('ServicesApproveal approveService error', error)
        }
    }

    React.useEffect(() => {
        fetchServices()
    }, [])

    return (
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

                    <form onSubmit={() => rejectService(service.id)}>
                        <input type='hidden' name='service_id' value={service.id} />
                        <input type='submit' className="btn btn-secondary" value="رفض عرض الخدمة" />
                    </form>

                    <form onSubmit={() => approveService(service.id)}>
                        <input type='hidden' name='service_id' value={service.id} />
                        <input type='submit' className="btn btn-success" value="موافقة على تقديم الخدمة" />
                    </form>

                </div>
            </div >
        ))


    )
}