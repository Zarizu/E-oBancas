<?php     
    include_once '../../header.php';
    include_once '../../../Source/Boot/Helpers/Supports.php';
    include_once '../../../Source/Controllers/Empresas.php';

    
    $query = "SELECT * FROM funcionarios";
    $statement = $conn->prepare($query);
    $statement->execute();

    $statement->setFetchMode(PDO::FETCH_OBJ); //PDO::FETCH_ASSOC
    $result = $statement->fetchAll();
    if($result)
    {
        foreach($result as $row)
        {
            ?>
            <tr>
                <td><?= $row->id; ?></td>
                <td><?= $row->fullname; ?></td>
                <td><?= $row->email; ?></td>
                <td><?= $row->phone; ?></td>
                <td><?= $row->course; ?></td>
            </tr>
            <?php
        }
    }


