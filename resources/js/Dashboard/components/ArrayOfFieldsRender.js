import React from 'react'

export default function ArrayOfFieldsRender(props) {
    const array_of_fields = props.array_of_fields
    const fields = array_of_fields.fields

    return fields.map((field,index) => {
        if (field.class == 'App\\FieldsTypes\\OptionsField') {
            // console.log(field.class)
            return <div key={index}>
                <p className="text-center mb-0">{field.label}</p>
                <div className="border border-dark rounded d-flex flex-row justify-content-around">
                    {/* {
                        field.titles.map((title, index) => (
                            <p key={index} className='mb-0'>{title} </p>
                        ))
                    } */}
                </div>
            </div>
        } else if (field.class == 'App\\FieldsTypes\\StringField') {

        } else if (field.class == 'App\\FieldsTypes\\TextAreaField') {
            return <div key={index}>   <p className="text-center mb-0">{field.label}</p>
                <div className="border border-dark rounded d-flex flex-row justify-content-around p-4">
                </div></div>
        } else if (field.class == 'App\\FieldsTypes\\LocationField') {

        } else if (field.class == 'App\\FieldsTypes\\ImageField') {
            return <div key={index}>
                <p className="text-center mb-0">{field.label}</p>
                <div className="border border-dark rounded d-flex flex-row justify-content-around p-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="50" height="50" fill="currentColor"
                        className="bi bi-camera-fill" viewBox="0 0 16 16">
                        <path d="M10.5 8.5a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z" />
                        <path
                            d="M2 4a2 2 0 0 0-2 2v6a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V6a2 2 0 0 0-2-2h-1.172a2 2 0 0 1-1.414-.586l-.828-.828A2 2 0 0 0 9.172 2H6.828a2 2 0 0 0-1.414.586l-.828.828A2 2 0 0 1 3.172 4H2zm.5 2a.5.5 0 1 1 0-1 .5.5 0 0 1 0 1zm9 2.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0z" />
                    </svg>
                </div>
            </div>
        }
    })
}