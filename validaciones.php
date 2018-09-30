<?php
function validarNombre()
{
    if (strlen($_POST["nombre"])>0) {
        return true;
    } else {
        return false;
    }
}

function validarUsername()
{
    if (strlen($_POST["username"])>=5) {
        return true;
    } else {
        return false;
    }
}

function validarEdad()
{
    if (is_integer($_POST["edad"]) && $_POST["edad"]>=18) {
        return true;
    } else {
        return false;
    }
}

function validarEmail()
{
    if (strlen($_POST["email"])==0) {
        return "El campo esta vacio";
    } elseif (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        return "El campo no es un email";
    } else {
        return "";
    }
}

function validarPass()
{
    if (strlen($_POST["contraseña"])==0 && strlen($_POST["confirmacion"])==0) {
        return "Los dos campos de contraseña estan vacios";
    }
    if (strlen($_POST["contraseña"])==0) {
        return "La contraseña esta vacia";
    }
    if (strlen($_POST["confirmacion"])==0) {
        return "Falta la confirmacion de contraseña";
    }
    if ($_POST["contraseña"]!= $_POST["confirmacion"]) {
        return "Las contraseñas no verifican";
    } else return "";
}

?>
