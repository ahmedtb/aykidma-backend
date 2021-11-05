import React from "react";
import {logError} from '../utility/helpers'
import ApiEndPoints from '../utility/ApiEndpoints'

export default function DoneOrdersIndex(){
        
    async function setup(){
        try{
            const response = await ApiEndPoints.fetchOrders('done', true, true, true)
            console.log('DoneOrdersIndex setup', response.data)
        }catch(error){logError(error)}
    }
    React.useEffect(() => {
        setup()
    }, [])
    
    return (
        <div>

        </div>
    )
}