@extends('layouts.app')
@section('custom-head')
<style type="text/css">
    #dropdown1 li a {
        color: #555;
        font-weight: lighter;
    }
    .panel{
        margin: 0px 1px;
        margin-bottom: 15px;
    }
    .panel.done{
        background-color: #ddd;
    }
    .panel.done .panel-heading, .panel.done .panel-body{
        text-decoration: line-through;
    }
    .panel .panel-heading {
        margin-bottom: .5rem;
        font-weight: bold;
    }
    .panel .panel-footer{
        border-top: solid .1px rgb(245,245,245);
        margin-top: 5px;
        padding-top: 5px;
    }
    .panel .panel-footer{
        font-style: italic;
        font-size: .9rem;
    }

    .panel .panel-footer span{
        color: #999;
        font-style: normal;
    }
    .dropdown-button{
        color: #999;
    }
</style>
@endsection
@section('content')
<div class="panel panel-default" style="display: none" id="note-template">
    <div class="panel-heading">
        Your top priority!
        <a class='dropdown-button right' href='#' data-activates='dropdown1'><i class="material-icons">reorder</i></a>
    </div>

    <div class="panel-body">
        This top priority is right here, 
    </div>
    <div class="panel-footer">
        <div class="panel-meta">
            <span>Deadline: </span> 23 February 2017 23:59
        </div>
        <div class="panel-meta">
            <span>Label: </span> Top Priority
        </div>
    </div>
</div>
<ul id='dropdown1' class='dropdown-content'>
    <li><a href="#!">Edit</a></li>
    <li><a href="#!">Mark as Done</a></li>
    <li class="divider"></li>
    <li><a href="#!" class="disabled">Delete</a></li>
</ul>
<div class="container">
    <div class="row">
        <div class="col m12 s12">
            <div class="panel panel-default">
                <div class="panel-heading">Welcome!</div>
                <div class="panel-body">
                    Thanks for chosing this Mang-Notes
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col m4 s12 note-placeholder">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Your top priority!
                    <a class='dropdown-button right' href='#' data-activates='dropdown1'><i class="material-icons">reorder</i></a>
                </div>

                <div class="panel-body">
                    This top priority is right here, 
                </div>
                <div class="panel-footer">
                    <div class="panel-meta">
                        <span>Deadline: </span> 23 February 2017 23:59
                    </div>
                    <div class="panel-meta">
                        <span>Label: </span> Top Priority
                    </div>
                </div>
            </div>
        </div>
        <div class="col m4 s12 note-placeholder">
            <div class="panel panel-default done">
                <div class="panel-heading">
                    Medium priority?
                    <a class='dropdown-button right' href='#' data-activates='dropdown1'><i class="material-icons">reorder</i></a>
                </div>

                <div class="panel-body">
                    Nevermind, you have this priority
                </div>
                <div class="panel-footer">
                    <div class="panel-meta">
                        <span>Deadline: </span> 23 February 2017 23:59
                    </div>
                    <div class="panel-meta">
                        <span>Label: </span> Top Priority
                    </div>
                    <div class="panel-meta">
                        <span>Status: </span> <b>Done</b>
                    </div>
                </div>
            </div>
        </div>
        <div class="col m4 s12 note-placeholder">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Low Priority, aint no body got time for this
                    <a class='dropdown-button right' href='#' data-activates='dropdown1'><i class="material-icons">reorder</i></a>
                </div>

                <div class="panel-body">
                    Im not working on this priority :)
                </div>
                <div class="panel-footer">
                    <div class="panel-meta">
                        <span>Deadline: </span> 23 February 2017 23:59
                    </div>
                    <div class="panel-meta">
                        <span>Label: </span> Top Priority
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('custom-footer')
<script type="text/javascript">
    $('.dropdown-button').dropdown();
    $(document).ready(function(){
        // Notes Append
        var placeholders = $('.note-placeholder');
        var shortestNote = placeholders.first();
        placeholders.each(function(){
            console.log($(this));
            if (shortestNote.outerHeight() > $(this).outerHeight())
                shortestNote = $(this);
        })
        shortestNote.append($('#note-template').clone().removeAttr('id').show());

        // Modal AJAX call
        $('.modal-trigger').click(function(){
            var trigger = $(this);
            $.get(trigger.attr('target-url')).done(function(response){
                $(trigger.attr('href') + "_loader").hide();
                $(trigger.attr('href') + "_content").html(response);
            }).fail(function(response){
                $(trigger.attr('href') + "_loader").hide();
                $(trigger.attr('href') + "_content").html(
                    "ERROR. you are trying to access <a href='" + trigger.attr('target-url') + "'> " + trigger.attr('target-url') + "</a> that currently not available. Try again later."
                );
            });
        });
    });
</script>
@endsection