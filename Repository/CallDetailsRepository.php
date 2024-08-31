<?php
include "Connection.php";

class CallDetailsRepository
{
    private $con;

    public function __construct()
    {
        $this->con = new Connection();
    }

    public function save($callId, $date, $details, $hours, $minutes): bool
    {
        try {
            $query = 'insert into Call_Details (Callid, Date, Details, Hours, Minutes) VALUES (:Callid,:Date, :Details, :Hours, :Minutes)';
            if (!is_null($this->con->getConnection())) {
                $queryStatement = $this->con->getConnection()->prepare($query);
                $queryStatement->bindParam(':Callid', $callId, PDO::PARAM_INT);
                $queryStatement->bindParam(':Date', $date);
                $queryStatement->bindParam(':Details', $details);
                $queryStatement->bindParam(':Hours', $hours, PDO::PARAM_INT);
                $queryStatement->bindParam(':Minutes', $minutes, PDO::PARAM_INT);

                $result = $queryStatement->execute();
                if (!$result) {
                    throw new Exception('Error saving data');
                }
            } else {
                throw new Exception('Error connecting to the database');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }

        return true;
    }

    public function getByCallId($callid): array|null
    {
        $query = 'select * from Call_Details where Callid=:Callid';
        if (!is_null($this->con->getConnection())) {
            $queryStatement = $this->con->getConnection()->prepare($query);
            $queryStatement->bindParam(':Callid', $callid, PDO::PARAM_INT);
            $queryStatement->execute();
            return $queryStatement->fetchAll();
        } else {
            return null;
        }
    }
}