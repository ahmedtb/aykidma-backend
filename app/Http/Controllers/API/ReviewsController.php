<?php

namespace App\Http\Controllers\API;

use App\Models\Offer;

use App\Rules\Base64Rule;
use App\Models\Service;
use App\Rules\LongString;
use Illuminate\Http\Request;
use App\Models\ServiceProvider;
use App\Rules\ArrayOfFieldsRule;
use App\Http\Controllers\Controller;
use App\Rules\PhoneNumberRule;
use Illuminate\Validation\ValidationException;

class ReviewsController extends Controller
{
    public function editReview(Request $request)
    {
        $request->validate([
            'id' => 'required|integer',
            'comment' => 'required_without:rating|string',
            'rating' => 'required_without:comment|min:0|max:5'
        ]);

        $review = $request->user('user')->reviews()->where('id', $request->id)->first();

        if ($review) {
            $review->update([
                'comment' => $request->comment,
                'rating' => $request->rating,
            ]);
            return response(['success' => 'review edited']);
        } else
            return response(['failed' => 'there is no a review that belongs to you with this id'], 400);
    }

    public function fetchReviews($id)
    {
        validator(['id' => $id], [
            'id' => 'required|exists:services,id'
        ])->validate();
        $service = Service::where('id', $id)->first();
        return $service->reviews;
    }
}
