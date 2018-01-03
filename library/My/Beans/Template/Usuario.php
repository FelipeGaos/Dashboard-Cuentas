<?php

class My_Beans_Template_Usuario {

    // ATRIBUTOS
    // ============================
    private $username;
    private $clave;
    private $nombres;
    private $ape_paterno;
    private $ape_materno;
    private $email;
    private $movil;
    private $estado;
    private $fecha_ultimo_acceso;
    private $fecha_ultima_modificacion;
    private $area;
    private $area2;
    private $tipo_usuario;
    private $beanStatus;
    private $id;
    
    // METODOS
    // ============================
    public function getUsername() {
        return $this->username;
    }

    public function getClave() {
        return $this->clave;
    }

    public function getNombres() {
        return $this->nombres;
    }

    public function getApe_paterno() {
        return $this->ape_paterno;
    }

    public function getApe_materno() {
        return $this->ape_materno;
    }

    public function getEmail() {
        return $this->email;
    }

    public function getMovil() {
        return $this->movil;
    }

    public function getEstado() {
        return $this->estado;
    }

    public function getFecha_ultimo_acceso() {
        return $this->fecha_ultimo_acceso;
    }

    public function getFecha_ultima_modificacion() {
        return $this->fecha_ultima_modificacion;
    }

    public function getArea() {
        return $this->area;
    }

    public function getArea2() {
        return $this->area2;
    }

    public function getTipo_usuario() {
        return $this->tipo_usuario;
    }
    
    public function getBeanStatus() {
        return $this->beanStatus;
    }

    public function setUsername($username) {
        $this->username = $username;
    }
    public function setId($id) {
        $this->id = $id;
    }

    public function setClave($clave) {
        $this->clave = $clave;
    }

    public function setNombres($nombres) {
        $this->nombres = $nombres;
    }

    public function setApe_paterno($ape_paterno) {
        $this->ape_paterno = $ape_paterno;
    }

    public function setApe_materno($ape_materno) {
        $this->ape_materno = $ape_materno;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function setMovil($movil) {
        $this->movil = $movil;
    }

    public function setEstado($estado) {
        $this->estado = $estado;
    }

    public function setFecha_ultimo_acceso($fecha_ultimo_acceso) {
        $this->fecha_ultimo_acceso = $fecha_ultimo_acceso;
    }

    public function setFecha_ultima_modificacion($fecha_ultima_modificacion) {
        $this->fecha_ultima_modificacion = $fecha_ultima_modificacion;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setArea2($area2) {
        $this->area2 = $area2;
    }

    public function setTipo_usuario($tipo_usuario) {
        $this->tipo_usuario = $tipo_usuario;
    }
    
    public function setBeanStatus($beanStatus) {
        $this->beanStatus = $beanStatus;
    }
    
} // End Class
