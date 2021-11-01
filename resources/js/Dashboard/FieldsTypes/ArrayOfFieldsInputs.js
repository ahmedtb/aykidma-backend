import React from 'react'

import { StringFieldClass, StringFieldInput } from './StringField'
import { TextAreaFieldClass, TextAreaFieldInput } from './TextAreaField'
import { ImageFieldClass, ImageFieldInput } from './ImageField'
import { LocationFieldClass, LocationFieldInput } from './LocationField'
import { OptionsFieldClass, OptionsFieldInput } from './OptionsField'
import { ArrayOfFieldsClass } from './ArrayOfFieldsCreator'

const reducer = (array_of_fields, action) => {

    switch (action.actionType) {
        case 'change value':
            const fields = array_of_fields.fields.map((field, fieldIndex) => {
                if (fieldIndex == action.fieldIndex)
                    field.value = action.value;
                return field;
            })
            return { class: ArrayOfFieldsClass, fields: fields }
    }
    return array_of_fields;
}

export default function ArrayOfFieldsInputs(props) {
    
    const [array_of_fields, dispatch] = React.useReducer(reducer, props.service.array_of_fields)
    const setarray_of_fields = props.setarray_of_fields

    React.useEffect(() => {
        setarray_of_fields(array_of_fields)
    }, [array_of_fields])

    return (
        <div style={{ padding: 25 }}>
                {
                    array_of_fields.fields?.map((field, index) => {
                        if (field.class == StringFieldClass) {
                            return <StringFieldInput
                                key={index}
                                field={field}
                                dispatch={(value) => dispatch({ actionType: 'change value', fieldIndex: index, value: value })}
                            />
                        } else if (field.class == TextAreaFieldClass) {
                            return <TextAreaFieldInput
                                key={index}
                                field={field}
                                dispatch={(value) => dispatch({ actionType: 'change value', fieldIndex: index, value: value })}
                            />
                        } else if (field.class == ImageFieldClass) {
                            return <ImageFieldInput
                                key={index}
                                field={field}
                                dispatch={(value) => dispatch({ actionType: 'change value', fieldIndex: index, value: value })}

                            />
                        } else if (field.class == OptionsFieldClass) {
                            return <OptionsFieldInput
                                key={index}
                                field={field}
                                dispatch={(value) => dispatch({ actionType: 'change value', fieldIndex: index, value: value })}
                            />
                        } else if (field.class == LocationFieldClass) {
                            return <LocationFieldInput
                                key={index}
                                field={field}
                                dispatch={(value) => dispatch({ actionType: 'change value', fieldIndex: index, value: value })}

                            />
                        }
                    })
                }
        </div>
    );

}
