@extends('layouts.admin')

@section('title', "Referrals | Uncle Fitter")

@section('content')
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <div class="col-md-10 col-sm-12"><h4>Referrals</h4></div>
                                <a class="btn btn-info btn-md button-info" href="{{ url("admin/referral-settings") }}">
                                    Referral Settings
                                </a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>From Name</th>
                                            <th>From To</th>
                                            <th>Amount</th>
                                            <th>Booking Id</th>
                                            <th>Redeem Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @if(isset($referrals) && $referrals && count($referrals)>0)
                                        @foreach($referrals as $referral)
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td>{{ $referral->sender_email }}</td>
                                            <td>{{ $referral->rec_email }}</td>
                                            <td>&#x20B5;{{ $referral->amount }}</td>
                                            <td>{{ $referral->rec_booking_id }}</td>
                                            <td>{{ $referral->rec_redeem ? 'Redeemed' : 'Available' }}</td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" align="center">No Record Exists</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        @if(isset($referrals) && $referrals && $referrals->links())
                                        <tr>
                                            <td colspan="6" align="center">
                                                <nav class="pagination"> {{ $referrals->links() }} </nav>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr class="records">
                                            <td colspan="6" align="center">Total Records: {{ $referrals->total() }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div> 
@endsection