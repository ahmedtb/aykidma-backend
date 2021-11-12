import React from "react";
import {Routes} from "../utility/Urls";
import { logError, ApiCallHandler } from "../utility/helpers";
import AllowedLink from '../components/AllowedLink'
import ArrayOfFieldsRender from "../FieldsTypes/ArrayOfFieldsRender";

export default function NotApprovedServicesIndex() {
    const [notapprovedservices, setnotapprovedservices] = React.useState([])
    async function setup() {
        // try {
        //     const response = await Api.fetchServices('false', ['ServiceProvider'])
        //     setnotapprovedservices(response.data)
        //     console.log('NotApprovedServicesIndex', response.data)
        // } catch (error) { logError(error, 'NotApprovedServicesIndex') }
        ApiCallHandler(
            async () => await Api.fetchServices('false', ['ServiceProvider']), setnotapprovedservices,
            'NotApprovedServicesIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])
    async function rejectService(id) {
        try {
            const response = await Api.rejectService(id)
            console.log('ServicesApprovealScreen rejectService', response.data)
            setup()
        } catch (error) {
            logError(error, 'ServicesApprovealScreen rejectService')
        }
    }

    async function approveService(id) {
        try {
            const response = await Api.approveService(id)
            console.log('ServicesApprovealScreen approveService', response.data)
            setup()
        } catch (error) {
            logError(error, 'ServicesApprovealScreen approveService')
        }
    }

    return (
        <div className='row justify-content-center'>
            {
                notapprovedservices.map((service, index) => (
                    <div key={index} className="col-5 p-1 m-1 border border-primary rounded">

                        <div className="col-12">
                            <AllowedLink to={Routes.showProvider(service.service_provider.id)}>
                                <div className="text-center"><strong>{service.service_provider.name}</strong></div>
                            </AllowedLink>
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