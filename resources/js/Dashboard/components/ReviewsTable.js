import React from "react";

import { Table, Modal, Button } from "react-bootstrap";
import { Routes } from '../utility/Urls'
import AllowedLink from './AllowedLink'

export default function ReviewsTable(props) {
    const reviews = props.reviews
    const [show, setShow] = React.useState(null);
    const handleClose = () => setShow(null);
    const handleShow = (id) => setShow(id);

    function hasUser(Object, Or = null) {
        if (reviews[0].user) 
        return Object
        else return Or;
    }
    function hasService(Object, Or = null) {
        if (reviews[0].service) return Object; else return Or;
    }
    if (reviews)
        return (
            <div>
                <Modal show={show} onHide={handleClose}>
                    <Modal.Header closeButton>
                        {/* <Modal.Title>{reviews[show]?.service?.title}</Modal.Title> */}
                        {hasService(
                            <Modal.Title>{reviews[show]?.service?.title}</Modal.Title>,
                            <Modal.Title>{reviews[show]?.id}</Modal.Title>
                        )}
                    </Modal.Header>
                    <Modal.Body>
                        <h3 className='text-center'>تركيبة الحقول</h3>
                        {/* <ArrayOfFieldsRender array_of_fields={reviews[show]?.array_of_fields} /> */}
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
                            <th>التعليق</th>
                            <th>الطلب</th>
                            <th>المستخدم</th>
                            <th>التقييم</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            reviews.map((review, index) =>
                                <tr key={index} onClick={() => handleShow(review.id)}>
                                    <td>{review.id}</td>
                                    <td>{review.comment}</td>
                                    <td>
                                        <AllowedLink to={Routes.showOrder(review.order_id)}>
                                            {review.order_id}
                                        </AllowedLink>
                                    </td>
                                    <td>
                                        {hasUser(
                                            <AllowedLink to={Routes.showUser(review.user_id)}>
                                                {review.user?.name}
                                            </AllowedLink>,
                                            <AllowedLink to={Routes.showUser(review.user_id)}>
                                                {review.user_id}
                                            </AllowedLink>
                                        )}
                                    </td>
                                    <td>{review.rating}</td>
                                </tr>
                            )
                        }
                    </tbody>
                </Table>
            </div>

        )
        else return null
}