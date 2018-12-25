@extends('adminConfiguration::layout.app')

@section('title')
    <?php 
    	$c=new indaleto\configuration\Configuration;
        echo $c->getConfig('empresa','');
     ?>
@endsection

@section('content')
		<div class="col-md-12">
			<form id="myForm" method="POST" action="/admin/settings/edit" enctype="multipart/form-data">
				@csrf
				<div class="card">
					<div class="card-header">Configurações</div>
					<div class="card-body">
						<div class="row">
							<div class="col-md-4">
								<div class="card">
									<div class="card-header">Dados Gerais</div>
									<div class="card-body">
										<div class="form-group">
											<label for="empresa">Nome da empresa</label>
											<input type="text" class="col-md-12" name="empresa" value="{{ $empresa }}">
											<label">(Nome abreviado)</label>
										</div>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="card">
									<div class="card-header">Imagem da Empresa</div>
									<div class="card-body">
										<div class="form-group">
											<img alt="logo" src="{{ $imagem }}" style="max-height:40px;max-width:200px;margin-bottom:5px;"/>
											<input type="file" accept="image/x-png,image/jpeg" name="imagem" id="imagem">
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
			window.location.href = "/admin/settings/remLogo"
		});
		$("#btnGuardar").click(function(){
			$("#myForm").submit();
		});


</script>

@endsection