@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Pixel Data</div>

                <div class="panel-body">
                    <pre>{{ var_dump($md) }} </pre><br /><br />
                    <pre>
                    {{ var_dump($result) }}
                    </pre>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
    
    });

</script>
@endsection
