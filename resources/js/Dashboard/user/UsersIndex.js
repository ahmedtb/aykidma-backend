import React from "react";
import {Api} from "../utility/Urls";
import { ApiCallHandler } from "../utility/helpers";
import UsersTable from "./components/UsersTable";

export default function UsersIndex() {
    const [users, setusers] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await Api.fetchUsers(),
            setusers,
            'UsersIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>
            <UsersTable services={users}/>
        </div>
    )
}