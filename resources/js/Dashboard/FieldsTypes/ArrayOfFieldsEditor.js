import React from 'react'

import { StringFieldClass, StringFieldEditor } from './StringField'
import { TextAreaFieldClass, TextAreaFieldEditor } from './TextAreaField'
import { ImageFieldClass, ImageFieldEditor } from './ImageField'
import { LocationFieldClass, LocationFieldEditor } from './LocationField'
import { OptionsFieldClass, OptionsFieldEditor } from './OptionsField'
import { ArrayOfFieldsClass } from './ArrayOfFieldsCreator'
import ArrayOfFieldsCreator from './ArrayOfFieldsCreator'

const reducer = (array_of_fields, action) => {

    switch (action.actionType) {
        case 'change field':
            let fields1 = array_of_fields.fields.map((field, index) => {
                if (index == action.index)
                    return action.field;
                return field;
            })
            return { class: ArrayOfFieldsClass, fields: fields1 }
        case 'remove field':
            let filtered = array_of_fields.fields.filter((value, index) => {
                return index != action.index;
            });
            return { class: ArrayOfFieldsClass, fields: filtered }
        case 'add field':
            let increased = [...array_of_fields.fields, action.newField]
            return { class: ArrayOfFieldsClass, fields: increased }
    }
    return array_of_fields;
}




export default function ArrayOfFieldsEditor(props) {
    const setEditedArrayOfFields = props.setEditedArrayOfFields
    const [array_of_fields, dispatch] = React.useReducer(reducer, props.array_of_fields)

    React.useEffect(() => {
        // console.log('ArrayOfFieldsEditor useEffect', array_of_fields)
        setEditedArrayOfFields(array_of_fields)
    }, [array_of_fields])

    
    function addNewField(fieldConfig) {
        dispatch({ actionType: 'add field', newField: fieldConfig })
    }

    return (
        <div style={{ padding: 25 }}>
                {
                    array_of_fields.fields?.map((field, index) => {
                        if (field.class == StringFieldClass) {
                            return <StringFieldEditor
                                key={index}
                                field={field}
                                dispatch={(field) => dispatch({ actionType: 'change field', index: index, field: field })}
                            />
                        } else if (field.class == TextAreaFieldClass) {
                            return <TextAreaFieldEditor
                                key={index}
                                field={field}
                                dispatch={(field) => dispatch({ actionType: 'change field', index: index, field: field })}
                            />
                        } else if (field.class == ImageFieldClass) {
                            return <ImageFieldEditor
                                key={index}
                                field={field}
                                dispatch={(field) => dispatch({ actionType: 'change field', index: index, field: field })}

                            />
                        } else if (field.class == OptionsFieldClass) {
                            return <OptionsFieldEditor
                                key={index}
                                field={field}
                                dispatch={(field) => dispatch({ actionType: 'change field', index: index, field: field })}
                            />
                        } else if (field.class == LocationFieldClass) {
                            return <LocationFieldEditor
                                key={index}
                                field={field}
                                dispatch={(field) => dispatch({ actionType: 'change field', index: index, field: field })}

                            />
                        }
                    })
                }
                <ArrayOfFieldsCreator addField={addNewField} />

        </div>
    )
}