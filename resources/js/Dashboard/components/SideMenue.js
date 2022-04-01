import React from 'react'
import { Row, Col, Button } from 'react-bootstrap'
import { Link } from 'react-router-dom'
import { Routes } from '../utility/Urls'
import {BsListOl}from 'react-icons/bs'
import { refreshUser } from '../redux/stateActions'
import { connect } from "react-redux"
import AllowedLink from './AllowedLink'

function ToggleLinks(props) {
    const [show, setshow] = React.useState(false)
    const links = props.links
    const label = props.label


    return <div>
        <a onClick={() => setshow(!show)}>{label}</a>
        <div className=''>
            {
                show ? links.map((link, index) => <AllowedLink key={index} className='my-2 text-white text-decoration-none' to={link.to}>
                    <div className='m-5'>
                        {link.label}
                    </div>
                </AllowedLink>) : null
            }
        </div>
    </div>
}

function SideMenue(props) {

    const [hide, sethide] = React.useState(false);


    if (hide)
        return <Col xs={1} className='bg-dark text-white p-1 ' >
            <Button onClick={() => sethide(!hide)}><BsListOl /></Button>
            <div className='text-center'> لوحة تحكم {props.user?.userable?.type} </div>
        </Col>
    else
        return <Col xs={3} className='bg-dark text-white p-1 ' >
            <Button onClick={() => sethide(!hide)}><BsListOl /></Button>
            <AllowedLink className='text-white text-decoration-none' to={Routes.dashboard()}>
                <div className='text-center fs-5'> لوحة تحكم {props.user?.name} </div>

            </AllowedLink>
            <div className='p-3'>


                <AllowedLink hide={true} className="nav-link mx-2" to={Routes.CategoriesScreen}>
                    <BsListOl />التصنيفات</AllowedLink>

                <AllowedLink hide={true} className="nav-link mx-2" to={Routes.reportsIndex()}>
                    <BsListOl />التقارير</AllowedLink>

                <ToggleLinks
                    label={<div className='d-flex'>
                        <BsListOl size={25} />
                        <div className=' mx-2'>المطالبات</div>
                    </div>}
                    links={[
                        { label: 'قائمة مزويدي الخدمات', to: Routes.serviceProvidersIndex() },
                        { label: 'قائمة الاشعارات', to: Routes.providerNotificationsIndex() },
                        { label: 'طلبات تسجيل كمزوّد', to: Routes.providerEnrollmentRequestsIndex() }
                    ]}
                />
                <ToggleLinks
                    label={'المستخدمين'}
                    links={[
                        { label: 'قائمة المستخدمين', to: Routes.usersIndex() },
                        { label: 'الاشعارات', to: Routes.userNotificationsIndex() },
                    ]}
                />

                <ToggleLinks
                    label={'الخدمات'}
                    links={[
                        { label: 'خدمات مفعلة', to: Routes.approvedServicesIndex() },
                        { label: 'خدمات مقترحه', to: Routes.notApprovedServicesIndex() },
                    ]}
                />
                <ToggleLinks
                    label={'الطلبات'}
                    links={[
                        { label: 'طلبات جديد', to: Routes.newOrders() },
                        { label: 'طلبات مستانفة', to: Routes.resumedOrders() },
                        { label: 'طلبات مكتملة', to: Routes.doneOrders() },
                        { label: 'التعليقات', to: Routes.reviewsIndex() },

                    ]}
                />

            </div>


        </Col >


}


const mapStateToProps = state => {
    return {
        user: state.state.user,
        allowedRoutes: state.state.allowedRoutes,
    }
}

const mapDispatchToProps = dispatch => {
    return {
        refreshUser: (user) => dispatch(refreshUser(user)),
    }
}


export default connect(mapStateToProps, mapDispatchToProps)(SideMenue)