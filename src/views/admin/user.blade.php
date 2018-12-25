@extends('adminConfiguration::layout.app')

@section('title')
    Users
@endsection

@section('content')
<div class="row">
	<div class="col-sm-6 col-md-4">
		<div class="card">
			<div class="card-header">Utilizador</div>
			<?php if (!isset($user->id)){
				$link="/admin/users/add";
				$user=new \App\User;
			}
			else{
				$link="/admin/users/$user->id/edit";
			} ?>
			<form id="myForm" method="POST" action="{{ $link }}">
				@csrf
				<div class="card-body">
					<div class="form-group">
						<label for="user">User</label>
						<input in="name" class="form-control" type="text" name="name" value="{{ $user->name  }}">
					</div>
					<div class="form-group">
						<label for="email">EMail</label>
						<input class="form-control" type="text" name="email" value="{{ $user->email }}">
					</div>
					<div class="form-group">
						<label for="type">Type</label>
						<select name="type" id="type" class="form-control">
							<option value="A" <?php if ($user->type=='A') echo "selected"; ?>>Administrator</option>
							<option value="O" <?php if ($user->type=='O') echo "selected"; ?>>Other</option>
						</select>
					</div>
				</div>
				<div class="card-footer">
		              <button id="btn-reset" class="btn btn-sm btn-success col-md-12" type="button">
		              <i class="fa fa-edit"></i>Enviar link para mudar password</button>
		        </div>
			</form>
		</div>
	</div>
	<div class="col-sm-6 col-md-8">
		<div class="card">
			<div class="card-header">Utilizadores</div>
			<div class="card-body">
				<table class="table table-striped table-bordered" id="users-table">
					<thead>
						<tr>
							<th>Name</th>
							<th>Email</th>
						</tr>
					</thead>
				</table>
			</div>
		</div>
	</div>
	
</div>
@endsection

@section('afterBodyScripts')

<script>
	

    $(function() {
        table=$('#users-table').DataTable({
            ajax: '{!! route('get.users') !!}',
            columns: [
                { data: 'name', name: 'name',"fnCreatedCell": function (nTd, sData, oData, iRow, iCol) { $(nTd).html("<a href='/admin/users/"+oData.id+"'>"+oData.name+"</a>");} },
                { data: 'email', name: 'email' }
            ]
        });

        var name="<?php echo $user->name;?>";
		if (name!=""){
			addButtonBreadcrumb('btn-eliminar','Eliminar','icon-trash');
		}
        $('#btn-eliminar').click( function(){
        	window.location.replace("/admin/users/{{ $user->id }}/del");
        });
        $('#btn-reset').click( function(){
        	window.location.replace("/admin/users/{{ $user->id }}/resetPassword");
        });
        $("#btnGuardar").click(function(){
			$("#myForm").submit();
		});
    });
</script>
@endsection