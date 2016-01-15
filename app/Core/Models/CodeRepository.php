<?php
include_once __DIR__ . "/Inventory.php";
class CodeRepository extends Repository {
    public $idFieldName = "id";

    public function getFreeCodesId($limit) {
        $request = 'SELECT c.id FROM qr_code c
                    LEFT JOIN qr_inventory i on c.id = i.id_code
                    WHERE i.id is NULL LIMIT %1$s;  ';

        $request = sprintf($request, $limit);

        $statement = $this->db->prepare($request);

        $statement->execute();
        $ids = $statement->fetchAll(PDO::FETCH_COLUMN, 0);

        return $ids;

    }

    public function affectCodes(Array $codesIds, $userId) {
        $this->logger->debug("Affectation de ".count($codesIds)." à l'utilisateur ".$userId);
        foreach($codesIds as $codeId) {
            $request = 'INSERT INTO qr_inventory (id_code, id_user) VALUES (:id_code, :id_user) ';

            $statement = $this->db->prepare($request);
            $statement->execute(array(
                ":id_code" => $codeId,
                ":id_user" => $userId
            ));

        }
    }

    public function getInventoryForUser($userId) {
        $request = 'SELECT id, id_code, id_user FROM qr_inventory WHERE id_user = :id_user';

        $statement = $this->db->prepare($request);

        $statement->execute(array(
            ":id_user" => $userId
        ));

        $codes = $statement->fetchAll(PDO::FETCH_CLASS, "Inventory");
        return $codes;
    }
}