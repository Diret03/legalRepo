@if(count($cases) > 0)
    @foreach($cases as $case)
        <tr id="case_ids{{$case->id}}"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
            <td class="w-4 p-4">
                <div class="flex items-center">
                    <input name="ids" type="checkbox" value="{{$case->id}}"
                           class="checkbox_ids w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 dark:focus:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="checkbox_ids" class="sr-only">checkbox</label>
                </div>
            </td>
            <td class="px-6 py-4">
                {{$case->id}}
            </td>
            <td class="px-6 py-4">
                <div class="text-black">
                    <div class="text-base font-semibold">{{$case->user->name}} {{$case->user->last_name}}</div>
                    <div class="font-normal text-gray-500">{{$case->user->email}}</div>
                </div>
            </td>
            <td class="px-6 py-4">
                {{$case->title}}
            </td>
            <td class="px-6 py-4">
                {{$case->trial->subject->name}}
            </td>
            <td class="px-6 py-4">
                {{$case->trial->name}}
            </td>
            <td class="px-6 py-4">
                <button data-modal-target="case-modal-{{$case->id}}" data-modal-toggle="case-modal-{{$case->id}}"
                        class="block text-white bg-red-650 hover:bg-red-200 hover:text-black focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center"
                        type="button">
                    Ver
                </button>
                <div id="case-modal-{{$case->id}}" tabindex="-1" aria-hidden="true"
                     class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <!-- Overlay -->
                    <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>

                    <div class="relative p-4 w-full max-w-5xl max-h-full">
                        <!-- Modal content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Modal header -->
                            <div
                                class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                                <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                                    Detalles del Caso
                                </h3>
                                <button type="button"
                                        class="details-modal text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                                        data-modal-hide="case-modal-{{$case->id}}">
                                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                         fill="none"
                                         viewBox="0 0 14 14">
                                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                              stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                                    </svg>
                                    <span class="sr-only">Cerrar modal</span>
                                </button>
                            </div>
                            <!-- Modal body -->
                            <div class="modal-body p-4 md:p-5 space-y-4">
                                <div>
                                    <h4 class="font-semibold text-gray-900">Etiquetas</h4>
                                    <div class="flex flex-wrap gap-1">
                                        @if(count($case->tags) > 0)
                                            @foreach ($case->tags as $tag)
                                                <a href="{{ route('cases.showByTag', $tag->id) }}"
                                                   class="bg-red-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                                    {{ $tag->name }}
                                                </a>
                                            @endforeach
                                        @else
                                            <p
                                                class="bg-blue-100 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                                No tiene etiquetas
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Contexto</h4>
                                    <textarea class="editor-modal" name="context">{{$case->context}}</textarea>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Problema Jurídico</h4>
                                    <textarea class="editor-modal" name="context">{{$case->analysis}}</textarea>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Respuesta</h4>
                                    <textarea class="editor-modal" name="context">{{$case->resolution}}</textarea>
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900 dark:text-white">Notas</h4>
                                    <textarea class="editor-modal" name="context">{{$case->note}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
            <td class="px-6 py-4">
                <div class="flex flex-col items-center">
                    @if($case->status == 'Aceptado')
                        <img src="{{asset('svg/approved.svg')}}" class="h-5 w-5 mb-2" alt="Aceptado icon">
                    @elseif($case->status == 'Pendiente')
                        <img src="{{asset('svg/pending.svg')}}" class="h-8 w-8 mb-2" alt="Pendiente icon">
                    @elseif($case->status == 'Rechazado')
                        <img src="{{asset('svg/rejected.svg')}}" class="h-5 w-5 mb-2" alt="Rechazado icon">
                    @endif
                    <span>{{$case->status}}</span>
                </div>
            </td>
            @if(Auth::user()->can('editar cualquier caso'))
                <td class="px-6 py-4">
                    <div class="flex items-center">
                        @can('editar cualquier caso')
                            <a href="{{route('cases.edit',$case->id)}}"
                               class="font-medium text-blue-600 dark:text-blue-500 hover:underline mr-5">
                                <img src="{{asset('svg/edit.svg')}}" class="size-7" alt="Editar icon">
                            </a>
                        @endcan
                        @can('eliminar cualquier caso')
                            <form action="{{route('cases.destroy',$case->id)}}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="font-medium text-blue-600 dark:text-blue-500 hover:underline"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este registro?')">
                                    <img src="{{asset('svg/delete.svg')}}" class="size-7" alt="Borrar icon">
                                </button>
                            </form>
                        @endcan
                    </div>
                </td>
            @endif
        </tr>
    @endforeach
@else
    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
        <td colspan="10" class="px-6 py-12 font-bold text-2xl text-center">No hay casos registrados</td>
    </tr>
@endif

