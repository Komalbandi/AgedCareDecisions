<?php

//include_once("Connection.php");
include_once("CallDetailsRepository.php");

class CallHeaderRepository
{
    private $con;
    private $callDetailsRepository;

    public function __construct()
    {
        $this->con = new Connection();
        $this->callDetailsRepository = new CallDetailsRepository();
    }

    public function save($date, $itperson, $username, $subject, $details)
    {
        try {
            $query = 'INSERT INTO Call_Header (Callid,date, itperson, username, subject, details) VALUES (:Callid,:date, :itperson, :username, :subject, :details)';

            if (!is_null($this->con->getConnection())) {
                $callid = $this->getUnusedCallHeaderId();
                $queryStatement = $this->con->getConnection()->prepare($query);
                $queryStatement->bindParam(':Callid', $callid, PDO::PARAM_INT);
                $queryStatement->bindParam(':date', $date);
                $queryStatement->bindParam(':itperson', $itperson);
                $queryStatement->bindParam(':username', $username);
                $queryStatement->bindParam(':subject', $subject);
                $queryStatement->bindParam(':details', $details);

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

        return $callid;
    }

    private function getUnusedCallHeaderId(): int
    {
        $query = 'SELECT Callid FROM Call_Header';

        if (!is_null($this->con->getConnection())) {
            $queryStatement = $this->con->getConnection()->prepare($query);
            $queryStatement->execute();
            $results = $queryStatement->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $key => $result) {
                if ($key === 0) {
                    $oldCallId = $result['Callid'];
                } else if ($result['Callid'] === ($oldCallId + 1)) {
                    $oldCallId = $result['Callid'];
                } else {
                    return $oldCallId + 1;
                }
            }
            return $oldCallId + 1;
        } else {
            throw new Exception('Error connecting to the database');
        }
    }

    public function search($callId, $username, $date): array|bool
    {
        try {
            $query = $this->getSearchQuery($callId, $username, $date);
            if (!is_null($this->con->getConnection())) {
                $queryStatement = $this->con->getConnection()->prepare($query);
                if (!empty($callId)) {
                    $queryStatement->bindParam(':Callid', $callId);
                }
                if (!empty($username)) {
                    $username = '%' . $username . '%';
                    $queryStatement->bindParam(':username', $username);
                }
                if (!empty($date)) {
                    $queryStatement->bindParam(':date', $date);
                }
                $queryStatement->execute();
                $results = $queryStatement->fetchAll(PDO::FETCH_ASSOC);
            } else {
                throw new Exception('Error connecting to the database');
            }
        } catch (\Exception $e) {
            echo $e->getMessage();
            return false;
        }
        return $this->responseBuilder($results);
    }

    public function responseBuilder($results)
    {
        $returnRespose = [];
        foreach ($results as $result) {
            $returnRespose[] = [
                'CallHeader' => $result,
                'CallDetails' => $this->callDetailsRepository->getByCallId($result['Callid'])
            ];
        }
        return $returnRespose;
    }

    public function getSearchQuery($callId, $username, $date): string
    {
        $query = 'SELECT * FROM Call_Header';

        if (!is_null($callId) || !is_null($username)) {
            $query = $query . ' WHERE ';
        }

        $query = (empty($callId) ? $query . 'Callid >= 0' : $query . 'Callid = :Callid');

        $query = (empty($username) ? $query : $query . ' AND UserName like :username');

        $query = (empty($date) ? $query : $query . ' AND Date >= :date');

        return $query;
    }
}