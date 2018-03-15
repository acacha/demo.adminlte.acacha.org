<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddEmailToNewsletterRequest;
use Newsletter;

/**
 * Class NewsletterController.
 *
 * @package App\Http\Controllers
 */
class NewsletterController extends Controller
{
    /**
     * Store email in newsletter
     *
     * @param AddEmailToNewsletterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AddEmailToNewsletterRequest $request)
    {
        $result = Newsletter::subscribePending($request->email);

        if ($result) {
            return redirect('/')->with(['msg' => 'Done!']);
        }

        return redirect('/')->with(['error'  => 'Already subscribed!']);
    }
}
