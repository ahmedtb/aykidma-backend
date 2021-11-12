import React from "react";
import { logError } from '../utility/helpers'
import {Api} from '../utility/Urls'
import OrdersTable from "../components/OrdersTable";

export default function NewOrdersIndex() {
    const [neworders, setneworders] = React.useState([])

    async function setup() {
        try {
            const response = await Api.fetchOrders('new', ['user', 'service.ServiceProvider', 'service'])
            console.log('NewOrdersIndex setup', response.data)
            setneworders(response.data)
        } catch (error) { logError(error) }
    }

    React.useEffect(() => {
        setup()
    }, [])


    return (
        <div>
            <h1 className='text-center'>طلبات جديدة</h1>
            <OrdersTable orders={neworders} />
        </div>
    )
}