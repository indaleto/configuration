@extends('adminConfiguration::layout.app')

@section('title')
    Profile
@endsection

@section('content')
	
	<div class="col-md-12">
		<form id="myForm" method="POST" action="/profile/edit" enctype="multipart/form-data">
			@csrf
			<div class="card">
				<div class="card-header">Perfil</div>
				<div class="card-body">
					<div class="row">
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">Nome</div>
								<div class="card-body">
									<div class="form-group">
										<label for="nome">Nome do utilizador</label>
										<input type="text" class="col-md-12" name="name" value="{{ $name }}">
									</div>
									<div class="form-group">
										<label for="nome">Email do utilizador</label>
										<input type="text" class="col-md-12" name="email" value="{{ $email }}">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">Mudar password</div>
								<div class="card-body">
									<div class="form-group">
										<label for="password">Nova password</label>
										<input type="password" class="col-md-12" name="password" value="">
										<label for="password2">Repita a password</label>
										<input type="password" class="col-md-12" name="password2" value="">
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-4">
							<div class="card">
								<div class="card-header">Imagem do perfil</div>
								<div class="card-body">
									<div class="form-group">
										<img alt="logo" src="<?php echo $avatar;?>" style="max-height:40px;max-width:200px;margin-bottom:5px;"/>
										<input type="file" accept="image/x-png,image/jpeg"name="imagem" id="imagem">
										<br><br>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			
		</form>
	</div>
	
@endsection

@section('afterBodyScripts')
	<script type="text/javascript">
		addButtonBreadcrumb('btnRemoverLogo','Remover Avatar','icon-trash');
		$("#btnRemoverLogo").click(function(){
			window.location.href = "/profile/remLogo"
		});
		$("#btnGuardar").click(function(){
			$("#myForm").submit();
		});
</script>
@endsection