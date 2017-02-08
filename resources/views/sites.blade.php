@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
            <div class="panel-heading">Add a Site</div>
            <div class="panel-body">
            <form name="site_form" id="site_form" action="" method="POST">
       <div class="control-group">
            <label class="control-label" for="site_name">Site Name</label>
            <div class="controls">
                <input type="text" size="45" maxlength="60" id="site_name" name="site_name" class="border-radius-none" placeholder="Site Name" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="site_url">Site URL</label>
            <div class="controls">
                <input type="url" size="45" maxlength="60" id="site_url" name="site_url" class="border-radius-none" placeholder="Site URL" required>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="site_category">Site Category</label>
            <div class="controls">
                <select id="site_category" name="site_category" class="border-radius-none" required>
                <option value="">Choose Site Category</option>
                {!! $categories !!}
                </select>
            </div>
        </div>
        <div class="control-group">
            {{ csrf_field() }}
            <br /><br /><div class="controls">
                <input type="submit" value="Continue">
            </div>
        </div>
            </form>
        </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">My Sites</div>
               <div class="panel-body">
                   @if (count($sites))
                       <table class="table table-hover" name="sites_table" id="sites_table" width="100%">
                       <thead>
                       <tr><th>Site Name</th><th>Site Url</th><th>Site Category</th></tr>
                       </thead>
                       <tbody>
                       @foreach ($sites as $site)
                           <tr class="site_row"><td>{{ $site->site_name }} </td><td> {{ $site->site_url }} </td><td> {{ $site->category }} </td></tr>
                       @endforeach
                       </tbody>
                       </table>
                   @else
                       <h3>No Sites Defined</h3> 
                   @endif
                        </div>
                    </div>
                </div>
        
    </div>
        </div>
    </div>
</div>
@endsection
