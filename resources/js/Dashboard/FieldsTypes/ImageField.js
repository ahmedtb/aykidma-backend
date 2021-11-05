import React from 'react'

import {convertFileToBase64} from '../utility/helpers'
import { BsCameraFill } from 'react-icons/bs'
import { AiFillFileImage } from 'react-icons/ai'

export const ImageFieldClass = 'App\\FieldsTypes\\ImageField'

export function ImageFieldInput(props) {

    const field = props.field
    const dispatch = props.dispatch
    return <div>
        <strong style={{ textAlign: 'center', fontSize: 20, fontWeight: 'bold' }}>{field.label}</strong>
        <input
            type='file'
            accept=".jpg"
            onChange={(e) => {
                const file = e.target.files[0]
                // console.log('ImageFieldInput', file)
                convertFileToBase64(file).then((base64) => {
                    dispatch(base64)
                })
            }}
        />
    </div>
}
export function ImageFieldRender(props) {
    const field = props.field

    return <div style={{ marginVertical: 10, alignItems: 'center', justifyContent: 'center', borderWidth: 1 }}>
        <div style={{ margin: 8 }}>
            <strong style={{ fontSize: 20, textAlign: 'center', fontWeight: 'bold' }}>{field.label}</strong>
        </div>
        <BsCameraFill size={75} />
    </div>
}

export function ImageFieldFormView(props) {
    const field = props.field

    // const value = field.value.latitude + ", " + field.value.longitude;
    return (
        <div style={{
            marginHorizontal: 8,
            borderWidth: 0.5,
            borderColor: '#d1c5c5',
            borderRadius: 10,
            marginVertical: 5,
        }}>
            <div style={{ flexDirection: 'row', borderBottomWidth: 0.5, }}>
                <AiFillFileImage size={24} color="grey" />
                <div style={{ marginLeft: 5, flex: 1, }}>
                    <strong style={{ color: 'black', fontSize: 17, flex: 1, fontWeight: 'bold' }}>{field.label}</strong>
                    <strong style={{ color: 'grey', fontSize: 10, }}>حقل اختيار صورة</strong>
                </div>
            </div>
            <div style={{ backgroundColor: '#f5f0f0', alignItems: 'center' }}>
                <img src={'data:image/jpg;base64,' + field.value} width={150} />
                {/* <Image source={{ uri: 'data:image/png;base64,' + field.value }} style={{ width: 150, height: 150, borderRadius: 7 }} /> */}
            </div>

        </div>
    )
}

export function ImageFieldCreator(props) {
    const set = props.set

    return <div style={{ marginVertical: 10, alignItems: 'center', justifyContent: 'center', borderWidth: 1 }}>
        <strong>اكتب النص الذي يصف حقل تحديد الموقع للزبون</strong>
        <input
            style={{ borderWidth: 1, borderRadius: 10, marginVertical: 5 }}
            onChangeText={(text) => {
                set({
                    label: text,
                    class: ImageFieldClass,
                    value: null
                })
            }}
        />
        <BsCameraFill size={75} />

    </div>
}

export function ImageFieldEditor(props) {
    const field = props.field
    const dispatch = props.dispatch
    const [label, setlabel] = React.useState(field.label)
    const [value, setvalue] = React.useState(field.value)

    return <div>
        <div style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
            <strong>حقل اختار صورة</strong>
        </div>

        <input style={{ fontSize: 12, borderWidth: 1, borderColor: '#dec9c8', borderRadius: 10 }}
            onChangeText={(text) => {
                setlabel(text)
                dispatch({
                    class: ImageFieldClass, label: text, value: value
                })
            }}
            value={field.label}
        />

        <input
            type='file'
            accept=".jpg"
            onChange={(e) => {
                const file = e.target.files[0]
                // console.log('ImageFieldInput', file)
                convertFileToBase64(file).then((base64) => {
                    setvalue(base64)
                    dispatch({ class: ImageFieldClass, label: label, value: base64 })
                })
            }}
        />
    </div>
}
