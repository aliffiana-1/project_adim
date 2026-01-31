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
                @if (session('role_name') != 'admin')
                <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#addModal" onclick="show_modal_add()">
                    <span class="fa fa-plus"></span> Add New
                </button>
                @endif
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
                        <td>Title</td>
                        <td>Content</td>
                        <td>Category</td>
                        <td>Level</td>
                        <td>Created At</td>
                        <td style="text-align: center;">Published</td>
                        <td colspan="2" style="text-align: center;">Action</td>
                    </tr>
                </thead>
                <tbody class="text-uppercase">
                    @if (!$article_data->isEmpty())
                    <?php $limit = isset($_GET['limit']) ? $_GET['limit'] : request('sortir');
                            $page = isset($_GET['page']) ? $_GET['page'] : 1;
                            
                            $no = $limit * $page - $limit; ?>
                    @foreach ($article_data as $data)
                    <tr style="font-size:12px">
                        <td>{{ ++$no }}</td>
                        <td>{{ $data->title }}
                        </td>
                        <td>{{ $data->content }}</td>
                        <td>{{ $data->category_name }}</td>
                        <td>{{ $data->article_level_name }}</td>
                        <td>{{ date('j F Y, H:i', strtotime($data->created_at)) }}</td>
                        <td style="text-align: center;">
                            @if ($data->is_published == 1)
                            <i class="fas fa-check" style="color: rgb(67, 214, 67)" title="Published"></i>
                            @else
                            <i class="fas fa-clock" style="color: red" title="Unpublished"></i>
                            @endif
                        </td>

                        <td style="text-align: center;">
                            <a style="text-decoration: none" class="fa fa-edit text-warning" title="Update" data-bs-toggle="modal" data-bs-target="#EditModal-{{ $data->id_article }}" href="#EditModal-{{ $data->id_article }}"></a>
                        </td>
                        <td style="text-align: center;">
                            <a style="text-decoration: none" class="far fa-trash-alt  text-danger" title="Delete" data-bs-toggle="modal" data-bs-target="#deleteModal-{{ $data->id_article }}" href="#deleteModal-{{ $data->id_article }}"></a>
                        </td>
                    </tr>
                    @php
                    $isAdmin = session('role_name') == 'admin';
                    @endphp


                    <div class="modal fade" id="EditModal-{{ $data->id_article }}" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Article</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <div class="modal-body">
                                    <form action="{{ route('edit_article') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="id_article" value="{{ $data->id_article }}">

                                        <div class="form-floating mb-2">
                                            <input type="text" name="title" class="form-control" value="{{ $data->title }}" {{ $isAdmin ? 'readonly' : '' }} required>
                                            <label>Title</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <select name="id_category" class="form-control select2-search" style="width: 100%" {{ $isAdmin ? 'disabled' : '' }} required>
                                                <option value=""> Select Category </option>
                                                @foreach ($categories as $key)
                                                <option value="{{ $key->id_category }}" {{ $data->id_category == $key->id_category ? 'selected' : '' }}>
                                                    {{ $key->category_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label>Category</label>
                                        </div>

                                        <div class="form-floating mb-2">
                                            <select name="id_article_level" class="form-control select2-search" style="width: 100%" {{ $isAdmin ? 'disabled' : '' }} required>
                                                <option value=""> Select Level </option>
                                                @foreach ($levels as $key)
                                                <option value="{{ $key->id_article_level }}" {{ $data->id_article_level == $key->id_article_level ? 'selected' : '' }}>
                                                    {{ $key->article_level_name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            <label>Level</label>
                                        </div>

                                        <div class="form-group mb-2">
                                            <label>Description</label>
                                            <textarea class="form-control" name="content" id="content_update-{{ $data->id_article }}" rows="3" {{ $isAdmin ? 'readonly' : '' }}>{{ $data->content }}</textarea>
                                        </div>

                                        @if(session('role_name') == 'admin')
                                        <div class="form-group">
                                            <label>Publish</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="1" type="radio" name="is_published" {{ $data->is_published == 1 ? 'checked' : '' }} required>
                                            <label class="form-check-label">Yes</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" value="2" type="radio" name="is_published" {{ $data->is_published == 2 ? 'checked' : '' }} required>
                                            <label class="form-check-label">No</label>
                                        </div>
                                        @else
                                        <input type="hidden" name="is_published" value="{{ $data->is_published }}">
                                        @endif


                                        <div class="modal-footer mt-3">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="modal fade" id="deleteModal-{{ $data->id_article }}" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addModalLongTitle">Delete Article</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <form action="{{ route('delete_article') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="id_article" value="{{ $data->id_article }}">
                                        <div class="input-group mb-3">
                                            <label for="question" class="form-label" style="text-transform: uppercase">Are you sure want to delete
                                                '{{ $data->title }}' Article?</label>
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
                {!! $article_data->firstItem() !!} to
                {!! $article_data->lastItem() !!} of {!! $article_data->total() !!} entries
            </div>
            <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                {!! $article_data->appends(request()->all())->links() !!}
            </div>
        </div>
    </div>
</div>
</div>
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModalLongTitle">Add Article</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('store_article') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-floating mb-2">
                        <input type="text" name="title" class="form-control" id="title" placeholder="Title" required>
                        <label for="title">Title</label>
                    </div>
                    <div class="form-floating mb-2">
                        <select name="id_category" class="form-control select2-search" style="width: 100%" required>
                            <option value=""> Select Category </option>
                            @foreach ($categories as $key)
                            <option value="{{ $key->id_category }}">
                                {{ $key->category_name }}
                            </option>
                            @endforeach
                        </select>
                        <label>Category</label>
                    </div>
                    <div class="form-floating mb-2">
                        <select id="id_article_level" name="id_article_level" class="form-control select2-search" style="width: 100%">
                            <option value=""> Select Level </option>
                            @foreach ($levels as $key)
                            <option value="{{ $key->id_article_level }}">{{ $key->article_level_name }}</option>
                            @endforeach
                        </select>
                        <label for="floatingSelect">Level</label>
                    </div>

                    <div class="form-group mb-2">
                        <label for="content">Description</label>
                        <textarea class="form-control" name="content" id="content" rows="3"></textarea>
                    </div>

                    @if(session('role_name') == 'admin')
                    <div class="form-group">
                        <label for="is_published">Publish</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="1" type="radio" name="is_published" required>
                        <label class="form-check-label">Yes</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" value="2" type="radio" name="is_published" required>
                        <label class="form-check-label">No</label>
                    </div>
                    @else
                    <input type="hidden" name="is_published" value="0"> {{-- default pending --}}
                    @endif

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
        $('#id_category').select2({
            dropdownParent: $('#addModal')
        });

        @foreach($article_data as $dataent)
        $('#is_published-{{ $dataent->id_article }}').select2({
            dropdownParent: $('#updateModal-{{ $dataent->id_article }}')
        });
        @endforeach
    });

    ClassicEditor
        .create(document.querySelector('#content'))
        .catch(error => {
            console.error(error);
        });

    @foreach($article_data as $data)
    ClassicEditor
        .create(document.querySelector('#content_update-{{ $data->id_article }}'))
        .catch(error => {
            console.error(error);
        });
    @endforeach


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
