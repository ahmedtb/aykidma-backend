import React from "react";
import { logError } from '../utility/helpers'
import ApiEndPoints from '../utility/ApiEndpoints'
import { Table } from "react-bootstrap";
import {getRandomKey} from '../utility/helpers'
export default function NewOrdersIndex() {
    const [neworders, setneworders] = React.useState([])
    async function setup() {
        try {
            const response = await ApiEndPoints.fetchOrders('new', true, true, true)
            console.log('NewOrdersIndex setup', response.data)
            setneworders(response.data)
        } catch (error) { logError(error) }
    }
    React.useEffect(() => {
        setup()
    }, [])
    return (
        <div>
            <div>طلبات جديدة</div>
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Username</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        neworders.map(neworder =>
                            <tr key={getRandomKey()}>
                                <td>{neworder.id}</td>
                                <td>{neworder.status}</td>
                                <td>{neworder.service_id}</td>
                                <td>{neworder.cost}</td>
                            </tr>)
                    }
                </tbody>
            </Table>

        </div>
    )
}