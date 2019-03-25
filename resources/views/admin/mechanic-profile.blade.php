@extends('layouts.admin')

@section('title', "Mechanic Profile | Uncle Fitter")

@section('content')

<?php
$profile_photo = ($profile->profile_photo && $profile->profile_photo != '') ? url($profile->profile_photo) : url('images/profile_photo/dummy-mechanic.png');
?>

<style type="text/css">
    .card-header-headshot-mechanic {
        height: 6em;
        width: 6em;
        border-radius: 50%;
        border: 2px solid #e63d25;
        background-image: url(<?php echo $profile_photo; ?>);
        background-size: cover;
        background-position: center center;
        box-shadow: 1px 3px 3px #3E4142;
    }
    .card-header-headshot {
        border: 2px solid #e63d25 !important;
    }
</style>

<div class="wrapper">
    <div class="content-wrapper">

        <section class="content-header">
            <div class="header-title" style="margin-left: 0">
                <h1 style="text-transform: capitalize;">Profile: {{ $profile->name }}</h1>
            </div>
        </section>

        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12 col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-header-headshot{{ ($profile->profile_photo) ? '-mechanic' : ''  }}"></div>
                        </div>
                        <div class="card-content">
                            <div class="card-content-member">

                                <h4 class="m-t-0">{{ $profile->name }}</h4>

                                @if($profile->mobile)
                                <p class="m-0">
                                    <i class="fa fa-phone"></i>{{ $profile->mobile_country_code.' '.$profile->mobile }}
                                </p>
                                @endif

                                @if($profile->email)
                                <p class="m-0">
                                    <i class="fa fa-envelope"></i> <a href="mailto: {{ $profile->email }}">{{ $profile->email }}</a>
                                </p>
                                @endif
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="rating-block">
                                <?php
                                $mean_overAllRating = 0;
                                $ratings = $profile->getRating;

                                if ($ratings->isNotEmpty()) {
                                    $mean_overAllRating = $ratings->avg('overall_rating');
                                }
                                $rating_percentage = ($mean_overAllRating / 5) * 100;
                                ?>
                                <h4>Average Rating</h4>
                                <h2 class="m-b-20">{{ number_format($mean_overAllRating, 2) }} <small>/ 5</small></h2>
                                <div class="star-ratings-sprite">
                                    <span style="width:{{ number_format($rating_percentage, 2) }}%" class="star-ratings-sprite-rating"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-md-8">
                    <div class="review-block">
                        @if(isset($ratings) && $ratings && sizeof($ratings))

                        <?php $ratings = $ratings->sortByDesc('id'); ?>

                        @foreach($ratings AS $rating)

                        <?php
                        $o_rating_percentage = ($rating->overall_rating / 5) * 100;
                        ?>
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="review-block-name">{{ $rating->getUser->name }}</div>
                                <h4>{{ number_format($rating->overall_rating, 2) }} <small>/ 5</small></h4>
                                <h5><small>Booking ID: {{ $rating->booking_id }}</small></h5>
                            </div>
                            <div class="col-sm-9">
                                <div class="review-block-rate">
                                    <div class="star-ratings-sprite">
                                        <span style="width:{{ number_format($o_rating_percentage, 2) }}%" class="star-ratings-sprite-rating"></span>
                                    </div>
                                </div>
                                @if($rating->user_note && $rating->user_note != '')
                                <div class="review-block-title">{{ $rating->user_note }}</div>
                                @endif
                            </div>
                        </div>
                        <hr/>
                        @endforeach
                        @else
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>No ratings yet!</h4>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div> 
        </section>
    </div>
</div>
@endsection