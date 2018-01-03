<?php

class My_Beans_Template_Proyecto {
    // ATRIBUTOS
    // ====================================
    private $id_proyecto;
    private $nombre;
    private $area;
    private $url;
    private $icono;

    // METODOS
    // ====================================
    public function getId_proyecto() {
        return $this->id_proyecto;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function getArea() {
        return $this->area;
    }

    public function getUrl() {
        return $this->url;
    }
    
    public function getIcono() {
        return $this->icono;
    }

    public function setId_proyecto($id_proyecto) {
        $this->id_proyecto = $id_proyecto;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
    }

    public function setArea($area) {
        $this->area = $area;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setIcono($icono) {
        $this->icono = $icono;
    }
    
} // End Class
