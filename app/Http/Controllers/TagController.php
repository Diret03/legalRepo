<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\LegalCase;

class TagController extends Controller
{

    //    public function list()
    //    {
    //        $tags = Tag::all()->sortBy('name')->groupBy(function ($tag) {
    //            return strtoupper(substr($tag->name, 0, 1));
    //        })->paginate(5);
    ////        dd($tags);
    //        return view('tags', compact('tags'));
    //    }

    public function list()
    {
        // Retrieve tags that are associated with at least one accepted case
        $acceptedTags = Tag::whereHas('cases', function ($query) {
            $query->where('status', 'accepted')->whereHas('user', function ($q) {
                $q->where('status', true);
            });
        })
            ->withCount(['cases as accepted_cases_count' => function ($query) {
                $query->where('status', 'accepted');
            }])
            ->get()
            ->sortBy('name');


        // dd($acceptedTags);

        // Group the accepted tags by the first letter of their name
        $groupedTags = $acceptedTags->groupBy(function ($tag) {
            return strtoupper(substr($tag->name, 0, 1));
        });


        $perPage = 8;
        $currentPage = request()->get('page', 1);
        $offset = ($currentPage - 1) * $perPage;
        $paginatedTags = new LengthAwarePaginator(
            $groupedTags->slice($offset, $perPage),
            $groupedTags->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('tags', compact('paginatedTags'));
    }
}
