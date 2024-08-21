<?php

require_once "conexion.php";

class ModeloAlumnos{

    /*=============================================
	Mostrar alumnos
	=============================================*/
	static public function mdlMostrarAlumnos($id){

		if($id != null){

			$stmt = Conexion::conectar()->prepare("CALL getAlumnosProfesor(:id)");

			$stmt->bindParam(":id", $id, PDO::PARAM_INT);

			$stmt->execute();

			$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

			return $resultado;


		}else{

			$stmt = Conexion::conectar()->prepare("CALL getAlumnos(NULL)");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	Mostrar alumnos
	=============================================*/
	static public function mdlMostrarAlumno($id){

		$stmt = Conexion::conectar()->prepare("CALL getAlumnos(:id)");

		$stmt->bindParam(":id", $id, PDO::PARAM_INT);

		$stmt->execute();

		$resultado = $stmt->fetch(PDO::FETCH_ASSOC);

		return $resultado;

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	Registro Alumnos
	=============================================*/

	static public function mdlRegistroAlumnos($datos){

		try {
			$stmt = Conexion::conectar()->prepare("CALL crearNuevoAlumno(:nombre, :apellidos, :numero_orden, :password, :img, :aula)");
	
			$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
			$stmt->bindParam(":numero_orden", $datos["numero_orden"], PDO::PARAM_STR);
			$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
			$stmt->bindParam(":img", $datos["img"], PDO::PARAM_STR);
			$stmt->bindParam(":aula", $datos["aula"], PDO::PARAM_STR);
	
			if($stmt->execute()){
				return "ok";
			} else {
				echo "\nPDO::errorInfo():\n";
				print_r($stmt->errorInfo());
			}
	
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	
		$stmt->close();
		$stmt = null;
	
	}

	/*=============================================
	Editar alumno
	=============================================*/

	static public function mdlEditarAlumno($datos){

		try {
			$stmt = Conexion::conectar()->prepare("CALL editarAlumno(:id, :nombre, :apellidos, :numero_orden, :password)");
	
			$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
			$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
			$stmt->bindParam(":numero_orden", $datos["numero_orden"], PDO::PARAM_STR);
			$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
	
			if($stmt->execute()){
				return "ok";
			} else {
				echo "\nPDO::errorInfo():\n";
				print_r($stmt->errorInfo());
			}
	
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	
		$stmt->close();
		$stmt = null;
	}
	

	/*=============================================
	Eliminar Alumno
	=============================================*/

	static public function mdlEliminarAlumno($tabla, $id){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE id = :id");

		$stmt -> bindParam(":id", $id, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	// TRAER JUEGOS
	static public function mdlObtenerJuegos(){

		$stmt = Conexion::conectar()->prepare("SELECT id, nombre, tema, img FROM juegos");
	
		if($stmt -> execute()){
	
			return $stmt -> fetchAll();
		
		}else{
	
			echo "\nPDO::errorInfo():\n";
			print_r(Conexion::conectar()->errorInfo());
	
		}
	
		$stmt -> close();
	
		$stmt = null;
	
	}

	static public function mdlAgregarPartida($datos){

		try {
			$stmt = Conexion::conectar()->prepare("CALL InsertarPartida(:idAlumno, :idJuego, :puntaje, :mmr)");
	
			$stmt->bindParam(":idAlumno", $datos["alumnoId"], PDO::PARAM_INT);
			$stmt->bindParam(":idJuego", $datos["registroJuego"], PDO::PARAM_INT);
			$stmt->bindParam(":puntaje", $datos["registroPuntaje"], PDO::PARAM_INT);
			$stmt->bindParam(":mmr", $datos["mmr"], PDO::PARAM_INT);
	
			if($stmt->execute()){
				return "ok";
			} else {
				echo "\nPDO::errorInfo():\n";
				print_r($stmt->errorInfo());
			}
	
		} catch (PDOException $e) {
			echo "Error: " . $e->getMessage();
		}
	
		$stmt->close();
		$stmt = null;
	}
	

}