<?php
$s="<?xml version='1.0' encoding='UTF-8'?>
<menu>
	<Admin>
		<utilizadores>
			<i>icon-drop</i>
			<l>users</l>
			<t>Utilizadores</t>
		</utilizadores>
		<definicoes>
			<i>icon-wrench</i>
			<l>settings</l>
			<t>Definições</t>
		</definicoes>
	</Admin>
	<Temas>
		<cores>
			<l>colors</l>
			<i>icon-drop</i>
		</cores>
		<tipografia>
			<l>typography</l>
			<i>icon-pencil</i>
		</tipografia>
		<exemplos>
			<l>Examples</l>
			<i>icon-puzzle</i>
		</exemplos>
	</Temas>
	<Componentes>
		<Base>
			<i>icon-puzzle</i>
			<Breadcrumb></Breadcrumb>
			<Cards></Cards>
			<Carousel></Carousel>
			<Collapse></Collapse>
			<Forms></Forms>
			<Jumbotron></Jumbotron>
			<ListGroup>
				<l>list-group</l>
				<t>List Group</t>
			</ListGroup>
			<Navs></Navs>
			<Pagination></Pagination>
			<Popovers></Popovers>
			<Scrollspy></Scrollspy>
		</Base>
		<Buttons>
			<i>icon-cursor</i>
			<Buttons></Buttons>
			<ButtonsGroup>
				<l>button-group</l>
				<t>Button group</t>
			</ButtonsGroup>
			<Dropdown></Dropdown>
			<BrandButtons>
				<l>brand-buttons</l>
				<t>Brand Buttons</t>
			</BrandButtons>
		</Buttons>
		<Charts>
			<i>icon-pie-chart</i>
		</Charts>
		<Icons>
			<i>icon-star</i>
			<CoreUiIcons>
				<l>coreui-icons</l>
				<t>CoreUi Icons</t>
			</CoreUiIcons>
			<Flags></Flags>
			<FontAwesome>
				<l>font-awesome</l>
				<t>Font Awesome</t>
			</FontAwesome>
			<SimpleLineIcons>
				<l>simple-line-icons</l>
				<t>Simple Line Icons</t>
			</SimpleLineIcons>
		</Icons>
		<Notifications>
			<i>icon-bell</i>
			<Alerts></Alerts>
			<Badge></Badge>
			<Modals></Modals>
			<Widgets></Widgets>
		</Notifications>
	</Componentes>
	<Extras>
		<Pages>
			<i>icon-star</i>
			<P400>
				<l>404</l>
				<t>404</t>
			</P400>
			<P500>
				<l>500</l>
				<t>500</t>
			</P500>
			<Login></Login>
			<Register></Register>
		</Pages>
	</Extras>
</menu>";
?>
<div class="sidebar">
        <nav class="sidebar-nav">
          <ul class="nav">
            <li class="nav-item">
              <a class="nav-link" href="/">
                <i class="nav-icon icon-speedometer"></i> Backoffice
              </a>
            </li>

<?php
$xml=simplexml_load_string($s);
foreach ($xml->children() as $menu) {
	if (isset($menu->t)){
			$t=$menu->t;
		}
		else{
			$t=ucfirst($menu->getName());
		}
	echo '<li class="nav-title">' . $menu->getName() . '</li>';
	if (isset($menu->l)){
			$l1=strtolower($menu->l);
		}
		else{
			$l1=strtolower($menu->getName());
		}
	foreach ($menu->children() as $key => $submenu) {
		if (isset($submenu->i)){
			$ic=$submenu->i;
		}
		else{
			$ic="";
		}
		if (isset($submenu->l)){
			$l2=strtolower($submenu->l);
		}
		else{
			$l2=strtolower($submenu->getName());
		}
		if (isset($submenu->t)){
			$t=$submenu->t;
		}
		else{
			$t=ucfirst($submenu->getName());
		}

		//Verifica se há submenus, ou seja, se há children diferentes de i, l, t:
		$hasubsubmenus=false;
		foreach ($submenu->children() as $key => $subsubmenu) {
			if ($subsubmenu->getName() !='i' && $subsubmenu->getName() !='l' && $subsubmenu->getName() !='t'){
				$hasubsubmenus=true;
				break;
			}
		}
		if (!$hasubsubmenus){
			echo '<li class="nav-item">
		              <a class="nav-link" href="/' . $l1 . '/' . $l2 . '">
		                <i class="nav-icon ' . $ic . '"></i> ' . $t . '</a>
		            </li>';
		}
		else{
			echo '<li class="nav-item nav-dropdown">
                  <a class="nav-link nav-dropdown-toggle" href="/">
                    <i class="nav-icon ' . $ic . '"></i> ' . $t . '</a><ul class="nav-dropdown-items">';
            foreach ($submenu->children() as $key => $subsubmenu) {
            	$name=$subsubmenu->getName();
            	if ($name=='i' || $name=='t' || $name=='l'){
					continue;
				}
				if (isset($subsubmenu->l)){
					$l3=strtolower($subsubmenu->l);
				}
				else{
					$l3=strtolower($subsubmenu->getName());
				}
				if (isset($subsubmenu->t)){
					$t=$subsubmenu->t;
				}
				else{
					$t=ucfirst($subsubmenu->getName());
				}
				echo '<li class="nav-item">
                      <a class="nav-link" href="/' . $l1 . '/' . $l2 . '/' . $l3 . '">
                        <i class="nav-icon ' . $ic . '"></i> ' . $t . '</a>
                    </li>';
            }
            echo '</ul></li>';
		}
	}
}

?>
 	</ul>
        </nav>
        <button class="sidebar-minimizer brand-minimizer" type="button"></button>
      </div>
