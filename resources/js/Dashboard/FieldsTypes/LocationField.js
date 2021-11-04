import React from 'react'

import { AiFillFileImage } from 'react-icons/ai';
// import LocationModal from '../components/LocationModal'
export const LocationFieldClass = 'App\\FieldsTypes\\LocationField'

export function LocationFieldInput(props) {
    const field = props.field
    const dispatch = props.dispatch

    return <div >
        <div style={{}}>
            <div style={{ fontSize: 20, textAlign: 'center', fontWeight: 'bold', }}>{field.label}</div>
        </div>
        {/* <LocationPicker
            onChange={(value) => { dispatch(value) }}
            value={field.value}
        /> */}
    </div>
}

export function LocationFieldRender(props) {
    const field = props.field

    return <div className='my-2'>
        <div className='m-1'>
            <div className='text-center' style={{ fontWeight: 'bold' }}>{field.label}</div>
        </div>
        <img src={('/assets/MapIcon.png')} height={100} />
    </div>
}

export function LocationFieldFormView(props) {
    const [locationModalVisibility, setLocationModalVisibility] = React.useState(false)
    const field = props.field

    const value = field.value.latitude + ", " + field.value.longitude;
    return (
        <div style={{
            marginHorizontal: 8,
            borderWidth: 0.5,
            borderColor: '#d1c5c5',
            borderRadius: 10,
            marginVertical: 5,
        }}>
            <div style={{ flexDirection: 'row', borderBottomWidth: 0.5, }}>
                <AiFillFileImage  size={24} />
                <div style={{ marginLeft: 5 }}>
                    <div style={{ color: 'black', fontSize: 17, flex: 1, fontWeight: 'bold' }}>{field.label}</div>
                    <div style={{ color: 'grey', fontSize: 10, }}>حقل اختيار صورة</div>
                </div>
            </div>
            <button style={{ flex: 1, backgroundColor: '#d1c5c5' }} onPress={() => setLocationModalVisibility(true)}>
                <div style={{ color: 'blue', fontSize: 20, textAlign: 'center' }}>{value}</div>
            </button>
            {/* <LocationModal
                visible={[locationModalVisibility, setLocationModalVisibility]}
                latitude={field.value.latitude} longitude={field.value.longitude}
            /> */}
        </div>
    )
}


export function LocationFieldCreator(props) {
    const set = props.set
    return <div style={{ marginVertical: 10 }}>
        <div>اكتب النص الذي يصف حقل تحديد الموقع للزبون</div>
        <input
            style={{ borderWidth: 1, borderRadius: 10, marginVertical: 5 }}
            onChangeText={(text) => {
                set({
                    label: text, class: LocationFieldClass,
                    value: {
                        latitude: null,
                        longitude: null
                    }
                })
            }}
        />
        <img src={'/assets/MapIcon.png'} style={{ width: 100, height: 100 }} />

    </div>
}

export function LocationFieldEditor(props) {

    const field = props.field
    const dispatch = props.dispatch
    const [label, setlabel] = React.useState(field.label)
    // const [value, setvalue] = React.useState(field.value)

    return <div >
        <div style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
            <div>حقل تحديد الموقع</div>
        </div>

        <div style={{ margin: 8 }}>

            <input style={{ textAlign: 'center', fontSize: 20, fontWeight: 'bold', borderWidth: 1, borderColor: '#dec9c8', borderRadius: 7 }}
                onChangeText={(text) => {
                    setlabel(text)
                    dispatch({
                        class: LocationFieldClass, label: text, value: field.value
                    })
                }}
                value={label}
                multiline={true}
            />
        </div>
        <img src={'/assets/MapIcon.png'} style={{ width: 100, height: 100 }} />
    </div>
}
