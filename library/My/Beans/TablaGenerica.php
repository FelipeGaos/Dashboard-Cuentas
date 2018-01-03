<?php
class My_Beans_TablaGenerica {
	private $status;
	private $lista = array ();
	private $filas;
	private $columnas = array ();
	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getLista() {
		return $this->lista;
	}
	public function setLista($lista) {
		$this->lista = $lista;
		return $this;
	}
	public function addLista($item, $key = "") {
		if (is_string($item)) {
			$item = trim($item);
		}
		if (is_string($key) && $key != "") {
			$key = trim($key);
		}
		if (isset ( $key ) && ! empty ( $key )) {
			if (isset ( $this->lista ["$key"] )) {
				$this->lista ["$key"] .= "\n" . $item;
			} else {
				$this->lista ["$key"] = $item;
			}
		} else {
			$this->lista [] = $item;
		}
		$this->filas ++;
		return $this;
	}
	public function getFilas() {
		return $this->filas;
	}
	public function setFilas($filas) {
		$this->filas = $filas;
		return $this;
	}
	public function getColumnas() {
		return $this->columnas;
	}
	public function setColumnas($columnas) {
		$this->columnas = $columnas;
		return $this;
	}
}