<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use Inertia\Inertia;
use Inertia\Response;

class CampaignController extends Controller
{
    public function show(): Response
    {
        return Inertia::render('public/Campaign/Show');
    }
}
