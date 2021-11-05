import React from "react";
import ApiEndpoints from "../utility/ApiEndpoints";
import { logError } from "../utility/helpers";

export default function ServiceProviderIndex(props) {
    const [providers, setproviders] = React.useState([])
    async function setup() {
        try {

            const response = await ApiEndpoints.fetchProviders(null, ['user'])
            setproviders(response.data)
            console.log('ServiceProviderIndex', response.data)
        } catch (error) { logError }
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>

        </div>
    )
}