@extends('layouts.admin')
@section('title', "Billings & Payments | Uncle Fitter")
@section('content')
@inject('bookingStatus', 'App\Utility\BookingStatus')
<div class="wrapper">
    <div class="content-wrapper">
        <!-- Main content -->
        <section class="content">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-bd">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h4>Billing & Payments</h4>
                            </div>
                        </div>

                        <div class="panel-body">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Booking Id</th>
                                            <th>User Name</th>
                                            <th>Payment Mode</th>
                                            <th>Service Amount</th>
                                            <th>VAT ({{ $vat_tax }}%)</th>
                                            <th>Total Amount</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = 0; ?>
                                        @if(count($result)>0)
                                        @foreach($result as $payment)
                                        <?php
                                        $booking_price = $payment->booking->price;
                                        $vat_price = $payment->booking->vat_cost;
                                        //$vat_price = ($payment->booking->price * $vat_tax) / 100;
                                        $total_price = $booking_price + $vat_price;
                                        ?>
                                        <tr>
                                            <td><?php echo ++$i; ?></td>
                                            <td><a href='{{ url("admin/bookings") }}'>{{ $payment->booking->id }}</a></td>
                                            <td>{{ $payment->booking->getUser->name }}</td>
                                            <td>
                                                @if($payment->mode == 'COS' || $payment->mode == 'Cash on site')
                                                {{ 'Cash on Site' }}
                                                @elseif($payment->mode == 'Paid Online' || $payment->mode == 'Paid Online')
                                                {{ 'Paid Online' }}
                                                @endif
                                            </td>
                                            <td align="right">&#x20B5;{{ number_format($payment->booking->price,2) }}</td>
                                            <!-- <td align="right">&#x20B5;{{ number_format($vat_price,2) }}</td> -->

                                            <td align="right">
                                                <?php
                                                $service_cost = (float) $payment->booking->price;
                                                $vat_cost = (float) $payment->booking->vat_cost;
                                                $vat_tax_100 = ($vat_cost * 100);
                                                $vat_tax_percentage = ($vat_tax_100 / $service_cost);
                                                ?>
                                                &#x20B5;{{ number_format($vat_tax_percentage, 2) }}
                                            </td>

                                            <td align="right">&#x20B5;{{ number_format($total_price,2) }}</td>
                                            <td>
                                                <span class="text-{{ strtolower($bookingStatus::getKeys($payment->status))}}">
                                                    {{ strtolower($bookingStatus::getKeys($payment->status))}}
                                                </span>
                                            </td>
                                        </tr>
                                        @endforeach
                                        @else
                                        <tr>
                                            <td colspan="6" align="center">No Record Exists</td>
                                        </tr>
                                        @endif
                                    </tbody>
                                    <tfoot>
                                        @if($result && $result->links())
                                        <tr>
                                            <td colspan="8" align="center">
                                                <nav class="pagination"> {{ $result->links() }} </nav>
                                            </td>
                                        </tr>
                                        @endif
                                        <tr class="records">
                                            <td colspan="8" align="center">Total Records: {{ $result->total() }}</td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section> <!-- /.content -->
    </div> <!-- /.content-wrapper -->
</div> 
@endsection
