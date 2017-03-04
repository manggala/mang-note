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

    .panel .panel-footer span.label{
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
        <span id="note_template_title">
            Your top priority!
        </span>
        <a class='dropdown-button right' href='#' data-activates='dropdown1'><i class="material-icons">reorder</i></a>
    </div>

    <div class="panel-body" id="note_template_content">
        This top priority is right here, 
    </div>
    <div class="panel-footer">
        <div class="panel-meta">
            <span class="label">Deadline: </span> <span id="note_template_deadline">23 February 2017 23:59</span>
        </div>
        <div class="panel-meta">
            <span class="label">Label: </span> <span id="note_template_priority">Top Priority</span>
        </div>
    </div>
</div>
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
            
        </div>
        <div class="col m4 s12 note-placeholder">
            
        </div>
        <div class="col m4 s12 note-placeholder">
            
        </div>
    </div>
</div>
@endsection
@section('custom-footer')
<script type="text/javascript">
    $('.dropdown-button').dropdown();
    // Notes Append
    function appendNotes(data){
        var placeholders = $('.note-placeholder');
        var shortestNote = placeholders.first();
        placeholders.each(function(){
            if (shortestNote.outerHeight() > $(this).outerHeight())
                shortestNote = $(this);
        })
        setTemplateData(data);
        shortestNote.append($('#note-template').clone().removeAttr('id').show());
        resetNoteTemplate();
    }

    // Setting All value from json
    function setTemplateData(data){
        $('#note_template_title').text(data.title);
        $('#note_template_content').text(data.content);
        $('#note_template_deadline').text(data.deadline);
        $('#note_template_priority').text(data.label_id);
        if (data.is_done == 1)
            $('#note-template').addClass('done');
    }

    // Reset all content of note template
    function resetNoteTemplate(){
        $('#note_template_title').text();
        $('#note_template_content').text();
        $('#note_template_deadline').text();
        $('#note_template_priority').text();
        $('#note-template').removeClass('done');
    }
    $(document).ready(function(){
        // Get Recent Notes
        $.get('{{url("rest/note")}}').done(function(response){
            for (var i = 0; i < response.data.length; i++){
                appendNotes(response.data[i]);
            }
        }).fail(function(){

        });

        // Modal AJAX call
        $('.modal-trigger').click(function(){
            var trigger = $(this);

            // Show ajax preloader
            $(trigger.attr('href') + '_loader').show();
            $(trigger.attr('href') + '_content').hide();
            console.log(trigger.attr('target-url'));
            // If server response, do following
            $.get(trigger.attr('target-url')).done(function(response){
                // If success, do following
                $(trigger.attr('href') + "_loader").hide();
                $(trigger.attr('href') + "_content").html(response).show();
            }).fail(function(response){
                // If error, do following
                $(trigger.attr('href') + "_loader").hide();
                $(trigger.attr('href') + "_content").html(
                    "ERROR. you are trying to access <a href='" + trigger.attr('target-url') + "'> " + trigger.attr('target-url') + "</a> that currently not available. Try again later."
                ).show();
            });
        });
    });
</script>
@endsection