<?php

namespace App\Http\Controllers;

use App\Models\Subject;
use Illuminate\Http\Request;
use App\Models\Trial;
use App\Models\LegalCase;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Route;
use App\Notifications\CaseAccepted;
use Barryvdh\DomPDF\Facade\Pdf;

class CaseController extends Controller
{

    public function index(Request $request)
    {

        Gate::authorize('viewAny', LegalCase::class);

        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $cases = LegalCase::orderBy($sortField, $sortDirection)
            ->whereHas('user', function ($q) {
                $q->where('status', true);
            })
            ->paginate(10);
        $trials = Trial::all();

        // Append sort parameters to pagination links
        $cases->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('cases.index', compact('cases', 'trials', 'sortField', 'sortDirection'));
    }

    public function archived(Request $request)
    {
        Gate::authorize('viewArchived', LegalCase::class);

        $sortField = $request->query('sort', 'updated_at'); // default sort field
        $sortDirection = $request->query('direction', 'desc'); // default sort direction

        $cases = LegalCase::onlyTrashed()
            ->orderBy($sortField, $sortDirection)
            ->paginate(10);

        // Append sort parameters to pagination links
        $cases->appends(['sort' => $sortField, 'direction' => $sortDirection]);

        return view('cases.archived', compact('cases'));
    }

    public function list(Request $request)
    {
//        $sortField = $request->query('sort', 'id'); // default sort field
//        $sortDirection = $request->query('direction', 'asc'); // default sort direction
//        $sortField = $request->query('sort', 'id');
        $sortField = in_array(strtolower($request->query('sort')), ['updated_at', 'id'])
            ? strtolower($request->query('sort'))
            : 'id';

        $sortDirection = in_array(strtolower($request->query('direction')), ['asc', 'desc'])
            ? strtolower($request->query('direction'))
            : 'asc';


        $page = $request->query("page", 1);

        $cases = LegalCase::where('status', 'accepted')
            ->orderBy($sortField, $sortDirection)
            ->whereHas('user', function ($q) {
                $q->where('status', true);
            })
            ->paginate(10);

        // Append sort parameters to pagination links
        $cases->appends(['sort' => $sortField, 'direction' => $sortDirection]);


        $trials = Trial::withCount(['cases' => function ($query) {
            $query->where('status', 'accepted')
                ->whereHas('user', function ($q) {
                    $q->where('status', true);
                });
        }])->orderBy('name', 'asc')->get();

        // Get subjects along with the count of accepted cases via trials
        $subjects = Subject::with(['trials' => function ($query) {
            $query->withCount(['cases' => function ($caseQuery) {
                $caseQuery->where('status', 'accepted')
                    ->whereHas('user', function ($q) {
                        $q->where('status', true);
                    });
            }]);
        }])->get();

        // Add a 'cases_count' attribute to each subject by summing the cases of its related trials
        foreach ($subjects as $subject) {
            $subject->cases_count = $subject->trials->sum('cases_count');
        }

        $tags = Tag::whereHas('cases', function ($query) {
            $query->where('status', 'accepted')
                ->whereHas('user', function ($q) {
                    $q->where('status', true);
                });
        })->get();

        // Return the data to the view
        return view('cases.list', compact('cases', 'trials', 'subjects', 'sortField', 'sortDirection', 'tags'));
    }

    public function create()
    {
        Gate::authorize('create', LegalCase::class);

        $trials = Trial::all();
        $subjects = Subject::all();
        $users = User::orderBy('last_name', 'asc')
            ->where('status', true)->get();
        $tags = Tag::whereHas('cases', function ($query) {
            $query->where('status', 'accepted')
                ->whereHas('user', function ($q) {
                    $q->where('status', true);
                });
        })->get();

        return view('cases.create', compact('trials', 'users', 'subjects', 'tags'));
    }

