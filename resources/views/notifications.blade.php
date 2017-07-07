@if(session('status')) 
    <div class="alert alert-{{ session('status')['type'] }} alert-dismissable">
        <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
        {{ session('status')['message'] }}
    </div>
@endif 
{{-- <div class="alert alert-dismissable hide" id="alertTemplate">
    <button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button>
</div> --}}