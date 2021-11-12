import React from 'react'
import { useParams } from 'react-router'
import {Api} from '../utility/Urls'
import moment from 'moment'
import OrdersTable from '../components/OrdersTable'

export default function ServiceShow() {
    const { id } = useParams()
    const [service, setservice] = React.useState(null)

    async function setup() {
        const response = await Api.fetchService(id, ['ServiceProvider', 'reviews', 'orders', 'category'])
        setservice(response.data)
        console.log('ServiceShow show', response.data)
    }
    React.useEffect(() => {
        setup()
    }, [])

    return <div>
        <div>عنوان الخدمة: {service?.title}</div>

        <div>موافق عليه: {service?.approved}</div>
        <div>
            تصنيف الخدمة: {service?.category.name}
            <img src={service?.category.image} />
        </div>
        <div>وصف الخدمة: {service?.description}</div>
        <div>ثمن: {service?.price}</div>
        <div>طلبات الخدمة:
            <OrdersTable orders={service?.orders} service={service} service_provider={service?.service_provider} />
        </div>
        <div>أنشئت في:{moment(service?.created_at).format('dd-mm-yyyy')} </div>

    </div>
}