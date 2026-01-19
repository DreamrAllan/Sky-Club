<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreReviewRequest;
use App\Http\Requests\UpdateReviewRequest;

class ReviewController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReviewRequest $request)
    {
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
            'review' => 'required',
        ]);
        Review::create([
            'id_user' => Auth::id(),
            'id_booking' => $request->booking,
            'rating' => $request->rating,
            'comment' => $request->review,
        ]);
        return redirect()->route('profile.show')->with(['activeTab' => 'history', 'activeBookingTab' => 'sparing']);
    }
}
