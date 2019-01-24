@extends('adminlte::page')

@section('content_header')
    <h1>Manage Faculties</h1>
@stop

@section('content')
    
<div class="box box-solid">
    <div class="box-header">
        <form action="/admin/faculties" method="post">
            <div class="input-group">
                <span class="input-group-addon">
                    <i class="fa fa-university"></i>
                </span>
                <input type="text" name="name" class="form-control" placeholder="New Faculty Name">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-success btn-flat">Add</button>
                </span>
            </div>
            {{ csrf_field() }}
        </form>
        @if ($errors->any())
                {!! implode('', $errors->all('<span class="help-block">:message</span>')) !!}
        @endif
    </div>
    <div class="box-body">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Sn.</th>
                    <th>Faculty Name</th>
                    <th>Date Added</th>
                    <th>Controls</th>
                </tr>
            </thead>
            <tbody>
                @foreach($faculties as $faculty)
                <tr>
                    <td>{{$loop->iteration }}</td>
                    <td>{{$faculty->name}}</td>
                    <td>{{$faculty->created_at}}</td>
                    <td>
                        <button
                            type="button" 
                            class="btn btn-sm btn-danger" 
                            data-toggle="modal" 
                            onclick="deleteFaculty({{$faculty->id}})"
                            data-target="#modal-delete">
                                <i class="fa fa-trash"></i>
                        </button>

                        <button
                            type="button" 
                            class="btn btn-sm btn-primary" 
                            data-toggle="modal" 
                            onclick="editFaculty({{$faculty->id}}, '{{$faculty->name}}')"
                            data-target="#modal-edit">
                                <i class="fa fa-pencil"></i>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>



    </div>
</div>


{{-- Delete Modal --}}
<div class="modal fade in" id="modal-delete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Delete Faculty</h4>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete the Faculty ?</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">No</button>

                {{-- delete button --}}
                <form action="" method="POST" id="form-delete">
                    {{method_field('DELETE')}}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-sm btn-danger" value="Yes"/>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Edit Modal --}}
<div class="modal fade in" id="modal-edit">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="" method="post" id="form-edit">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Edit Faculty</h4>
                </div>
                <div class="modal-body">
                    <input type="text" name="name" id="edit-faculty-name" class="form-control" placeholder="Faculty Name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Cancel</button>
                    {{method_field('PUT')}}
                    {{ csrf_field() }}
                    <input type="submit" class="btn btn-sm btn-primary" value="Save Changes"/>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function deleteFaculty(id){
		$("#form-delete").attr("action", `faculties/${id}`);
	}

    function editFaculty(id, name){
		$("#form-edit").attr("action", `faculties/${id}`);
        $("#edit-faculty-name").val(name);
	}

</script>

@stop