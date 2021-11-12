import React from "react";
import { useParams } from "react-router";
import {Api} from '../utility/Urls'
import {logError} from '../utility/helpers';

export default function ServiceProviderShow(props) {
    const { id } = useParams()
    const [provider, setprovider] = React.useState(null)
    async function setup() {
        try {

            const response = await Api.fetchProvider(id)
            console.log('ServiceProviderShow',response.data)
            setprovider(response.data)
        } catch (error) { logError(error,'ServiceProviderShow') }
    }
    React.useEffect(() => {
        setup()
    }, [])
    return (
        <div>
            <div>{provider?.name}</div>
            <img src={provider?.image} height={'200'} className="rounded mx-auto d-block" alt="صورة مزود الخدمة" />

        </div>
    )
}