<?php
class Database {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function selectData($id = null) {
        $query = $id !== null ?
            $this->pdo->prepare("SELECT * FROM jouw_tabel WHERE id = :id") :
            $this->pdo->query("SELECT * FROM jouw_tabel");

        $result = $id !== null ? 
            $this->executeAndFetch($query, ['id' => $id]) :
            $query->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    private function executeAndFetch($query, $params = []) {
        $query->execute($params);
        return $query->fetch(PDO::FETCH_ASSOC);
    }
}

$database = new Database($pdo);
$data = $database->selectData();

echo "<table border='1'>
        <tr>
            <th>ID</th>
            <th>Naam</th>
            <th>Email</th>
            <th>Acties</th>
        </tr>";

foreach ($data as $row) {
    echo "<tr>
            <td>{$row['id']}</td>
            <td>{$row['naam']}</td>
            <td>{$row['email']}</td>
            <td>
                <button>Edit</button>
                <button>Delete</button>
            </td>
          </tr>";
}

echo "</table>";
