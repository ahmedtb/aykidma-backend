import React from 'react'

import { BsCardList } from 'react-icons/bs'
// import ListOptions from '../components/ListOptions'
// import ModalWrapper from '../components/ModalWrapper'
export const OptionsFieldClass = 'App\\FieldsTypes\\OptionsField'

export function OptionsFieldInput(props) {
    const field = props.field
    const dispatch = props.dispatch

    return <div >
        <div style={{ fontSize: 20, fontWeight: 'bold' }}>{field.label}</div>
        {/* <ListOptions
            onChange={
                (option) => {
                    dispatch(option)
                }
            }
            choice={field.value}
            list={field.options} label='اختر' /> */}
    </div>
}

export function OptionsFieldRender(props) {
    const field = props.field
    return <div>
        <div style={{fontWeight: 'bold' }}>{field.label}</div>
        <div>الاختيارات المتاحة</div>
        {field.options.map((title, index) => (
            <div key={index}>
                {title}
            </div>
        ))}
    </div>
}

export function OptionsFieldFormView(props) {
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
                <div style={{ color: 'grey', fontSize: 10, }}>حقل اختيارات</div>
            </div>
        </div>
        <div style={{ color: 'black', fontSize: 20, flex: 1, textAlign: 'center', padding: 5, backgroundColor: '#f5f0f0' }}>{field.value}</div>
    </div>
}


export function OptionsFieldCreator(props) {
    const set = props.set
    const [label, setLabel] = React.useState(null)
    const [title, setTitle] = React.useState(null)
    const [options, setoptions] = React.useState([])

    function addTitle(title) {
        if (!title)
            return
        set({
            label: label, class: OptionsFieldClass, options: [...options, title], value: null
        })
        setoptions([...options, title])
        setTitle(null)
    }
    function addLabel(label) {
        set({
            label: label, class: OptionsFieldClass, options: options, value: null
        })
        setLabel(label)
    }

    return (
        <div>

            <div>اكتب النص الذي يصف مساحة النص هذه للزبون</div>
            <divInput style={{ fontSize: 20, fontWeight: 'bold', borderWidth: 1, borderRadius: 7 }}
                onChangeText={(text) => {
                    addLabel(text)
                }}
            />

            {
                options?.map((addedTitle, index) => (
                    <div key={index} >
                        <div>{addedTitle}</div>
                    </div>
                ))
            }

            <divInput style={{ fontSize: 12, borderWidth: 1 }}
                value={title}
                onChangeText={setTitle}
            />
            <button onClick={() => {
                addTitle(title)
            }}>
                <div style={{ fontSize: 20, backgroundColor: 'grey' }}>add title</div>
            </button>
        </div>
    )
}



export function OptionsFieldEditor(props) {
    const field = props.field
    const dispatch = props.dispatch
    const [options, setoptions] = React.useState(field.options)
    const [label, setlabel] = React.useState(field.label)

    const [visible, setVisible] = React.useState(false)

    function onTitleChange(title, index) {
        let changedArray = [...options]
        changedArray[index] = title
        setoptions(changedArray)
        dispatch({
            label: label, class: OptionsFieldClass, options: options, value: null
        })
    }


    return <div style={{ marginVertical: 15 }}>
        <div style={{ flexDirection: 'row', justifyContent: 'space-between' }}>
            <div>حقل اختياري</div>
        </div>
        <divInput style={{ fontSize: 20, fontWeight: 'bold', borderWidth: 1, borderColor: '#dec9c8', borderRadius: 7 }}
            onChangeText={(text) => {
                setlabel(text)
                dispatch({
                    label: text, class: OptionsFieldClass, options: options, value: null
                })
            }}
            value={field.label}
        />
        <div >
            <div style={{ padding: 5 }}>
                <button onClick={() => setVisible(true)}>
                    <div style={{ borderWidth: 1, borderRadius: 10, marginVertical: 5, textAlign: 'center', padding: 7, fontSize: 18 }}>
                        {field.options.map((title, index) => (
                            <div key={index}>{title}</div>
                        ))}
                    </div>
                </button>
            </div>

            {/* <ModalWrapper visible={visible}>

                <div>
                    {options.map((title, index) => (
                        <divInput key={index} style={{ fontSize: 12, borderWidth: 1 }}
                            onChangeText={(text) => {
                                onTitleChange(text, index)
                            }}
                            value={title}
                        />
                    ))}
                </div>


                <div style={{ flexDirection: 'row', justifyContent: 'center' }}>

                    <Pressable
                        onClick={() => setVisible(!visible)}
                    >
                        <div >اغلاق</div>
                    </Pressable>

                </div>

            </ModalWrapper> */}
        </div >
    </div>
}
