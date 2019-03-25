<table class="table table-bordered table-hover">
    @if(!$referrals->isEmpty())    
    <thead>
        <tr>
            <th>#</th>
            <th>Amount</th>
            <th>Email</th>
            <th>Booking Id</th>
            <th>Redeem</th>
        </tr>
    </thead>
    @endif
    <tbody>
        @forelse($referrals as $key=>$referral)
            @if(($referral->rec_id == Auth::user()->id ) || ($referral->sender_id == Auth::user()->id && $referral->rec_redeem))
            <tr class="{{($referral->rec_id == Auth::user()->id ? 'warning' : '')}}">
                <td>{{$referral->id}}</td>
                <td>{{$referral->amount}}</td>
                @if($referral->rec_id == Auth::user()->id)
                    <td>{{$referral->sender_email}}</td>
                    <td>{{$referral->rec_redeem ? $referral->rec_booking_id : ''}}</td>
                    <td>{{$referral->rec_redeem ? 'Redeemed' : 'Available'}}</td>
                @endif
                @if($referral->sender_id == Auth::user()->id)
                    <td>{{$referral->rec_email}}</td>
                    <td>{{$referral->sender_redeem ? $referral->sender_booking_id : ''}}</td>
                    <td>{{$referral->sender_redeem ? 'Redeemed' : 'Available'}}</td>
                @endif
            </tr>
            @elseif($referral->count() ==1)
                <tr>
                    <td colspan="3">
                        <div class="alert alert-info">No referral entry found under this!
                        </div>
                    </td>
                </tr>
            
            @endif
        @empty
    <div class="alert alert-info">No referral entry found under this!
    </div>
    @endforelse
</tbody>
</table>       