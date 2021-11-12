import React from "react";
import { logError } from '../utility/helpers'
import {Api} from '../utility/Urls'
import OrdersTable from "../components/OrdersTable";

export default function DoneOrdersIndex() {
    const [doneorders, setdoneorders] = React.useState([])

    async function setup() {
        try {
            const response = await Api.fetchOrders('done', ['user', 'service.ServiceProvider', 'service'])
            console.log('doneOrdersIndex setup', response.data)
            setdoneorders(response.data)
        } catch (error) { logError(error) }
    }

    React.useEffect(() => {
        setup()
    }, [])


    return (
        <div>
            <h1 className='text-center'>طلبات مكتملة</h1>
            <OrdersTable orders={doneorders} />
        </div>
    )

}