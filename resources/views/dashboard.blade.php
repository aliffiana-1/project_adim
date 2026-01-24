@section('css')
    <style>
        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: maroon;
            border-color: maroon;
        }

        .page-link {
            position: relative;
            display: block;
            color: maroon;
            text-decoration: none;
            background-color: #fff;
            border: 1px solid #dee2e6;
            transition: color .15s ease-in-out, background-color .15s ease-in-out, border-color .15s ease-in-out, box-shadow .15s ease-in-out;
        }

        .card-sl {
            border-radius: 8px;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
        }

        .card-image img {
            height: 280px;
            width: 100%;
            border-radius: 8px 8px 0px 0;
        }

        .card-action {
            position: relative;
            float: right;
            margin-top: -25px;
            margin-right: 20px;
            z-index: 2;
            color: #E26D5C;
            background: #fff;
            border-radius: 100%;
            padding: 15px;
            font-size: 15px;
            box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.2), 0 1px 2px 0 rgba(0, 0, 0, 0.19);
        }

        .card-heading {
            font-size: 18px;
            font-weight: bold;
            background: #fff;
            padding: 10px 15px;
        }

        .card-text {
            padding: 10px 15px;
            background: #fff;
            font-size: 14px;
            color: #636262;
            display: -webkit-box;
            max-width: 100%;
            max-height: 55px;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-button {
            display: flex;
            justify-content: center;
            padding: 10px 0;
            width: 100%;
            background-color: maroon;
            color: #fff;
            border-radius: 0 0 8px 8px;
        }

        .card-button:hover {
            text-decoration: none;
            background-color: rgb(157, 31, 31);
            color: #fff;

        }
    </style>
@stop

@extends('template')
@section('dashboard')
    <div class="container-fluid py-5">
        <div class="container py-5">
            {{-- <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px">
                <h5 class="fw-bold text-uppercase" style="color: maroon">Latest Events</h5>
                <h1 class="mb-0">BPJS</h1>
            </div>
            
            <div class="row">
                <div class="col-md-6 d-flex flex-column align-items-md-start" id="showing_page">
                    Showing
                    {!! $data_news->firstItem() !!} to
                    {!! $data_news->lastItem() !!} of {!! $data_news->total() !!} entries
                </div>
                <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                    {!! $data_news->appends(request()->all())->links() !!}
                </div>
            </div> --}}
        </div>
    </div>
@endsection
