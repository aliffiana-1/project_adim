<style>
    .hideextra {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

</style>
@extends('template')
@section('category_editor')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px">
            <h5 class="fw-bold text-uppercase mt-4" style="color: maroon">BPJS</h5>
            <h1 class="mb-0">Category Center</h1>
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
                        <td>Category Name</td>
                        <td colspan="2" style="text-align: center;">Action</td>
                    </tr>
                </thead>

                <tbody class="text-uppercase">
                    @if (!$category_data->isEmpty())
                    <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            
                            $no = $limit * $page - $limit; ?>
                    @foreach ($category_data as $data)
                    <tr style="font-size:12px">
                    <td>{{ ++$no }}</td>
                    <td>{{ $data->category_name }}</td>

                    <td style="text-align: center;">
                        <a
                            class="fa fa-edit text-warning"
                            data-bs-toggle="modal"
                            data-bs-target="#EditModal-{{ $data->id_category }}"
                            title="Edit"
                            style="text-decoration:none"
                        ></a>
                    </td>

                    <td style="text-align: center;">
                        <a
                            class="far fa-trash-alt text-danger"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteModal-{{ $data->id_category }}"
                            title="Delete"
                            style="text-decoration:none"
                        ></a>
                    </td>
                </tr>


                    <div class="modal fade" id="EditModal-{{ $data->id_category }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('edit_category') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id_category" value="{{ $data->id_category }}">

                                    <div class="form-floating mb-2">
                                        <input
                                            type="text"
                                            name="category_name"
                                            class="form-control"
                                            value="{{ $data->category_name }}"
                                            required
                                        >
                                        <label>Category Name</label>
                                    </div>

                                    <div class="modal-footer mt-3">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save</button>
                                    </div>
                                </form>

                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="deleteModal-{{ $data->id_category }}" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLongTitle">Delete category</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('delete_category') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_category" value="{{ $data->id_category }}">
                                        <div class="input-group mb-3">
                                            <label for="question" class="form-label" style="text-transform: uppercase">Are you sure want to delete
                                                '{{ $data->category_name }}' category?</label>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
                {!! $category_data->firstItem() !!} to
                {!! $category_data->lastItem() !!} of {!! $category_data->total() !!} entries
            </div>
            <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                {!! $category_data->appends(request()->all())->links() !!}
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLongTitle">Add category</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('store_category') }}" method="POST">
                @csrf
                <div class="form-floating mb-2">
                    <input
                        type="text"
                        name="category_name"
                        class="form-control"
                        placeholder="Category Name"
                        required
                    >
                    <label>Category Name</label>
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
    });


    function show_modal_add() {
        $('#addModal').modal('show');
    }

    @if(\Session::has('success'))
    var msg = "{{ Session::get('success') }}"
    Swal.fire(
        'Success'
        , msg
        , 'success'
    )
    @php\ Session::forget('success') @endphp
    @php\ Session::forget('error') @endphp
    @endif

    @if(\Session::has('error'))
    var msg = "{{ Session::get('error') }}"
    Swal.fire(
        'Whoops'
        , msg
        , 'error'
    )
    @php\ Session::forget('success') @endphp
    @php\ Session::forget('error') @endphp
    @endif

    @if(\Session::has('info'))
    var msg = "{{ Session::get('info') }}"
    Swal.fire(
        'Whoops'
        , msg
        , 'info'
    )
    @php\ Session::forget('success') @endphp
    @php\ Session::forget('info') @endphp
    @endif

</script>
@stop
