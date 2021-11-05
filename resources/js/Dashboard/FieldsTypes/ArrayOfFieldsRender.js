import React from 'react'

import { StringFieldClass, StringFieldRender } from './StringField'
import { TextAreaFieldClass, TextAreaFieldRender } from './TextAreaField'
import { ImageFieldClass, ImageFieldRender } from './ImageField'
import { LocationFieldClass, LocationFieldRender } from './LocationField'
import { OptionsFieldClass, OptionsFieldRender } from './OptionsField'

export default function ArrayOfFieldsRender(props) {

    const array_of_fields = props.array_of_fields

    return (
        <div>
            {
                array_of_fields?.fields.map((field, index) => {
                    if (field.class == StringFieldClass) {
                        return <StringFieldRender
                            key={index}
                            field={field}
                        />
                    } else if (field.class == TextAreaFieldClass) {
                        return <TextAreaFieldRender
                            key={index}
                            field={field}
                        />
                    } else if (field.class == ImageFieldClass) {
                        return <ImageFieldRender
                            key={index}
                            field={field}

                        />
                    } else if (field.class == OptionsFieldClass) {
                        return <OptionsFieldRender
                            key={index}
                            field={field}
                        />
                    } else if (field.class == LocationFieldClass) {
                        return <LocationFieldRender
                            key={index}
                            field={field}
                        />
                    }
                })
            }
        </div>
    )
}