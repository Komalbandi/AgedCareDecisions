<?php
//Todo: relocate to Controller folder
include_once("Views/CallHeader.php");
include_once("Repository/CallHeaderRepository.php");

class CallHeaderController
{
    private $view;
    private $respository;

    public function __construct()
    {
        $this->view = new CallHeader();
        $this->respository = new CallHeaderRepository();
    }

    public function index(): void
    {
        $callId = $_GET['callid'];
        $username = $_GET['username'];
        $date = $_GET['date'];

        $results = $this->respository->search($callId, $username, $date);
        $this->view->renderSearch($results);
    }

    public function create(): void
    {
        $this->view->renderCreate();
    }

    public function save(): void
    {
        $date = $_POST['date'];
        $itperson = $_POST['itperson'];
        $username = $_POST['username'];
        $subject = $_POST['subject'];
        $details = $_POST['details'];
        $callid = $this->respository->save($date, $itperson, $username, $subject, $details);
        if ($callid) {
            header('Location: CallDetailsController.php?callid=' . $callid);
        }
    }
}

if (count($_POST) > 0) {
    (new CallHeaderController())->save();
} else if (isset($_GET['page']) && $_GET['page'] === 'create') {
    (new CallHeaderController())->create();
} else {
    (new CallHeaderController())->index();
}