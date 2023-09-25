<?php

interface DataSource
{
    public function executeGetQuery(string $query, string $params, mixed ...$data);
    public function executeGetQueryWithSerializer(string $query, string $params, $serializer, mixed ...$data);
    public function executePostQuery(string $query, string $params, mixed ...$data);
    public function executeMultiplePostQuery(string $query, string $params, array $data);
}
