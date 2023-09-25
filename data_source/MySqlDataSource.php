<?php
require_once($_SERVER["DOCUMENT_ROOT"] . "/data_source/DataSource.php");

class MySqlDataSource implements DataSource
{
    private mysqli $mySqlConnection;

    public function __construct(mysqli $mySqlConnection)
    {
        $this->mySqlConnection = $mySqlConnection;
    }


    public function executeGetQuery(string $query, string $params, mixed ...$data)
    {
        $stmt = $this->mySqlConnection->prepare($query);
        $response = [];
        if (strlen($params) > 0) {
            $stmt->bind_param($params, ...$data);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($response, $row);
        }
        $stmt->close();
        return $response;
    }

    public function executeGetQueryWithSerializer(string $query, string $params, $serializer, mixed ...$data)
    {
        $stmt = $this->mySqlConnection->prepare($query);
        $response = [];
        if (strlen($params) > 0) {
            $stmt->bind_param($params, ...$data);
        }
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            array_push($response, $serializer($row));
        }
        $stmt->close();
        return $response;
    }

    public function executePostQuery(string $query, string $params, mixed ...$data)
    {
        $stmt = $this->mySqlConnection->prepare($query);
        if (strlen($params) > 0) {
            $stmt->bind_param($params, ...$data);
        }
        $stmt->execute();
        $response = [$stmt->insert_id, ...$data];
        $stmt->close();
        return $response;
    }

    public function executeMultiplePostQuery(string $query, string $params, array $data)
    {
        $stmt = $this->mySqlConnection->prepare($query);
        $isParam = strlen($params);
        foreach ($data as $item) {
            if ($isParam) {
                if (is_array($item)) {
                    $stmt->bind_param($params, ...$item);
                } else {
                    $stmt->bind_param($params, $item);
                }
            }
            $stmt->execute();
        }

        $stmt->close();
    }
}
