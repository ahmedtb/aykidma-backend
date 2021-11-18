
import axios from "axios";
import { identity, random } from "lodash";

export function getRandomKey() {
    return random(0, 10000000)
}

export function convertFileToBase64(file) {
    return new Promise((resolve, reject) => {
        const reader = new FileReader();
        reader.readAsDataURL(file);
        reader.onload = () => resolve(reader.result);
        reader.onerror = reject;
    });
}


export function logError(error, sourceName = '') {
    // if (sourceName)
    //     console.log('error from: ', sourceName)
    if (error.response) {
        // Request made and server responded
        console.log(sourceName, error.response.data);
        console.log(sourceName, error.response.status);
        console.log(sourceName, error.response.headers);
        console.log(sourceName, 'url' + error.response.request.responseURL);
    } else if (error.request) {
        // The request was made but no response was received
        console.log(sourceName, error.request);
    } else {
        // Something happened in setting up the request that triggered an Error
        console.log('Error', error.message);
    }
    console.log(sourceName, error.stack)
}

export async function post(url, params = null, setData = null, callerIdentifier = null, logData = false) {
    try {
        const response = await axios.post(url, params)
        if (setData)
            setData(response.data)
        if (callerIdentifier && logData)
            console.log(callerIdentifier, response.data)
        return response
    } catch (error) {
        logError(error, callerIdentifier)
    }
}

export async function get(url, params = null, setData = null, callerIdentifier = null, logData = false) {
    try {
        const response = await axios.get(url, params)
        if (setData)
            setData(response.data)
        if (callerIdentifier && logData)
            console.log(callerIdentifier, response.data)
        return response
    } catch (error) {
        logError(error, callerIdentifier)
    }
}


export async function ApiCallHandler(ApiEndpoint, setData = null, Identifier = '', logData = false) {
    try {
        const response = await ApiEndpoint()
        if (setData)
            setData(response.data)
        if (Identifier && logData)
            console.log(Identifier, response.data)
    } catch (error) {
        logError(error, Identifier)
    }
}