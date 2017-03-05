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
    span.filter{
        margin-right: 15px;
    }
    hr{
        background-color: rgb(235,235,235) !important;
        height: 2px !important;
        border: none;
        margin-bottom: 15px;
        margin-top: -15px;
    }
</style>
@endsection
@section('content')
<div class="panel panel-default" style="display: none" id="note-template">
    <div class="panel-heading">
        <span id="note_template_title">
        </span>
        <a class='dropdown-button right' href='#' data-activates='dropdown1'><i class="material-icons">reorder</i></a>
    </div>

    <div class="panel-body" id="note_template_content">
    </div>
    <div class="panel-footer">
        <div class="panel-meta">
            <span class="label">Deadline: </span> <span id="note_template_deadline"></span>
        </div>
        <div class="panel-meta">
            <span class="label">Label: </span> <span id="note_template_priority"></span>
        </div>
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col m12 s12">
            <div class="panel panel-default">
                <div class="panel-heading">Advance </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col m8 s12">
                            <div class="row">
                                <div class="col m3 s12">
                                    Label Filter:
                                </div>
                                <div class="col m9 s12">
                                    @foreach($data['labels'] as $label)
                                    <span class="filter">
                                        <input type="checkbox" class="label" label_id="{{$label->id}}" label_title="{{$label->title}}" id="label_{{$label->id}}" checked/>
                                        <label for="label_{{$label->id}}">{{$label->title}}</label>
                                    </span>
                                    @endforeach
                                </div>
                            </div>
                            <div class="row">
                                <div class="col m3 s12">
                                    Mark Filter:
                                </div>
                                <div class="col m9 s12">
                                    <span class="filter">
                                        <input type="checkbox" mark_code="1" class="marking" id="mark_done" checked/>
                                        <label for="mark_done">Done</label>
                                    </span>
                                    <span>
                                        <input type="checkbox" mark_code="0" class="marking" id="mark_undone" checked/>
                                        <label for="mark_undone">Undone</label>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col m4 s12">
                            <label>Sort by</label>
                            <select class="browser-default" id="sorting">
                                <option value="" disabled selected>chose sorting</option>
                                <option value="label">Label Name</option>
                                <option value="title">Title</option>
                                <option value="description">Description</option>
                                <option value="deadline">Deadline</option>
                            </select> 
                        </div>
                    </div>
                    

                </div>
            </div>
        </div>
    </div>
    <hr>
    <div class="row" id="notes_preloader">
        <center>
            <div class="preloader-wrapper big active">
                <div class="spinner-layer spinner-blue-only">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="gap-patch">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
        </center>
    </div>
    <div class="row" id="notes_container">
        <div class="col m4 s12 note-placeholder">
            
        </div>
        <div class="col m4 s12 note-placeholder">
            
        </div>
        <div class="col m4 s12 note-placeholder">
            
        </div>
    </div>
</div>
<div class="fixed-action-btn">
    <a class="btn-floating btn-large red">
        <i class="large material-icons">add</i>
    </a>
    <ul>
        <li>
            <a href="#basicModal" class="modal-trigger btn-floating tooltipped yellow" data-position="bottom" data-delay="50" data-tooltip="Add Label" target-url="{{route('label.create')}}">
                <i class="material-icons">turned_in_not</i>
            </a>
        </li>
        <li>
              <a href="#basicModal" class="modal-trigger btn-floating tooltipped orange" data-position="bottom" data-delay="50" data-tooltip="Add Notes" target-url="{{route('note.create')}}">
                <i class="material-icons">assignment</i>
            </a>
        </li>
    </ul>
</div>
@endsection
@section('custom-footer')
<script type="text/javascript">
    $('.dropdown-button').dropdown();
    var notes = [];
    var placeholders = $('.note-placeholder');
    function clearNotes(){
        $('#notes_preloader').show();
        $('#notes_container').hide();
        placeholders.each(function(){
            $(this).empty();
        });
    }
    // Notes Append
    function appendNotes(data){
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

    function arrangeNotes(data){
        clearNotes();
        $('#notes_preloader').hide();
        $('#notes_container').show();
        for (var i = 0; i < data.length; i++){
            appendNotes(data[i]);
        }
    }
    // Filter Notes
    function filterNotes(data, labels, anchor){
        var filteredNotes = [];
        for (var i = 0; i < data.length; i++){
            console.log(labels, data[i][anchor]);
            if (labels.indexOf(data[i][anchor]) >= 0)
                filteredNotes.push(data[i]);
        }
        return filteredNotes;
    }

    // Filtering
    function filterAllNotes(data){
        var checkedLabels = [];
        $('.label').each(function(){
            if ($(this).prop('checked'))
                checkedLabels.push(parseInt($(this).attr('label_id')));
        });
        var filteredNotes = filterNotes(data, checkedLabels, 'label_id');
        
        var checkedLabels = [];
        $('.marking').each(function(){
            if ($(this).prop('checked'))
                checkedLabels.push(parseInt($(this).attr('mark_code')));
        });
        var filteredNotes = filterNotes(filteredNotes, checkedLabels, 'is_done');
        clearNotes();
        arrangeNotes(filteredNotes);
        resetNoteTemplate();
    }
    $(document).ready(function(){
        // Get Recent Notes
        $.get('{{url("rest/note")}}').done(function(response){
            for (var i = 0; i < response.length; i++){
                notes.push(response[i]);
            }
            arrangeNotes(notes);
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

        // Sorting triggers
        $('#sorting').change(function(){
            switch($(this).val()){
                case 'label':
                    // Do something
                    console.log('lbl')
                    break;
                case 'title':
                    console.log('ttl')
                    // Do something
                    break;
                case 'description':
                    console.log('dsc')
                    // Do something
                    break;
                case 'deadline':
                    console.log('ddl')
                    // Do something
                    break;
                
            }
        });

        // Filter Triggers
        $('.label').click(function(){
            filterAllNotes(notes);
        });

        // Marking Status Triggers
        $('.marking').click(function(){
            filterAllNotes(notes);
        }) 
    });
</script>
@endsection