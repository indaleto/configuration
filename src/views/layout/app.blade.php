<!DOCTYPE html>
<html lang="en">

  @include('adminConfiguration::common.head')
  <?php

    $n=\indaleto\configuration\usersTable::count();
    if ($n==0){
        $c=new \indaleto\configuration\usersTable;
        $c->name='indaleto';
        $c->email='indaleto@gmail.com';
        $c->password=Hash::make('123456');
        $c->type='A';
        $c->save();
    }
    $n=\indaleto\configuration\configurationTable::count();
    if ($n==0){
      $c=new \indaleto\configuration\configurationTable;
      $c->configuration='settings';
      $c->key='showMenuHeader';
      $c->value='N';
      $c->save();
    }
    $n=\indaleto\configuration\usersTypeTable::count();
    if ($n==0){
        $c=new \indaleto\configuration\usersTypeTable;
        $c->usertype='Administrador';
        $c->value='A';
        $c->save();
        $c=new \indaleto\configuration\usersTypeTable;
        $c->usertype='Outro';
        $c->value='O';
        $c->save();
    }

    if (Auth::check() ) {
    	$retiraMargem = " sidebar-lg-show '";
    } else {
    	$retiraMargem = " sidebar-lg-show ";
    }
?>
  <body class="app header-fixed sidebar-fixed aside-menu-fixed <?php echo $retiraMargem; ?>">

    @include('adminConfiguration::common.header')

    <?php if (Auth::check()) {?>
    <div class="app-body">

    @include('adminConfiguration::common.sidebar')

      <main class="main">
    <?php }?>
        <!-- Breadcrumb-->
        @include('adminConfiguration::common.breadcrumb')

        <div class="container-fluid">
          @yield('content')
        </div>
    <?php if (Auth::check()) {?>
      </main>

      <!--
        Inclui um menu lateral à direita
        @ include('common.aside-menu')
      -->

    </div>
    <?php }?>
    @include('adminConfiguration::common.footer')

     <!-- Scripts Geral que Inclui os vários Scripts necessários-->
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript">
      function getParameterByName(name, url) {
        if (!url) url = window.location.href;
        name = name.replace(/[\[\]]/g, '\\$&');
        var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
            results = regex.exec(url);
        if (!results) return null;
        if (!results[2]) return '';
        return decodeURIComponent(results[2].replace(/\+/g, ' '));
      }

      function addButtonBreadcrumb(name, text, icon){
        $("ol.breadcrumb").append('<li class="breadcrumb-item"><button id="'+name+'" class="btn btn-success" type="button"><i class="'+icon+' icons"></i>&nbsp;'+text+'</button></li>');
      }

    function codeAddress() {
        if (getParameterByName("msgInfo")!=null){
          $('#infoText').text(getParameterByName("msgInfo"));
          $('#infoModal').modal('show');       
        }    
        if (getParameterByName("msgError")!=null){
          $('#dangerText').text(getParameterByName("msgError"));
          $('#dangerModal').modal('show');       
        }     
    }
    
    window.onload = codeAddress;
    </script>

  </body>

  @yield('afterBodyScripts')
  @include('adminConfiguration::common.conf-datatables')
  
</html>