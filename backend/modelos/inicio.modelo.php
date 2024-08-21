<?php

require_once "conexion.php";

class ModeloInicio{

	/*=============================================
	Sumar Ventas
	=============================================*/

	static public function mdlAnaliticas(){

		try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("CALL GetTotals()");
    
            $stmt->execute();
    
            // Usa fetchAll() para obtener todas las filas
            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
    
            $stmt->closeCursor();
            $stmt = null;
    
            return $resultado;
    
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
            return false;
        }

	}

	static public function mdlPromedioAula(){

		try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("CALL GetAnaliticas()");
    
            $stmt->execute();
    
            // Usa fetchAll() para obtener todas las filas
            $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
            $stmt->closeCursor();
            $stmt = null;
    
            return $resultado;
    
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
            return false;
        }

	}

	static public function mdlTopAlumnos(){

		try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("CALL TopAlumnos()");
    
            $stmt->execute();
    
            // Usa fetchAll() para obtener todas las filas
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