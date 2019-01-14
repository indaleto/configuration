<?php
    $paginasSemHeader=['/info','/error'];
    
$paginaComMenuNovo=['admin/users'];

$_logo = "/img/brand/logo.svg";
$_menu = ["dashboard", "Admin/users", "Admin/settings"];

//$_menuUser = ["\Account", "updates", "messages", "tasks", "comments", "\Setting", "profile", "settings", "payments", "projects", "logout"];
$_menuUser = ["\Account", "perfil", "logout"];

//$_iconMenuUser = ["", "fa-bell-o", "fa-envelope-o", "fa-tasks", "fa-comments", "", "fa-user", "fa-wrench", "fa-usd", "fa-file", "fa-lock"];
$_iconMenuUser = ["", "fa-user", "fa-lock"];

$_showRightMenu = false; //Caso seja verdadeiro deve ser retirado o comentário no app.blade.php
//que impede que o ficheiro aside.blade.php seja carregado
$_showUserMenu = true;

$req_uri = $_SERVER['REQUEST_URI'];
$path_url=strtok($_SERVER["REQUEST_URI"],'?');
if (in_array($path_url, $paginasSemHeader)){
    return true;
}

$c= new indaleto\configuration\Configuration;
$imagem=$c->getConfig('imagem',"/img/brand/logo.svg");
$avatar = $c->getProfileAvatar(); 

?>

        <div class="modal fade" id="infoModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-info" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Informação</h4>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div class="modal-body">
                  <p id="infoText"></p>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                </div>
              </div>
              <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </div>

        <div class="modal fade" id="dangerModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-danger" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h4 class="modal-title">Aviso</h4>
                  <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                  </button>
                </div>
                <div id="dangerText" class="modal-body">
                  <p></p>
                </div>
                <div class="modal-footer">
                  <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
                </div>
              </div>
              <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </div>          

<header class="app-header navbar">
    <button class="navbar-toggler sidebar-toggler d-lg-none mr-auto" data-toggle="sidebar-show" type="button">
        <span class="navbar-toggler-icon">
        </span>
    </button>

    <a class="navbar-brand" href="/">
        <img alt="Logo" class="navbar-brand-full" height="35" src={{ $imagem }} width="89">
            <img alt="Logo" class="navbar-brand-minimized" height="30" src="{{ $imagem }}" width="30">
            </img>
        </img>
    </a>
    <button class="navbar-toggler sidebar-toggler d-md-down-none" data-toggle="sidebar-lg-show" type="button">
        <span class="navbar-toggler-icon">
        </span>
    </button>

    <?php 
    $c=new indaleto\configuration\Configuration;
    if ($c->getConfig('showMenuHeader')=='S'){
     ?>
    <ul class="nav navbar-nav d-md-down-none">
    <?php
        for ($i = 0; $i < count($_menu); $i++) {
		echo '<li class="nav-item px-3">
            <a class="nav-link" href="/' . str_replace(' ','-',strtolower($_menu[$i])) . '">
                ' . ucfirst($_menu[$i]) . '
            </a>
        </li>';
	}
	?>
    </ul>
    <?php } ?>
    <ul class="nav navbar-nav ml-auto">

        <!-- EXEMPLO DE UM AVISO DE MENSAGENS
        <li class="nav-item d-md-down-none">
            <a class="nav-link" href="#">
                <i class="icon-bell">
                </i>
                <span class="badge badge-pill badge-danger">
                    5
                </span>
            </a>
        </li> -->

<?php
if ($_showUserMenu && Auth::check()) {
		?>
        

        <li class="nav-item dropdown">
            <a aria-expanded="false" aria-haspopup="true" class="nav-link" data-toggle="dropdown" href="#" role="button">

                <?php 
                    array_unshift($_menuUser,'\\'.Auth::user()->name);
                    array_unshift($_iconMenuUser,'');
                ?>
                <img alt="logo" src="{{ $avatar }}" style="max-height:30px;max-width:30px;margin:5px;"/>
                <i class="cui-chevron-bottom icons"></i>

            </a>
            <div class="dropdown-menu dropdown-menu-right">

            <?php
                for ($i = 0; $i < count($_menuUser); $i++) {
        			if ($_menuUser[$i][0] == '\\') {
        				echo '<div class="dropdown-header text-center">
                        <strong>
                            ' . substr($_menuUser[$i], 1) . '
                        </strong>
                    </div>';
        			} else {
        				echo '<a class="dropdown-item" href="/' . $_menuUser[$i] . '">
                            <i class="fa ' . $_iconMenuUser[$i] . '">
                            </i>
                            ' . ucfirst($_menuUser[$i]) . '
                            
                        </a>';
                        /*echo '<a class="dropdown-item" href="/' . $_menuUser[$i] . '">
                            <i class="fa ' . $_iconMenuUser[$i] . '">
                            </i>
                            ' . ucfirst($_menuUser[$i]) . '
                            <span class="badge badge-info">
                                42
                            </span>
                        </a>';*/
        			}
        		}
		    ?>
            
            </div>
        </li>
        <?php
}
	?>
    </ul>
<?php
if ($_showRightMenu) {
		?>

    <button class="navbar-toggler aside-menu-toggler d-md-down-none" data-toggle="aside-menu-lg-show" type="button">
        <span class="navbar-toggler-icon">
        </span>
    </button>

<?php
}?>

    
</header>