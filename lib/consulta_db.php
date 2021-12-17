<?php
    require_once('connecta_db_persistent.php');
    try{
        $sql = 'SELECT * FROM `users`';
        $usuaris = $db->query($sql);
        if($usuaris){
            echo '<table>';
            foreach ($usuaris as $fila) {
                echo '<tr>';
                echo '<td>' . $fila['username'] . '</td>';
                echo '<td>' . $fila['userFirstName'] . '</td>';
                echo '<td>' . $fila['userLastName'] . '</td>';
                echo '<td>' . $fila['creationDate'] . '</td>';
                echo '<td>' . $fila['passHash'] . '</td>';
                echo '</tr>';
            }
            echo '</table>';
        }
    }catch(PDOException $e){
        echo 'Error amb la BDs: ' . $e->getMessage();
    }