<?php

require_once "conexion.php";

class ModeloJuegos
{
    public static function mdlMostrarJuegos($tabla)
    {

        $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

        $stmt->execute();

        return $stmt->fetchAll();

        $stmt = null;

    }

    public static function mdlMostrarJuego($tabla,$valor)
    {
        if (is_numeric($valor)) {
            
            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE id = :id");

            $stmt -> bindParam(":id", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();

            $stmt -> close();

            $stmt = null;
            
        }else{

            $stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE nombre = :nombre");

            $stmt -> bindParam(":nombre", $valor, PDO::PARAM_STR);

            $stmt->execute();

            return $stmt->fetch();

            $stmt -> close();

            $stmt = null;

        }
    }

    static public function mdlTraerEstadisticas($idAlumno){
		try {
            $conexion = Conexion::conectar();
			$stmt = $conexion->prepare("CALL ObtenerInfoPartidasPorAlumno(:idAlumno)");
	
			$stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
	
			$stmt->execute();
	
			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
	
			$stmt->closeCursor();
			$stmt = null;
	
			return $resultado;
	
		} catch (PDOException $e) {
			echo "Error en la conexión: " . $e->getMessage();
			return false;
		}
	}

}