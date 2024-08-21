<?php

require_once "conexion.php";

class ModeloPartida{

    static public function mdlInsertarPartida($idAlumno, $idJuego, $puntajeJuego, $mmr_cambio) {

        try {
            $conexion = Conexion::conectar();
            
            $stmt = $conexion->prepare("CALL InsertarPartida(:idAlumno, :idJuego,:puntajeJuego, :mmr_cambio)");
    
            $stmt->bindParam(":idAlumno", $idAlumno, PDO::PARAM_INT);
            $stmt->bindParam(":idJuego", $idJuego, PDO::PARAM_STR);
            $stmt->bindParam(":puntajeJuego", $puntajeJuego, PDO::PARAM_INT);
            $stmt->bindParam(":mmr_cambio", $mmr_cambio, PDO::PARAM_STR);
    
            $stmt->execute();
    
            $stmt->closeCursor();
            $stmt = null;
    
            return true;
    
        } catch (PDOException $e) {
            echo "Error en la conexión: " . $e->getMessage();
            return false;
        }

    }
	
}