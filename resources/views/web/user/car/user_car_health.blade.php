<div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
    <h3 class="modal-title">Car Health</h3>
</div>
<div class="panel panel-bd">
    @if(isset($userCarHealth) && $userCarHealth && count($userCarHealth)>0)
    <?php $arr = [] ;?>
    @foreach($userCarHealth AS $key=>$value)
    <div class='row car-health-contents'>
        <div class="col-sm-4">
            {{ strtoupper($key) }}
        </div>
        
        <div class="col-sm-4">
            @for($i=1; $i<=$value; $i++)
            <div class='round round-{{ $value }}'></div>
            @endfor
            @for($j=1; $j<=5-$value; $j++)
            <div class='round-default'></div>
            @endfor
        </div>
        
        <div class="col-sm-4">
            <?php
            switch ($value) {
                case "1":
                    echo "Poor";
                    break;
                case "2":
                    echo "Good";
                    break;
                case "3":
                    echo "Average";
                    break;
                case "4":
                    echo "Very Good";
                    break;
                case "5":
                    echo "Excellent";
                    break;
                default:
                    echo "Very Poor";
            }
            ?>
        </div>
    </div>
    @endforeach
    @else
    <div class='row text-center health-status'>Car health status not available.</div>
    @endif
</div>
<div class="modal-footer">
    <button type="button" class="btn btn-primary" data-dismiss="modal">Close</button>
</div>