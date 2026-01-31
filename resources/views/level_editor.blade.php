<style>
    .hideextra {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
@extends('template')
@section('level_editor')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px">
            <h5 class="fw-bold text-uppercase mt-4" style="color: maroon">BPJS</h5>
            <h1 class="mb-0">Level Editor</h1>
        </div>
        <div class="row gy-3">
            <div class="col-md-9">
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal" onclick="show_modal_add()">
                    <span class="fa fa-plus"></span> Add New
                </button>
            </div>
            <div class="col-md-3">
                <form method="GET" id="search_form">
                    <div class="input-group mb-3">
                        <input class="form-control me-2 search" type="text" name="search" value="{{ request('search') }}" placeholder="Search" aria-label="Search">
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
                        <td>Level Name</td>
                        <td>Updated At</td>
                        <td colspan="2" style="text-align: center;">Action</td>
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                    @if (!$level_data->isEmpty())
                    @php
                    $limit = request('sortir') ?? 10;
                    $page = request('page') ?? 1;
                    $no = $limit * $page - $limit;
                    @endphp

                    @foreach ($level_data as $data)
                    <tr>
                        <td>{{ ++$no }}</td>
                        <td>{{ $data->article_level_name }}</td>
                        <td>
                            {{ $data->updated_at ? date('j F Y, H:i', strtotime($data->updated_at)) : '-' }}
                        </td>

                        <td class="text-center">
                            <a class="fa fa-edit text-warning" data-bs-toggle="modal" data-bs-target="#EditModal-{{ $data->id_article_level }}"></a>
                        </td>
                        <td class="text-center">
                            <a class="far fa-trash-alt text-danger" data-bs-toggle="modal" data-bs-target="#DeleteModal-{{ $data->id_article_level }}"></a>
                        </td>
                    </tr>

                    {{-- EDIT MODAL --}}
                    <div class="modal fade" id="EditModal-{{ $data->id_article_level }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('edit_level') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_article_level" value="{{ $data->id_article_level }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Edit Level</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-floating mb-2">
                                            <input type="text" name="article_level_name" class="form-control" value="{{ $data->article_level_name }}" required>
                                            <label>Level Name</label>
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

                    {{-- DELETE MODAL --}}
                    <div class="modal fade" id="DeleteModal-{{ $data->id_article_level }}" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <form action="{{ route('delete_level') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_article_level" value="{{ $data->id_article_level }}">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Delete Level</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <p>Are you sure want to delete
                                            <b>{{ $data->article_level_name }}</b>?</p>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-danger">Delete</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    @endforeach
                    @else
                    <tr>
                        <td colspan="5" class="text-center">No data</td>
                    </tr>
                    @endif
                </tbody>


            </table>
        </div>
        <div class="row">

            <div class="col-md-1 d-flex flex-column">
                <div class="btn-group dropup">
                    <button type="button" class="btn btn-maroon dropdown-toggle" style="background-color: maroon; color:white;" data-bs-toggle="dropdown" aria-expanded="false">
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
                {!! $level_data->firstItem() !!} to
                {!! $level_data->lastItem() !!} of {!! $level_data->total() !!} entries
            </div>
            <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                {!! $level_data->appends(request()->all())->links() !!}
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="addModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('store_level') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Level</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="form-floating mb-2">
                        <input type="text" name="article_level_name" class="form-control" required>
                        <label>Level Name</label>
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
    var strQuery, strUrlParams, nSortir, nSearch;

    $(document).ready(function() {
        strQuery = window.location.search;
        strUrlParams = new URLSearchParams(strQuery);
        nSortir = strUrlParams.get('sortir');
        nSearch = strUrlParams.get('search');
    });

    /* ambil sortir */
    function getSortir() {
        var result;
        var nPaginatorSelected = $(".listAttr.active").val();

        if (nSortir) {
            result = nSortir;
        } else if (nPaginatorSelected) {
            result = nPaginatorSelected;
        } else {
            result = 10;
        }
        return result;
    }

    /* ambil search */
    function getSearch() {
        var result;
        var nSearchFiltering = $(".search").val();

        if (nSearch) {
            result = nSearch;
        } else if (nSearchFiltering) {
            result = nSearchFiltering;
        } else {
            result = "";
        }
        return result;
    }

    /* klik dropdown sortir */
    $(".listAttr").click(function() {
        var nValue = $(this).val();
        submitFilter(nValue);
    });

    /* submit filter */
    function submitFilter(nValue, search) {
        var nSortirSelected = nValue ? nValue : getSortir();
        var nSearchFiltered = search ? search : getSearch();

        $('#sortir').val(nSortirSelected);
        $('.search').val(nSearchFiltered);
        $('#search_form').submit();
    }

    /* show modal add */
    function show_modal_add() {
        $('#addModal').modal('show');
    }

    /* SWEETALERT */
    @if(\Session::has('success'))
    Swal.fire('Success', "{{ Session::get('success') }}", 'success');
    @php\ Session::forget('success') @endphp
    @endif

    @if(\Session::has('error'))
    Swal.fire('Whoops', "{{ Session::get('error') }}", 'error');
    @php\ Session::forget('error') @endphp
    @endif

    @if(\Session::has('info'))
    Swal.fire('Info', "{{ Session::get('info') }}", 'info');
    @php\ Session::forget('info') @endphp
    @endif

</script>

@stop
