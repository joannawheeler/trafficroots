@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-title">My Tickets</div>
            <div class="ibox-content table-responsive">
            <table width="100%" class="table table-border table-hover">
            <thead><tr><th>Ticket ID</th><th>Subject</th><th>Type</th><th>Status</th><th>Date Created</th><th>Date Update</th><th>Details</th></tr></thead>
            <tbody>
            @foreach($mytickets as $ticket)
                <tr><td>{{$ticket->id}}</td><td>{{$ticket->subject}}</td><td>{{$ticket->type}}</td><td>{{$ticket->status}}</td><td>{{$ticket->created_at}}</td><td>{{$ticket->updated_at}}</td><td><a href=""><i class="fa fa-cogs"></i></a></td></tr>

            @endforeach
            </tbody>
            </table>
            </div>
        </div>
            <div class="ibox">
            <div class="ibox-title">Create Support Ticket</div>
            <div class="ibox-content">
            <form name="ticket_form" id="ticket_form" action="" method="POST">
       <div class="control-group">
            <label class="control-label" for="subject">Ticket Subject</label>
            <div class="controls">
                <input type="text" size="40" id="subject" name="subject" class="border-radius-none" maxlength="50" required>
            </div>
        </div>
       <div class="control-group">
            <label class="control-label" for="description">Ticket Description</label>
            <div class="controls">
                <textarea id="description" name="description" class="border-radius-none" rows="10" cols="60" required></textarea>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label" for="location_type">Ticket Type</label>
            <div class="controls">
                <select id="type" name="type" class="border-radius-none"  required>
                <option value="">Choose One</option>
                @foreach($ticket_types as $ticket_type)
                    <option value="{{$ticket_type->id}}">{{$ticket_type->description}}</option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="control-group">
            {{ csrf_field() }}
            <br /><br /><div class="controls">
                <input type="submit" value="Create New Ticket">
            </div>
        </div>
            </form>
        </div>
    </div>
        </div>
    </div>
</div>
   <script type="text/javascript">
       jQuery(document).ready(function ($) {
               $('.nav-click').removeClass("active");
               $('#nav_support').addClass("active");
       });
   </script>
@endsection
