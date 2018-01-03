<?php

class IndexController extends Zend_Controller_Action {

    // ATRIBUTOS:
    // ================================================
    private $client;
    protected $session;

    // METODOS:
    // ================================================

    public function init() {
        /* Initialize action controller here */
        //	My_Utils::log('init');
        $cookieName = "Zend_Auth_" . My_ConfigIni::get('cookie')->name;
        $this->session = new Zend_Session_Namespace($cookieName);
        $wsdl = My_ConfigIni::get('wsdl');
        My_Utils::log("WSDL: ". $wsdl);
        $this->client = new Zend_Soap_Client($wsdl, array('encoding' => 'UTF-8'));
        $this->view->session = $this->session;
    }

    public function preDispatch() {
        //My_Utils::log('preDispatch');
    }



    /**
     * Funcion principal de la aplicacion, despliega menu publico o dependiendo de los permisos de usuario
     * @return mixed
     */

    /*
    public function indexAction() {
        try {
            $this->_helper->layout->setLayout('layout');
            //$this->_helper->layout->disableLayout();
            if (isset($this->session->username->username)) {
                My_Utils::log("** Sesion Iniciada **");
                My_Utils::log("Usuario: " . print_r($this->session->username->username, 1));
                My_Utils::log("Segundos: " . My_ConfigIni::get('resources')->session->remember_me_seconds);
                $this->session->setExpirationSeconds(My_ConfigIni::get('resources')->session->remember_me_seconds);
            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }*/


    public function tareaAction() {
 My_Utils::log("Captura de datos");
        
        try {



            if (isset($this->session->username)) {
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender();

                $titulo = $this->_getParam('titulo');
                $descripcion = $this->_getParam('descripcion');
                 $prioridad = $this->_getParam('prioridad');
                $periodicidad = $this->_getParam('periodicidad');
                $fecha_inicio = $this->_getParam('fecha_inicio');
                $fecha_hasta = $this->_getParam('fecha_hasta');
                 $responsable = $this->_getParam('responsable');
            
                // Declaracion de variables:
                $status = My_Constantes::STATUS_ERROR;
                $menuObj = null;
                $arr_return = array();

                // Recibe los parametros del formulario de login
                $arr_parametros = $this->_getAllParams();
                if (!isset ($titulo)) {
                    My_Utils::log("** ERROR: Parametros NO recibidos **");
                } else {
                    // Valida que ambos parametros no vengan vacios
                    if ($titulo != "") {
                        // Limpiar datos antes de enviar a WS
                        $descripcion = $this->sanitizarDatosDeEntrada($descripcion);
                        // Envia variables a WS que coteja con la BD
                        $auth = $this->client->setTarea($titulo, $descripcion, $prioridad, $periodicidad, $fecha_inicio, $fecha_hasta, $responsable); 
                      //  My_Utils::log(print_r($auth, 1));
                    } else {
                        My_Utils::log("** Parametros vienen vacios **");
                    }
                }

                $arr_return["titulo"] = $titulo;
                $arr_return["descripcion"] = $descripcion;
                $arr_return["prioridad"] = $prioridad;
                $arr_return["periodicidad"] = $periodicidad;
                $arr_return["fecha_inicio"] = $fecha_inicio;
                $arr_return["fecha_hasta"] = $fecha_hasta;
                $arr_return["responsable"] = $responsable;
                $arr_return = $auth;
                //My_Utils::log("ARRAY RETORNO: \n" . print_r($arr_return, 1));

                echo json_encode($arr_return);

            }else {

                $this->_helper->layout->setLayout('loginlayout');
            }

            
        } catch (Exception $e) {
            $status = My_Constantes::STATUS_ERROR;
            My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
        }
    }
    

