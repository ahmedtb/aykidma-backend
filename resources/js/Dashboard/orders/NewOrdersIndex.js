import React from "react";
import { logError } from '../utility/helpers'
import ApiEndPoints from '../utility/ApiEndpoints'
import Routes from '../utility/Routes'
import AllowedLink from '../components/AllowedLink'
import { Table, Modal, Button } from "react-bootstrap";
import { getRandomKey } from '../utility/helpers'
import ArrayOfFieldsRender from '../FieldsTypes/ArrayOfFieldsRender'

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

    const [show, setShow] = React.useState(null);
    const handleClose = () => setShow(null);
    const handleShow = (id) => setShow(id);

    return (
        <div>
            <Modal show={show} onHide={handleClose}>
                <Modal.Header closeButton>
                    <Modal.Title>{neworders[show]?.service.title}</Modal.Title>
                </Modal.Header>
                <Modal.Body>
                    <h3 className='text-center'>تركيبة الحقول</h3>
                    <ArrayOfFieldsRender array_of_fields={neworders[show]?.array_of_fields} />
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
                        neworders.map(neworder =>
                            <tr key={getRandomKey()} onClick={() => handleShow(neworder.id)}>
                                <td>{neworder.id}</td>
                                <td>{neworder.status}</td>
                                <td>
                                    <AllowedLink to={Routes.showService(neworder.service.id)}>
                                        {neworder.service.title}
                                    </AllowedLink>
                                </td>
                                <td>{neworder.service.service_provider.name}</td>
                                <td>{neworder.cost} $</td>
                            </tr>)
                    }
                </tbody>
            </Table>

        </div>
    )
}