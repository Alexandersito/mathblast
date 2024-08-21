<?php

require_once "conexion.php";

class ModeloChat{

	static public function mdlMostrarChat() {
        try {
            $conexion = Conexion::conectar();
            $stmt = $conexion->prepare("CALL ChatGlobal()");
    
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

    static public function mdlInsertarChat($idAlumno, $chatInput) {
        try {
            $conexion = Conexion::conectar();
            
            $stmt = $conexion->prepare("CALL InsertMensaje(:idAlumno, :chatInput)");
    
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":chatInput", $chatInput, PDO::PARAM_STR);
    
            $stmt->execute();
    
            // Obtener los detalles del mensaje insertado
            $result = $conexion->query("SELECT a.id, m.contenido, DATE_FORMAT(m.fecha, '%H:%i') as fecha, CONCAT(a.nombre, ' ', a.apellidos)as nombre, a.img FROM mensajes m JOIN alumno a ON m.id_alumno = a.id ORDER BY m.id DESC LIMIT 1;
            ");
            $mensaje = $result->fetch(PDO::FETCH_ASSOC);
    
            return $mensaje;
            
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
            return false;
        }
    }
	
}