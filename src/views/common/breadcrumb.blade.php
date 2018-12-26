<?php 
	$paginasSemHeader=['/info','/error'];
	$paginaComMenuNovo=['admin/users'];
	$paginaComMenuGuardar=['admin/settings','profile','admin/users/%'];
	$substituir=["users" => "utilizadores", "settings" => "definições"];
 ?>
        <ol class="breadcrumb">
          <?php

//Constroi o caminho do painel de navegação se as view existirem.
$req_uri = $_SERVER['REQUEST_URI'];
$path_url=strtok($_SERVER["REQUEST_URI"],'?');

if (in_array($path_url, $paginasSemHeader)){
	return true;
}

$p=strpos($req_uri, '?');
if($p>1){
	$req_uri=substr($req_uri, 0,$p);
}
echo '<li class="breadcrumb-item">
              	<button class="btn btn-primary" type="button">
                      &nbsp;<a href="/" style="color:white;">Home </a></button>
          	  </li>';
//echo '<li style="margin-top:5px;" class="breadcrumb-item"><a href="/"">Home</a></li>';
$req_uri = substr($req_uri, 1);
if (strlen($req_uri) > 0 && $req_uri[strlen($req_uri) - 1] == '/') {
	$req_uri = substr($req_uri, 0, strlen($req_uri) - 1);
}
$caminhos = explode('/', $req_uri);
$caminhoRel = '/';
$view = '';
foreach ($caminhos as $caminho => $value) {
	if (strpos($value, '?')>0){
		break;
	}
	if ($value=='0' || $value==""){ continue;}
	$caminhoRel .= $value . '/';
	$view .= $value . '.';
	$viewAux = substr($view, 0, strlen($view) - 1);
	if (isset($substituir[$value])){
		$value=$substituir[$value];
	}
	if (view()->exists($viewAux) || view()->exists('adminConfiguration::'.$viewAux)) {
		echo '<li class="breadcrumb-item">
              	<button class="btn btn-primary" type="button">
                      &nbsp;<a href="'.$caminhoRel.'" style="color:white;">' . ucfirst($value) . ' </a></button>
          	  </li>';
		/*echo '<li style="margin-top:5px;" class="breadcrumb-item">
                                    <a href="' . $caminhoRel . '">' . ucfirst($value) . ' </a>
                                    </li>';*/
	} else {
		/*echo '<li style="margin-top:5px;" class="breadcrumb-item">' . ucfirst($value) . '</li>';*/
		echo '<li class="breadcrumb-item">
              	<button class="btn btn-secondary" type="button">
                      ' . ucfirst($value) . '</button>
          	  </li>';
	}
}
?>

<?php 
	$existe=false;
	$nextPage="";
	foreach ($paginaComMenuNovo as $key => $pagina) {
		if ($req_uri==$pagina){
			$existe=true;
			$nextPage='/'.$req_uri.'/0';
		}
	}

	if ($existe){
		echo '<li class="breadcrumb-item">
              	<button class="btn btn-primary" type="button">
                      <i class="icon-plus icons"></i>&nbsp;<a href="'.$nextPage.'" style="color:white;">Novo</a></button>
          	  </li>';
		
    }

    $existe=false;
    $pagGuardar="";
	foreach ($paginaComMenuGuardar as $key => $pagina) {
		if ($req_uri==$pagina){
			$existe=true;
			$pagGuardar=$pagina;
			break;
		}
		else{
			$p=strpos($pagina,'%');
			if ($p>0){
				$paginaInicio=substr($pagina, 0,$p);
				$paginaFim=substr($pagina,$p+2);
				if ($paginaFim!=''){
					$paginaTotal=$paginaInicio.'SEP/'.$paginaFim;
				}
				else{
					$paginaTotal=$paginaInicio.'SEP';
				}
				$caminhosPagina=explode('/', $paginaTotal);
				$caminhos=explode('/',$req_uri);
				$iguais=true;
				foreach ($caminhos as $key => $caminho) {
					if ($caminho!=$caminhosPagina[$key] && $caminhosPagina[$key]!='SEP' )
						$iguais=false;
				}
				if ($iguais && count($caminhos)==count($caminhosPagina)){
					$existe=true;
					$pagGuardar=$pagina;
					break;
				}
			}
		}
	}

	if ($existe){
		echo '<li class="breadcrumb-item">
              	<button id="btnGuardar" class="btn btn-success" type="button">
                      <i class="icon-drawer icons"></i>&nbsp;Guardar</button>
          	  </li>';
		
    }

?>
</ol>