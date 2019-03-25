@extends('layouts.admin')

@section('title', "Add New $user_type | Uncle Fitter")

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
                                <h4>Add New {{ ((isset($user_type) && $user_type) ? $user_type : '') }}</h4>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-5">
                                    <form action="{{ url("admin/user/save-user") }}" method="POST" name="addUserForm" id="addUserForm">
                                        <div class="col-md-12 form-group">
                                            <label for="name">Name</label>
                                            <input type="text" name="name" id="name" class="form-control" value="" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="email">Email Address</label>
                                            <input type="text" name="email" id="email" class="form-control" value="" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="mobile_country_code">Country Code</label>
                                            <select name="mobile_country_code" id="mobile_country_code" class="form-control">
                                                <?php
                                                $calling_codes = [93, 355, 213, 684, 376, 244, 809, 268, 54, 374, 297, 247, 61, 672, 43, 994, 242, 246, 973, 880, 375, 32,
                                                    501, 229, 809, 975, 284, 591, 387, 267, 55, 284, 673, 359, 226, 257, 855, 237, 1, 238, 1, 345, 238, 236, 235, 56, 86, 886,
                                                    57, 269, 242, 682, 506, 385, 53, 357, 420, 45, 246, 767, 809, 253, 593, 20, 503, 240, 291, 372, 251, 500, 298, 679, 358,
                                                    33, 596, 594, 241, 220, 995, 49, 233, 350, 30, 299, 473, 671, 502, 224, 245, 592, 509, 504, 852, 36, 354, 91, 62, 98, 964,
                                                    353, 972, 39, 225, 876, 81, 962, 7, 254, 855, 686, 82, 850, 965, 996, 371, 856, 961, 266, 231, 370, 218, 423, 352, 853, 389,
                                                    261, 265, 60, 960, 223, 356, 692, 596, 222, 230, 269, 52, 691, 373, 33, 976, 473, 212, 258, 95, 264, 674, 977, 31, 599, 869,
                                                    687, 64, 505, 227, 234, 683, 850, 1670, 47, 968, 92, 680, 507, 675, 595, 51, 63, 48, 351, 1787, 974, 262, 40, 7, 250, 670,
                                                    378, 239, 966, 221, 381, 248, 232, 65, 421, 386, 677, 252, 27, 34, 94, 290, 869, 508, 249, 597, 268, 46, 41, 963, 689, 886, 7,
                                                    255, 66, 228, 690, 676, 1868, 216, 90, 993, 688, 256, 380, 971, 44, 598, 1, 7, 678, 39, 58, 84, 1340, 681, 685, 381, 967, 381, 243, 260, 263];
                                                foreach ($calling_codes as $key => $code) {
                                                    ?>
                                                    <option {{ ($code == 233) ? 'selected' : '' }} value="+{{ $code }}">+{{ $code }}</option>
                                                    <?php
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="mobile">Mobile Number</label>
                                            <input type="text" name="mobile" id="mobile" class="form-control" value="" />
                                        </div>
                                        <div class="col-md-12 form-group">
                                            <label for="password">Password</label>
                                            <input type="password" name="password" id="password" class="form-control" value="" />
                                        </div>                                        
                                        <div class="col-md-12 form-group">
                                            <label for="default_location">Default Location</label>
                                            <select name="default_location" id="default_location" class="form-control">
                                                <option value="">Select Location</option>
                                                @if(isset($locations) && $locations) 
                                                @foreach($locations AS $location)
                                                <option value="{{ $location->id }}">{{ $location->zip_code }}</option>
                                                @endforeach
                                                @endif
                                            </select>
                                        </div>
                                        <div class="col-md-12 form-group">
                                            {{ csrf_field()}}
                                            <br/>
                                            <input type="hidden" name="role" value="{{ ((isset($page) && $page) ? $page : '') }}" />
                                            <button type="submit" name="save-user" id="save-user" class="btn btn-primary">Save User</button>
                                        </div>
                                    </form>
                                </div>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
@endsection