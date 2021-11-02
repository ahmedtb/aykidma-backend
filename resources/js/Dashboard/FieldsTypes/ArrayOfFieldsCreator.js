import React from 'react'

import { StringFieldClass, StringFieldCreator } from './StringField'
import { TextAreaFieldClass, TextAreaFieldCreator } from './TextAreaField'
import { ImageFieldClass, ImageFieldCreator } from './ImageField'
import { LocationFieldClass, LocationFieldCreator } from './LocationField'
import { OptionsFieldClass, OptionsFieldCreator } from './OptionsField'

export const ArrayOfFieldsClass = 'App\\FieldsTypes\\ArrayOfFields'

const fieldsTypes = {
    [StringFieldClass]: 'حقل نص عادي',
    [TextAreaFieldClass]: 'مساحة نصية',
    [OptionsFieldClass]: 'قائمة اختيار',
    [LocationFieldClass]: 'تحديد موقع المستخدم',
    [ImageFieldClass]: 'حقل صورة'
}




export default function ArrayOfFieldsCreator(props) {

    const addField = props.addField
    const [selectedType, setSelectedType] = React.useState();
    const [field, setfield] = React.useState({});



    return (
        <div>

            <div style={{ flexDirection: 'row', flex: 1, alignItems: 'center' }}>
                <strong style={{ fontSize: 15, fontWeight: 'bold' }}>نوع الحقل</strong>
                <div style={{ flex: 1, borderWidth: 0.5, margin: 3, borderRadius: 8 }}>
                    <select
                        onChange={(e) => {
                            console.log(e.target.value)
                        }} className="form-select" aria-label="Default select example">
                        <option selected>اختر نوع الحقل</option>
                        {
                            Object.keys(fieldsTypes).map(function (key, index) {
                                return <option key={index} value={key}>{fieldsTypes[key]}</option>
                            })
                        }
                    </select>
                </div>
            </div>

            {
                (() => {
                    if (selectedType == StringFieldClass) {
                        return (
                            <StringFieldCreator set={(field) => setfield(field)} />
                        )
                    } else if (selectedType == TextAreaFieldClass) {
                        return (
                            <TextAreaFieldCreator set={(field) => setfield(field)} />
                        )
                    } else if (selectedType == OptionsFieldClass) {
                        return (
                            <OptionsFieldCreator set={(field) => setfield(field)} />
                        )
                    } else if (selectedType == LocationFieldClass) {
                        return (
                            <LocationFieldCreator set={(field) => setfield(field)} />
                        )
                    } else if (selectedType == ImageFieldClass) {
                        return (
                            <ImageFieldCreator set={(field) => setfield(field)} />
                        )
                    }
                })()
            }

            <button
                onClick={() => {
                    // dispatch({ actionType: 'add field', field: field })
                    addField(field)
                    setfield({})
                    setSelectedType(null)
                }}
                style={{ alignSelf: 'flex-end', backgroundColor: 'red', width: '20%', padding: 10, marginVertical: 5, justifyContent: 'center', borderRadius: 19 }}
            >
                <strong style={{ textAlign: 'center', color: 'white', fontSize: 10 }}>اضف الحقل</strong>
            </button>
        </div>
    )

}