    public function store(Request $request)
    {
        $validated_data = $request->validate([
            'title' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'trial_id' => 'required|exists:trials,id',
            'status' => 'nullable|string|in:pending,accepted,rejected',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'required|string',
            'tags' => 'nullable|array|max:5', // must be an array and has at most 5 items
            'tags.*' => 'string|distinct|min:3|max:50', // each tag must be a string, at least 3 characters, and at most 50 characters
        ], [
            'context.required' => 'El campo contexto es obligatorio.',
            'analysis.required' => 'El campo de problema jurídico es obligatorio.',
            'resolution.required' => 'El campo de respuesta es obligatorio.',
            'note.required' => 'El campo de recomendaciones es obligatorio.',
            'tags.*.min' => 'La etiqueta :position debe tener al menos :min caracteres.',
            'tags.*.max' => 'La etiqueta :attribute no debe ser mayor que :max caracteres.',
        ]);

        // null coalescing to check if 'user_id' exists in $validated_data
        $user_id = $validated_data['user_id'] ?? Auth::user()->id;
        $isAdmin = isset($validated_data['user_id']); // Admin if 'user_id' was explicitly set

        $status = $validated_data['status'] ?? 'pending';

        $case = LegalCase::create([
            'title' => $validated_data['title'],
            'user_id' => $user_id,
            'trial_id' => $validated_data['trial_id'],
            'status' => $status,
            'context' => $validated_data['context'],
            'analysis' => $validated_data['analysis'],
            'resolution' => $validated_data['resolution'],
            'note' => $validated_data['note'],
        ]);

        if (!empty($validated_data['tags'])) {
            $formattedTags = [];
            foreach ($validated_data['tags'] as $tag) {
                $formattedTags[] = strtolower($tag);
            }
            $case->syncTags($formattedTags);
        }

        if (!$isAdmin) {
            return redirect()->route('cases.mycases', ['status' => 'pending'])->with('success', 'Juicio subido exitosamente, espera a que sea aprobado.');
        }

        return redirect()->route('cases.index')->with('success', 'Juicio creado exitosamente.');
    }


    public function edit($id)
    {
        $case = LegalCase::findOrFail($id);

//        if($case->status == 'Aceptado' || $case->user_id !== Auth::id()){
//            abort(403);
//        }
        Gate::authorize('update', $case);

        $trials = Trial::all();
        $subjects = Subject::all();
        $users = User::orderBy('last_name', 'asc')
            ->where('status', true)->get();
        $tags = Tag::whereHas('cases', function ($query) {
            $query->where('status', 'accepted')
                ->whereHas('user', function ($q) {
                    $q->where('status', true);
                });
        })->get();

        $myTags = $case->tags->pluck('name')->toArray();

        return view('cases.edit', compact('case', 'trials', 'users', 'subjects', 'tags', 'myTags'));
    }

    public function update(Request $request, $id)
    {
        $case = LegalCase::findOrFail($id);
        Gate::authorize('update', $case);

        $validated_data = $request->validate([
            'title' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'trial_id' => 'required|exists:trials,id',
            'status' => 'nullable|string|in:pending,accepted,rejected',
            'context' => 'required|string',
            'analysis' => 'required|string',
            'resolution' => 'required|string',
            'note' => 'required|string',
            'tags' => 'nullable|array|max:5', // must be an array and has at most 5 items
            'tags.*' => 'string|distinct|min:3|max:50', // each tag must be a string, at least 3 characters, and at most 50 characters
        ], [
            'context.required' => 'El campo contexto es obligatorio.',
            'analysis.required' => 'El campo de problema jurídico es obligatorio.',
            'resolution.required' => 'El campo de respuesta es obligatorio.',
            'note.required' => 'El campo de recomendaciones es obligatorio.',
            'tags.*.min' => 'La etiqueta :attribute debe tener al menos :min caracteres.',
            'tags.*.max' => 'La etiqueta :attribute no debe ser mayor que :max caracteres.',
        ]);

        // null coalescing to check if 'user_id' exists in $validated_data
        $user_id = $validated_data['user_id'] ?? Auth::user()->id;
        $isAdmin = isset($validated_data['user_id']); // Admin if 'user_id' was explicitly set
        $status = $validated_data['status'] ?? 'pending';


        $case->update([
            'title' => $validated_data['title'],
            'user_id' => $user_id,
            'trial_id' => $validated_data['trial_id'],
            'status' => $status,
            'context' => $validated_data['context'],
            'analysis' => $validated_data['analysis'],
            'resolution' => $validated_data['resolution'],
            'note' => $validated_data['note'],
        ]);


        if (!empty($validated_data['tags'])) {
            $formattedTags = [];
            foreach ($validated_data['tags'] as $tag) {
                $formattedTags[] = strtolower($tag);
            }
            $case->syncTags($formattedTags);
        }

        if (!$isAdmin) {
            return redirect()->route('cases.mycases', ['user_id' => Auth::user()->id, 'status' => 'pending'])->with('success', 'Juicio actualizado exitosamente, espera a que sea aprobado.');
        }

        return redirect()->route('cases.index')->with('success', 'Juicio actualizado exitosamente.');
    }


