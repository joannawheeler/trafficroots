@extends('layouts.app')
@section('title', '- Support')
@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
        <div class="ibox">
            <div class="ibox-title">Ticket {{ $ticket->id }}<div class="pull-right"><a href="/tickets"><button class="btn btn-xs btn-primary"><i class="fa fa-cogs"></i>&nbsp;Back to Tickets</button></a></div></div>
            <div class="ibox-content table-responsive">
            <table width="100%" class="table table-border table-hover">
            <thead><tr><th>Ticket ID</th><th>Subject</th><th>Type</th><th>Status</th><th>Date Created</th><th>Date Updated</th></tr></thead>
            <tbody>
		<tr><td>{{$ticket->id}}</td><td>{{$ticket->subject}}</td><td>{{$ticket->type}}</td><td>
                @if($ticket->status == 0)
                Pending
                @elseif($ticket->status == 1)
                Replied
                @elseif($ticket->status == 2)
                Closed
                @endif
                </td><td>{{$ticket->created_at}}</td><td>{{$ticket->updated_at}}</td></tr>

            </tbody>
            </table>
	    </div>
            <div class="ibox-content">
                <div class="row alert-info"><div class="col-md-1"><b><i>Me:</i></b></div><div class="col-md-5"><div class="well">{{ stripslashes($ticket->description) }}</div></div><div class="col-md-6"></div></div>
                @foreach(App\Ticket::find($ticket->id)->replies as $reply)
		<div class="row
                @if(!$reply->admin)
                 alert-info
                @endif
                ">
                @if($reply->admin)
                    <div class="col-md-6"></div><div class="col-md-1"><b><i>Admin:</i></b></div><div class="col-md-5"><div class="well">{{ stripslashes($reply->comments) }}</div></div></div>
		@else 
                    <div class="col-md-1"><b><i>Me:</i></b></div><div class="col-md-5"><div class="well">{{ stripslashes($reply->comments) }}</div></div><div class="col-md-6"></div></div>
		@endif
                @endforeach

            </div>
            <div class="ibox-content">
		<h4>Add A Reply</h4>
		<form name="reply_form" id="reply_form" action="/reply" method="POST">
                    <input type="hidden" name="ticket_id" id="ticket_id" value="{{ $ticket->id }}"
                    <div class="control-group">
                    <label class="control-label" for="description">Comments</label>
                    <div class="controls">
                        <textarea id="comments" name="comments" class="border-radius-none" rows="10" cols="60" required></textarea>
                    </div>
                    </div>
                    <div class="control-group">
                        {{ csrf_field() }}
                    <br /><br />
                    <div class="controls">
                        <input type="submit" value="Submit Reply">
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
