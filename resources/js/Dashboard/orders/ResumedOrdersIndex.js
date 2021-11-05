import React from "react";
import { logError } from '../utility/helpers'
import ApiEndPoints from '../utility/ApiEndpoints'

export default function ResumedOrdersIndex() {
    const [resumedorders, setresumedorders] = React.useState([])

    async function setup() {
        try {
            const response = await ApiEndPoints.fetchOrders('resumed', true, true, true)
            console.log('ResumedOrdersIndex setup', response.data)
            setresumedorders(response.data)
        } catch (error) { logError(error) }
    }
    React.useEffect(() => {
        setup()
    }, [])
    return (
        <div>

        </div>
    )
}