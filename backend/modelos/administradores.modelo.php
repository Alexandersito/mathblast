<?php

require_once "conexion.php";

class ModeloAdministradores{

	/*=============================================
	Mostrar Administradores
	=============================================*/
	static public function mdlMostrarAdministradores($tabla, $item, $valor){

		if($item != null && $valor != null){

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt->bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt-> close();

		$stmt = null;

	}

	/*=============================================
	Registro administradores
	=============================================*/

	static public function mdlRegistroAdministradores($datos){

		try {
			$stmt = Conexion::conectar()->prepare("CALL crearNuevoAdministrador(:dni, :nombre, :apellidos, :usuario, :password, :cargo)");
	
			$stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
			$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
			$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
			$stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
	
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
	Editar Administrador
	=============================================*/

	static public function mdlEditarAdministrador($datos){

		try {
			$stmt = Conexion::conectar()->prepare("CALL editarAdministrador(:id, :dni, :nombre, :apellidos, :usuario, :password, :cargo)");
	
			$stmt->bindParam(":id", $datos["id"], PDO::PARAM_INT);
			$stmt->bindParam(":dni", $datos["dni"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre", $datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":apellidos", $datos["apellidos"], PDO::PARAM_STR);
			$stmt->bindParam(":usuario", $datos["usuario"], PDO::PARAM_STR);
			$stmt->bindParam(":password", $datos["password"], PDO::PARAM_STR);
			$stmt->bindParam(":cargo", $datos["cargo"], PDO::PARAM_STR);
	
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
	Actualizar administrador
	=============================================*/

	static public function mdlActualizarAdministrador($tabla, $item1, $valor1, $item2, $valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :$item2 WHERE $item1 = :$item1");

		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			echo "\nPDO::errorInfo():\n";
    		print_r(Conexion::conectar()->errorInfo());

		}

		$stmt -> close();

		$stmt = null;

	}

	/*=============================================
	Eliminar Administrador
	=============================================*/

	static public function mdlEliminarAdministrador($tabla, $id){

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

}