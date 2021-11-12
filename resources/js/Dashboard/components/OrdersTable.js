import React from "react";

import { Table, Modal, Button } from "react-bootstrap";
import { getRandomKey } from '../utility/helpers'
import ArrayOfFieldsRender from '../FieldsTypes/ArrayOfFieldsRender'
import { Routes } from '../utility/Urls'
import AllowedLink from './AllowedLink'

export default function OrdersTable(props) {
    const orders = props.orders
    const [show, setShow] = React.useState(null);
    const handleClose = () => setShow(null);
    const handleShow = (id) => setShow(id);

    function hasService(Object, OR = null) {
        if (orders && orders[0]?.service)
            return Object
        else
            return OR
    }
    function hasServiceProvider(Object, OR = null) {
        if (orders && orders[0]?.service?.service_provider)
            return Object
        else
            return OR
    }
    function hasArrayOfFields(Object, OR = null) {
        if (orders && orders[0]?.array_of_fields)
            return Object
        else
            return OR
    }
    if (orders)
        return (
            <div>
                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        {hasService(
                            <Modal.Title>{orders[show]?.service?.title}</Modal.Title>,
                            <Modal.Title>{orders[show]?.id}</Modal.Title>
                        )}

                    </Modal.Header>
                    <Modal.Body>
                        {hasArrayOfFields(<>
                            <h3 className='text-center'>تركيبة الحقول</h3>
                            <ArrayOfFieldsRender array_of_fields={orders[show]?.array_of_fields} />
                        </>)}

                    </Modal.Body>
                    <Modal.Footer>
                        <Button variant="secondary" onClick={handleClose}>
                            Close
                        </Button>
                        <Button variant="primary" onClick={handleClose}>
                            Save Changes
                        </Button>
                    </Modal.Footer>
                </Modal>
                <Table striped bordered hover>
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>الحالة</th>
                            {hasService(<th>الخدمة</th>, <th>service id</th>)}
                            {hasServiceProvider(<th>مزود الخدمة</th>)}
                            <th>السعر</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            orders.map(order =>
                                <tr key={getRandomKey()} onClick={() => handleShow(order.id)}>
                                    <td>{order.id}</td>
                                    <td>{order.status}</td>
                                    {hasService(
                                        <td>
                                            <AllowedLink to={Routes.showService(order.service?.id)}>
                                                {order.service?.title}
                                            </AllowedLink>
                                        </td>,
                                        <td>
                                            <AllowedLink to={Routes.showService(order.service_id)}>
                                                {order.service_id}
                                            </AllowedLink>
                                        </td>
                                    )}

                                    {hasServiceProvider(
                                        <td>
                                            <AllowedLink to={Routes.showProvider(order.service?.service_provider?.id)}>
                                                {order.service?.service_provider?.name}
                                            </AllowedLink>
                                        </td>
                                    )}


                                    <td>{order.cost} $</td>
                                </tr>
                            )
                        }
                    </tbody>
                </Table>
            </div>

        )
    else return null
}