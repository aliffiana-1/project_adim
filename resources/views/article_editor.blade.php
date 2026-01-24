<style>
    .hideextra {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
</style>
@extends('template')
@section('article_editor')
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px">
                <h5 class="fw-bold text-uppercase mt-4" style="color: maroon">BPJS</h5>
                <h1 class="mb-0">Article Center</h1>
            </div>
            <div class="row gy-3">
                <div class="col-md-9">
                    <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal"
                        onclick="show_modal_add()">
                        <span class="fa fa-plus"></span> Add New
                    </button>
                </div>
                <div class="col-md-3">
                    <form method="GET" id="search_form">
                        <div class="input-group mb-3">
                            <input class="form-control me-2 search" type="text" name="search"
                                value="{{ request('search') }}" placeholder="Search" aria-label="Search">
                            <input type="hidden" name="sortir" id="sortir" value="{{ request('sortir') }}">
                            <button class="btn btn-outline-success btnSearch" type="submit">Search</button>
                        </div>
                    </form>
                </div>
            </div>
            &nbsp;
            <div class="table-responsive">


                <table class="table table-striped align-center mb-4">
                    <thead>
                        <tr class="text-uppercase" style="font-weight: bold; font-size:12px">
                            <td>No</td>
                            <td>Date Created</td>
                            <td>Date Updated</td>
                            <td>Title</td>
                            <td>Type</td>
                            <td style="text-align: center;">Publish</td>
                            <td colspan="2" style="text-align: center;">Action</td>
                        </tr>
                    </thead>
                    <tbody class="text-uppercase">
                        @if (!$events_data->isEmpty())
                            <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            
                            $no = $limit * $page - $limit; ?>
                            @foreach ($events_data as $ev)
                                <tr style="font-size:12px">
                                    <td>{{ ++$no }}</td>
                                    <td class="hideextra">{{ date('j F Y, H:i', strtotime($ev->events_inserted_at)) }}
                                    <td class="hideextra">{{ date('j F Y, H:i', strtotime($ev->events_updated_at)) }}
                                    </td>
                                    <td>{{ $ev->events_title }}</td>
                                    <td>
                                        @if ($ev->events_type == 1)
                                            News
                                        @else
                                            Webinar
                                        @endif
                                    </td>
                                    <td style="text-align: center;"><i
                                            class="fas fa-{{ $ev->events_status == 1 ? 'check' : 'clock' }}"
                                            style="color: {{ $ev->events_status == 1 ? 'rgb(67, 214, 67)' : 'red' }}"
                                            title="{{ $ev->events_status == 1 ? 'Published' : 'Unpublished' }}"></i></td>
                                    <td style="text-align: center;">
                                        <a style="text-decoration: none" class="fa fa-edit text-warning" title="Update"
                                            data-bs-toggle="modal" data-bs-target="#EditModal-{{ $ev->id_events }}"
                                            href="#EditModal-{{ $ev->id_events }}"></a>
                                    </td>
                                    {{-- <td style="text-align: center;">
                                    <a style="text-decoration: none" class="fa fa-edit text-info" title="Edit"
                                        data-bs-toggle="modal" data-bs-target="#updateModal-{{ $ev->id_events }}"
                                        href="#updateModal-{{ $ev->id_events }}"></a>
                                </td> --}}
                                    <td style="text-align: center;">
                                        <a style="text-decoration: none" class="far fa-trash-alt  text-danger"
                                            title="Delete" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal-{{ $ev->id_events }}"
                                            href="#deleteModal-{{ $ev->id_events }}"></a>
                                    </td>
                                </tr>
                                <div class="modal fade" id="updateModal-{{ $ev->id_events }}" tabindex="-1" role="dialog"
                                    aria-labelledby="addModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLongTitle">Publish events</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form 
                                                {{-- action="{{ route('admin/update-events') }}"  --}}
                                                method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_events" value="{{ $ev->id_events }}">
                                                    <div class="mb-3">
                                                        <label for="events_type" class="form-label"></label>
                                                        <select class="form-control" name="events_status"
                                                            id="events_status-{{ $ev->id_events }}" style="width: 100%">
                                                            <option> --- Choose --- </option>
                                                            @if ($ev->events_status != 1)
                                                                <option value="1">Publish</option>
                                                            @endif
                                                            @if ($ev->events_status != 2)
                                                                <option value="2">Unpublish</option>
                                                            @endif
                                                            {{-- pending = 0, publish = 1, unpublish = 2 --}}
                                                        </select>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>


                                <div class="modal fade" id="EditModal-{{ $ev->id_events }}" tabindex="-1" role="dialog"
                                    aria-labelledby="addModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLongTitle">Update Event</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form 
                                                {{-- action="{{ route('admin/edit-events') }}"  --}}
                                                method="POST"
                                                    enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="mb-3">
                                                        <label class="form-label">Preview</label>
                                                    </div>
                                                    <input type="hidden" required name="id_events" value="{{ $ev->id_events }}">
                                                    <div class="mb-3">
                                                        <img src="{{ asset('events/' . $ev->events_img) }}"
                                                            width="200px">
                                                    </div>
                                                    <div class="mb-3">
                                                        <input  class="form-control" type="file"
                                                            value="{{ $ev->events_img }}" name="events_img"
                                                            id="events_img">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="events_title" class="form-label">Input New
                                                            Title</label>
                                                        <input required value="{{ $ev->events_title }}" class="form-control"
                                                            type="text" name="events_title">
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="events_desc" class="form-label">Input New
                                                            Description</label>
                                                        <textarea required class="form-control" name="events_desc" id="events_desc_update-{{ $ev->id_events }}">{!! $ev->events_desc !!}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="events_status">Publish</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input required class="form-check-input" value="1" type="radio"
                                                            name="events_status" id="flexRadioDefault1"
                                                            {{ $ev->events_status == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            Yes
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" value="2" type="radio"
                                                            required
                                                            name="events_status" id="flexRadioDefault2"
                                                            {{ $ev->events_status == 2 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            No
                                                        </label>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="events_type">Change Type</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" value="1" type="radio"
                                                            required
                                                            name="events_type" id="flexRadioDefault1"
                                                            {{ $ev->events_type == 1 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexRadioDefault1">
                                                            News
                                                        </label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" value="2" type="radio"
                                                            name="events_type" id="flexRadioDefault2"
                                                            required
                                                            {{ $ev->events_type == 2 ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="flexRadioDefault2">
                                                            Webinar
                                                        </label>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Submit</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <div class="modal fade" id="deleteModal-{{ $ev->id_events }}" tabindex="-1"
                                    role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="addModalLongTitle">Delete events</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close">
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form 
                                                {{-- action="{{ route('admin/delete-events') }}"  --}}
                                                method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id_events" value="{{ $ev->id_events }}">
                                                    <div class="input-group mb-3">
                                                        <label for="question" class="form-label"
                                                            style="text-transform: uppercase">Are you sure want to delete
                                                            '{{ $ev->events_title }}' Event?</label>
                                                    </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-primary">Delete</button>
                                            </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="8" style="text-align: center"> No data </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
            <div class="row">

                <div class="col-md-1 d-flex flex-column">
                    <div class="btn-group dropup">
                        <button type="button" class="btn btn-maroon dropdown-toggle"
                            style="background-color: maroon; color:white;" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            {{ request('sortir') == null ? '10' : request('sortir') }}
                        </button>
                        <ul class="dropdown-menu" id="listSortir">
                            <li class="listAttr" value="10"><a class="dropdown-item text-small">10</a></li>
                            <li class="listAttr" value="20"><a class="dropdown-item" href="#">20</a></li>
                            <li class="listAttr" value="50"><a class="dropdown-item" href="#">50</a></li>
                            <li class="listAttr" value="100"><a class="dropdown-item" href="#">100</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col d-flex flex-column" id="showing_page">
                    Showing
                    {!! $events_data->firstItem() !!} to
                    {!! $events_data->lastItem() !!} of {!! $events_data->total() !!} entries
                </div>
                <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                    {!! $events_data->appends(request()->all())->links() !!}
                </div>
            </div>
        </div>
    </div>
    </div>
    <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addModalLongTitle">Article Center</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <div class="modal-body">
                    <form 
                    {{-- action="{{ route('admin/store-events') }}"  --}}
                    method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-floating mb-2">
                            <input type="text" name="events_title" class="form-control" id="events_title"
                                placeholder="Title" required>
                            <label for="events_title">Title</label>
                        </div>
                        <div class="form-floating mb-2">
                            <select required class="form-control" id="floatingSelect" name="events_type">
                                <option value="">Choose Type</option>
                                <option value="1">News</option>
                                <option value="2">Webinar</option>
                            </select>
                            <label for="floatingSelect">Type</label>
                        </div>
                        <div class="form-floating mb-2">
                            <input type="datetime-local" name="events_date" class="form-control" id="events_date"
                                required>
                            <label for="events_date">Event date</label>
                        </div>
                        <div class="form-group mb-2">
                            <label for="events_desc">Description</label>
                            <textarea class="form-control" name="events_desc" id="events_desc" rows="3"></textarea>
                        </div>
                        <div class="form-group mb-2">
                            <label for="events_img">Image (<span style="font-weight: bold">Max. 2 MB</span>)</label>
                            <input type="file" class="form-control" name="events_img" id="events_img" required>
                        </div>
                        <div class="form-group">
                            <label for="events_status">Publish</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" value="1" type="radio" name="events_status"
                                id="flexRadioDefault1" required>
                            <label class="form-check-label" for="flexRadioDefault1">
                                Yes
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" required value="2" type="radio" name="events_status"
                                id="flexRadioDefault2">
                            <label class="form-check-label" for="flexRadioDefault2">
                                No
                            </label>
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('js')
    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var strQuery, strUrlParams, nSortir, nPaginatorSelected;
        $(document).ready(function() {

            strQuery = window.location.search;
            strUrlParams = new URLSearchParams(strQuery);
            nSortir = strUrlParams.get('sortir')
            nSearch = strUrlParams.get('search')

        });

        function getSortir() {
            var result;
            nPaginatorSelected = $(".listAttr").val();
            if (nSortir) {
                result = nSortir;
            } else {
                if (nPaginatorSelected) {
                    result = nPaginatorSelected;
                } else {
                    result = 10;
                }
            }
            return result;
        }

        function getSearch() {
            var result;
            nSearchFiltering = $(".search").val();
            if (nSearch) {
                result = nSearch;

            } else {
                if (nSearchFiltering) {
                    result = nSearchFiltering;
                } else {
                    result = ""
                }
            }
            return result;
        }

        $('#btnSearch').click(function() {
            var search = $(this).val();
            submitFilter(search);
        });


        $(".listAttr").click(function() {
            var nValue = $(this).val();
            submitFilter(nValue);
        });

        function submitFilter(nValue, search) {

            if (nValue) {
                var nSortirSelected = nValue;
            } else {
                var nSortirSelected = getSortir();
            }

            if (search) {
                var nSearchFiltered = search;
            } else {
                var nSearchFiltered = getSearch();
            }

            $('#sortir').val(nSortirSelected);
            $('#search').val(nSearchFiltered);
            $('#search_form').submit();
        }
        $(document).ready(function() {
            $('#events_type').select2({
                dropdownParent: $('#addModal')
            });

            @foreach ($events_data as $Event)
                $('#events_status-{{ $Event->id_events }}').select2({
                    dropdownParent: $('#updateModal-{{ $Event->id_events }}')
                });
            @endforeach
        });

        ClassicEditor
            .create(document.querySelector('#events_desc'))
            .catch(error => {
                console.error(error);
            });

        @foreach ($events_data as $ev)
            ClassicEditor
                .create(document.querySelector('#events_desc_update-{{ $ev->id_events }}'))
                .catch(error => {
                    console.error(error);
                });
        @endforeach


        function show_modal_add() {
            $('#addModal').modal('show');
        }

        @if (\Session::has('success'))
            var msg = "{{ Session::get('success') }}"
            Swal.fire(
                'Success',
                msg,
                'success'
            )
            @php \Session::forget('success') @endphp
            @php \Session::forget('error') @endphp
        @endif

        @if (\Session::has('error'))
            var msg = "{{ Session::get('error') }}"
            Swal.fire(
                'Whoops',
                msg,
                'error'
            )
            @php \Session::forget('success') @endphp
            @php \Session::forget('error') @endphp
        @endif

        @if (\Session::has('info'))
            var msg = "{{ Session::get('info') }}"
            Swal.fire(
                'Whoops',
                msg,
                'info'
            )
            @php \Session::forget('success') @endphp
            @php \Session::forget('info') @endphp
        @endif
    </script>
@stop
