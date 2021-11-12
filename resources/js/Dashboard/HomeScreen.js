import React from "react"
import { Routes, Api } from './utility/Urls'
import { ApiCallHandler } from './utility/helpers'
import OrdersTable from "./components/OrdersTable"

export default function HomeScreen(props) {
    const [data, setdata] = React.useState()
    React.useEffect(() => {
        ApiCallHandler(
            async () => await Api.home(),
            setdata,
            'HomeScreen',
            true
        )
    }, [])

    return (
        <div>
            <div>عدد المستخدمين {data?.usersCount}</div>
            <div>عدد المدراء {data?.adminsCount}</div>
            <div>عدد التصنيفات {data?.categoriesCount}</div>
            <div>عدد الطلبات {data?.ordersCount}</div>
            <div>عدد التقيمات {data?.reviewsCount}</div>
            <div>عدد طلبات تسجيل مزود {data?.providerEnrollmentRequestsCount}</div>
            <div>عدد اشعارات المزودين {data?.providerNotificationsCount}</div>
            <div>عدد التقارير {data?.reportsCount}</div>
            <div>عدد الخدمات {data?.servicesCount}</div>
            <div>عدد اشعارات المستخدمين {data?.userNotificationsCount}</div>
            <OrdersTable orders={data?.latestOrders} />
        </div>
    )
}