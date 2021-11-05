import React from "react";

import { Table, Modal, Button } from "react-bootstrap";
import { getRandomKey } from '../../utility/helpers'
import ArrayOfFieldsRender from '../../FieldsTypes/ArrayOfFieldsRender'
import Routes from '../../utility/Routes'
import AllowedLink from '../../components/AllowedLink'

export default function OrdersTable(props) {
    const orders = props.orders
    const [show, setShow] = React.useState(null);
    const handleClose = () => setShow(null);
    const handleShow = (id) => setShow(id);
    return (
        <div>
            <Modal show={show} onHide={handleClose}>
                <Modal.Header closeButton>
                    <Modal.Title>{orders[show]?.service.title}</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <h3 className='text-center'>تركيبة الحقول</h3>
                    <ArrayOfFieldsRender array_of_fields={orders[show]?.array_of_fields} />
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
                        <th>الخدمة</th>
                        <th>مزود الخدمة</th>
                        <th>السعر</th>
                    </tr>
                </thead>
                <tbody>
                    {
                        orders.map(order =>
                            <tr key={getRandomKey()} onClick={() => handleShow(order.id)}>
                                <td>{order.id}</td>
                                <td>{order.status}</td>
                                <td>
                                    <AllowedLink to={Routes.showService(order.service.id)}>
                                        {order.service.title}
                                    </AllowedLink>
                                </td>
                                <td>
                                    <AllowedLink to={Routes.showProvider(order.service.service_provider.id)}>
                                        {order.service.service_provider.name}
                                    </AllowedLink>
                                </td>
                                <td>{order.cost} $</td>
                            </tr>
                        )
                    }
                </tbody>
            </Table>
        </div>

    )
}