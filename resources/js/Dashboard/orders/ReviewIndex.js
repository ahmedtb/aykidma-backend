import React from "react";
import {Api} from "../utility/Urls";
import { ApiCallHandler } from "../utility/helpers";
import ReviewsTable from '../components/ReviewsTable'

export default function ReviewsIndex(props) {
    const [reviews, setreviews] = React.useState([])
    async function setup() {
        ApiCallHandler(async () => await Api.fetchReviews(['user']),
            setreviews,
            'ReviewsIndex',
            true
        )
    }
    React.useEffect(() => {
        setup()
    }, [])

    return (
        <div>
            <ReviewsTable reviews={reviews} />
        </div>
    )
}