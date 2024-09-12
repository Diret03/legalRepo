<?php

namespace App\Http\Controllers;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;
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
        $tags = Tag::all()->sortBy('name');

        $groupedTags = $tags->groupBy(function ($tag) {
            return strtoupper(substr($tag->name, 0, 1));
        });

        $perPage = 6;
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