 public function indexAction() {
        try {
            if (isset($this->session->username)){
                    $this->_helper->layout->setLayout('layout');
                    $arr_parametros = $this->_getAllParams();
                    My_Utils::log("parametros: " . print_r($arr_parametros, 1));
            }else {
                    $this->_helper->layout->setLayout('loginlayout');
            }

           
           // $this->_helper->layout->disableLayout();
           
          // $suma= $this->client->sumar($this->_getParam('x'),$this->_getParam('y'));
            //$valor= $this->client->$this->_getParam('x');
          //  $this->view->id =$valor;
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }


    public function getTareaAction() {
        try {

            if (isset($this->session->username)){
                $this->_helper->layout->disableLayout();
                 $this->_helper->viewRenderer->setNoRender();
                $listaTareas = $this->client->getTarea();
                My_Utils::log(print_r($listaTareas,1));
                if ($listaTareas["estado"]=="OK") {
                    $i=0;
                    foreach ($listaTareas["data"] as $fila) {
                            $arr[$i]["title"]=$fila["nombre_tarea"];
                            $arr[$i]["start"]=$fila["fecha_inicio"];
                            $arr[$i]["end"]=$fila["fecha_hasta"];
                            $i++;
                            My_Utils::log(print_r($fila,1));
                        } 

                echo json_encode($arr);  
                }
            }else{
           
          }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }




    public function vistaAction () {
        try {
            //My_Utils::log($this->session->username);
             //$this->_helper->viewRenderer->setNoRender(true);
            if (isset($this->session->username)){
           //$this->_helper->layout->setLayout('vista');
            $this->_helper->layout->disableLayout();
            }else{
            $this->_helper->layout->setLayout('loginlayout');
            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

     public function tablaAction () {
        try {
            //My_Utils::log($this->session->username);
             //$this->_helper->viewRenderer->setNoRender(true);
            if (isset($this->session->username)){
           //$this->_helper->layout->setLayout('vista');
            $this->_helper->layout->disableLayout();
            }else{
            $this->_helper->layout->setLayout('loginlayout');
            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }
    public function calendarAction () {
        try {
            //My_Utils::log($this->session->username);
             //$this->_helper->viewRenderer->setNoRender(true);
            if (isset($this->session->username)){
           //$this->_helper->layout->setLayout('vista');
            $this->_helper->layout->disableLayout();
            $nombre_tarea = $this->client->ver_lista_tareas();
            $this->view->tareas = $nombre_tarea;
            My_Utils::log(print_r($nombre_tarea,1)); My_Utils::log('controlador');

            $nombre_usuario = $this->client->ver_lista_usuarios();
            $this->view->usuarios = $nombre_usuario;
            My_Utils::log(print_r($nombre_tarea,1)); My_Utils::log('controlador');

            $periodicidad = $this->client->ver_lista_per();
            $this->view->per = $periodicidad;
           
            }else{
            $this->_helper->layout->setLayout('loginlayout');
            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

    public function homeAction() {
        try {
            $this->_helper->viewRenderer->setNoRender(true);
            //My_Utils::log($this->session->username);
            if (isset($this->session->username)){
            $this->_helper->layout->setLayout('layout');
            }else{
            $this->_helper->layout->setLayout('loginlayout');
          }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

    public function administrarUsuariosAction() {
        try {

            My_Utils::log(print_r($this->session->username, 1));
            if (isset($this->session->username)){
                $this->_helper->layout->disableLayout();
            $listaUsuarios = $this->client->getUsuario();
            $this->view->usuarios = $listaUsuarios;
           // $this->render('administrar-usuarios');
            }else{
           // $this->_helper->layout->setLayout('administrar-usuarios');
          }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

   
    /**
     * Trae los items que formaran parte del Menu.
     */
    public function crearMenuAction() {
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender(true);
         try {
            My_Utils::log("Usuario MENU: " . print_r(@$this->session->username->username, 1));
        
    $return = array("statusController" => true, "menu" => null);

       
            // Si existe la sesion, se trae el menu para un usuario especifico, si no, se trae el menu publico
            if (isset($this->session->username->username))
                $return["menu"] = $this->client->getMenu($this->session->username->username);
            else
                $return["menu"] = $this->client->getMenu();
        } catch (Exception $e) {
            $return["statusController"] = false;
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        echo json_encode($return);
    }

    /**
     * Muestra pantalla de login
     */
    public function displayLoginFormAction() {
        try {
            $this->_helper->layout->disableLayout();




        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

 /**
     * Muestra pantalla de accesos de todos los trabajadores
     */
    public function verHorasTotalAction() {
        try {
            if (!isset($this->session->username)) {
                My_Utils::log("Sesion no valida");
                $this->view->mensaje = "Sesion expirada";
                $this->_helper->layout->setLayout('layout');
                $this->render('index');
                return;
            }
            else{
                
                
                $this->_helper->layout->setLayout('layout');
                $this->view->infoUsuarios=  $this->client->getTrabajadores($this->_getParam('fecha',date("Y-m")));
                $this->view->feriados = $this->client->getFestivos();
                $this->view->fecha = $this->_getParam('fecha',date("Y-m"));
                $this->view->usuario = $this->session->username;
            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }
    /**
     * Muestra pantalla de accesos de un trabajador en un mes
     */
    public function verHorasMensualAction() {
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }     
        else{
            
            try {

                    My_Utils::log("id " . $this->_getParam('id'));
                    My_Utils::log("fecha " . $this->_getParam('fecha'));
                    $this->_helper->layout->setLayout('layout');
                    $this->view->fecha = $this->_getParam('fecha',date("Y-m"));
                    $this->view->userSesion = $this->session->username;
                    $this->view->feriados = $this->client->getFestivos();

                    $this->view->infoHoraUsuarios = $this->client->getHorarioTrabajador($this->_getParam('id'), $this->view->fecha);

                    $this->view->horasActualTrabajador = $this->client->getHorasActual($this->_getParam('id'), date("Y-m"));
                    $this->view->horasMensuales=  $this->client->getTrabajadores(date("Y-m"));
                    
                    for ($i=0; $i < count($this->view->infoHoraUsuarios); $i++) { 
                        $arrHoras[$i] = $this->view->infoHoraUsuarios[$i]['id_reg'];
                    }

                    My_Utils::log("horas usuarios:  " . print_r($this->view->horasActualTrabajador,1));
                
            } catch (Exception $e) {
                My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
            }
        }
    }



    public function logEdicionesAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }
        else{
        
            $this->_helper->layout->disableLayout();
            $this->view->horas = $this->client->getHoras($this->_request->getPost('id'));
        }
    }



//controlador para modificar horas de ingreso o de salida
    public function logGuardarAction(){
        if (!isset($this->session->username)) {
                My_Utils::log("Sesion no valida");
                $this->view->mensaje = "Sesion expirada";
                $this->_helper->layout->setLayout('layout');
                $this->render('index');
                return;
        }
        else{
            try{
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
                //echo $this->_getParam('ingreso');
                //echo print_r($this->_getAllParams(),1);

                $arr_return = array(null,null);

                My_Utils::log("INGRESO :". $this->_getParam('ingreso'));
                My_Utils::log("INGRESO old :". $this->_getParam('ingreso_old'));
                My_Utils::log("SALIDA :". $this->_getParam('salida'));
                My_Utils::log("SALIDA old :". $this->_getParam('salida_old'));
                My_Utils::log("ID SESION: ". $this->session->username[0]['id']);

    //solo se modifica si se cambia una hora
                if ($this->_getParam('ingreso') != $this->_getParam('ingreso_old')) {
                    $arr_return[0] =  $this->client->setHoraIngreso($this->_getParam('id_mov'), $this->_getParam('ingreso'),$this->_getParam('ingreso_old'),$this->_getParam('comentario'),$this->_getParam('id_usuario'),$this->session->username[0]['id']);
                }

    //solo se modifica si se cambia un parametro o la salida está vacía

                if ($this->_getParam('salida') != $this->_getParam('salida_old') || $this->_getParam('vacio') == "") {
                    $arr_return[1] =  $this->client->setHoraSalida($this->_getParam('id_mov'), $this->_getParam('salida'),$this->_getParam('salida_old'),$this->_getParam('comentario'),$this->_getParam('id_usuario'),$this->session->username[0]['id']);
                }


                
                //My_Utils::log("ARRAY RETORNO: \n" . print_r($arr_return, 1));




                echo json_encode($arr_return);

                

            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
        }
    }


    /**
     * Autentica los usuarios
     */
    public function loginAction() {
        //echo "llegue";
 My_Utils::log("Valida Sesion");
        
        try {
            //$this->_helper->layout->setLayout('layout');

            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();

            $username = $this->_getParam('usuario');
            $clave = $this->_getParam('contraseña');
            // Declaracion de variables:
            $status = My_Constantes::STATUS_ERROR;
            $menuObj = null;

            //$username = $clave = "";
            $arr_return = array();

            // Recibe los parametros del formulario de login
            $arr_parametros = $this->_getAllParams();
            ////////////////////////////////////////////////////////////
            //Arreglar isset y cambiarlo por paso de parametros username y clave
            //////////////////////////////////////////////////////////////////
            // Si los parametros no vienen, se retorna el status
            if (!isset ($username) && !isset($clave)) {
                My_Utils::log("** ERROR: Parametros NO recibidos **");
            } else {
              //  $username = $arr_parametros["username"];
                //$clave = $arr_parametros["clave"];

                // Valida que ambos parametros no vengan vacios
                if ($username != "" && $clave != "") {

                    // Limpiar datos antes de enviar a WS
                    $username = $this->sanitizarDatosDeEntrada($username);
                    $clave = $this->sanitizarDatosDeEntrada($clave);

                    // Envia variables a WS que coteja con la BD


                    $auth = $this->client->getAuth($username, $clave);
                    
                    My_Utils::log(print_r($auth, 1));

                    // Si las credenciales son validas, se crea la sesion
                    if (count($auth) > 0 ) {
                        My_Utils::log("Crea la sesion");
                        $this->session->setExpirationSeconds(My_ConfigIni::get('resources')->session->remember_me_seconds);
                        $this->session->username = $auth;

                        // Trae los items del menu que le corresponden a un perfil de usuario determinado
                        if (isset($auth)) {
                            My_Utils::log("CREA VARIABLES DE SESION");
                            // Trae las herramientas publicas + las herramientas privadas a las cuales tiene permisos el usuario
                            //$menuObj["menu"] = $this->client->getMenu($auth->username);
                            //My_Utils::log(print_r($menuObj, 1));

                            //if ($menuObj["menu"]->status === My_Constantes::STATUS_OK) {
                                //$this->session->menu = $menuObj["menu"]->lista;
                                //My_Utils::log("VARIABLES DE SESION: \n" . print_r($this->session->username->username, 1));
                            //}
                            $status = "OK";
                        }
                    } else {
                        // Si el login falla, se destruyen las sesiones que esten activas
                        Zend_Session::namespaceUnset('Zend_Auth');
                        $this->session->unsetAll();
                    }
                } else {
                    My_Utils::log("** Parametros vienen vacios **");
                }
            }

            $arr_return["estado"] = $status;
            $arr_return["username"] = $username;
            My_Utils::log("ARRAY RETORNO: \n" . print_r($arr_return, 1));

            echo json_encode($arr_return);
        } catch (Exception $e) {
            $status = My_Constantes::STATUS_ERROR;
            My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
        }
    }

    /**
     * Implementa reglas de seguridad para datos de formulario
     * @return string
     */
    public function sanitizarDatosDeEntrada($data) {
        try {
            $data = trim($data); // Quita cualquier cosa del inicio y final de la cadena
            $data = stripslashes($data); // Escapa caracteres
            $data = htmlspecialchars($data); // convierte caracteres especiales a formato HTML

            return $data;
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
        }
    }

    public function logoutAction() {
        try {

            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            //$this->_helper->layout->setLayout('layout');

            if (isset($this->session->username)) {
                $cookieName = "Zend_Auth_" . My_ConfigIni::get('cookie')->name;
                Zend_Session::namespaceUnset($cookieName);
                $this->session->unsetAll();
                My_Utils::log('** Destroy Session **');
            }
            My_Utils::log('** Logout **');


            return $this->_helper->redirector('index', 'index'); // action, controller
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

    public function nuevaClaveAction() {
        $status = "";
        try {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $username = $this->_getParam("username");
            $status = $this->client->getClave($username);
        } catch (Exception $e) {
            $status = My_Constantes::STATUS_ERROR;
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        echo $status;
    }

    public function cambiarClaveAction() {
        $status = My_Constantes::STATUS_ERROR;
        try {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $clave_actual = $this->_getParam("clave_actual");
            $clave_nueva = $this->_getParam("clave_nueva");
            $clave_nueva2 = $this->_getParam("clave_nueva2");

            if (!isset($this->session->username)) {
                $status = My_Constantes::$STATUS_DESC[My_Constantes::STATUS_SESION_EXPIRADA];
            } else {
                $username = $this->session->username->username;
                My_Utils::log("username: $username, clave_actual: $clave_actual, clave_nueva: $clave_nueva, clave_nueva2: $clave_nueva2");
                $status = $this->client->setNuevaClave($username, $clave_actual, $clave_nueva, $clave_nueva2);
            }
        } catch (Exception $e) {
            $status = My_Constantes::STATUS_ERROR;
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        echo $status;
    }

    public function sesionAction() {
        try {
            if (!isset($this->session->username)) {
                My_Utils::log("Sesion no valida");
                $this->view->mensaje = "Sesion expirada";
                $this->_helper->layout->setLayout('layout');
                $this->render('index');
                return;
            }else{
                $this->_helper->layout->setLayout('layout');
                $this->view->ingresosHoy = $this->client->getHorasHoy(date("Y-m-d"));
            }

        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }
    

    public function diasFestivosAction(){

        try{
            if (!isset($this->session->username)) {
                My_Utils::log("Sesion no valida");
                $this->view->mensaje = "Sesion expirada";
                $this->_helper->layout->setLayout('layout');
                $this->render('index');
                return;
            }else{
                $this->_helper->layout->setLayout('layout');
                $this->view->festivos = $this->client->getFestivos();
            }

        }catch (Exception $e){
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

    public function modalFestivosAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else
            $this->_helper->layout->disableLayout();
    }

    public function festivosGuardarAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();


            $respuesta = array();
            $datos = $this->_getAllParams();

            $response = $this->client->setFestivos($datos['fecha'],$datos['descripcion']);
            $respuesta['estado']=$response;
            if ($response == 'No') {
                $respuesta['mensaje']=("Fecha ya se encuentra registrada");
            }
            else
                $respuesta['mensaje']=("Nueva fecha creada");

            echo json_encode($respuesta);
        }
    }


    public function eliminarFestivoAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{    
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            

            $respuesta = array();
            $fecha = $this->_getParam('fecha');        

            $response = $this->client->borrarFestivo($fecha);

            $respuesta['estado'] = $response;

            if ($response == "OK") {
                $respuesta['mensaje'] = "Se ha eliminado el dia festivo";
            }
            else
                $respuesta['mensaje'] = "Se ha producido un error";

            $periodo = explode("-", $fecha);
            $this->view->periodo = $periodo[0]."-".$periodo[1];


            My_Utils::log("FESTIVO BORRADO:  ".$response);

            echo json_encode($respuesta);

        }
    }

    public function cuentasAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->setLayout('layout');
            $this->view->usuarios = $this->client->getUsuarios();
        }
    }

    public function modalDetalleCuentasAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{

            $this->_helper->layout->disableLayout();

            $this->view->trabajador = $this->_getAllParams();
     
            
            My_Utils::log("NOMBRE TRABAJADOR: ". print_r($this->view->trabajador,1));
        }
    }

    public function modalAgregarUsuarioAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
        }
    }

    public function guardarUsuarioAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            try{

                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
                $nombre = $this->_getParam('nombre');
                $correo = $this->_getParam('correo');
                $rut = $this->_getParam('rut');
                $cargo = $this->_getParam('cargo');
                $horas = $this->_getParam('horas');

                $response = $this->client->setNuevoUsuario($nombre, $correo, $rut, $cargo, $horas);

                My_Utils::log("response  _>".$response);

                $respuesta=array();
                $respuesta['estado']=$response;
                if ($response == 'NOK') {
                    $respuesta['mensaje']= "Se ha producido un error";
                }
                else if($response == 'NO')
                    $respuesta['mensaje']= "Trabajador ya se encuentra registrado";
                else{
                    $respuesta['mensaje']= "Nuevo trabajador registrado";
                }
echo json_encode($respuesta);
            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }

        }
    }
/*
    function eliminarUsuarioAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{    
            try{
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
                
                $respuesta = array();
                $id_usuario = $this->_getParam('id');
                My_Utils::log($id_usuario);
                $response = $this->client->eliminarUsuario($id_usuario);

                $respuesta['estado'] = $response;
                if ($response == 'NOK') {
                    $respuesta['mensaje']= "No se ha podido eliminar el trabajador";
                }
                else{
                    $respuesta['mensaje']= "Trabajador eliminado";
                }

                echo json_encode($respuesta);


            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }

            
        }

    }*/

    function modalEditarUsuarioAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
            $this->view->usuario = $this->client->getUsuarioSeleccionado($this->_request->getPost('id'));
        }
    }

    function editarUsuarioAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{

            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);




            try {

                $id = $this->_getParam('id');
                $nombre = $this->_getParam('nombre');
                $correo = $this->_getParam('correo');
                $rut = $this->_getParam('rut');
                $cargo = $this->_getParam('cargo');
                $horas = $this->_getParam('horas');

                $response = $this->client->updateUsuario($id, $nombre, $correo, $rut, $cargo, $horas);

            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
            $respuesta=array();
            $respuesta['estado']=$response;
                if ($response == 'NOK') {
                    $respuesta['mensaje']= "Error Detectado";
                }
                else if ($response == 'NO') {
                    $respuesta['mensaje']= "El trabajador ya se encuentra registrado";
                }
                else{
                    $respuesta['mensaje']= "Trabajador editado con exito";
                }
echo json_encode($respuesta);
            
        }
    }


    function cuentasAdminAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->setLayout('layout');
            $this->view->usuarios = $this->client->getAdmins();
            $this->view->sesion = $this->session->username;
        }

    }

    function modalAgregarAdminAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
            $trabajadores = $this->client->getUsuarios();
        }
    }

    function guardarAdminAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{

            try{


                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);


                $respuesta = array();
                My_Utils::log("NUEVVVVVVOOOOOOO amdonod");
                $nombre = $this->_getParam('nombre');
                $nombre_usuario = $this->_getParam('nombre_usuario');
                $pass = $this->_getParam('pass');
                $correo = $this->_getParam('correo');

                $response = $this->client->setNuevoAdmin($nombre, $nombre_usuario, $pass, $correo);
                $respuesta['estado'] = $response;
                
                My_Utils::log($response);
                
                if ($response == "USUARIO") {
                    $respuesta['mensaje'] = ("Usuario ya se encuentra registrado");
                }
                else if ($response == "CORREO"){
                    $respuesta['mensaje'] = "Correo ingresado ya se encuentra registrado";
                }
                else if ($response == "OK"){
                    $respuesta['mensaje'] = ("Usuario guardado");
                }
                else
                    $respuesta['mensaje'] = "Se ha producido un error";

                echo json_encode($respuesta);

            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }

        }

    }

    function eliminarAdminAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            try{
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);
                
                $respuesta = array();
                
                $id_usuario = $this->_getParam('id');
                My_Utils::log($id_usuario);
                
                $response = $this->client->eliminarAdmin($id_usuario);

                $respuesta['estado'] = $response;

                if($response == "NO"){
                    $respuesta['mensaje'] = "No se ha podido eliminar usuario";
                }
                else
                    $respuesta['mensaje'] = "Se ha eliminado usuario exitosamente";

                echo json_encode($respuesta);
            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }

          
        }
    }

    function modalEditarAdminAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
            $this->view->usuario = $this->client->getAdminSeleccionado($this->_request->getPost('id'));
        }
    }

    function editarAdminAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            try {
                $respuesta = array();
                $id = $this->_getParam('id');


                $nombre = $this->_getParam('nombre');
                $nombre_old = $this->_getParam('nombre_old');
                $correo = $this->_getParam('correo');
                $correo_old = $this->_getParam('correo_old');
                $usuario = $this->_getParam('usuario');
                $usuario_old = $this->_getParam('usuario_old');
                $pass = $this->_getParam('pass'); 
                $pass_old = $this->_getParam('pass_old');
              
                $response = $this->client->updateAdmin($id,$nombre,$nombre_old,$correo,$correo_old,$usuario,$usuario_old,$pass,$pass_old);

                $respuesta['estado'] = $response; 

                if ($response == "OK") 
                    $respuesta['mensaje'] = "Se han guardado los cambios";
                else if ($response == "CORREO")
                    $respuesta['mensaje'] = "El correo ya esta regstrado";
                else if($response == "USUARIO")
                    $respuesta['mensaje'] = "El nombre de usuario ya esta registrado";
                else
                    $response['mensaje'] = "Se ha producido un error";
                

                echo json_encode($respuesta);

            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
            
        }
    }

    function imprimirHojaAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
    $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return; 
        }else{
            $this->_helper->layout->disableLayout();
            $this->view->fecha = $this->_getParam('fecha',date("Y-m"));
            $this->view->infoHoraUsuarios = $this->client->getHorarioTrabajador($this->_getParam('id'), $this->view->fecha);
        }
    }
 
    
    function modalUbicacionesAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();

            $this->view->xin = $this->_getParam('xin');
            $this->view->yin = $this->_getParam('yin');
            $this->view->xout = $this->_getParam('xout');
            $this->view->yout = $this->_getParam('yout');
        }
    }

    function modalComentarioAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            try{
                $this->_helper->layout->disableLayout();

                $id = $this->_getParam('id');

                $this->view->hora = $this->client->getHoraLog($id);
            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
        }
        
    }


    function dependenciasAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            try{
                $this->_helper->layout->setLayout('layout');
                $this->view->dependencias = $this->client->getDependencias(); 
                
            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
        }
    }

    function modalVerAreaAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();

            $this->view->poligono = $this->_getParam('area');
            $this->view->id = $this->_getParam('id');
            $this->view->det = $this->_getParam('detalle');
        }
    }


    function editarDependenciaAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            try {
                $respuesta = array();
                $id = $this->_getParam('id');


                $descripcion = $this->_getParam('descripcion');
                $descripcion_old = $this->_getParam('descripcion_old');
                $coord = $this->_getParam('coord');
                $coord_old = $this->_getParam('coord_old');

              

                $response = $this->client->updateArea($id,$descripcion,$descripcion_old,$coord,$coord_old);



                $respuesta['estado'] = $response;
                if ($response == "OK") 
                    $respuesta['mensaje'] = "Se ha modificado el area seleccionada";
                
                else if ($response == "NO")
                    $respuesta['mensaje'] = "Ya se encuentra un area con esa descripcion";
                
                else $respuesta['mensaje'] = "Se ha producido un error al modificar el area";

                echo json_encode($respuesta);

                My_Utils::log("MENSAJEEEE : ".$respuesta['mensaje']);
                My_Utils::log("RESPUESTA: " .$response);


            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
            
        }
    }

    function modalNuevaAreaAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            try {
                $this->_helper->layout->disableLayout();

                            
            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
        }
    } 


    function crearNuevaAreaAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            try{

                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);


                $respuesta = array();
                My_Utils::log("NUEVVVVVVOAAAAA areaaa");
                $desc = $this->_getParam('desc');
                $area = $this->_getParam('area');
               

                $response = $this->client->setNuevaArea($desc, $area);

                $respuesta['estado'] = $response;

                My_Utils::log($response);
                
                if ($response == "NO") {
                    $respuesta['mensaje'] = "Ya se encuentra un area con esa descripcion";
                }
                else if ($response == "OK"){
                    $respuesta['mensaje'] = "Area creada exitosamente";
                }else{
                    $respuesta['mensaje'] = "Se ha producido un error";
                }

                echo json_encode($respuesta);

            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
        }
    }

    function eliminarAreaAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
            $this->render('index');
            return;
        }else{
            try{

                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender(true);



                $respuesta = array();
                My_Utils::log("ELIMINANDO areaaa");
                $id = $this->_getParam('id');
               
               

                $response = $this->client->eliminarArea($id);
                $respuesta['estado'] = $response;

                if ($response == 'OK') {
                    $respuesta['mensaje'] = "Se ha eliminado el area seleccionada con exito";
                }
                else{
                    $respuesta['mensaje'] = "Se ha producido un error al eliminar el area";
                }
                My_Utils::log($response);
                
                echo json_encode($respuesta);
            } catch (Exception $e) {
                $status = My_Constantes::STATUS_ERROR;
                My_Utils::log($e->getMessage(), true, Zend_Log::ERR);
                My_Utils::log($e->getTraceAsString(), true, Zend_Log::ERR);
            }
        }
    }   

    function borrarUuidAction(){
        if (!isset($this->session->username)) {
            My_Utils::log("Sesion no valida");
            $this->view->mensaje = "Sesion expirada";
            $this->_helper->layout->setLayout('layout');
        $this->render('index');
            return;
        }else{
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);
            $id = $this->_getParam('id');
            My_Utils::log("ID TRABAJADOR: " . $id);
            $this->client->borrarUUID($id);
        }
    }


