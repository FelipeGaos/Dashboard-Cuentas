<?php
class My_Beans_ListaGenerica {
	private $status;
	private $cont_lista;
	private $lista = array();

	public function getStatus() {
		return $this->status;
	}
	public function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	public function getContLista() {
		return $this->cont_lista;
	}
	public function setContLista($cont_lista) {
		$this->cont_lista = $cont_lista;
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
			if (isset($this->lista ["$key"])) {
				$this->lista ["$key"] .= "\n" .$item;
			}
			else {
				$this->lista ["$key"] = $item;
			}	
		} else {
			$this->lista [] = $item;
		}
		$this->cont_lista++;
		return $this;
	}
}