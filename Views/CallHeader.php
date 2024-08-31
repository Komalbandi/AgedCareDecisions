<?php

class CallHeader
{
    public function renderCreate()
    {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Create caller</title>
            <link rel="stylesheet" href="app.css">
        </head>
        <body>
        <form class="createCaller__form" method="post" action="CallHeaderController.php">
            <div class="m-10">
            <label for="dateCreated">Date *</label>
            <input type="date" id="dateCreated" name="date" required>
            </div>
            
            <div class="m-10">
            <label for="iTPerson">It person *</label>
            <input type="text" id="iTPerson" name="itperson" required>
            </div>
            
            <div class="m-10">
            <label for="userName">User name *</label>
            <input type="text" id="userName" name="username" required>
            </div>
            
            <div class="m-10">
            <label for="subject">Subject *</label>
            <input type="text" id="subject" name="subject" required>
            </div>
            
            <div class="m-10">
            <label for="details">Details *</label>
            <input type="text" id="details" name="details" required>
            </div>
            
            <div class="m-10">
            <label for="callStatus">Status *</label>
            <select required name="status" id="callStatus">
                <option value="">Select status</option>
                <option value="New">New</option>
                <option value="In Progress">In Progress</option>
                <option value="Completed">Completed</option>
            </select>
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

    public function renderSearch($results)
    {
        echo '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title>Create caller</title>
            <link rel="stylesheet" href="app.css">
        </head>
        <body>
        <form method="get" action="CallHeaderController.php">
            <div class="m-10">
            <label for="callid">Callid</label>
            <input type="text" id="callid" name="callid">
            </div>
            
            <div class="m-10">
            <label for="username">User name</label>
            <input type="text" id="username" name="username">
            </div>
            
            <div class="m-10">
            <label for="date">Date</label>
            <input type="date" id="date" name="date">
            </div>
            
            <div class="m-10">
            <input type="submit" value="Search" />
            </div>
        </form>
        
        <section>
        ' . $this->getSearchBody($results) . '
        </section>
        <div>
        </div>
        </section>
        <script>
            
        </script>
        </body>
        </html>';
    }

    public function getSearchBody($results)
    {
        $body = '';
        foreach ($results as $result) {
            $body = $body . '<div>
            <h1>Call Header</h1>
            <p>Callid: ' . $result['CallHeader']['Callid'] . '</p>
            <p>Date:' . $result['CallHeader']['Date'] . '</p>
            <p>ITPerson:' . $result['CallHeader']['ITPerson'] . '</p>
            <p>UserName:' . $result['CallHeader']['UserName'] . '</p>
            <p>Subject:' . $result['CallHeader']['Subject'] . '</p>
            <p>Details:' . $result['CallHeader']['Details'] . '</p>
            <p>Total time:' . $result['CallHeader']['Total_Hours'] . ':' . $result['CallHeader']['Total_Minutes'] . '</p>
</div><br/>';

            foreach($result['CallDetails'] as $callDetail){
                $body = $body . '<div>
                <h1>Call Details Callid:'.$callDetail['Callid'].'</h1>
                <p>Date:' . $callDetail['Date'] . '</p>
                <p>Details:' . $callDetail['Details'] . '</p>
                <p>Time:' . $callDetail['Hours'] . ':' . $callDetail['Minutes'] . '</p>
                </div><br/>';
            }
        }
        return $body;
    }
}