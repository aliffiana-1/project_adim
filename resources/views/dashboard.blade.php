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
            <div class="section-title text-center position-relative pb-3 mb-5 mx-auto" style="max-width: 600px">
                <h5 class="fw-bold text-uppercase" style="color: maroon">Latest Events</h5>
                <h1 class="mb-0">BPJS</h1>
            </div>
            @if ($data_news->isEmpty())
                <div class="row g-5">
                    <div class="col-lg-4">
                        <div class="blog-item bg-light rounded overflow-hidden">
                            <div class="blog-img position-relative overflow-hidden">
                                <img class="img-fluid" src="{{ asset('assets/image/no_news.png') }}" alt="" />
                            </div>
                            <div class="p-4">
                                <h4 class="mb-3">News unavailable</h4>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="row g-5 mb-4">
                    @foreach ($data_news as $news)
                        <div class="col-lg-4">
                            <div class="card-sl">
                                <div class="card-image" style="position: relative;">
                                    <img class="img-fluid"
                                        src="{{ $news->events_img == null ? asset('assets/image/no_news.png') : asset('events/' . $news->events_img) }}"
                                        alt="" style="object-fit: cover;" />
                                    {{-- <img class="frame-overlay" src="{{ asset('assets/image/uniji-frame.png') }}"
                                        alt="Frame overlay"
                                        style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; pointer-events: none;" /> --}}
                                </div>
                                <div class="p-4" style="height: 300px;">
                                    <div class="card-text">
                                        <span style="color:grey">Last updated :
                                            {{ date('d/m/Y', strtotime($news->events_inserted_at)) }}</span>
                                    </div>
                                    <div class="card-heading">
                                        <span class="text-uppercase">{{ $news->events_title }}</span>
                                    </div>
                                    <div class="card-text">
                                        {!! $news->events_desc !!}
                                    </div>
                                </div>
                                @if ($news->events_type == 1)
                                    <?php $link = '/news/detail/'; ?>
                                @else
                                    <?php $link = '/webinar/detail/'; ?>
                                @endif
                                <a class="card-button" href="{{ url($link . $news->id_events) }}"
                                    style="text-decoration: none;">Read More</a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
            <div class="row">
                <div class="col-md-6 d-flex flex-column align-items-md-start" id="showing_page">
                    Showing
                    {!! $data_news->firstItem() !!} to
                    {!! $data_news->lastItem() !!} of {!! $data_news->total() !!} entries
                </div>
                <div class="col-md-6 d-flex flex-column align-items-md-end" id="showing_page">
                    {!! $data_news->appends(request()->all())->links() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
