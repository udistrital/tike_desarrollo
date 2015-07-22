<?php
//inicio desde menus
    
   // echo "sesion ". reportico_session_name();


    if(isset($_REQUEST['informes']))
        {
            $proyecto=$_REQUEST['informes'];    	
            $pass=$_REQUEST['acceso']; 
            $_REQUEST['jump_to_language']='es_es';
            $_REQUEST['jump_to_menu_project']=$proyecto;
            $_REQUEST['project_password']=  $pass;
            $_REQUEST['clear_session']='yes';
            $_REQUEST['submit_menu_project']='Ejecutar';
            //var_dump($_REQUEST);
        }
    else{ $proyecto=$_REQUEST['project'];  }
          
    if($proyecto=='admin')
        {$_REQUEST['access_mode']='FULL';
         $_REQUEST['admin_password']=$_REQUEST['project_password'];
         $_REQUEST['login']='Acceder';
        }
    else{$_REQUEST['access_mode']='ONEPROJECT';}           
           

?>
