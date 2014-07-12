<div class="row form-group">
    <div class="col-xs-12">
        <ul class="nav nav-pills nav-justified thumbnail setup-panel">
            <li class="
            @if($active == 'type')
            active
            @else
            disabled
            @endif
            "><a href="#step-1">
                    <h4 class="list-group-item-heading">Step 1</h4>
                    <p class="list-group-item-text">Select Event Type</p>
                </a></li>
            <li class="
            @if($active == 'info')
            active
            @else
            disabled
            @endif
            "><a href="#step-2">
                    <h4 class="list-group-item-heading">Step 2</h4>
                    <p class="list-group-item-text">Fill up Event Information</p>
                </a></li>
            <li class="
            @if($active == 'options')
            active
            @else
            disabled
            @endif
            "><a href="#step-3">
                    <h4 class="list-group-item-heading">Step 3</h4>
                    <p class="list-group-item-text">Fill up Event Options</p>
                </a></li>
            <li class="
            @if($active == 'photos')
            active
            @else
            disabled
            @endif
            "><a href="#step-3">
                    <h4 class="list-group-item-heading">Step 4</h4>
                    <p class="list-group-item-text">Add Photos </p>
                </a></li>
        </ul>
    </div>
</div>