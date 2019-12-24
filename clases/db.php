<?php

abstract class DB {
  public abstract function crearUsuario(Usuario $usuario);
  public abstract function getUsers();
  public abstract function buscarPorID($id);
  public abstract function searchByEmail($email);

  public function existeElUsuario($email) {
    if ($this->traerUsuarioPorEmail($email) === null) {
      return false;
    } else {
      return true;
    }
  }
}

?>
