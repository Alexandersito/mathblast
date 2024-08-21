<?php

require_once "conexion.php";

class ModeloAlumnos{

    /*=============================================
	MOSTRAR ALUMNO
	=============================================*/

	static public function mdlMostrarAlumno($tabla, $item, $valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

		$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

		$stmt -> execute();

		return $stmt -> fetch();

		$stmt-> close();

		$stmt = null;

	}

	static public function validarIngreso($numero_orden, $seccion){
		try {
			$conexion = Conexion::conectar();
			$stmt = $conexion->prepare("CALL ObtenerAlumnoActivoPorNumeroOrdenYSeccion(:numero_orden, :seccion)");
	
			$stmt->bindParam(":numero_orden", $numero_orden, PDO::PARAM_INT);
			$stmt->bindParam(":seccion", $seccion, PDO::PARAM_STR);
	
			$stmt->execute();
	
			$resultado = $stmt->fetch();
	
			$stmt->closeCursor();
			$stmt = null;
	
			return $resultado;
	
		} catch (PDOException $e) {
			echo "Error en la conexión: " . $e->getMessage();
			return false;
		}
	}

	static public function getAlumnoDetails($idAlumno){
		try {
			$conexion = Conexion::conectar();
			$stmt = $conexion->prepare("CALL GetAlumnoDetails(:idAlumno)");
	
			$stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
	
			$stmt->execute();
	
			$resultado = $stmt->fetch();
	
			$stmt->closeCursor();
			$stmt = null;
	
			return $resultado;
	
		} catch (PDOException $e) {
			echo "Error en la conexión: " . $e->getMessage();
			return false;
		}
	}

	static public function mdlMostrarMRR(){
		try {
			$conexion = Conexion::conectar();
			$stmt = $conexion->prepare("CALL GetAlumnosByMMR()");
	
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