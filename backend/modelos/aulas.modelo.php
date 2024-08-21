<?php

require_once "conexion.php";

class ModeloAulas{

	/*=============================================
	Mostrar Aulas
	=============================================*/
	static public function mdlMostrarAulas($id){

		if($id != null){

			$stmt = Conexion::conectar()->prepare("CALL getAulas(:id)");
	
			$stmt->bindParam(":id", $id, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("CALL getAulas(NULL)");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt-> close();

		$stmt = null;

	}

    static public function mdlObtenerProfesores(){
        $stmt = Conexion::conectar()->prepare("SELECT id, CONCAT(nombre, ' ', apellidos) AS nombre_completo FROM profesor WHERE estado = 1 AND cargo = 'Profesor'");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function mdlMostrarAulaProfesor($id_profesor) {
        $stmt = Conexion::conectar()->prepare("CALL getAulaProfesor(:id_profesor)");
        
        $stmt->bindParam(":id_profesor", $id_profesor, PDO::PARAM_INT);
        
        $stmt->execute();
        
        return $stmt->fetch();
    }

    /*=============================================
	Crear Aula
	=============================================*/
    static public function mdlCrearAula($nombre, $id_profesor){
        $stmt = Conexion::conectar()->prepare("INSERT INTO aula_anio (nombre, id_profesor, anio, activo) VALUES (:nombre, :id_profesor, YEAR(CURDATE()), 1)");
        
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":id_profesor", $id_profesor, PDO::PARAM_INT);
        
        if($stmt->execute()){
            return "ok";
        } else {
            return "error";
        }
        
        $stmt = null;
    }
    

	/*=============================================
	Editar aula
	=============================================*/

	static public function mdlEditarAula($nombre, $id_profesor, $idAula) {
        $stmt = Conexion::conectar()->prepare("UPDATE aula_anio SET nombre = :nombre, id_profesor = :id_profesor WHERE id = :idAula");
    
        $stmt->bindParam(":nombre", $nombre, PDO::PARAM_STR);
        $stmt->bindParam(":id_profesor", $id_profesor, PDO::PARAM_INT);
        $stmt->bindParam(":idAula", $idAula, PDO::PARAM_INT);
    
        if($stmt->execute()){
            return "ok";
        } else {
            return "error";
        }
    
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
	Eliminar aulas
	=============================================*/

	static public function mdlEliminarAula($idAula) {
        $stmt = Conexion::conectar()->prepare("DELETE FROM aula_anio WHERE id = :idAula");
    
        $stmt->bindParam(":idAula", $idAula, PDO::PARAM_INT);
    
        if($stmt->execute()){
            return "ok";
        } else {
            return "error";
        }
    
        $stmt = null;
    }

    /*=============================================
	Actualizar aula
	=============================================*/

	static public function mdlActualizarAula($tabla, $item1, $valor1, $item2, $valor2) {
        $stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :$item2 WHERE $item1 = :$item1");
    
        $stmt->bindParam(":$item1", $valor1, PDO::PARAM_INT);
        $stmt->bindParam(":$item2", $valor2, PDO::PARAM_INT);
    
        if($stmt->execute()){
            return "ok";
        } else {
            return "error";
        }
    
        $stmt = null;
    }
    
    

}