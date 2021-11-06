import React from "react";
import ApiEndpoints from "../utility/ApiEndpoints";
import { ApiCallHandler } from "../utility/helpers";
import UsersTable from "./components/UsersTable";

export default function UsersIndex() {
    const [users, setusers] = React.useState([])
    function setup() {
        ApiCallHandler(
            async () => await ApiEndpoints.fetchUsers(),
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