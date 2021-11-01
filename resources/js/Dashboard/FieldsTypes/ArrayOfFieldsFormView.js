import React from 'react'

import { StringFieldClass, StringFieldFormView } from './StringField'
import { TextAreaFieldClass, TextAreaFieldFormView } from './TextAreaField'
import { ImageFieldClass, ImageFieldFormView } from './ImageField'
import { LocationFieldClass, LocationFieldFormView } from './LocationField'
import { OptionsFieldClass, OptionsFieldFormView } from './OptionsField'

export default function ArrayOfFieldsFormView(props) {

    const array_of_fields = props.array_of_fields

    return (
        <div>
            {
                array_of_fields.fields.map((field, index) => {
                    if (field.class == StringFieldClass) {
                        return <StringFieldFormView
                            key={index}
                            field={field}
                        />
                    } else if (field.class == TextAreaFieldClass) {
                        return <TextAreaFieldFormView
                            key={index}
                            field={field}
                        />
                    } else if (field.class == ImageFieldClass) {
                        return <ImageFieldFormView
                            key={index}
                            field={field}

                        />
                    } else if (field.class == OptionsFieldClass) {
                        return <OptionsFieldFormView
                            key={index}
                            field={field}
                        />
                    } else if (field.class == LocationFieldClass) {
                        return <LocationFieldFormView
                            key={index}
                            field={field}
                        />
                    }
                })
            }
        </div>
    )
}