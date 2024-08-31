<?php
//Todo: relocate to Controller folder
include("./Views/CallDetails.php");
include("./Repository/CallDetailsRepository.php");

class CallDetailsController
{
    private $view;
    private $repository;

    public function __construct()
    {
        $this->view = new CallDetails();
        $this->repository = new CallDetailsRepository();
    }

    public function index(int $callid): void
    {
        $this->view->renderCreate($callid);
    }

    public function save()
    {
        $callId = $_POST['callid'];
        $date = $_POST['date'];
        $details = $_POST['details'];
        $call_time_start = $_POST['call_time_start'];
        $call_time_end = $_POST['call_time_end'];

        $startTime = DateTime::createFromFormat('H:i', $call_time_start);
        $endTime = DateTime::createFromFormat('H:i', $call_time_end);

        if ($startTime > $endTime) {
            $this->view->renderTimeError();
            return;
        }

        $total_hours = $endTime->diff($startTime)->format('%h');
        $total_minutes = $endTime->diff($startTime)->format('%i');
        if ($this->repository->save($callId, $date, $details, $total_hours, $total_minutes)) {
            $this->view->renderSuccessMessage();
        }
    }
}

if (count($_GET) > 0) {
    (new CallDetailsController())->index($_GET['callid']);
} else if (count($_POST) > 0) {
    (new CallDetailsController())->save();
}