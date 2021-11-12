import React from "react";

import { Table, Modal, Button } from "react-bootstrap";
import { getRandomKey } from '../../utility/helpers'
import ArrayOfFieldsRender from '../../FieldsTypes/ArrayOfFieldsRender'
import {Routes} from '../../utility/Urls'
import AllowedLink from '../../components/AllowedLink'

export default function OrdersTable(props) {
    const orders = props.orders
    const service = props.service
    const service_provider = props.service_provider


    const [show, setShow] = React.useState(null);
    const handleClose = () => setShow(null);
    const handleShow = (id) => setShow(id);

    return (
        <div>
            <Modal show={show} onHide={handleClose}>
                <Modal.Header closeButton>
                    <Modal.Title>{service?.title}</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <h3 className='text-center'>تركيبة الحقول</h3>
                    <ArrayOfFieldsRender array_of_fields={orders ? orders[show]?.array_of_fields : null} />
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
            <h1 className='text-center'>طلبات جديدة</h1>
            <Table striped bordered hover>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الحالة</th>
                        <th>الخدمة</th>
                        <th>مزود الخدمة</th>
                        <th>السعر</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        orders?.map(order =>
                            <tr key={getRandomKey()} onClick={() => handleShow(order.id)}>
                                <td>{order.id}</td>
                                <td>{order.status}</td>
                                <td>
                                    {service?.title}
                                </td>
                                <td>
                                    <AllowedLink to={Routes.showProvider(service_provider.id)}>
                                        {service_provider?.name}
                                    </AllowedLink>
                                </td>
                                <td>{order.cost} $</td>
                            </tr>)
                    }
                </tbody>
            </Table>

        </div>
    )
}