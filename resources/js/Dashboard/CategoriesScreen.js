import axios from 'axios'
import React from 'react'
import ApiEndpoints from './utility/ApiEndpoints'
import logError from './utility/logError'
import ImagePicker from './components/ImagePicker'
import { Modal, Button } from 'react-bootstrap'

function EditModal(props) {

    const editcategory = props.editcategory
    const seteditcategory = props.seteditcategory

    const show = editcategory?.show
    const handleClose = () => {
        seteditcategory({ category: null, show: false })
    }
    const changeName = (name) => {
        seteditcategory({ category: { ...editcategory.category, name: name }, show: true })
    }

    async function submitEdit() {
        try {
            const response = await axios.put(ApiEndpoints.editcategory.replace(':id', editcategory.category.id), {
                name: editcategory?.category?.name,
                image: editcategory?.category?.name,
                parent_id: editcategory?.category?.name,
            })
            console.log('EditModal', response.data)
        } catch (error) {
            logError(error, 'EditModal')
        }
    }

    return <Modal show={show} onHide={handleClose}>
        <Modal.Header closeButton>
            <Modal.Title>تعديل التصنيف: {editcategory?.category?.name}</Modal.Title>
        </Modal.Header>
        <Modal.Body>
            <input type='text' onChange={e => changeName(e.target.value)} />
        </Modal.Body>
        <Modal.Footer>
            <Button variant="secondary" onClick={handleClose}>
                Close
            </Button>
            <Button variant="primary" onClick={submitEdit}>
                Save Changes
            </Button>
        </Modal.Footer>
    </Modal>
}

function NewCategoryCreator(props) {
    const categories = props.categories

    const [newcategoryname, setnewcategoryname] = React.useState('')
    const [parent_id, setparent_id] = React.useState(null)
    const [image, setimage] = React.useState(null)

    async function createCategory() {
        try {
            const response = await axios.post(ApiEndpoints.createCategory, { name: newcategoryname, image: image, parent_id: parent_id })
            console.log('CategoriesScreen', response.data)
            setup()
        } catch (error) { logError(error, 'CategoriesScreen') }
    }

    return (<div className="col-md-4">
        <div className="card">
            <div className="card-header">
                <h3>انشاء تصنيف جديد</h3>
            </div>

            <div className="card-body">

                <div className="form-group">
                    <select className="form-control" name="parent_id" onChange={(e) => setparent_id(e.target.value)}>
                        <option value="">Select Parent Category</option>
                        {
                            categories.map((category, index) => (
                                <option key={index} value={category.id}>{category.name}</option>
                            ))
                        }
                    </select>
                </div>

                <div className="form-group">
                    <input onChange={e => setnewcategoryname(e.target.value)} className="form-control" value={newcategoryname} placeholder="Category Name" required />
                </div>
                <ImagePicker setimage={setimage} />
                <div className="form-group">
                    <button onClick={createCategory} className="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>)
}

export default function CategoriesScreen(props) {

    const [categories, setcategories] = React.useState([])


    async function setup() {
        try {

            const response = await axios.get(ApiEndpoints.fetchCategories)
            // console.log('CategoriesScreen', response.data)
            setcategories(response.data)
        } catch (error) { logError(error, 'CategoriesScreen') }
    }

    async function destroyCategory(id) {
        try {
            const response = await axios.delete(ApiEndpoints.destroyCategory.replace(':id', id))
            console.log('CategoriesScreen', response.data)
            setup()
        } catch (error) { logError(error, 'CategoriesScreen') }
    }

    React.useEffect(() => {
        setup()
    }, [])


    const [editcategory, seteditcategory] = React.useState(null)

    return (
        <div>
            <EditModal seteditcategory={seteditcategory} editcategory={editcategory} />
            <div className="row">
                <div className="col-md-8">

                    <div className="card">
                        <div className="card-header">
                            <h3>التصنيفات</h3>
                        </div>
                        <div className="card-body">
                            <ul className="list-group">
                                {categories.map((category, index) => (
                                    <li key={index} className="list-group-item">
                                        <div className="d-flex justify-content-between">
                                            {category.name}

                                            <div className="button-group d-flex">

                                                <button onClick={() => seteditcategory({ category: category, show: true })} className="btn btn-sm btn-primary">Edit</button>

                                                <button onClick={() => destroyCategory(category.id)} className="btn btn-sm btn-danger">Delete</button>
                                            </div>
                                        </div>

                                        <ul className="list-group mt-2">
                                            {
                                                category.children?.map((child, index) => (
                                                    <li key={index} className="list-group-item">
                                                        <div className="d-flex justify-content-between">
                                                            {child.name}

                                                            <div className="button-group d-flex">
                                                                <button onClick={() => editModal()} className="btn btn-sm btn-primary">Edit</button>

                                                                <button onClick={() => destroyCategory(child.id)} className="btn btn-sm btn-danger">Delete</button>
                                                            </div>
                                                        </div>
                                                    </li>
                                                ))
                                            }
                                        </ul>
                                    </li>

                                ))}
                            </ul>
                        </div>
                    </div>
                </div>

                <NewCategoryCreator categories={categories}/>
            </div>
        </div>
    )
}