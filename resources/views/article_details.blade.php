@extends('template')
@section('article-details')
<div class="container-fluid py-5">
    <div class="container py-5">
        <div class="section-title text-center position-relative pb-3 mb-3 mx-auto" style="max-width: 600px">
            <h5 class="fw-bold text-uppercase mt-4" style="color: maroon">BPJS</h5>
            <h1 class="mb-0">{{ $title }}</h1>
        </div>
        @if ($article_detail != null)
        <div class="row">

            <div class="col-lg-9 mt-5 mx-auto">
                <div class="card mb-3">
                    <div class="d-flex" style="margin: 10px">
                        <div class="text-start ps-3">
                            <h3 class="mb-3 text-uppercase">{{ $article_detail->title }}</h3>
                            <span>
                                <p>
                                    Category : {{ $article_detail->category_name }}
                                </p>
                                <p>
                                    Level : {{ $article_detail->article_level_name }}
                                </p>
                            </span>
                            <img src="{{ asset('assets/image/calendar.png') }}" width="20px"><span class="me-2">
                                Last updated :
                                @if ($article_detail->created_at != null)
                                {{ date('l, j F Y', strtotime($article_detail->created_at)) }} at
                                {{ date('H:i', strtotime($article_detail->created_at)) }} WIB
                                @else
                                No event date
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                <div class="card mb-3">
                    <div class="card">
                        <div class="card-body">
                            <h6>Description</h6>
                            <p style="text-align: justify;">{!! $article_detail->content !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>
@endsection
