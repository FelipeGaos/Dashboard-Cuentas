<?php

class My_Beans_Template_Menu {
    // ATRIBUTOS
    // ================================
    private $id_herramienta; 
    private $nombre_herramienta; 
    private $url; 
    private $item_padre; 
    private $orden; 
    private $target; 
    private $nombre_proyecto;
    private $icono_proyecto;
    
    // METODOS
    // ================================
    public function getId_herramienta() {
        return $this->id_herramienta;
    }

    public function getNombre_herramienta() {
        return $this->nombre_herramienta;
    }

    public function getUrl() {
        return $this->url;
    }

    public function getItem_padre() {
        return $this->item_padre;
    }

    public function getOrden() {
        return $this->orden;
    }

    public function getTarget() {
        return $this->target;
    }

    public function getNombre_proyecto() {
        return $this->nombre_proyecto;
    }

    public function getIcono_proyecto() {
        return $this->icono_proyecto;
    }

    public function setId_herramienta($id_herramienta) {
        $this->id_herramienta = $id_herramienta;
    }

    public function setNombre_herramienta($nombre_herramienta) {
        $this->nombre_herramienta = $nombre_herramienta;
    }

    public function setUrl($url) {
        $this->url = $url;
    }

    public function setItem_padre($item_padre) {
        $this->item_padre = $item_padre;
    }

    public function setOrden($orden) {
        $this->orden = $orden;
    }

    public function setTarget($target) {
        $this->target = $target;
    }

    public function setNombre_proyecto($nombre_proyecto) {
        $this->nombre_proyecto = $nombre_proyecto;
    }

    public function setIcono_proyecto($icono_proyecto) {
        $this->icono_proyecto = $icono_proyecto;
    }
}
