<div class="popover-menu" id="popTask">
    <div class="row">
        <div class="col-sm-3"><strong>Name:</strong></div>
        <div class="col-sm-9">{{ $user->name}}</div>
    </div>
    <div class="row">
        <div class="col-sm-3"><strong>Email:</strong></div>
        <div class="col-sm-9">{{ $user->email}}</div>
    </div>
    <div class="row">
        <div class="col-sm-3"><strong>Phone:</strong></div>
        <div class="col-sm-9">{{ $user->mobile}}</div>
    </div>
    <div class="row">
        <div class="col-sm-12 text-center">
            <img class="mechanic-profile-img" src="{{ url($user->profile_photo) }}" width="64" height="64" />
        </div>
    </div>
</div>