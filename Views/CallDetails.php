<?php

class CallDetails
{
    public function renderCreate($callid)
    {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Call details</title>
            <link rel="stylesheet" href="app.css">
        </head>
        <body>
        <form class="createCaller__form" method="post" action="CallDetailsController.php">
            <div class="m-10 d-none">
            <label for="callid">CallId</label>
            <input type="text" id="callid" name="callid" value="' . $callid . '">
            </div>
            
            <div class="m-10">
            <label for="call_date">Date *</label>
            <input type="date" id="call_date" name="date" required>
            </div>
            
            <div class="m-10">
            <label for="details">Details *</label>
            <input type="text" id="details" name="details" required>
            </div>
            
            <div class="m-10">
            <label for="call_time_start">Call start time *</label>
            <input type="time" id="call_time_start" name="call_time_start" required>
            </div>
            
            <div class="m-10">
            <label for="call_time_end">Call end time *</label>
            <input type="time" id="call_time_end" name="call_time_end" required>
            </div>
            
            <div class="m-10">
            <input type="submit" value="Submit" />
            </div>
        </form>
        <script>
            
        </script>
        </body>
        </html>';
    }

    public function renderTimeError(){
        echo '<h1>Start time should be before end time</h1>';
    }

    public function renderSuccessMessage(){
        echo '<h1>Call details saved successfully</h1><br/><button onclick="location.href = \'/\';">Home screen</button>';
    }
}