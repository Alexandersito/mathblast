<?php

class ControladorJuegos
{
    // MOSTRAR JUEGOS
    public static function ctrMostrarJuegos()
    {

        $tabla = "juegos";

        $respuesta = ModeloJuegos::mdlMostrarJuegos($tabla);

        return $respuesta;

    }

    public static function ctrMostrarJuego($valor)
    {

        $tabla = "juegos";

        $respuesta = ModeloJuegos::mdlMostrarJuego($tabla,$valor);

        return $respuesta;

    }
}