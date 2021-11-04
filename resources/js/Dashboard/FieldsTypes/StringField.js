import React from 'react'
import {BsCardList} from 'react-icons/bs'
export const StringFieldClass = 'App\\FieldsTypes\\StringField'

export function StringFieldInput(props) {
    const field = props.field
    const dispatch = props.dispatch

    return <div >
        <div style={{ fontSize: 20, fontWeight: 'bold' }}>{field.label}</div>
        <input
            style={{ borderWidth: 1, borderRadius: 10, marginVertical: 5 }}
            onChangeText={(text) => {
                dispatch(text)
            }}
            value={field.value}
        />
    </div>
}

export function StringFieldRender(props) {
    const field = props.field
    return <div >
        <div>{field.label}</div>
        <input
            style={{ borderWidth: 1, borderRadius: 10, marginVertical: 5 }}
            value={field.value??''}
            disabled
        />
    </div>
}

export function StringFieldFormView(props) {
    const field = props.field
    return <div style={{
        marginHorizontal: 8,
        borderWidth: 0.5,
        borderColor: '#d1c5c5',
        borderRadius: 10,
        marginVertical: 5,
    }}>
        <div style={{ flexDirection: 'row', borderBottomWidth: 0.5, }}>
            <BsCardList size={24} />
            <div style={{ marginLeft: 5, flex: 1, }}>
                <div style={{ color: 'black', fontSize: 17, flex: 1, fontWeight: 'bold' }}>{field.label}</div>
                <div style={{ color: 'grey', fontSize: 10, }}>حقل نصي</div>
            </div>
        </div>
        <div style={{ color: 'black', fontSize: 20, flex: 1, textAlign: 'center', padding: 10, backgroundColor: '#f5f0f0' }}>{field.value}</div>
    </div>
}



export function StringFieldCreator(props) {
    const set = props.set

    return <div style={{ marginVertical: 10 }}>
        <div>اكتب النص الذي يصف هذا الحقل للزبون</div>
        <input
            style={{ borderWidth: 1, borderRadius: 10, marginVertical: 5 }}
            onChangeText={(text) => {
                set({
                    label: text, class: StringFieldClass, value: null
                })
            }}
        />
    </div>
}

export function StringFieldEditor(props) {
    const field = props.field
    const dispatch = props.dispatch
    const [label, setlabel] = React.useState(field.label)
    const [value, setvalue] = React.useState(field.value)

    return (
        <div style={{ marginVertical: 15 }}>

            <div style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
                <div>حقل نصي</div>
            </div>

            <input style={{ fontSize: 12, borderWidth: 1, borderColor: '#dec9c8', borderRadius: 10 }}
                onChangeText={(text) => {
                    setlabel(text)
                    dispatch({
                        class: StringFieldClass, label: text, value: value
                    })
                }}
                value={label}
            />
            <input
                style={{ borderWidth: 1, borderColor: '#dec9c8', borderRadius: 10, marginVertical: 5 }}
                onChangeText={(text) => {
                    setvalue(text)
                    dispatch({
                        class: StringFieldClass, label: label, value: value
                    })
                }}
                value={value}
            />
        </div>
    )
}