    public function search(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('search');
            $view = $request->input('view');
            $page = max(1, intval($request->input('page', 1))); // Ensure page is an integer and at least 1
            $sortField = $request->input('sort', 'id');
            $sortDirection = $request->input('direction', 'asc');

            if (!empty($query)) {
                $dbDriver = DB::getDriverName();

                // Use ILIKE for PostgreSQL and LIKE for others
                $likeOperator = $dbDriver === 'pgsql' ? 'ILIKE' : 'LIKE';

                // Perform search query
                if ($view == 'mycases') {
                    $cases = LegalCase::where('user_id', Auth::id()) // Mandatory condition
                    ->where(function ($queryBuilder) use ($query, $likeOperator) {
                        $queryBuilder->where('title', $likeOperator, '%' . $query . '%')
                            ->orWhereHas('trial', function ($trialQuery) use ($query, $likeOperator) {
                                $trialQuery->where('name', $likeOperator, '%' . $query . '%')
                                    ->orWhereHas('subject', function ($subjectQuery) use ($query, $likeOperator) {
                                        $subjectQuery->where('name', $likeOperator, '%' . $query . '%');
                                    });
                            });
                    })
                        ->get();
                } elseif ($view == 'all-list') {
                    $queryBuilder = LegalCase::query()->where('status', 'accepted');

                    $subjectIds = $request->input('subject_ids', []);
                    $trialIds = $request->input('trial_ids', []);

                    // Apply subject filter if provided
                    if (!empty($subjectIds)) {
                        $queryBuilder->whereHas('trial.subject', function ($q) use ($subjectIds) {
                            $q->whereIn('id', $subjectIds);
                        });
                    }

                    // Apply trial filter if provided, as an OR condition within the filtered subjects
                    if (!empty($trialIds)) {
                        $queryBuilder->orWhere(function ($q) use ($trialIds) {
                            $q->whereIn('trial_id', $trialIds);
                        });
                    }


                    $queryBuilder->where(function ($q) use ($query, $likeOperator) {
                        $q->where('title', $likeOperator, '%' . $query . '%')
                            ->orWhereHas('trial', function ($trialQuery) use ($query, $likeOperator) {
                                $trialQuery->where('name', $likeOperator, '%' . $query . '%');
                            });
                    });


                    $cases = $queryBuilder->get();
                } else {
                    $cases = LegalCase::where('id', $likeOperator, '%' . $query . '%')
                        ->orWhere('title', $likeOperator, '%' . $query . '%')
                        ->orWhereHas('trial', function ($queryBuilder) use ($query, $likeOperator) {
                            $queryBuilder->where('name', $likeOperator, '%' . $query . '%')
                                ->orWhereHas('subject', function ($subjectQuery) use ($query, $likeOperator) {
                                    $subjectQuery->where('name', $likeOperator, '%' . $query . '%');
                                });
                        })
                        ->get();
                }
            } else {

                if ($view == 'table') {
                    $cases = LegalCase::orderBy('updated_at', 'desc')->paginate(10, ['*'], 'page', $page);
                } elseif ($view == 'mycases') {

                    $user_id = $request->input('user_id');
                    $status = $request->input('status');

                    if ($status != 'all') {
                        $cases = LegalCase::where('user_id', $user_id)
                            ->where('status', $status)
                            ->orderBy('updated_at', 'desc')->paginate(12);
                    } else {
                        $cases = LegalCase::where('user_id', $user_id)
                            ->orderBy('updated_at', 'desc')->paginate(12);
                    }
                } elseif ($view == 'review') {
                    $cases = LegalCase::orderBy('updated_at', 'desc')->paginate(12);
                } elseif ($view == 'all-list') {
                    $cases = LegalCase::where('status', 'accepted')
                        ->orderBy($sortField, $sortDirection)
                        ->paginate(10, ['*'], 'page', $page);

                    $cases->appends([
                        'search' => $query,
                        'view' => $view,
                        'sort' => $sortField,
                        'direction' => $sortDirection
                    ]);
                }
            }
            if (count($cases) > 0) {


                if ($view == 'table') {
                    $output = view('cases.partials.row', ['cases' => $cases])->render();
                } elseif ($view == 'mycases') {
                    $output = view('cases.partials.mylist', ['cases' => $cases])->render();
                } elseif ($view == 'review') {
                    $output = view('cases.partials.reviewlist', ['cases' => $cases])->render();
                } elseif ($view == 'all-list') {
                    $output = view('cases.partials.all-list', [
                        'cases' => $cases,
                        'sortField' => $sortField,
                        'sortDirection' => $sortDirection
                    ])->render();
                }
            } else {
                if ($view == 'table') {
                    $output = '<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                               <td colspan="10" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron resultados</td>
                           </tr>';
                } else {
                    $output =
                        '<div
                        class="flex items-center p-4 mb-4 text-sm text-red-800 border border-red-300 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400 dark:border-red-800"
                        role="alert">
                        <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true"
                             xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                        </svg>
                        <span class="sr-only">Info</span>
                        <div> No se encontraron resultados</div>

                    </div>';
                }
            }
            return $output;
        }
    }


    public function cleanFilters(Request $request)
    {
        $page = $request->input('page', 1);
        $sortField = $request->input('sort', 'id');
        $sortDirection = $request->input('direction', 'asc');

        $cases = LegalCase::where('status', 'accepted')
            ->orderBy($sortField, $sortDirection)
            ->paginate(10, ['*'], 'page', $page);

        $cases->appends([
            'sort' => $sortField,
            'direction' => $sortDirection
        ]);

        return view('cases.partials.all-list', [
            'cases' => $cases,
            'sortField' => $sortField,
            'sortDirection' => $sortDirection
        ])->render();
    }


    public function getTags($id)
    {
        $case = LegalCase::findOrFail($id);
        $tags = [];

        foreach ($case->tags as $tag) {

            $tags[] = [
                'id' => $tag->name,
                'name' => $tag->name
            ];
        }
        return response()->json(['tags' => $tags]);
    }


    public function showCasesbyTrial($trial_id)
    {

        $cases = LegalCase::where('trial_id', $trial_id)
            ->where('status', 'accepted')
            ->whereHas('user', function ($q) {
                $q->where('status', true);
            })
            ->paginate(5);
        $trial = Trial::findOrFail($trial_id);
        $trial_name = $trial->name;
        return view('cases.byTrial', compact('cases', 'trial', 'trial_name'));
    }

    public function show($id, Request $request)
    {
        $case = LegalCase::findOrFail($id);
        Gate::authorize('view', $case);

        $tag = $request->query('tag');
        $trial = $request->query('juicio');

        if ($tag) {
            $tagId = intval($tag);
            return view('cases.show', compact('case', 'tagId'));
        } elseif ($trial) {
            $trialId = intval($trial);
            return view('cases.show', compact('case', 'trialId'));
        }

        return view('cases.show', compact('case'));
    }


    public function showCaseByTrial($id)
    {

        $case = LegalCase::findOrFail($id);
        $accessedBy = 'trial';
        return view('cases.show', compact('case', 'accessedBy'));
    }

    public function showCaseByTag($id, $tag)
    {
        $case = LegalCase::findOrFail($id);
        $accessedBy = 'tag';
        //        dd($tag);
        return view('cases.show', compact('case', 'tag', 'accessedBy'));
    }


    public function listUser()
    {
        $cases = LegalCase::paginate(10);
        return view('cases.list', compact('cases'));
    }


    public function review(Request $request)
    {
        Gate::authorize('review', LegalCase::class);

        $status = $request->query('status', 'pending'); // default sort field

        $query = LegalCase::query();

        $query->when($status !== 'all', function ($q) use ($status) {
            return $q->where('status', $status);
        });

        $cases = $query->orderBy('updated_at', 'desc')->paginate(12);

        // Append sort parameters to pagination links
        $cases->appends(['status' => $status]);

        return view('cases.review', compact('cases'));
    }

    public function approve($id)
    {
        $case = LegalCase::findOrFail($id);
        Gate::authorize('approve', $case);

        $case->status = 'accepted';
        $case->save();

        $user = User::findOrFail($case->user_id);

        try {
            $user->notify(new CaseAccepted($case));
        } catch (\Exception $exception) {
            return redirect()->route('cases.review')->with('info', "Juicio " . $id . " aprobado correctamente. Sin embargo, no se pudo enviar la notificación por correo electrónico al digitador debido a que tiene un correo no válido.");
        }

        return redirect()->route('cases.review')->with('success', "Juicio " . $id . " aprobado correctamente.");
    }

    public function myCases(Request $request)
    {
        Gate::authorize('viewMyCases', LegalCase::class);

        $status = $request->query('status', 'accepted');

        $query = LegalCase::query()
            ->where('user_id', Auth::id());

        $query->when($status !== 'all', function ($q) use ($status) {
            return $q->where('status', $status);
        });

        $cases = $query->orderBy('updated_at', 'desc')->paginate(12);

        // Append sort parameters to pagination links
        $cases->appends(['status' => $status]);

        return view('cases.mycases', compact('cases'));
    }

    public function reject(Request $request, $id)
    {
        $case = LegalCase::findOrFail($id);
        Gate::authorize('reject', $case);

        $validated_data = $request->validate([
            'rejection_message' => 'required|string'
        ]);

        $case->rejection_message = $validated_data['rejection_message'];
        $case->status = 'rejected';
        $case->save();

        $user = User::findOrFail($case->user_id);

        try {
            $user->notify(new CaseAccepted($case));
        } catch (\Exception $exception) {
            return redirect()->route('cases.review')->with('info', "Juicio " . $id . " rechazado correctamente. Sin embargo, no se pudo enviar la notificación por correo electrónico al digitador debido a que tiene un correo no válido.");
        }

        return redirect()->route('cases.review')->with('success', "Juicio " . $id . " rechazado correctamente.");
    }

    public function showByTag($id)
    {

        $tag = Tag::findOrFail($id);
        $tag_name = $tag->name;
        $cases = LegalCase::withAnyTags([$tag_name])
            ->where('status', 'accepted')
            ->whereHas('user', function ($q) {
                $q->where('status', true);
            })
            ->paginate(10);

        return view('cases.byTag', compact('cases', 'tag', 'tag_name'));
    }

    public function deleteSelected(Request $request)
    {

        $ids = $request->ids;
        $cases = LegalCase::whereIn('id', $ids)->get();
        $deletedNames = [];

        foreach ($cases as $case) {
            $deletedNames[] = $case->title;
            $case->delete();
        }

        $response['success'] = [
            'message' => 'Se han eliminado los siguientes casos:',
            'names' => $deletedNames,
        ];

        return response()->json($response);
    }


    public function destroy($id, Request $request)
    {
        $case = LegalCase::findOrFail($id);
        Gate::authorize('delete', $case);

        $case->delete();

        if ($request->query('from')) {
            return redirect()->route('cases.mycases', Auth::id())->with('success', 'Tu caso se ha eliminado exitosamente.');
        }

        return redirect()->back()->with('success', 'Caso eliminado exitosamente.');
    }

    public function restore($id)
    {
        $case = LegalCase::onlyTrashed()->findOrFail($id);

        Gate::authorize('restore', $case);

        $case->restore();

        return redirect()->back()->with('success', 'Caso restaurado exitosamente.');
    }

    public function forceDelete($id)
    {
        $case = LegalCase::onlyTrashed()->findOrFail($id);

        Gate::authorize('forceDelete', LegalCase::class);

        $case->forceDelete();

        return redirect()->back()->with('success', 'Caso eliminado definitivamente.');
    }

    public function forceDeleteSelected(Request $request)
    {
        Gate::authorize('forceDelete', LegalCase::class);

        $ids = $request->ids;
        $cases = LegalCase::whereIn('id', $ids)->onlyTrashed()->get();
        $deletedNames = [];

        foreach ($cases as $case) {
            $deletedNames[] = $case->title;
            $case->forceDelete();
        }

        $response['success'] = [
            'message' => 'Se han eliminado los siguientes casos permanentemente:',
            'names' => $deletedNames,
        ];

        return response()->json($response);
    }


    public function generatePDF($id)
    {

        $case = LegalCase::findOrFail($id);

        $data = [
            'case' => $case,
        ];

        $pdf = Pdf::loadView('pdf.case', $data)
            ->setPaper('A4', 'landscape');

        $pdfName = "Caso: " . $case->title . ".pdf";

        return $pdf->download($pdfName);
    }

    public function filter(Request $request)
    {
        try {

            // Log incoming request data
            Log::info('Filter request received', [
                'subject_ids' => $request->input('subject_ids'),
                'trial_ids' => $request->input('trial_ids'),
                'tag_ids' => $request->input('tag_ids'),
                'search' => $request->input('q'),
                'sort' => $request->input('sort'),
                'direction' => $request->input('direction'),
                'page' => $request->input('page'),
            ]);

            $query = LegalCase::query();


            if ($request->header('View') === 'list') {
                $query->where('status', 'accepted')
                    ->whereHas('user', function ($q) {
                        $q->where('status', true);
                    });
            }


            // Apply search if provided
            if ($request->filled('q')) {
                $searchTerm = $request->q;
                $query->where(function ($q) use ($searchTerm) {
                    $q->where('id', 'ILIKE', "%{$searchTerm}%")
                        ->orWhere('title', 'ILIKE', "%{$searchTerm}%")
                        //search by subject name
                        ->orWhereHas('trial.subject', function ($q) use ($searchTerm) {
                            $q->where('name', 'ILIKE', "%{$searchTerm}%");
                        })
                        //search by trial name
                        ->orWhereHas('trial', function ($q) use ($searchTerm) {
                            $q->where('name', 'ILIKE', "%{$searchTerm}%");
                        })
                        //search by tag name
                        ->orWhereHas('tags', function ($q) use ($searchTerm) {
                            $q->where('name', 'ILIKE', "%{$searchTerm}%");
                        });
                });

                //search by author user
                if ($request->header('View') === 'archived' || $request->header('View') === 'index') {
                    $query->orWhereHas('user', function ($q) use ($searchTerm) {
                        $q->where('name', 'ILIKE', "%{$searchTerm}%")
                            ->orWhere('last_name', 'ILIKE', "%{$searchTerm}%")
                            ->orWhere('email', 'ILIKE', "%{$searchTerm}%");
                    });
                }
            }

            if ($request->header('View') === 'archived') {
                $query->onlyTrashed();
            }

            // Apply subject and trial filters with OR condition
            if ($request->filled('subject_ids') || $request->filled('trial_ids') || $request->filled('tag_ids')) {
                $query->where(function ($query) use ($request) {
                    // Add subject filter if present
                    if ($request->filled('subject_ids')) {
                        $query->orWhereHas('trial', function ($q) use ($request) {
                            $q->whereIn('subject_id', $request->subject_ids);
                        });
                    }

                    // Add trial filter if present
                    if ($request->filled('trial_ids')) {
                        $query->orWhereIn('trial_id', $request->trial_ids);
                    }

                    //Add tag filter if present
                    if ($request->filled('tag_ids')) {
                        $query->orWhereHas('tags', function ($q) use ($request) {
                            $q->whereIn('id', $request->tag_ids);
                        });
                    }
                });
            }

            // Apply sorting
            $sortField = in_array(strtolower($request->query('sort')), ['updated_at', 'id'])
                ? strtolower($request->query('sort'))
                : 'id';
            $sortDirection = in_array(strtolower($request->query('direction')), ['asc', 'desc'])
                ? strtolower($request->query('direction'))
                : 'asc';
            $page = intval($request->input('page', 1));

            $query->orderBy($sortField, $sortDirection);

            // Log the SQL query being executed
            Log::info('SQL Query:', [
                'sql' => $query->toSql(),
                'bindings' => $query->getBindings()
            ]);

            $totalCount = $query->count();

            // Adjust page if it exceeds the last possible page
            $perPage = 10;
            $lastPage = max(1, ceil($totalCount / $perPage));
            $page = min($page, $lastPage);

            //paginate results
            $cases = $query->paginate($perPage, ['*'], 'page', $page);

            // Log the number of results
//            Log::info('Query results', [
//                'total' => $cases->total(),
//                'current_page' => $cases->currentPage()
//            ]);

            Log::info('Obtained cases', ['cases'=>$cases]);

            if ($request->ajax()) {

                if ($cases->isEmpty()) {

                    if($request->header('View') === 'archived' || $request->header('View') === 'index') {
                        return '<tr class="bg-white border-b hover:bg-gray-50">
                                            <td colspan="10" class="px-6 py-12 font-bold text-2xl text-center">No se encontraron casos archivados</td>
                                        </tr>';

                    }

                    return response()->view('cases.partials.empty-results')->header('Content-Type', 'text/html');
                }
                if ($request->header('View') === 'archived') {
                    return response()->view('cases.partials.archived-row', compact('cases'))->header('Content-Type', 'text/html');
                }
                if ($request->header('View') === 'index') {
                    return response()->view('cases.partials.row', compact('cases'))->header('Content-Type', 'text/html');
                }
                if ($request->header('View') === 'list') {
                    return response()->view('cases.partials.all-list', compact('cases'))->header('Content-Type', 'text/html');
                }
            }

            return view('cases.list', compact('cases'));

        } catch (\Exception $e) {
            Log::error('Error in filter method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            if ($request->ajax()) {
                return response()->json([
                    'error' => $e->getMessage()
                ], 500);
            }

            throw $e;
        }
    }


}
