import React from "react"
import { Routes, Api } from './utility/Urls'
import { ApiCallHandler } from './utility/helpers'
import OrdersTable from "./components/OrdersTable"
import ReviewsTable from "./components/ReviewsTable"
import { Row, Col } from 'react-bootstrap'
import ReportsTable from "./components/ReportsTable"

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
            <Row>
                <Col xs={3}>
                    <div>عدد المستخدمين {data?.usersCount}</div>
                    <div>عدد المزوديين {data?.ProvidersCount}</div>
                    <div>عدد المزوديين المفعليين {data?.activatedProvidersCount}</div>

                    <div>عدد المدراء {data?.adminsCount}</div>
                    <div>عدد التصنيفات {data?.categoriesCount}</div>
                    <div>عدد الطلبات {data?.ordersCount}</div>
                    <div>عدد التقيمات {data?.reviewsCount}</div>
                    <div>عدد طلبات تسجيل مزود {data?.providerEnrollmentRequestsCount}</div>
                    <div>عدد اشعارات المزودين {data?.providerNotificationsCount}</div>
                    <div>عدد التقارير {data?.reportsCount}</div>
                    <div>عدد الخدمات المفعلة {data?.approvedServicesCount}</div>
                    <div>عدد الخدمات المقترحة {data?.notApprovedServicesCount}</div>
                    <div>عدد اشعارات المستخدمين {data?.userNotificationsCount}</div>
                </Col>
                <Col xs={9}>
                    <h4>اخر {data?.latestOrders.length} الطلبات</h4>
                    <OrdersTable orders={data?.latestOrders} />
                    <h4>اخر {data?.latestReports.length} تقارير</h4>
                    <ReportsTable reports={data?.latestReports} />
                
                    <h4>اخر {data?.latestReviews.length} تقييمات</h4>
                    <ReviewsTable reviews={data?.latestReviews} />
                </Col>
            </Row>
        </div>
    )
}