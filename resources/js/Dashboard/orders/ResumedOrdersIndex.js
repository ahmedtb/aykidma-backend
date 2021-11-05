import React from "react";
import { logError } from '../utility/helpers'
import ApiEndPoints from '../utility/ApiEndpoints'
import OrdersTable from "./components/OrdersTable";

export default function ResumedOrdersIndex() {
    const [resumedorders, setresumedorders] = React.useState([])

    async function setup() {
        try {
            const response = await ApiEndPoints.fetchOrders('resumed', ['user', 'service.ServiceProvider', 'service'])
            console.log('resumedOrdersIndex setup', response.data)
            setresumedorders(response.data)
        } catch (error) { logError(error) }
    }

    React.useEffect(() => {
        setup()
    }, [])


    return (
        <div>
            <h1 className='text-center'>طلبات مستانفة</h1>
            <OrdersTable orders={resumedorders} />
        </div>
    )

}