/**
     * Muestra pantalla de login
     */
    public function tabla1Action() {
        try {
            $this->_helper->layout->disableLayout();
            



        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }

    function validaSesionAction(){
      // My_Utils::log("Valida Sesion");
        //    $this->_helper->layout->disableLayout();
          //  $this->_helper->viewRenderer->setNoRender(true);
            //$user = $this->_getParam('usuario');
            //$pass = $this->_getParam('contraseña');

            //if($user=="kevin"&& $pass=="kevin"){

              //  $resultado['estado']="OK";
            //}else{

              //  $resultado['estado']="NOK";
            //}
        


          //echo json_encode($resultado);
    }

/*    public function administrarUsuariosAction() {

        try {
            $this->_helper->layout->setLayout('loginLayout');

            if (!isset($this->session->username)) {
                $this->view->mensaje = "Sesion expirada";
                $this->render('index');
            }


            $listaUsuarios = $this->client->getUsuario();
            $this->view->usuarios = $listaUsuarios;
            

        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
    }*/

    /**
     * Listar usuarios para realizar CRUD.
     */
    public function datosModalAction() {
        try {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $user = $this->_getParam("user");

            // Control de sesion.
            if (!isset($this->session->username)) {
                $this->view->mensaje = "Sesion expirada";
                $this->render('index');
            } else {
            
            $arrReturn = $this->client->getUsuario($user);

            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        echo json_encode($arrReturn);
    }


    /**
     * Listar usuarios para realizar CRUD.
     */
    public function eliminarUsuarioAction() {
        try {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $user = $this->_getParam("user");

            // Control de sesion.
            if (!isset($this->session->username)) {
                $this->view->mensaje = "Sesion expirada";
                $this->render('index');
            } else {
            
            $arrReturn = $this->client->desactivaUsuario($user);

            }
        } catch (Exception $e) {
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        echo json_encode($arrReturn);
    }

    /**
     * Guarda los datos del usuario especifico.
     */
    public function setDatosUsuarioAction() {
        try {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender(true);

            $return = array(
              "statusController" => true
            );

            $user = $this->_getParam("username");
            $nombres = $this->_getParam("nombres");
            $ape_paterno = $this->_getParam("ape_paterno");
            $ape_materno = $this->_getParam("ape_materno");
            $clave = $this->_getParam("clave");
            $e_mail = $this->_getParam("e_mail");
            $movil = $this->_getParam("movil");
            $estado = $this->_getParam("estado");
        //   $estado = ($estado == "1") ? 1 : 0;

            if (isset($user)) {
                My_Utils::log("Datos: $user, $nombres, $ape_paterno, $ape_materno, $clave, $e_mail, $movil, $estado");
                $return["statusController"] = $this->client->setUsuario($user, $nombres, $ape_paterno, $ape_materno, $clave, $e_mail, $movil, $estado);

            } else {
                $return["statusController"] = false;
            }
        } catch (Exception $e) {
            $return["statusController"] = false;
            My_Utils::log($e->getMessage(), false, Zend_Log::ERR);
            My_Utils::log($e->getTraceAsString(), false, Zend_Log::ERR);
        }
        echo json_encode($return);
    }
    


}//  End Class