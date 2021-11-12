import axios from 'axios'
import React from 'react'
import {Api} from './utility/Urls'
import {logError, ApiCallHandler} from './utility/helpers'
import ImagePicker from './components/ImagePicker'
import { Modal, Button } from 'react-bootstrap'

function EditModal(props) {

    const editcategory = props.editcategory
    const seteditcategory = props.seteditcategory
    const submitEdit = props.submitEdit

    const show = editcategory?.show
    const handleClose = () => {
        seteditcategory({ category: null, show: false })
    }
    const changeName = (name) => {
        seteditcategory({ category: { ...editcategory.category, name: name }, show: true })
    }

    function submit() {
        const id = editcategory.category.id
        const name = editcategory.category.name
        const image = editcategory.category.image
        const parent_id = editcategory.category.parent_id
        submitEdit(id, name, image, parent_id)
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
            <Button variant="primary" onClick={submit}>
                Save Changes
            </Button>
        </Modal.Footer>
    </Modal>
}

function NewCategoryCreator(props) {
    const categories = props.categories
    const createCategory = props.createCategory

    const [newcategoryname, setnewcategoryname] = React.useState('')
    const [parent_id, setparent_id] = React.useState(null)
    const [image, setimage] = React.useState(null)

    function submit(){
        createCategory(newcategoryname, image, parent_id )
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
                    <button onClick={submit} className="btn btn-primary">Create</button>
                </div>
            </div>
        </div>
    </div>)
}

export default function CategoriesScreen(props) {

    const [categories, setcategories] = React.useState([])

    async function fetchCategories() {
        ApiCallHandler(
            async () => await Api.fetchCategories(), setcategories,
            'fetchCategories',
            true
        )
    }

    async function destroyCategory(id) {
        // try {
        //     const response = await Api.destroyCategory(id)
        //     console.log('destroyCategory', response)
        //     fetchCategories()
        // } catch (error) { logError(error, 'destroyCategory') }
        ApiCallHandler(
            async () => await Api.destroyCategory(id), fetchCategories,
            'destroyCategory',
            true
        )
    }

    async function submitEdit(id, name, image, parent_id) {
        // try {
        //     const response = await Api.editcategory(id, name, image, parent_id)
        //     console.log('EditModal', response.data)
        //     fetchCategories()
        // } catch (error) {
        //     logError(error, 'EditModal')
        // }
        ApiCallHandler(
            async () => await Api.editcategory(id, name, image, parent_id), fetchCategories,
            'EditModal',
            true
        )
    }

    async function createCategory(name, image, parent_id) {
        // try {
        //     const response = await Api.createCategory( name, image, parent_id )
        //     console.log('CategoriesScreen', response.data)
        //     fetchCategories()
        // } catch (error) { logError(error, 'CategoriesScreen') }
        ApiCallHandler(
            async () => await Api.createCategory( name, image, parent_id ), fetchCategories,
            'CategoriesScreen',
            true
        )
    }


    React.useEffect(() => {
        fetchCategories()
    }, [])


    const [editcategory, seteditcategory] = React.useState(null)

    return (
        <div>
            <EditModal submitEdit={submitEdit} seteditcategory={seteditcategory} editcategory={editcategory} />
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
                                            <img src={category.image} width={'100'} />
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
                                                            <img src={child.image} width={'100'} />

                                                            <div className="button-group d-flex">
                                                                <button onClick={() => seteditcategory({ category: child, show: true })} className="btn btn-sm btn-primary">Edit</button>

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

                <NewCategoryCreator createCategory={createCategory} categories={categories} />
            </div>
        </div>
    )
}