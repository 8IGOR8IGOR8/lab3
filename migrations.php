<?php
$db = new PDO("mysql:host=127.0.0.1;dbname=network", "root", "");

function showClients()
{
    global $db;
    $statement = $db->query("SELECT DISTINCT `name` FROM clients");
    while ($data = $statement->fetch()) {
        echo "<option value='$data[0]'>$data[0]</option>";
    }
}

function findProfiles($db, $client)
{
    $statement = $db->prepare("SELECT `start`, stop, in_trafic, out_trafic FROM seanses inner join clients on FID_Client = ID_Client WHERE `name`=?");
    $statement->execute([$client]);
    $txt = "<table>";
    $txt .= " <tr>
 <th> Start time  </th>
 <th> Stop time </th>
 <th> In Traffic </th>
 <th> Out Traffic </th>
</tr> ";
    while ($data = $statement->fetch()) {
        $txt .= " <tr>
 <th> {$data['start']}  </th>
 <th> {$data['stop']} </th>
 <th> {$data['in_trafic']} </th>
 <th> {$data['out_trafic']} </th>
</tr> ";
    }
    $txt .= "</table>";
    echo $txt;
}

function findStatistics(PDO $db, $start, $stop)
{
    $statement = $db->prepare("
SELECT `name`, `start`, stop, in_trafic, out_trafic 
FROM seanses inner join clients on FID_Client = ID_Client 
WHERE `start` BETWEEN :start_date AND :stop OR `stop` BETWEEN :start_date AND :stop
");
    $statement->execute(["start_date" => $start, "stop" => $stop]);
    $txt = "<table>";
    $txt .= " <tr>
 <th> Name  </th>
 <th> Start time  </th>
 <th> Stop time </th>
 <th> In Traffic </th>
 <th> Out Traffic </th>
</tr> ";
    while ($data = $statement->fetch()) {
        $txt .= " <tr>
 <th> {$data['name']}  </th>
 <th> {$data['start']}  </th>
 <th> {$data['stop']} </th>
 <th> {$data['in_trafic']} </th>
 <th> {$data['out_trafic']} </th>
</tr> ";
    }
    $txt .= "</table>";
    echo json_encode($txt);
}

function findBalances($db)
{
    $statement = $db->prepare("SELECT `name`, login, password, IP, balance FROM clients WHERE balance < 0");
    $statement->execute();
    $txt = "<table>";
    $txt .= " <tr>
 <th> Name  </th>
 <th> Login  </th>
 <th> Password </th>
 <th> IP </th>
 <th> Balance </th>
</tr> ";
    while ($data = $statement->fetch()) {
        $txt .= " <tr>
 <th> {$data['name']}  </th>
 <th> {$data['login']}  </th>
 <th> {$data['password']} </th>
 <th> {$data['IP']} </th>
 <th> {$data['balance']} </th>
</tr> ";
    }
    $txt .= "</table>";
    echo $txt;
}

if (isset($_POST["clients"])) {
    findProfiles($db, $_POST["clients"]);
} elseif (isset($_POST["start"])) {
    findStatistics($db, $_POST["start"], $_POST["stop"]);
} elseif (isset($_POST["balance"])) {
    findBalances($db);
}
